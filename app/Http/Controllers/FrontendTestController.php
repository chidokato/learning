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
            ->latest();

        if ($search !== '') {
            $query->where('title', 'like', "%{$search}%");
        }

        $tests = $query->get();
        
        $userId = auth()->id() ?? 1; // Fallback to 1 for testing if not logged in
        
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

        $topics = \App\Models\Topic::test()->withCount('tests')->orderBy('name')->get();

        return view('frontend.tests.index', compact('tests', 'userResults', 'search', 'topics'));
    }

    public function show($id)
    {
        $test = Test::with(['questions.answers' => function($query) {
            $query->orderBy('label');
        }])->findOrFail($id);
        
        return view('frontend.tests.show', compact('test'));
    }
}
