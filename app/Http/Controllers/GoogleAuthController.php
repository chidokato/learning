<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use App\Services\GoogleAuthConfigService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class GoogleAuthController extends Controller
{
    /**
     * Tự động đảm bảo cột google_id tồn tại trong bảng users (tránh lỗi 1054 Unknown column)
     */
    protected function ensureGoogleIdColumnExists(): bool
    {
        try {
            if (Schema::hasColumn('users', 'google_id')) {
                return true;
            }

            // Tự động thêm cột google_id nếu chưa có trong DB (ví dụ máy chủ chưa chạy migration)
            Schema::table('users', function ($table) {
                $table->string('google_id')->nullable()->after('email')->index();
            });

            Log::info('Auto-created missing column google_id in users table successfully.');
            return true;
        } catch (\Throwable $e) {
            Log::warning('Could not auto-add google_id column: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Xác định Callback URL một cách an toàn và tự động tương thích (Local & Production HTTPS)
     */
    protected function getRedirectUrl(): string
    {
        $configured = GoogleAuthConfigService::get('redirect_uri') ?: config('services.google.redirect');
        $host = request()->getHost();

        // Nếu chạy trên domain chính thức indochinerealestate.vn thì luôn dùng URL callback HTTPS chuẩn
        if (str_contains($host, 'indochinerealestate.vn')) {
            return 'https://learning.indochinerealestate.vn/auth/google/callback';
        }

        if (!empty($configured)) {
            return $configured;
        }

        $url = route('auth.google.callback');
        if (request()->isSecure()) {
            $url = preg_replace('/^http:/i', 'https:', $url);
        }

        return $url;
    }

    /**
     * Chuyển hướng người dùng sang trang xác thực Google OAuth
     */
    public function redirectToGoogle()
    {
        // 1. Kiểm tra bật/tắt tính năng
        if (!GoogleAuthConfigService::get('is_enabled', true)) {
            return redirect()->route('frontend.login')->with('warning', 'Tính năng đăng nhập bằng Google hiện đang tạm tắt để bảo trì.');
        }

        $clientId = GoogleAuthConfigService::get('client_id') ?: config('services.google.client_id');
        $clientSecret = GoogleAuthConfigService::get('client_secret') ?: config('services.google.client_secret');

        if (empty($clientId) || empty($clientSecret)) {
            return redirect()->route('frontend.login')->with('warning', 'Hệ thống chưa cấu hình GOOGLE_CLIENT_ID và GOOGLE_CLIENT_SECRET. Quản trị viên vui lòng thiết lập trong trang Quản trị > Cấu hình Google.');
        }

        $redirectUrl = $this->getRedirectUrl();

        // Tự động kiểm tra và tạo cột google_id trong DB ngay khi người dùng bấm nút đăng nhập
        $this->ensureGoogleIdColumnExists();

        // Cập nhật runtime config cho Socialite
        config([
            'services.google.client_id' => $clientId,
            'services.google.client_secret' => $clientSecret,
            'services.google.redirect' => $redirectUrl,
        ]);

        return Socialite::driver('google')
            ->redirectUrl($redirectUrl)
            ->stateless()
            ->redirect();
    }

    /**
     * Nhận phản hồi từ Google và xử lý đăng nhập / đăng ký
     */
    public function handleGoogleCallback(Request $request)
    {
        // 1. Kiểm tra nếu người dùng bấm Hủy (Cancel) hoặc từ chối cấp quyền tại Google
        if ($request->has('error')) {
            $error = $request->get('error');
            if ($error === 'access_denied') {
                return redirect()->route('frontend.login')->with('info', 'Bạn đã hủy đăng nhập bằng tài khoản Google.');
            }
            return redirect()->route('frontend.login')->with('error', 'Đăng nhập Google không thành công: ' . $error);
        }

        $clientId = GoogleAuthConfigService::get('client_id') ?: config('services.google.client_id');
        $clientSecret = GoogleAuthConfigService::get('client_secret') ?: config('services.google.client_secret');

        if (empty($clientId) || empty($clientSecret)) {
            return redirect()->route('frontend.login')->with('warning', 'Hệ thống chưa cấu hình Google Client ID & Secret.');
        }

        $redirectUrl = $this->getRedirectUrl();

        config([
            'services.google.client_id' => $clientId,
            'services.google.client_secret' => $clientSecret,
            'services.google.redirect' => $redirectUrl,
        ]);

        try {
            // Sử dụng stateless() để tránh lỗi InvalidStateException do session / cookie cross-site
            $googleUser = Socialite::driver('google')
                ->redirectUrl($redirectUrl)
                ->stateless()
                ->user();
        } catch (\Exception $e) {
            Log::error('Google Auth Error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
            ]);
            return redirect()->route('frontend.login')->with('error', 'Đăng nhập Google thất bại hoặc phiên xác thực đã hết hạn. Vui lòng thử lại.');
        }

        if (!$googleUser || empty($googleUser->getEmail())) {
            return redirect()->route('frontend.login')->with('error', 'Không thể lấy thông tin email từ tài khoản Google của bạn.');
        }

        // Đảm bảo cột google_id tồn tại trong DB, nếu chưa có sẽ tự động tạo ngay
        $hasGoogleId = $this->ensureGoogleIdColumnExists();

        // 1. Trường hợp người dùng đang đăng nhập sẵn và thực hiện liên kết Google
        if (Auth::check()) {
            $currentUser = Auth::user();

            // Kiểm tra xem Google ID này đã được liên kết với tài khoản khác chưa
            if ($hasGoogleId) {
                $existingWithGoogle = User::where('google_id', $googleUser->getId())
                    ->where('id', '!=', $currentUser->id)
                    ->first();

                if ($existingWithGoogle) {
                    return redirect()->route('frontend.profile')->with('error', 'Tài khoản Google này đã được liên kết với một tài khoản khác (' . $existingWithGoogle->email . ').');
                }

                $currentUser->google_id = $googleUser->getId();
            }

            $avatar = $googleUser->getAvatar();
            if ($avatar && (empty($currentUser->avatar) || str_contains($currentUser->avatar, 'googleusercontent.com'))) {
                $currentUser->avatar = Str::limit($avatar, 250, '');
            }
            $currentUser->save();
            return redirect()->route('frontend.profile')->with('success', 'Đã liên kết tài khoản Google thành công!');
        }

        // 2. Kiểm tra tài khoản đã từng đăng nhập bằng google_id
        $user = null;
        if ($hasGoogleId) {
            $user = User::where('google_id', $googleUser->getId())->first();
        }

        if ($user) {
            $avatar = $googleUser->getAvatar();
            if ($avatar && (empty($user->avatar) || str_contains($user->avatar, 'googleusercontent.com'))) {
                $user->avatar = Str::limit($avatar, 250, '');
            }
            if (!$user->email_verified_at) {
                $user->email_verified_at = now();
            }
            $user->save();

            Auth::login($user, true);
            return redirect()->intended(route('frontend.home'))->with('success', 'Đăng nhập thành công bằng tài khoản Google!');
        }

        // 3. Kiểm tra nếu email đã tồn tại (đã đăng ký trước đó bằng form thông thường)
        $existingUser = User::where('email', $googleUser->getEmail())->first();

        if ($existingUser) {
            if ($hasGoogleId) {
                $existingUser->google_id = $googleUser->getId();
            }
            $avatar = $googleUser->getAvatar();
            if ($avatar && (empty($existingUser->avatar) || str_contains($existingUser->avatar, 'googleusercontent.com'))) {
                $existingUser->avatar = Str::limit($avatar, 250, '');
            }
            if (!$existingUser->email_verified_at) {
                $existingUser->email_verified_at = now();
            }
            $existingUser->save();

            Auth::login($existingUser, true);
            return redirect()->intended(route('frontend.home'))->with('success', 'Đăng nhập Google thành công! Tài khoản của bạn đã được liên kết.');
        }

        // 4. Người dùng mới hoàn toàn -> Tự động tạo tài khoản học viên
        $userName = $googleUser->getName() ?: ($googleUser->getNickname() ?: 'Học viên');
        $avatar = $googleUser->getAvatar();

        $userData = [
            'name' => $userName,
            'email' => $googleUser->getEmail(),
            'password' => Hash::make(Str::random(32)),
            'email_verified_at' => now(),
            'avatar' => $avatar ? Str::limit($avatar, 250, '') : null,
            'permission' => 5, // Quyền học viên (Student)
        ];

        if ($hasGoogleId) {
            $userData['google_id'] = $googleUser->getId();
        }

        $newUser = User::create($userData);

        Auth::login($newUser, true);

        return redirect()->intended(route('frontend.home'))->with('success', 'Chào mừng bạn! Đăng ký và đăng nhập thành công bằng tài khoản Google.');
    }

    /**
     * Hủy liên kết tài khoản Google
     */
    public function unlinkGoogle()
    {
        if (!Auth::check()) {
            return redirect()->route('frontend.login');
        }

        $user = Auth::user();
        if (empty($user->google_id)) {
            return redirect()->route('frontend.profile')->with('info', 'Tài khoản chưa từng liên kết với Google.');
        }

        $user->google_id = null;
        $user->save();

        return redirect()->route('frontend.profile')->with('success', 'Đã hủy liên kết tài khoản Google thành công.');
    }
}
