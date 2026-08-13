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
}
