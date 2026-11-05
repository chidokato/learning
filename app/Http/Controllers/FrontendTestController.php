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

    public function show(Request $request, $id)
    {
        if (!auth()->check()) {
            session()->flash('warning', 'Vui lòng đăng nhập để vào làm bài kiểm tra.');
            return redirect()->guest(route('frontend.login'));
        }

        $test = Test::with(['questions.answers'])->findOrFail($id);

        $userId = auth()->id();
        $sessionKey = "test_attempt_order_{$test->id}_{$userId}";

        // Khi người dùng bấm "Làm lại bài" hoặc có yêu cầu tạo lượt mới
        if ($request->has('retake') || $request->has('reset')) {
            session()->forget($sessionKey);
        }

        $orderData = session()->get($sessionKey);
        $currentQuestionIds = $test->questions->pluck('id')->sort()->values()->toArray();
        $isValid = false;

        if ($orderData && isset($orderData['questions'], $orderData['answers'], $orderData['created_at'])) {
            $savedQuestionIds = collect($orderData['questions'])->sort()->values()->toArray();
            $maxAgeSeconds = ($test->duration && $test->duration > 0)
                ? ($test->duration * 60 + 1800)
                : 7200;

            if ($savedQuestionIds === $currentQuestionIds && (now()->timestamp - $orderData['created_at']) < $maxAgeSeconds) {
                $isValid = true;
            }
        }

        if ($isValid) {
            // Khôi phục đúng thứ tự xáo trộn đang làm dở của học viên khi F5 / tải lại trang
            $questionsById = $test->questions->keyBy('id');
            $orderedQuestions = collect();

            foreach ($orderData['questions'] as $qId) {
                if ($question = $questionsById->get($qId)) {
                    if (isset($orderData['answers'][$qId])) {
                        $answersById = $question->answers->keyBy('id');
                        $orderedAnswers = collect();
                        foreach ($orderData['answers'][$qId] as $ansId) {
                            if ($ans = $answersById->get($ansId)) {
                                $orderedAnswers->push($ans);
                            }
                        }
                        foreach ($question->answers as $ans) {
                            if (!$orderedAnswers->contains('id', $ans->id)) {
                                $orderedAnswers->push($ans);
                            }
                        }
                        $question->setRelation('answers', $orderedAnswers);
                    }
                    $orderedQuestions->push($question);
                }
            }

            foreach ($test->questions as $q) {
                if (!$orderedQuestions->contains('id', $q->id)) {
                    $orderedQuestions->push($q);
                }
            }

            $test->setRelation('questions', $orderedQuestions);
        } else {
            // Tạo mới ngẫu nhiên thứ tự câu hỏi và thứ tự đáp án cho lượt làm bài này
            $shuffledQuestions = $test->questions->shuffle()->values();
            $savedAnswersOrder = [];

            foreach ($shuffledQuestions as $question) {
                $shuffledAnswers = $question->answers->shuffle()->values();
                $savedAnswersOrder[$question->id] = $shuffledAnswers->pluck('id')->toArray();
                $question->setRelation('answers', $shuffledAnswers);
            }

            $test->setRelation('questions', $shuffledQuestions);

            session()->put($sessionKey, [
                'questions'  => $shuffledQuestions->pluck('id')->toArray(),
                'answers'    => $savedAnswersOrder,
                'created_at' => now()->timestamp,
            ]);
        }
        
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
