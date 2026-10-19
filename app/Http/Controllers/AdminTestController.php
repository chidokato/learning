<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Test;
use App\Models\Post;
use App\Models\Topic;
use App\Models\Question;
use App\Models\Answer;
use App\Imports\TestImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class AdminTestController extends Controller
{
    public function index()
    {
        $tests = Test::with(['questions', 'topics', 'post'])->latest()->paginate(10);
        $courses = Post::where('type', 'course')->get();
        $topics = Topic::test()->orderBy('name')->get();
        return view('backend.tests.index', compact('tests', 'courses', 'topics'));
    }

    public function show(Test $test)
    {
        return redirect()->route('backend.tests.edit', $test->id);
    }

    public function edit(Test $test)
    {
        $test->load([
            'topics',
            'questions' => function ($query) {
                $query->orderBy('order')->with(['answers' => function ($q) {
                    $q->orderBy('label');
                }]);
            }
        ]);
        $courses = Post::where('type', 'course')->get();
        $topics = Topic::test()->orderBy('name')->get();
        return view('backend.tests.edit', compact('test', 'courses', 'topics'));
    }

    public function import(Request $request)
    {
        $request->validate([
            'post_id' => 'nullable',
            'topic_id' => 'nullable|exists:topics,id',
            'topic_ids' => 'nullable|array',
            'topic_ids.*' => 'exists:topics,id',
            'title' => 'required',
            'pass_score' => 'required|numeric',
            'duration' => 'nullable|numeric|min:0',
            'file' => 'required|mimes:xlsx,xls,csv'
        ]);

        try {
            $topicIds = (array) $request->input('topic_ids', []);
            if ($request->filled('topic_id') && !in_array($request->topic_id, $topicIds)) {
                $topicIds[] = (int)$request->topic_id;
            }
            $primaryTopicId = !empty($topicIds) ? $topicIds[0] : ($request->topic_id ?: null);

            $test = Test::create([
                'post_id' => $request->post_id ?: null,
                'topic_id' => $primaryTopicId,
                'title' => $request->title,
                'pass_score' => $request->pass_score,
                'duration' => $request->duration ? (int)$request->duration : 0,
            ]);

            if (!empty($topicIds)) {
                $test->topics()->sync($topicIds);
            }

            Excel::import(new TestImport($test->id), $request->file('file'));
            
            return redirect()->back()->with('success', 'Tạo bài test và import câu hỏi thành công!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Đã có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    public function update(Request $request, Test $test)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'post_id' => 'nullable',
            'topic_id' => 'nullable|exists:topics,id',
            'topic_ids' => 'nullable|array',
            'topic_ids.*' => 'exists:topics,id',
            'pass_score' => 'required|numeric|min:1',
            'duration' => 'nullable|numeric|min:0',
        ]);

        try {
            DB::transaction(function () use ($request, $test) {
                $topicIds = (array) $request->input('topic_ids', []);
                if ($request->filled('topic_id') && !in_array($request->topic_id, $topicIds)) {
                    $topicIds[] = (int)$request->topic_id;
                }
                $primaryTopicId = !empty($topicIds) ? $topicIds[0] : ($request->topic_id ?: null);

                $test->update([
                    'title' => $request->title,
                    'post_id' => $request->post_id ?: null,
                    'topic_id' => $primaryTopicId,
                    'pass_score' => $request->pass_score,
                    'duration' => $request->duration ? (int)$request->duration : 0,
                ]);

                $test->topics()->sync($topicIds);

                if ($request->filled('questions_data')) {
                    $questionsData = json_decode($request->questions_data, true);
                    if (is_array($questionsData)) {
                        $submittedQuestionIds = [];
                        $existingQuestionIds = $test->questions()->pluck('id')->toArray();

                        $order = 1;
                        foreach ($questionsData as $qData) {
                            $qContent = trim($qData['content'] ?? '');
                            if ($qContent === '') {
                                continue;
                            }

                            $qType = ($qData['type'] ?? '') === 'multiple_choice' ? 'multiple_choice' : 'single_choice';
                            $qId = !empty($qData['id']) && in_array((int)$qData['id'], $existingQuestionIds) ? (int)$qData['id'] : null;

                            if ($qId) {
                                $question = Question::find($qId);
                                $question->update([
                                    'content' => $qContent,
                                    'type' => $qType,
                                    'order' => $order++,
                                ]);
                            } else {
                                $question = Question::create([
                                    'test_id' => $test->id,
                                    'content' => $qContent,
                                    'type' => $qType,
                                    'order' => $order++,
                                ]);
                            }

                            $submittedQuestionIds[] = $question->id;

                            // Handle answers
                            $existingAnswerIds = $question->answers()->pluck('id')->toArray();
                            $submittedAnswerIds = [];
                            $answersData = $qData['answers'] ?? [];

                            if (is_array($answersData)) {
                                $correctCount = 0;
                                foreach ($answersData as $aIndex => $aData) {
                                    $aContent = trim($aData['content'] ?? '');
                                    if ($aContent === '') {
                                        continue;
                                    }

                                    $aLabel = trim($aData['label'] ?? '');
                                    if (!$aLabel) {
                                        $aLabel = chr(65 + ($aIndex % 26));
                                    }

                                    $isCorrect = !empty($aData['is_correct']) ? true : false;
                                    if ($isCorrect) {
                                        $correctCount++;
                                    }

                                    $aId = !empty($aData['id']) && in_array((int)$aData['id'], $existingAnswerIds) ? (int)$aData['id'] : null;

                                    if ($aId) {
                                        $answer = Answer::find($aId);
                                        $answer->update([
                                            'label' => $aLabel,
                                            'content' => $aContent,
                                            'is_correct' => $isCorrect,
                                        ]);
                                    } else {
                                        $answer = Answer::create([
                                            'question_id' => $question->id,
                                            'label' => $aLabel,
                                            'content' => $aContent,
                                            'is_correct' => $isCorrect,
                                        ]);
                                    }

                                    $submittedAnswerIds[] = $answer->id;
                                }

                                // Auto set question type based on correct answers count
                                if ($correctCount > 1 && $question->type !== 'multiple_choice') {
                                    $question->update(['type' => 'multiple_choice']);
                                }
                            }

                            // Delete removed answers
                            Answer::where('question_id', $question->id)
                                ->whereNotIn('id', $submittedAnswerIds)
                                ->delete();
                        }

                        // Delete removed questions
                        Question::where('test_id', $test->id)
                            ->whereNotIn('id', $submittedQuestionIds)
                            ->delete();
                    }
                }
            });

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Cập nhật bài kiểm tra và danh sách câu hỏi thành công!',
                ]);
            }

            if ($request->has('save_and_exit')) {
                return redirect()->route('backend.tests.index')->with('success', 'Cập nhật bài kiểm tra và danh sách câu hỏi thành công!');
            }

            return redirect()->route('backend.tests.edit', $test->id)->with('success', 'Cập nhật bài kiểm tra và danh sách câu hỏi thành công!');
        } catch (\Exception $e) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Đã có lỗi xảy ra: ' . $e->getMessage(),
                ], 500);
            }
            return redirect()->back()->with('error', 'Đã có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    public function destroy(Test $test)
    {
        $test->delete();
        return redirect()->back()->with('success', 'Xóa bài test thành công!');
    }
}
