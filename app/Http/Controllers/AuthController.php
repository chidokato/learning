<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class AuthController extends Controller
{
    /**
     * Hiển thị trang đăng nhập cho người dùng
     */
    public function showLoginForm(): View|RedirectResponse
    {
        return redirect()->route('frontend.home')
            ->with('info', 'Tính năng Đăng nhập đang được tạm ẩn.');
    }

    /**
     * Xử lý đăng nhập
     */
    public function login(Request $request): RedirectResponse
    {
        return redirect()->route('frontend.home')
            ->with('info', 'Tính năng Đăng nhập đang được tạm ẩn.');
    }

    /**
     * Hiển thị trang đăng ký
     */
    public function showRegisterForm(): View|RedirectResponse
    {
        return redirect()->route('frontend.home')
            ->with('info', 'Tính năng Đăng ký đang được tạm ẩn.');
    }

    /**
     * Xử lý đăng ký tài khoản mới
     */
    public function register(Request $request): RedirectResponse
    {
        return redirect()->route('frontend.home')
            ->with('info', 'Tính năng Đăng ký đang được tạm ẩn.');
    }

    /**
     * Đăng xuất người dùng
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('frontend.home')
            ->with('success', 'Bạn đã đăng xuất khỏi hệ thống thành công.');
    }

    /**
     * Xử lý yêu cầu quên mật khẩu (Mô phỏng gửi email khôi phục)
     */
    public function forgotPassword(Request $request): RedirectResponse
    {
        return redirect()->route('frontend.home')
            ->with('info', 'Tính năng Đăng nhập đang được tạm ẩn.');
    }
    /**
     * Cập nhật thông tin cá nhân
     */
    public function updateProfile(Request $request): RedirectResponse
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'address' => ['nullable', 'string', 'max:255'],
            'password' => ['nullable', 'string', 'min:6', 'confirmed'],
        ]);

        $data = [
            'name' => $validated['name'],
            'phone' => $validated['phone'] ?? null,
            'address' => $validated['address'] ?? null,
        ];

        if (! empty($validated['password'])) {
            $data['password'] = Hash::make($validated['password']);
        }

        $user->update($data);

        return redirect()->route('frontend.profile')
            ->with('success', 'Cập nhật thông tin thành công.');
    }
}
