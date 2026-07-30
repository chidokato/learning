<?php

namespace App\Http\Controllers;

use App\Models\CustomerInquiry;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class AdminController extends Controller
{
    public function login(): View
    {
        return view('backend.auth.login');
    }

    public function authenticate(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $admin = User::firstOrCreate(
            ['email' => 'tuan.pn92@gmail.com'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('123456'),
            ]
        );

        if ($credentials['email'] !== $admin->email || $credentials['password'] !== '123456') {
            return back()
                ->withErrors(['email' => 'Thông tin đăng nhập không chính xác.'])
                ->onlyInput('email');
        }

        Auth::login($admin, $request->boolean('remember'));
        $request->session()->regenerate();

        return redirect()->route('backend.admin.dashboard');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('backend.admin.login');
    }

    public function dashboard(): View|RedirectResponse
    {
        if (! Auth::check()) {
            return redirect()->route('backend.admin.login');
        }

        $stats = [
            'courses' => Post::query()->whereIn('type', [Post::TYPE_COURSE, Post::TYPE_PRODUCT])->count(),
            'properties' => Post::query()->whereIn('type', [Post::TYPE_COURSE, Post::TYPE_PRODUCT])->count(),
            'agents' => User::query()->count(),
            'customers' => CustomerInquiry::query()->count(),
            'pending_posts' => Post::query()->whereIn('type', [Post::TYPE_COURSE, Post::TYPE_PRODUCT])->where('is_active', false)->count(),
        ];

        $latestInquiries = CustomerInquiry::query()
            ->latest()
            ->limit(3)
            ->get();

        $activities = $latestInquiries->map(function (CustomerInquiry $inquiry) {
            return [
                'title' => 'Khach hang moi: ' . $inquiry->name,
                'detail' => trim($inquiry->phone . ($inquiry->project_title ? ' | ' . $inquiry->project_title : '')),
            ];
        })->all();

        if ($activities === []) {
            $activities = [
                ['title' => 'Chua co khach hang moi', 'detail' => 'Form thong tin khach hang se hien thi tai day sau khi co nguoi gui.'],
            ];
        }

        return view('backend.admin.dashboard_content', compact('stats', 'activities'));
    }
}
