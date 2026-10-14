<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class GoogleAuthController extends Controller
{
    /**
     * Chuyển hướng người dùng sang trang xác thực Google OAuth
     */
    public function redirectToGoogle()
    {
        $clientId = config('services.google.client_id');
        $clientSecret = config('services.google.client_secret');

        if (empty($clientId) || empty($clientSecret)) {
            return redirect()->route('frontend.login')->with('warning', 'Hệ thống chưa cấu hình GOOGLE_CLIENT_ID và GOOGLE_CLIENT_SECRET trong file .env. Vui lòng thiết lập để kích hoạt tính năng này.');
        }

        $redirectUrl = config('services.google.redirect') ?: route('auth.google.callback');

        return Socialite::driver('google')
            ->redirectUrl($redirectUrl)
            ->redirect();
    }

    /**
     * Nhận phản hồi từ Google và xử lý đăng nhập / đăng ký
     */
    public function handleGoogleCallback()
    {
        $clientId = config('services.google.client_id');
        $clientSecret = config('services.google.client_secret');

        if (empty($clientId) || empty($clientSecret)) {
            return redirect()->route('frontend.login')->with('warning', 'Hệ thống chưa cấu hình GOOGLE_CLIENT_ID và GOOGLE_CLIENT_SECRET.');
        }

        try {
            $redirectUrl = config('services.google.redirect') ?: route('auth.google.callback');

            try {
                $googleUser = Socialite::driver('google')
                    ->redirectUrl($redirectUrl)
                    ->user();
            } catch (\Laravel\Socialite\Two\InvalidStateException $e) {
                $googleUser = Socialite::driver('google')
                    ->redirectUrl($redirectUrl)
                    ->stateless()
                    ->user();
            }
        } catch (\Exception $e) {
            Log::error('Google Auth Error: ' . $e->getMessage());
            return redirect()->route('frontend.login')->with('error', 'Đăng nhập Google thất bại hoặc bạn đã hủy xác thực.');
        }

        if (!$googleUser || empty($googleUser->getEmail())) {
            return redirect()->route('frontend.login')->with('error', 'Không thể lấy thông tin email từ tài khoản Google.');
        }

        // 1. Kiểm tra tài khoản đã từng đăng nhập bằng google_id
        $user = User::where('google_id', $googleUser->getId())->first();

        if ($user) {
            if (empty($user->avatar) && $googleUser->getAvatar()) {
                $user->avatar = $googleUser->getAvatar();
            }
            if (!$user->email_verified_at) {
                $user->email_verified_at = now();
            }
            $user->save();

            Auth::login($user, true);
            return redirect()->intended(route('frontend.home'))->with('success', 'Đăng nhập Google thành công!');
        }

        // 2. Kiểm tra nếu email đã tồn tại (Đã đăng ký bằng form thông thường trước đó)
        $existingUser = User::where('email', $googleUser->getEmail())->first();

        if ($existingUser) {
            $existingUser->google_id = $googleUser->getId();
            if (empty($existingUser->avatar) && $googleUser->getAvatar()) {
                $existingUser->avatar = $googleUser->getAvatar();
            }
            if (!$existingUser->email_verified_at) {
                $existingUser->email_verified_at = now();
            }
            $existingUser->save();

            Auth::login($existingUser, true);
            return redirect()->intended(route('frontend.home'))->with('success', 'Đăng nhập Google thành công! Tài khoản của bạn đã được liên kết.');
        }

        // 3. Người dùng mới hoàn toàn -> Tự động tạo tài khoản đăng ký
        $newUser = User::create([
            'name' => $googleUser->getName() ?: 'Học viên',
            'email' => $googleUser->getEmail(),
            'google_id' => $googleUser->getId(),
            'password' => Hash::make(Str::random(32)),
            'email_verified_at' => now(),
            'avatar' => $googleUser->getAvatar(),
            'permission' => 5, // Quyền học viên
        ]);

        Auth::login($newUser, true);

        return redirect()->intended(route('frontend.home'))->with('success', 'Đăng ký và đăng nhập thành công bằng tài khoản Google!');
    }
}
