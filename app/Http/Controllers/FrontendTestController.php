<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Test;
use App\Models\UserTestResult;

class FrontendTestController extends Controller
{
    public function index(Request $request)
    {
        $search = trim($request->input('search', ''));

        $query = Test::query()
            ->withCount('questions')
            ->with(['post:id,title,slug', 'topics:id,name,slug'])
            ->orderByDesc('is_special')
            ->latest();

        if ($search !== '') {
            $query->where('title', 'like', "%{$search}%");
        }

        $tests = $query->get();
        
        $userResults = collect();
        if (auth()->check()) {
            $userId = auth()->id();
            // Lấy thống kê làm bài của user theo từng bài test
            $userResults = UserTestResult::where('user_id', $userId)
                ->whereIn('test_id', $tests->pluck('id'))
                ->get()
                ->groupBy('test_id')
                ->map(function ($items) {
                    return [
                        'attempts'   => $items->count(),
                        'max_score'  => $items->max('score'),
                        'is_passed'  => $items->contains('is_passed', true),
                        'latest'     => $items->sortByDesc('created_at')->first(),
                    ];
                });
        }

        $topics = \App\Models\Topic::test()->withCount('tests')->orderBy('name')->get();

        return view('frontend.tests.index', compact('tests', 'userResults', 'search', 'topics'));
    }

    public function show($id)
    {
        if (!auth()->check()) {
            session()->flash('warning', 'Vui lòng đăng nhập để vào làm bài kiểm tra.');
            return redirect()->guest(route('frontend.login'));
        }

        $test = Test::with(['questions.answers' => function($query) {
            $query->orderBy('label');
        }])->findOrFail($id);
        
        return view('frontend.tests.show', compact('test'));
    }

    public function viewResult($result_id)
    {
        if (!auth()->check()) {
            session()->flash('warning', 'Vui lòng đăng nhập để xem kết quả bài thi.');
            return redirect()->guest(route('frontend.login'));
        }

        // Tạm thời đóng trang xem chi tiết đáp án kết quả đối với học viên thường
        if (!auth()->user()->isAdmin()) {
            return redirect()->route('frontend.history.tests')
                ->with('warning', 'Chức năng xem chi tiết đáp án bài kiểm tra đang tạm thời đóng.');
        }

        $userId = auth()->id();

        $result = UserTestResult::with([
            'test.questions.answers' => function($query) {
                $query->orderBy('label');
            },
            'test.post:id,title,slug',
            'test.topics:id,name,slug'
        ])->findOrFail($result_id);

        $test = $result->test;
        $userAnswers = $result->user_answers ?? [];

        return view('frontend.tests.result', compact('result', 'test', 'userAnswers'));
    }
}
