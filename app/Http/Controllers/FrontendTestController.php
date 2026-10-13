<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Test;
use App\Models\UserTestResult;

class FrontendTestController extends Controller
{
    public function index()
    {
        $tests = Test::whereNull('post_id')->latest()->get();
        
        $user_id = auth()->id() ?? 1; // Fallback to 1 for testing if not logged in
        
        // Lấy thống kê làm bài của user theo từng bài test
        $userResults = UserTestResult::where('user_id', $user_id)
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

        return view('frontend.tests.index', compact('tests', 'userResults'));
    }

    public function show($id)
    {
        $test = Test::with(['questions.answers' => function($query) {
            $query->orderBy('label');
        }])->findOrFail($id);
        
        return view('frontend.tests.show', compact('test'));
    }
}
