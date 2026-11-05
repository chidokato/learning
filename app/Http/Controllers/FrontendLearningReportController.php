<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\LearningProgressExport;
use App\Models\UserCourseHistory;
use App\Models\UserTestResult;
use App\Models\Department;
use App\Models\Post;

class FrontendLearningReportController extends Controller
{
    /**
     * Báo cáo tiến độ đào tạo & kết quả thi của nhân viên (Giao diện bảng & Bộ lọc)
     */
    public function index(Request $request)
    {
        // 1. Kiểm tra đăng nhập và quyền Admin
        if (!auth()->check()) {
            return redirect()->route('frontend.login');
        }

        if (!auth()->user()->isAdmin()) {
            abort(403, 'Chức năng báo cáo đào tạo chỉ dành cho Quản trị viên hệ thống.');
        }

        // 2. Lấy dữ liệu báo cáo đã lọc
        $reportData = $this->buildReportData($request);
        $allRows = $reportData['rows'];
        $kpi = $reportData['kpi'];

        // 3. Phân trang 20 dòng / trang
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $perPage = (int) $request->input('per_page', 20);
        if ($perPage < 5) $perPage = 20;

        $currentItems = array_slice($allRows, ($currentPage - 1) * $perPage, $perPage);
        $paginatedResults = new LengthAwarePaginator(
            $currentItems,
            count($allRows),
            $perPage,
            $currentPage,
            ['path' => LengthAwarePaginator::resolveCurrentPath()]
        );
        $paginatedResults->withQueryString();

        // 4. Lấy danh sách dropdown bộ lọc
        $departments = Department::orderBy('name')->get(['id', 'name']);
        $courses = Post::where('type', 'course')->orderBy('title')->get(['id', 'title']);

        // 5. Tham số lọc đang chọn
        $filters = [
            'search' => trim($request->input('search', '')),
            'department_id' => $request->input('department_id', 'all'),
            'course_id' => $request->input('course_id', 'all'),
            'learning_status' => $request->input('learning_status', 'all'),
            'test_result' => $request->input('test_result', 'all'),
            'view_mode' => $request->input('view_mode', 'best_attempt'),
            'per_page' => $perPage,
        ];

        return view('frontend.admin.reports.learning', compact(
            'paginatedResults',
            'kpi',
            'departments',
            'courses',
            'filters'
        ));
    }

    /**
     * Xuất báo cáo ra file Excel (.xlsx) chuẩn theo mẫu
     */
    public function exportExcel(Request $request)
    {
        // 1. Kiểm tra đăng nhập và quyền Admin
        if (!auth()->check()) {
            return redirect()->route('frontend.login');
        }

        if (!auth()->user()->isAdmin()) {
            abort(403, 'Chức năng xuất báo cáo chỉ dành cho Quản trị viên hệ thống.');
        }

        // 2. Lấy toàn bộ dữ liệu khớp bộ lọc
        $reportData = $this->buildReportData($request);
        $rows = $reportData['rows'];

        // 3. Tạo file Excel và tải về
        $fileName = 'Bao_cao_tien_do_dao_tao_' . date('d_m_Y_His') . '.xlsx';

        return Excel::download(new LearningProgressExport($rows), $fileName);
    }

    /**
     * Hàm dùng chung xử lý truy vấn và lọc dữ liệu báo cáo
     */
    protected function buildReportData(Request $request): array
    {
        $search = trim($request->input('search', ''));
        $departmentId = $request->input('department_id', 'all');
        $courseId = $request->input('course_id', 'all');
        $learningStatus = $request->input('learning_status', 'all');
        $testResult = $request->input('test_result', 'all');
        $viewMode = $request->input('view_mode', 'best_attempt'); // 'best_attempt' (mặc định), 'latest_attempt', 'all_attempts'

        // Hàm helper định dạng điểm thi (ví dụ: 26/30 hoặc -)
        $formatScore = function ($score, $totalQ) {
            if ($score === '-' || $score === null || $score === '') {
                return '-';
            }
            return ($totalQ > 0) ? ($score . '/' . $totalQ) : (string) $score;
        };

        // 1. Truy vấn lịch sử học tập
        $historyQuery = UserCourseHistory::with([
            'user.department',
            'post.tests' => function ($q) {
                $q->withCount('questions');
            }
        ]);

        if ($departmentId !== 'all' && !empty($departmentId)) {
            $historyQuery->whereHas('user', function ($uq) use ($departmentId) {
                $uq->where('department_id', (int) $departmentId);
            });
        }

        if ($courseId !== 'all' && !empty($courseId)) {
            $historyQuery->where('post_id', (int) $courseId);
        }

        if ($learningStatus === 'completed') {
            $historyQuery->where(function ($q) {
                $q->whereNotNull('completed_at')->orWhere('progress_percent', '>=', 100);
            });
        } elseif ($learningStatus === 'in_progress') {
            $historyQuery->where(function ($q) {
                $q->whereNull('completed_at')->where('progress_percent', '<', 100);
            });
        }

        $histories = $historyQuery->get();

        $processedUserTests = [];
        $rawRows = [];

        foreach ($histories as $h) {
            $user = $h->user;
            if (!$user) continue;
            $post = $h->post;
            if (!$post) continue;

            $courseCode = 'KH' . str_pad($post->id, 3, '0', STR_PAD_LEFT);
            $courseTitle = $post->title;
            $studyTime = $h->formatted_study_time;
            $isCourseCompleted = ($h->completed_at || $h->progress_percent >= 100);
            $learningStatusText = $isCourseCompleted ? 'Hoàn thành' : 'Chưa hoàn thành';

            $tests = $post->tests;

            if ($tests->isNotEmpty()) {
                foreach ($tests as $test) {
                    $key = "u_{$user->id}_t_{$test->id}";
                    $processedUserTests[$key] = true;

                    $attempts = UserTestResult::where('user_id', $user->id)
                        ->where('test_id', $test->id)
                        ->orderBy('id', 'asc')
                        ->get();

                    $totalAttempts = $attempts->count();
                    $totalQuestions = (int) ($test->questions_count ?? ($test->relationLoaded('questions') ? $test->questions->count() : ($test ? $test->questions()->count() : 0)));

                    if ($totalAttempts === 0) {
                        $rawRows[] = [
                            'user_id' => $user->id,
                            'user_avatar' => $user->avatar,
                            'post_id' => $post->id,
                            'test_id' => $test->id,
                            'employee_code' => $user->employee_code ?: '',
                            'name' => $user->name,
                            'job_title' => $user->job_title ?: '',
                            'department' => $user->department->name ?? '',
                            'email' => $user->email,
                            'course_code' => $courseCode,
                            'course_title' => $courseTitle,
                            'study_time' => $studyTime,
                            'learning_status' => $learningStatusText,
                            'attempts_count' => 0,
                            'attempt_status' => 'Chưa thi',
                            'score' => '-',
                            'result' => 'Chưa thi',
                            'completed_at' => null,
                            'is_passed' => null,
                            'is_completed' => $isCourseCompleted,
                        ];
                    } else {
                        if ($viewMode === 'best_attempt') {
                            $bestIndex = 0;
                            $bestAtt = $attempts[0];
                            foreach ($attempts as $idx => $att) {
                                if (
                                    $att->score > $bestAtt->score ||
                                    ($att->score == $bestAtt->score && $att->is_passed && !$bestAtt->is_passed)
                                ) {
                                    $bestAtt = $att;
                                    $bestIndex = $idx;
                                }
                            }
                            $rawRows[] = [
                                'user_id' => $user->id,
                                'user_avatar' => $user->avatar,
                                'post_id' => $post->id,
                                'test_id' => $test->id,
                                'employee_code' => $user->employee_code ?: '',
                                'name' => $user->name,
                                'job_title' => $user->job_title ?: '',
                                'department' => $user->department->name ?? '',
                                'email' => $user->email,
                                'course_code' => $courseCode,
                                'course_title' => $courseTitle,
                                'study_time' => $studyTime,
                                'learning_status' => $learningStatusText,
                                'attempts_count' => $totalAttempts,
                                'attempt_status' => 'Lần ' . ($bestIndex + 1),
                                'score' => $formatScore($bestAtt->score, $totalQuestions),
                                'result' => $bestAtt->is_passed ? 'Đạt' : 'Không đạt',
                                'completed_at' => $bestAtt->completed_at ?: $bestAtt->created_at,
                                'is_passed' => (bool) $bestAtt->is_passed,
                                'is_completed' => $isCourseCompleted,
                            ];
                        } elseif ($viewMode === 'latest_attempt') {
                            $lastIndex = $attempts->count() - 1;
                            $latestAtt = $attempts[$lastIndex];
                            $rawRows[] = [
                                'user_id' => $user->id,
                                'user_avatar' => $user->avatar,
                                'post_id' => $post->id,
                                'test_id' => $test->id,
                                'employee_code' => $user->employee_code ?: '',
                                'name' => $user->name,
                                'job_title' => $user->job_title ?: '',
                                'department' => $user->department->name ?? '',
                                'email' => $user->email,
                                'course_code' => $courseCode,
                                'course_title' => $courseTitle,
                                'study_time' => $studyTime,
                                'learning_status' => $learningStatusText,
                                'attempts_count' => $totalAttempts,
                                'attempt_status' => 'Lần ' . ($lastIndex + 1),
                                'score' => $formatScore($latestAtt->score, $totalQuestions),
                                'result' => $latestAtt->is_passed ? 'Đạt' : 'Không đạt',
                                'completed_at' => $latestAtt->completed_at ?: $latestAtt->created_at,
                                'is_passed' => (bool) $latestAtt->is_passed,
                                'is_completed' => $isCourseCompleted,
                            ];
                        } else {
                            foreach ($attempts as $idx => $att) {
                                $rawRows[] = [
                                    'user_id' => $user->id,
                                    'user_avatar' => $user->avatar,
                                    'post_id' => $post->id,
                                    'test_id' => $test->id,
                                    'employee_code' => $user->employee_code ?: '',
                                    'name' => $user->name,
                                    'job_title' => $user->job_title ?: '',
                                    'department' => $user->department->name ?? '',
                                    'email' => $user->email,
                                    'course_code' => $courseCode,
                                    'course_title' => $courseTitle,
                                    'study_time' => $studyTime,
                                    'learning_status' => $learningStatusText,
                                    'attempts_count' => $totalAttempts,
                                    'attempt_status' => 'Lần ' . ($idx + 1),
                                    'score' => $formatScore($att->score, $totalQuestions),
                                    'result' => $att->is_passed ? 'Đạt' : 'Không đạt',
                                    'completed_at' => $att->completed_at ?: $att->created_at,
                                    'is_passed' => (bool) $att->is_passed,
                                    'is_completed' => $isCourseCompleted,
                                ];
                            }
                        }
                    }
                }
            } else {
                // Khóa học chưa gán bài thi
                $rawRows[] = [
                    'user_id' => $user->id,
                    'user_avatar' => $user->avatar,
                    'post_id' => $post->id,
                    'test_id' => null,
                    'employee_code' => $user->employee_code ?: '',
                    'name' => $user->name,
                    'job_title' => $user->job_title ?: '',
                    'department' => $user->department->name ?? '',
                    'email' => $user->email,
                    'course_code' => $courseCode,
                    'course_title' => $courseTitle,
                    'study_time' => $studyTime,
                    'learning_status' => $learningStatusText,
                    'attempts_count' => 0,
                    'attempt_status' => 'Không có bài thi',
                    'score' => '-',
                    'result' => '-',
                    'completed_at' => null,
                    'is_passed' => null,
                    'is_completed' => $isCourseCompleted,
                ];
            }
        }

        // 2. Bổ sung các bài thi người dùng đã làm trực tiếp
        $testResultsQuery = UserTestResult::with([
            'user.department',
            'test' => function ($tq) {
                $tq->withCount('questions');
            },
            'test.post'
        ])->orderBy('id', 'asc');
        if ($departmentId !== 'all' && !empty($departmentId)) {
            $testResultsQuery->whereHas('user', function ($uq) use ($departmentId) {
                $uq->where('department_id', (int) $departmentId);
            });
        }

        $allDirectResults = $testResultsQuery->get();
        foreach ($allDirectResults as $res) {
            $key = "u_{$res->user_id}_t_{$res->test_id}";
            if (isset($processedUserTests[$key])) {
                continue;
            }

            $user = $res->user;
            if (!$user) continue;
            $test = $res->test;
            if (!$test) continue;
            $post = $test->post;

            if ($courseId !== 'all' && !empty($courseId)) {
                if (!$post || $post->id != $courseId) {
                    continue;
                }
            }

            $courseCode = $post ? ('KH' . str_pad($post->id, 3, '0', STR_PAD_LEFT)) : ('KT' . str_pad($test->id, 3, '0', STR_PAD_LEFT));
            $courseTitle = $post ? $post->title : $test->title;

            $attempts = UserTestResult::where('user_id', $user->id)
                ->where('test_id', $test->id)
                ->orderBy('id', 'asc')
                ->get();

            $totalAttempts = $attempts->count();
            $totalQuestions = (int) ($test->questions_count ?? ($test->relationLoaded('questions') ? $test->questions->count() : ($test ? $test->questions()->count() : 0)));
            $processedUserTests[$key] = true;

            if ($viewMode === 'best_attempt') {
                $bestIndex = 0;
                $bestAtt = $attempts[0];
                foreach ($attempts as $idx => $att) {
                    if (
                        $att->score > $bestAtt->score ||
                        ($att->score == $bestAtt->score && $att->is_passed && !$bestAtt->is_passed)
                    ) {
                        $bestAtt = $att;
                        $bestIndex = $idx;
                    }
                }
                $rawRows[] = [
                    'user_id' => $user->id,
                    'user_avatar' => $user->avatar,
                    'post_id' => $post ? $post->id : null,
                    'test_id' => $test->id,
                    'employee_code' => $user->employee_code ?: '',
                    'name' => $user->name,
                    'job_title' => $user->job_title ?: '',
                    'department' => $user->department->name ?? '',
                    'email' => $user->email,
                    'course_code' => $courseCode,
                    'course_title' => $courseTitle,
                    'study_time' => $bestAtt->formatted_duration ?: 'Chưa ghi nhận',
                    'learning_status' => 'Chưa hoàn thành',
                    'attempts_count' => $totalAttempts,
                    'attempt_status' => 'Lần ' . ($bestIndex + 1),
                    'score' => $formatScore($bestAtt->score, $totalQuestions),
                    'result' => $bestAtt->is_passed ? 'Đạt' : 'Không đạt',
                    'completed_at' => $bestAtt->completed_at ?: $bestAtt->created_at,
                    'is_passed' => (bool) $bestAtt->is_passed,
                    'is_completed' => false,
                ];
            } elseif ($viewMode === 'latest_attempt') {
                $lastIndex = $attempts->count() - 1;
                $latestAtt = $attempts[$lastIndex];
                $rawRows[] = [
                    'user_id' => $user->id,
                    'user_avatar' => $user->avatar,
                    'post_id' => $post ? $post->id : null,
                    'test_id' => $test->id,
                    'employee_code' => $user->employee_code ?: '',
                    'name' => $user->name,
                    'job_title' => $user->job_title ?: '',
                    'department' => $user->department->name ?? '',
                    'email' => $user->email,
                    'course_code' => $courseCode,
                    'course_title' => $courseTitle,
                    'study_time' => $latestAtt->formatted_duration ?: 'Chưa ghi nhận',
                    'learning_status' => 'Chưa hoàn thành',
                    'attempts_count' => $totalAttempts,
                    'attempt_status' => 'Lần ' . ($lastIndex + 1),
                    'score' => $formatScore($latestAtt->score, $totalQuestions),
                    'result' => $latestAtt->is_passed ? 'Đạt' : 'Không đạt',
                    'completed_at' => $latestAtt->completed_at ?: $latestAtt->created_at,
                    'is_passed' => (bool) $latestAtt->is_passed,
                    'is_completed' => false,
                ];
            } else {
                foreach ($attempts as $idx => $att) {
                    $rawRows[] = [
                        'user_id' => $user->id,
                        'user_avatar' => $user->avatar,
                        'post_id' => $post ? $post->id : null,
                        'test_id' => $test->id,
                        'employee_code' => $user->employee_code ?: '',
                        'name' => $user->name,
                        'job_title' => $user->job_title ?: '',
                        'department' => $user->department->name ?? '',
                        'email' => $user->email,
                        'course_code' => $courseCode,
                        'course_title' => $courseTitle,
                        'study_time' => $att->formatted_duration ?: 'Chưa ghi nhận',
                        'learning_status' => 'Chưa hoàn thành',
                        'attempts_count' => $totalAttempts,
                        'attempt_status' => 'Lần ' . ($idx + 1),
                        'score' => $formatScore($att->score, $totalQuestions),
                        'result' => $att->is_passed ? 'Đạt' : 'Không đạt',
                        'completed_at' => $att->completed_at ?: $att->created_at,
                        'is_passed' => (bool) $att->is_passed,
                        'is_completed' => false,
                    ];
                }
            }
        }

        // 3. Lọc theo từ khóa tìm kiếm & kết quả thi
        $filteredRows = [];
        foreach ($rawRows as $row) {
            // Lọc từ khóa
            if ($search !== '') {
                $searchLower = mb_strtolower($search, 'UTF-8');
                $match = (
                    str_contains(mb_strtolower($row['name'], 'UTF-8'), $searchLower) ||
                    str_contains(mb_strtolower($row['email'], 'UTF-8'), $searchLower) ||
                    str_contains(mb_strtolower($row['employee_code'], 'UTF-8'), $searchLower) ||
                    str_contains(mb_strtolower($row['course_title'], 'UTF-8'), $searchLower) ||
                    str_contains(mb_strtolower($row['course_code'], 'UTF-8'), $searchLower) ||
                    str_contains(mb_strtolower($row['department'], 'UTF-8'), $searchLower)
                );
                if (!$match) {
                    continue;
                }
            }

            // Lọc kết quả thi
            if ($testResult === 'passed' && $row['result'] !== 'Đạt') continue;
            if ($testResult === 'failed' && $row['result'] !== 'Không đạt') continue;
            if ($testResult === 'not_taken' && $row['result'] !== 'Chưa thi') continue;

            $filteredRows[] = $row;
        }

        // 4. Tính toán KPI thống kê tổng hợp
        $totalRecords = count($filteredRows);
        $uniqueUsers = count(array_unique(array_column($filteredRows, 'user_id')));
        $completedCount = 0;
        $passedCount = 0;
        $failedCount = 0;
        $notTakenCount = 0;

        foreach ($filteredRows as $r) {
            if ($r['learning_status'] === 'Hoàn thành') {
                $completedCount++;
            }
            if ($r['result'] === 'Đạt') {
                $passedCount++;
            } elseif ($r['result'] === 'Không đạt') {
                $failedCount++;
            } elseif ($r['result'] === 'Chưa thi') {
                $notTakenCount++;
            }
        }

        $testedTotal = $passedCount + $failedCount;
        $passRate = $testedTotal > 0 ? round(($passedCount / $testedTotal) * 100) : 0;
        $completionRate = $totalRecords > 0 ? round(($completedCount / $totalRecords) * 100) : 0;

        $kpi = [
            'totalRecords' => $totalRecords,
            'uniqueUsers' => $uniqueUsers,
            'completedCount' => $completedCount,
            'completionRate' => $completionRate,
            'passedCount' => $passedCount,
            'failedCount' => $failedCount,
            'notTakenCount' => $notTakenCount,
            'passRate' => $passRate,
        ];

        return [
            'rows' => $filteredRows,
            'kpi' => $kpi,
        ];
    }
}
