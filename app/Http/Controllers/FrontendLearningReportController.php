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
        $departments = Department::getTreeOptions();
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

        // Hàm helper định dạng ngày thi (ví dụ: 05/11/2026 10:13 hoặc -)
        $formatTestDate = function ($date) {
            if (!$date) return '-';
            if (is_string($date)) {
                try {
                    $date = \Carbon\Carbon::parse($date);
                } catch (\Exception $e) {
                    return $date;
                }
            }
            return $date->timezone('Asia/Ho_Chi_Minh')->format('d/m/Y H:i');
        };

        // Hàm helper định dạng thời gian hoàn thành bài thi (ví dụ: 1 phút 53 giây hoặc -)
        $formatTestDuration = function ($att) {
            if (!$att) return '-';
            if (!empty($att->formatted_duration)) {
                return $att->formatted_duration;
            }
            if (!empty($att->duration_seconds) && $att->duration_seconds > 0) {
                return $att->duration_seconds . ' giây';
            }
            return '-';
        };

        // Hàm helper lấy Unix timestamp an toàn để sắp xếp
        $getTimestamp = function ($date) {
            if (!$date) return 0;
            if ($date instanceof \Carbon\Carbon || $date instanceof \DateTimeInterface) {
                return $date->getTimestamp();
            }
            if (is_numeric($date)) {
                return (int) $date;
            }
            $ts = strtotime((string) $date);
            return ($ts !== false) ? $ts : 0;
        };

        // 1. Truy vấn lịch sử học tập
        $allDepartments = Department::all()->keyBy('id');

        // Hàm helper phân giải Công ty và Phòng ban từ cây phòng ban
        $resolveDeptInfo = function ($user) use ($allDepartments) {
            $deptId = $user->department_id ?? null;
            if (!$deptId || !$allDepartments->has($deptId)) {
                return [
                    'company' => '-',
                    'department' => '-',
                ];
            }

            $dept = $allDepartments->get($deptId);

            // Tìm node gốc (Công ty)
            $current = $dept;
            $visited = [];
            while ($current->parent_id && $allDepartments->has($current->parent_id) && !isset($visited[$current->id])) {
                $visited[$current->id] = true;
                $current = $allDepartments->get($current->parent_id);
            }

            $root = $current;

            if ($dept->id !== $root->id) {
                // Thuộc cấp con: root là Công ty, dept hiện tại là Phòng ban
                return [
                    'company' => $root->name,
                    'department' => $dept->name,
                ];
            }

            // Đơn vị gốc (Level 0)
            // Kiểm tra xem đơn vị gốc này có đơn vị con trực thuộc hay không (như INDOCHINE trong hình)
            $hasChildren = $allDepartments->contains('parent_id', $dept->id);
            if ($hasChildren) {
                return [
                    'company' => $dept->name,
                    'department' => '-',
                ];
            }

            // Đơn vị độc lập (không cha, không con)
            $nameLower = mb_strtolower($dept->name, 'UTF-8');
            if (
                str_contains($nameLower, 'công ty') || 
                str_contains($nameLower, 'cty') || 
                str_contains($nameLower, 'tập đoàn') || 
                str_contains($nameLower, 'chi nhánh') ||
                str_contains($nameLower, 'indochine')
            ) {
                return [
                    'company' => $dept->name,
                    'department' => '-',
                ];
            }

            return [
                'company' => '-',
                'department' => $dept->name,
            ];
        };

        // Nếu lọc theo department_id, lấy luôn tất cả ID phòng ban con
        $filterDeptIds = [];
        if ($departmentId !== 'all' && !empty($departmentId)) {
            $selectedDept = $allDepartments->get((int) $departmentId);
            if ($selectedDept) {
                $filterDeptIds = array_merge([$selectedDept->id], $selectedDept->getAllDescendantIds());
            } else {
                $filterDeptIds = [(int) $departmentId];
            }
        }

        $historyQuery = UserCourseHistory::with([
            'user.department',
            'post.tests' => function ($q) {
                $q->withCount('questions');
            }
        ]);

        if (!empty($filterDeptIds)) {
            $historyQuery->whereHas('user', function ($uq) use ($filterDeptIds) {
                $uq->whereIn('department_id', $filterDeptIds);
            });
        }

        if ($courseId !== 'all' && !empty($courseId)) {
            $historyQuery->where('post_id', (int) $courseId);
        }

        if ($learningStatus === 'completed') {
            $historyQuery->where(function ($q) {
                $q->whereNotNull('completed_at')
                  ->orWhere('progress_percent', '>=', 100)
                  ->orWhere(function ($sub) {
                      $sub->where('total_pages', '>', 0)
                          ->whereRaw('current_page >= total_pages');
                  });
            });
        } elseif ($learningStatus === 'in_progress') {
            $historyQuery->where(function ($q) {
                $q->whereNull('completed_at')
                  ->where('progress_percent', '<', 100)
                  ->where(function ($sub) {
                      $sub->where('total_pages', '<=', 0)
                          ->orWhereRaw('current_page < total_pages');
                  });
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
            $isCourseCompleted = ($h->completed_at || $h->progress_percent >= 100 || ($h->total_pages > 0 && $h->current_page >= $h->total_pages));
            $learningStatusText = $isCourseCompleted ? 'Hoàn thành' : 'Chưa hoàn thành';
            $historyActivityTime = $getTimestamp($h->last_learned_at ?: ($h->updated_at ?: $h->created_at));

            $tests = $post->tests;

            if ($tests->isNotEmpty()) {
                foreach ($tests as $test) {
                    $key = "u_{$user->id}_t_{$test->id}";
                    $processedUserTests[$key] = true;

                    $attempts = UserTestResult::where('user_id', $user->id)
                        ->where('test_id', $test->id)
                        ->orderBy('id', 'asc')
                        ->get();
                    $attempts->each(function($att) use ($test) {
                        $att->setRelation('test', $test);
                    });

                    $totalAttempts = $attempts->count();
                    $totalQuestions = (int) ($test->questions_count ?? ($test->relationLoaded('questions') ? $test->questions->count() : ($test ? $test->questions()->count() : 0)));

                    $deptInfo = $resolveDeptInfo($user);

                    if ($totalAttempts === 0) {
                        $rawRows[] = [
                            'user_id' => $user->id,
                            'user_avatar' => $user->avatar,
                            'post_id' => $post->id,
                            'test_id' => $test->id,
                            'employee_code' => $user->employee_code ?: '',
                            'name' => $user->name,
                            'job_title' => $user->job_title ?: '',
                            'company' => $deptInfo['company'],
                            'department' => $deptInfo['department'],
                            'email' => $user->email,
                            'course_code' => $courseCode,
                            'course_title' => $courseTitle,
                            'study_time' => $studyTime,
                            'learning_status' => $learningStatusText,
                            'attempts_count' => 0,
                            'attempt_status' => 'Chưa thi',
                            'test_date' => '-',
                            'test_duration' => '-',
                            'score' => '-',
                            'result' => 'Chưa thi',
                            'completed_at' => null,
                            'test_timestamp' => 0,
                            'activity_timestamp' => $historyActivityTime,
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
                                'company' => $deptInfo['company'],
                                'department' => $deptInfo['department'],
                                'email' => $user->email,
                                'course_code' => $courseCode,
                                'course_title' => $courseTitle,
                                'study_time' => $studyTime,
                                'learning_status' => $learningStatusText,
                                'attempts_count' => $totalAttempts,
                                'attempt_status' => 'Lần ' . ($bestIndex + 1),
                                'test_date' => $formatTestDate($bestAtt->completed_at ?: $bestAtt->created_at),
                                'test_duration' => $formatTestDuration($bestAtt),
                                'score' => $formatScore($bestAtt->score, $totalQuestions),
                                'result' => $bestAtt->is_passed ? 'Đạt' : 'Không đạt',
                                'completed_at' => $bestAtt->completed_at ?: $bestAtt->created_at,
                                'test_timestamp' => $getTimestamp($bestAtt->completed_at ?: $bestAtt->created_at),
                                'activity_timestamp' => $historyActivityTime,
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
                                'company' => $deptInfo['company'],
                                'department' => $deptInfo['department'],
                                'email' => $user->email,
                                'course_code' => $courseCode,
                                'course_title' => $courseTitle,
                                'study_time' => $studyTime,
                                'learning_status' => $learningStatusText,
                                'attempts_count' => $totalAttempts,
                                'attempt_status' => 'Lần ' . ($lastIndex + 1),
                                'test_date' => $formatTestDate($latestAtt->completed_at ?: $latestAtt->created_at),
                                'test_duration' => $formatTestDuration($latestAtt),
                                'score' => $formatScore($latestAtt->score, $totalQuestions),
                                'result' => $latestAtt->is_passed ? 'Đạt' : 'Không đạt',
                                'completed_at' => $latestAtt->completed_at ?: $latestAtt->created_at,
                                'test_timestamp' => $getTimestamp($latestAtt->completed_at ?: $latestAtt->created_at),
                                'activity_timestamp' => $historyActivityTime,
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
                                    'company' => $deptInfo['company'],
                                    'department' => $deptInfo['department'],
                                    'email' => $user->email,
                                    'course_code' => $courseCode,
                                    'course_title' => $courseTitle,
                                    'study_time' => $studyTime,
                                    'learning_status' => $learningStatusText,
                                    'attempts_count' => $totalAttempts,
                                    'attempt_status' => 'Lần ' . ($idx + 1),
                                    'test_date' => $formatTestDate($att->completed_at ?: $att->created_at),
                                    'test_duration' => $formatTestDuration($att),
                                    'score' => $formatScore($att->score, $totalQuestions),
                                    'result' => $att->is_passed ? 'Đạt' : 'Không đạt',
                                    'completed_at' => $att->completed_at ?: $att->created_at,
                                    'test_timestamp' => $getTimestamp($att->completed_at ?: $att->created_at),
                                    'activity_timestamp' => $historyActivityTime,
                                    'is_passed' => (bool) $att->is_passed,
                                    'is_completed' => $isCourseCompleted,
                                ];
                            }
                        }
                    }
                }
            } else {
                // Khóa học chưa gán bài thi
                $deptInfo = $resolveDeptInfo($user);
                $rawRows[] = [
                    'user_id' => $user->id,
                    'user_avatar' => $user->avatar,
                    'post_id' => $post->id,
                    'test_id' => null,
                    'employee_code' => $user->employee_code ?: '',
                    'name' => $user->name,
                    'job_title' => $user->job_title ?: '',
                    'company' => $deptInfo['company'],
                    'department' => $deptInfo['department'],
                    'email' => $user->email,
                    'course_code' => $courseCode,
                    'course_title' => $courseTitle,
                    'study_time' => $studyTime,
                    'learning_status' => $learningStatusText,
                    'attempts_count' => 0,
                    'attempt_status' => 'Không có bài thi',
                    'test_date' => '-',
                    'test_duration' => '-',
                    'score' => '-',
                    'result' => '-',
                    'completed_at' => null,
                    'test_timestamp' => 0,
                    'activity_timestamp' => $historyActivityTime,
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
        if (!empty($filterDeptIds)) {
            $testResultsQuery->whereHas('user', function ($uq) use ($filterDeptIds) {
                $uq->whereIn('department_id', $filterDeptIds);
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
            $attempts->each(function($att) use ($test) {
                $att->setRelation('test', $test);
            });

            $totalAttempts = $attempts->count();
            $totalQuestions = (int) ($test->questions_count ?? ($test->relationLoaded('questions') ? $test->questions->count() : ($test ? $test->questions()->count() : 0)));
            $processedUserTests[$key] = true;

            $deptInfo = $resolveDeptInfo($user);

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
                    'company' => $deptInfo['company'],
                    'department' => $deptInfo['department'],
                    'email' => $user->email,
                    'course_code' => $courseCode,
                    'course_title' => $courseTitle,
                    'study_time' => $bestAtt->formatted_duration ?: 'Chưa ghi nhận',
                    'learning_status' => 'Chưa hoàn thành',
                    'attempts_count' => $totalAttempts,
                    'attempt_status' => 'Lần ' . ($bestIndex + 1),
                    'test_date' => $formatTestDate($bestAtt->completed_at ?: $bestAtt->created_at),
                    'test_duration' => $formatTestDuration($bestAtt),
                    'score' => $formatScore($bestAtt->score, $totalQuestions),
                    'result' => $bestAtt->is_passed ? 'Đạt' : 'Không đạt',
                    'completed_at' => $bestAtt->completed_at ?: $bestAtt->created_at,
                    'test_timestamp' => $getTimestamp($bestAtt->completed_at ?: $bestAtt->created_at),
                    'activity_timestamp' => $getTimestamp($bestAtt->completed_at ?: $bestAtt->created_at),
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
                    'company' => $deptInfo['company'],
                    'department' => $deptInfo['department'],
                    'email' => $user->email,
                    'course_code' => $courseCode,
                    'course_title' => $courseTitle,
                    'study_time' => $latestAtt->formatted_duration ?: 'Chưa ghi nhận',
                    'learning_status' => 'Chưa hoàn thành',
                    'attempts_count' => $totalAttempts,
                    'attempt_status' => 'Lần ' . ($lastIndex + 1),
                    'test_date' => $formatTestDate($latestAtt->completed_at ?: $latestAtt->created_at),
                    'test_duration' => $formatTestDuration($latestAtt),
                    'score' => $formatScore($latestAtt->score, $totalQuestions),
                    'result' => $latestAtt->is_passed ? 'Đạt' : 'Không đạt',
                    'completed_at' => $latestAtt->completed_at ?: $latestAtt->created_at,
                    'test_timestamp' => $getTimestamp($latestAtt->completed_at ?: $latestAtt->created_at),
                    'activity_timestamp' => $getTimestamp($latestAtt->completed_at ?: $latestAtt->created_at),
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
                        'company' => $deptInfo['company'],
                        'department' => $deptInfo['department'],
                        'email' => $user->email,
                        'course_code' => $courseCode,
                        'course_title' => $courseTitle,
                        'study_time' => $att->formatted_duration ?: 'Chưa ghi nhận',
                        'learning_status' => 'Chưa hoàn thành',
                        'attempts_count' => $totalAttempts,
                        'attempt_status' => 'Lần ' . ($idx + 1),
                        'test_date' => $formatTestDate($att->completed_at ?: $att->created_at),
                        'test_duration' => $formatTestDuration($att),
                        'score' => $formatScore($att->score, $totalQuestions),
                        'result' => $att->is_passed ? 'Đạt' : 'Không đạt',
                        'completed_at' => $att->completed_at ?: $att->created_at,
                        'test_timestamp' => $getTimestamp($att->completed_at ?: $att->created_at),
                        'activity_timestamp' => $getTimestamp($att->completed_at ?: $att->created_at),
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
                    str_contains(mb_strtolower($row['company'], 'UTF-8'), $searchLower) ||
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

        // 3.5. Sắp xếp theo thời gian làm bài gần nhất (mới nhất lên đầu)
        usort($filteredRows, function ($a, $b) {
            $timeA = $a['test_timestamp'] ?? 0;
            $timeB = $b['test_timestamp'] ?? 0;

            // 1. Bài làm có thời gian làm bài gần nhất lên đầu
            if ($timeA !== $timeB) {
                return $timeB <=> $timeA;
            }

            // 2. Nếu cùng thời gian thi hoặc cả 2 chưa thi: Sắp xếp theo thời gian học/hoạt động gần nhất
            $actA = $a['activity_timestamp'] ?? 0;
            $actB = $b['activity_timestamp'] ?? 0;
            if ($actA !== $actB) {
                return $actB <=> $actA;
            }

            // 3. Fallback theo user_id
            return ($b['user_id'] ?? 0) <=> ($a['user_id'] ?? 0);
        });

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
