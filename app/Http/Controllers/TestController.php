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
        $test = Test::with(['questions.answers'])->find($test_id);
        if (!$test) {
            return response()->json(['error' => 'Bài test không tồn tại'], 404);
        }

        // 1. Lấy danh sách đáp án người dùng đã chọn
        $userAnswers = $request->input('answers', []);

        // Hỗ trợ cả trường hợp submit từ form serialize với name dạng q_{question_id}
        if (empty($userAnswers)) {
            foreach ($request->all() as $key => $val) {
                if (str_starts_with($key, 'q_')) {
                    $cleanKey = str_replace('[]', '', $key);
                    $qId = (int)str_replace('q_', '', $cleanKey);
                    if ($qId > 0) {
                        $ansIds = is_array($val) ? array_map('intval', $val) : [(int)$val];
                        $userAnswers[] = [
                            'question_id' => $qId,
                            'answer_ids'  => $ansIds,
                        ];
                    }
                }
            }
        }

        // Tạo map phương án chọn theo question_id để lưu vào database
        $savedAnswersMap = [];
        foreach ($userAnswers as $ua) {
            $qId = (int)($ua['question_id'] ?? 0);
            $ansIds = array_values(array_filter(array_map('intval', (array)($ua['answer_ids'] ?? []))));
            if ($qId > 0 && !empty($ansIds)) {
                $savedAnswersMap[$qId] = $ansIds;
            }
        }

        // 2. Chấm điểm bài làm
        $totalQuestions = $test->questions->count();
        $totalCorrect = 0;

        foreach ($test->questions as $question) {
            $correctAnswerIds = $question->answers->where('is_correct', true)->pluck('id')->map(fn($id) => (int)$id)->values()->toArray();
            $userAnswerIds = $savedAnswersMap[$question->id] ?? [];

            sort($correctAnswerIds);
            sort($userAnswerIds);

            if (!empty($correctAnswerIds) && $correctAnswerIds === $userAnswerIds) {
                $totalCorrect++;
            }
        }

        $isCancelled = $request->boolean('is_cancelled') || $request->boolean('is_canceled');
        $isPassed = !$isCancelled && ($totalCorrect >= $test->pass_score);

        $user_id = auth()->id() ?? auth('sanctum')->id() ?? 1;

        $result = UserTestResult::create([
            'user_id'      => $user_id,
            'test_id'      => $test_id,
            'score'        => $totalCorrect,
            'is_passed'    => $isPassed,
            'completed_at' => now(),
            'user_answers' => $savedAnswersMap,
        ]);

        if ($isCancelled) {
            session()->flash('warning', 'Bạn đã hủy bài làm. Lượt làm bài này đã được ghi nhận vào hệ thống.');
        }

        $resultUrl = route('frontend.tests.result', $result->id);

        return response()->json([
            'message' => $isCancelled ? 'Đã hủy bài làm và ghi nhận 1 lượt thi' : 'Nộp bài thành công',
            'result' => [
                'id'              => $result->id,
                'total_correct'   => $totalCorrect,
                'total_questions' => $totalQuestions,
                'is_passed'       => $isPassed,
                'is_cancelled'    => $isCancelled,
                'result_url'      => $resultUrl,
            ]
        ]);
    }
}
