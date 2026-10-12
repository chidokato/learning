<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Test;
use App\Models\Post;
use App\Imports\TestImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;

class AdminTestController extends Controller
{
    public function index()
    {
        $tests = Test::with('questions')->latest()->paginate(10);
        $courses = Post::where('type', 'course')->get();
        return view('backend.tests.index', compact('tests', 'courses'));
    }

    public function show(Test $test)
    {
        $test->load('questions.answers');
        return view('backend.tests.show', compact('test'));
    }

    public function import(Request $request)
    {
        $request->validate([
            'post_id' => 'nullable',
            'title' => 'required',
            'pass_score' => 'required|numeric',
            'file' => 'required|mimes:xlsx,xls,csv'
        ]);

        try {
            $test = Test::create([
                'post_id' => $request->post_id,
                'title' => $request->title,
                'pass_score' => $request->pass_score
            ]);

            Excel::import(new TestImport($test->id), $request->file('file'));
            
            return redirect()->back()->with('success', 'Tạo bài test và import câu hỏi thành công!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Đã có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    public function destroy(Test $test)
    {
        $test->delete();
        return redirect()->back()->with('success', 'Xóa bài test thành công!');
    }
}
