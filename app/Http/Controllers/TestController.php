<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Test;
use App\Models\Question;
use App\Models\UserTestResult;
use App\Imports\TestImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;

class TestController extends Controller
{
    /**
     * Upload file Excel để import câu hỏi cho 1 bài test (Dành cho Admin)
     */
    public function importExcel(Request $request, $test_id)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required|mimes:xlsx,xls,csv'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $test = Test::find($test_id);
        if (!$test) {
            return response()->json(['error' => 'Bài test không tồn tại'], 404);
        }

        try {
            Excel::import(new TestImport($test_id), $request->file('file'));
            return response()->json(['message' => 'Import thành công!']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Đã có lỗi xảy ra: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Lấy danh sách câu hỏi để học viên làm bài
     */
    public function getTestQuestions($test_id)
    {
        $test = Test::with(['questions.answers' => function($query) {
            $query->select('id', 'question_id', 'label', 'content');
        }])->find($test_id);

        if (!$test) {
            return response()->json(['error' => 'Bài test không tồn tại'], 404);
        }

        return response()->json($test);
    }

    /**
     * Nộp bài kiểm tra và chấm điểm tự động
     */
    public function submitTest(Request $request, $test_id)
    {
        $test = Test::find($test_id);
        if (!$test) {
            return response()->json(['error' => 'Bài test không tồn tại'], 404);
        }

        // Format body:
        // 'answers' => [
        //     [ 'question_id' => 1, 'answer_ids' => [1] ], // 1 đáp án
        //     [ 'question_id' => 2, 'answer_ids' => [3, 4] ], // Nhiều đáp án
        // ]
        $userAnswers = $request->input('answers', []);
        
        $totalCorrect = 0;
        $totalQuestions = $test->questions()->count();

        foreach ($userAnswers as $ua) {
            $question = Question::with('answers')->find($ua['question_id']);
            if (!$question || $question->test_id != $test_id) continue;

            $correctAnswerIds = $question->answers->where('is_correct', true)->pluck('id')->toArray();
            $userAnswerIds = $ua['answer_ids'] ?? [];

            // Kiểm tra xem user có chọn đúng mảng đáp án không
            sort($correctAnswerIds);
            sort($userAnswerIds);

            if ($correctAnswerIds === $userAnswerIds) {
                $totalCorrect++;
            }
        }

        $isPassed = $totalCorrect >= $test->pass_score;

        $user_id = auth()->id() ?? auth('sanctum')->id() ?? 1;

        $result = UserTestResult::create([
            'user_id' => $user_id,
            'test_id' => $test_id,
            'score' => $totalCorrect,
            'is_passed' => $isPassed,
            'completed_at' => now(),
        ]);

        return response()->json([
            'message' => 'Nộp bài thành công',
            'result' => [
                'total_correct' => $totalCorrect,
                'total_questions' => $totalQuestions,
                'is_passed' => $isPassed,
            ]
        ]);
    }
}
