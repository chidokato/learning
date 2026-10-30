<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\UserTestResult;
use App\Models\Test;
use App\Models\Department;
use App\Models\User;

class FrontendTestReportController extends Controller
{
    /**
     * Báo cáo theo dõi danh sách nhân viên làm bài kiểm tra dành cho Admin
     * Chỉ hiển thị lần làm bài có điểm cao nhất của mỗi nhân viên cho từng bài thi.
     */
    public function index(Request $request)
    {
        // 1. Kiểm tra quyền Admin
        if (!auth()->check() || !auth()->user()->isAdmin()) {
            abort(403, 'Chức năng báo cáo chỉ dành cho Quản trị viên hệ thống.');
        }

        // 2. Lấy các tham số lọc
        $search = trim($request->input('search', ''));
        $testId = $request->input('test_id', 'all');
        $departmentId = $request->input('department_id', 'all');
        $status = $request->input('status', 'all');

        // 3. Tính toán KPI tổng quan
        $totalAttempts = UserTestResult::count();
        $uniqueUsers = UserTestResult::distinct('user_id')->count('user_id');
        $passedAttempts = UserTestResult::where('is_passed', true)->count();
        $failedAttempts = $totalAttempts - $passedAttempts;
        $passRate = $totalAttempts > 0 ? round(($passedAttempts / $totalAttempts) * 100) : 0;

        $kpi = [
            'totalAttempts'  => $totalAttempts,
            'uniqueUsers'    => $uniqueUsers,
            'passedAttempts' => $passedAttempts,
            'failedAttempts' => $failedAttempts,
            'passRate'       => $passRate,
        ];

        // 4. Lấy lượt làm bài có điểm số cao nhất của mỗi nhân viên cho từng bài test
        $bestSubquery = DB::table('user_test_results')
            ->selectRaw("
                SUBSTRING_INDEX(GROUP_CONCAT(id ORDER BY score DESC, completed_at DESC, id DESC), ',', 1) as best_id,
                COUNT(*) as attempts_count
            ")
            ->groupBy('user_id', 'test_id');

        $query = UserTestResult::query()
            ->joinSub($bestSubquery, 'best_attempts', function ($join) {
                $join->on('user_test_results.id', '=', 'best_attempts.best_id');
            })
            ->select('user_test_results.*', 'best_attempts.attempts_count')
            ->with([
                'user' => function($q) {
                    $q->select('id', 'name', 'email', 'avatar', 'employee_code', 'department_id');
                },
                'user.department:id,name',
                'test' => function($q) {
                    $q->withCount('questions');
                },
                'test.post:id,title,slug',
            ])
            ->orderByDesc('user_test_results.id');

        // Lọc theo từ khóa tìm kiếm (Tên NV, Email, Mã NV, Tên bài test)
        if ($search !== '') {
            $query->where(function($q) use ($search) {
                $q->whereHas('user', function($uq) use ($search) {
                    $uq->where('name', 'like', "%{$search}%")
                       ->orWhere('email', 'like', "%{$search}%")
                       ->orWhere('employee_code', 'like', "%{$search}%");
                })->orWhereHas('test', function($tq) use ($search) {
                    $tq->where('title', 'like', "%{$search}%");
                });
            });
        }

        // Lọc theo Bài kiểm tra cụ thể
        if ($testId !== 'all' && !empty($testId)) {
            $query->where('user_test_results.test_id', (int)$testId);
        }

        // Lọc theo Phòng ban
        if ($departmentId !== 'all' && !empty($departmentId)) {
            $query->whereHas('user', function($uq) use ($departmentId) {
                $uq->where('department_id', (int)$departmentId);
            });
        }

        // Lọc theo Kết quả (Đạt / Chưa đạt)
        if ($status === 'passed') {
            $query->where('user_test_results.is_passed', true);
        } elseif ($status === 'failed') {
            $query->where('user_test_results.is_passed', false);
        }

        // Phân trang 15 kết quả / trang kèm giữ nguyên query params
        $results = $query->paginate(15)->withQueryString();

        // 5. Lấy danh sách dropdown lọc
        $allTests = Test::orderBy('title')->get(['id', 'title']);
        $departments = Department::orderBy('name')->get(['id', 'name']);

        return view('frontend.admin.reports.tests', compact(
            'results',
            'kpi',
            'allTests',
            'departments',
            'search',
            'testId',
            'departmentId',
            'status'
        ));
    }

    /**
     * API lấy danh sách toàn bộ các lần làm bài của một nhân viên đối với một bài test (cho popup)
     */
    public function userTestHistory(Request $request)
    {
        // 1. Kiểm tra quyền Admin
        if (!auth()->check() || !auth()->user()->isAdmin()) {
            return response()->json([
                'success' => false,
                'message' => 'Bạn không có quyền truy cập.'
            ], 403);
        }

        $userId = (int) $request->input('user_id');
        $testId = (int) $request->input('test_id');

        $user = User::select('id', 'name', 'email', 'avatar', 'employee_code', 'department_id')
            ->with('department:id,name')
            ->find($userId);

        $test = Test::withCount('questions')->with('post:id,title,slug')->find($testId);

        if (!$user || !$test) {
            return response()->json([
                'success' => false,
                'message' => 'Không tìm thấy thông tin nhân viên hoặc bài kiểm tra.'
            ], 404);
        }

        $attempts = UserTestResult::where('user_id', $userId)
            ->where('test_id', $testId)
            ->orderBy('id', 'asc')
            ->get();

        $maxScore = $attempts->max('score');
        $totalQuestions = $test->questions_count ?? $test->questions()->count();

        // Đánh số thứ tự Lần 1..N theo thời gian, sau đó đảo ngược để hiển thị lần mới nhất lên đầu
        $attemptList = $attempts->values()->map(function ($att, $index) use ($totalQuestions, $maxScore) {
            $pct = $totalQuestions > 0 ? round(($att->score / $totalQuestions) * 100) : 0;
            return [
                'id' => $att->id,
                'attempt_number' => $index + 1,
                'score' => $att->score,
                'total_questions' => $totalQuestions,
                'percentage' => $pct,
                'is_passed' => (bool) $att->is_passed,
                'is_best' => ($att->score == $maxScore),
                'completed_at' => $att->completed_at 
                    ? $att->completed_at->timezone('Asia/Ho_Chi_Minh')->format('H:i d/m/Y')
                    : ($att->created_at ? $att->created_at->timezone('Asia/Ho_Chi_Minh')->format('H:i d/m/Y') : 'N/A'),
                'view_url' => route('frontend.tests.result', $att->id),
            ];
        })->reverse()->values();

        $userAvatar = !empty($user->avatar)
            ? (Str::startsWith($user->avatar, ['http://', 'https://']) ? $user->avatar : asset($user->avatar))
            : null;

        return response()->json([
            'success' => true,
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'employee_code' => $user->employee_code,
                'department_name' => $user->department->name ?? null,
                'avatar' => $userAvatar,
            ],
            'test' => [
                'id' => $test->id,
                'title' => $test->title,
                'pass_score' => $test->pass_score,
                'total_questions' => $totalQuestions,
                'course_title' => $test->post->title ?? null,
            ],
            'stats' => [
                'total_attempts' => $attempts->count(),
                'max_score' => $maxScore,
                'has_passed' => $attempts->contains('is_passed', true),
            ],
            'attempts' => $attemptList,
        ]);
    }
}
