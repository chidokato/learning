<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckUserIsActive
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            $user = Auth::user();

            if (! $user->is_active) {
                // Thu hồi tất cả API token nếu có
                if (method_exists($user, 'tokens')) {
                    $user->tokens()->delete();
                }

                // Đăng xuất và hủy phiên làm việc (Session)
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                if ($request->expectsJson() || $request->ajax()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Website lưu hành nội bộ. Tài khoản của bạn chưa được kích hoạt hoặc đã bị khóa, cần liên hệ admin để được cấp tài khoản.',
                    ], 403);
                }

                $loginRoute = $request->is('admin*') ? 'backend.admin.login' : 'frontend.login';
                $notice = 'Website lưu hành nội bộ. Tài khoản của bạn chưa được kích hoạt hoặc đã bị khóa, cần liên hệ admin để được cấp tài khoản.';

                return redirect()->route($loginRoute)
                    ->with('account_notice', $notice)
                    ->with('account_notice_type', 'warning')
                    ->with('error', $notice);
            }
        }

        return $next($request);
    }
}
