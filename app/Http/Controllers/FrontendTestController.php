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
        
        // Lấy kết quả của user để hiển thị trạng thái
        $results = UserTestResult::where('user_id', $user_id)->get()->keyBy('test_id');

        return view('frontend.tests.index', compact('tests', 'results'));
    }

    public function show($id)
    {
        $test = Test::with(['questions.answers' => function($query) {
            $query->orderBy('label');
        }])->findOrFail($id);
        
        return view('frontend.tests.show', compact('test'));
    }
}
