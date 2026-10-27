<?php

namespace App\Http\Controllers;

use App\Services\GoogleAuthConfigService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class AdminGoogleAuthController extends Controller
{
    /**
     * Hiển thị trang cấu hình Google OAuth
     */
    public function index(): View
    {
        $config = GoogleAuthConfigService::all();

        // Kiểm tra trạng thái cột google_id trong bảng users
        $hasGoogleIdColumn = false;
        try {
            $hasGoogleIdColumn = Schema::hasColumn('users', 'google_id');
        } catch (\Throwable $e) {
            Log::warning('Check google_id column error: ' . $e->getMessage());
        }

        // Các URL chuẩn để hiển thị cho quản trị viên copy
        $host = request()->getHost();
        $isLive = str_contains($host, 'indochinerealestate.vn');
        
        $liveOrigin = 'https://learning.indochinerealestate.vn';
        $liveCallback = 'https://learning.indochinerealestate.vn/auth/google/callback';

        $currentOrigin = (request()->isSecure() ? 'https://' : 'http://') . $host;
        $currentCallback = route('auth.google.callback');

        return view('backend.settings.google-auth', compact(
            'config',
            'hasGoogleIdColumn',
            'isLive',
            'liveOrigin',
            'liveCallback',
            'currentOrigin',
            'currentCallback'
        ));
    }

    /**
     * Cập nhật thông tin cấu hình Google OAuth
     */
    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'client_id' => ['nullable', 'string', 'max:500'],
            'client_secret' => ['nullable', 'string', 'max:500'],
            'redirect_uri' => ['nullable', 'string', 'max:500'],
        ]);

        $data = [
            'is_enabled' => $request->boolean('is_enabled'),
            'client_id' => trim($validated['client_id'] ?? ''),
            'client_secret' => trim($validated['client_secret'] ?? ''),
            'redirect_uri' => trim($validated['redirect_uri'] ?? ''),
        ];

        GoogleAuthConfigService::save($data);

        // Xóa cache cấu hình
        try {
            Artisan::call('config:clear');
        } catch (\Throwable $e) {
            // bỏ qua nếu không thể gọi artisan
        }

        return redirect()
            ->route('backend.google-auth.index')
            ->with('success', 'Đã lưu cấu hình Google OAuth thành công!');
    }

    /**
     * Tự động khởi tạo / cập nhật cột google_id vào CSDL bảng users
     */
    public function fixDatabase(): RedirectResponse
    {
        try {
            if (!Schema::hasColumn('users', 'google_id')) {
                Schema::table('users', function ($table) {
                    $table->string('google_id')->nullable()->after('email')->index();
                });

                return redirect()
                    ->route('backend.google-auth.index')
                    ->with('success', 'Đã tự động thêm cột `google_id` vào bảng `users` thành công! Lỗi Unknown column đã được khắc phục hoàn toàn.');
            }

            return redirect()
                ->route('backend.google-auth.index')
                ->with('info', 'Cột `google_id` đã tồn tại sẵn trong bảng `users`, không cần thêm lại.');
        } catch (\Throwable $e) {
            Log::error('Fix database google_id error: ' . $e->getMessage());
            return redirect()
                ->route('backend.google-auth.index')
                ->with('error', 'Không thể tự động thêm cột do lỗi CSDL: ' . $e->getMessage() . '. Bạn có thể chạy `php artisan migrate` hoặc thêm thủ công trong phpMyAdmin.');
        }
    }
}
