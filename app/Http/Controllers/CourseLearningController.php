<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\UserCourseHistory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CourseLearningController extends Controller
{
    /**
     * Nhận heartbeat ghi nhận thời gian học và tiến trình học thực tế
     */
    public function trackLearning(Request $request, string $slug): JsonResponse
    {
        $cleanSlug = trim(urldecode($slug));
        $post = Post::where('slug', $cleanSlug)->first();

        if (! $post) {
            return response()->json(['success' => false, 'message' => 'Không tìm thấy bài học'], 404);
        }

        $activeSeconds = min(60, max(0, (int) $request->input('active_seconds', 0)));
        $currentPage = max(1, (int) $request->input('current_page', 1));
        $totalPages = max(1, (int) $request->input('total_pages', 1));
        $clientProgress = min(100, max(0, (int) $request->input('progress_percent', 0)));

        if (auth()->check()) {
            $userId = auth()->id();

            $history = UserCourseHistory::firstOrCreate(
                ['user_id' => $userId, 'post_id' => $post->id],
                [
                    'last_learned_at' => now(),
                    'study_time_seconds' => 0,
                    'current_page' => 1,
                    'total_pages' => $totalPages,
                    'progress_percent' => 0,
                ]
            );

            // Cộng dồn thời gian học thực tế
            $history->study_time_seconds = ((int) $history->study_time_seconds) + $activeSeconds;
            $history->current_page = $currentPage;
            $history->total_pages = max((int) $history->total_pages, $totalPages);
            $history->last_learned_at = now();

            // Luôn lưu tiến độ cao nhất mà người học đã đạt được
            $history->progress_percent = max((int) $history->progress_percent, $clientProgress);

            if ($history->progress_percent >= 100 && ! $history->completed_at) {
                $history->completed_at = now();
            }

            $history->save();

            return response()->json([
                'success' => true,
                'logged_in' => true,
                'study_time_seconds' => $history->study_time_seconds,
                'formatted_time' => $history->formatted_study_time,
                'progress_percent' => $history->progress_percent,
                'current_page' => $history->current_page,
                'total_pages' => $history->total_pages,
                'completed' => (bool) $history->completed_at,
            ]);
        }

        // Người dùng chưa đăng nhập (Khách) -> Lưu tạm vào session
        $sessionKey = "guest_learning_{$post->id}";
        $data = session()->get($sessionKey, [
            'study_time_seconds' => 0,
            'current_page' => 1,
            'total_pages' => $totalPages,
            'progress_percent' => 0,
        ]);

        $data['study_time_seconds'] = ((int) $data['study_time_seconds']) + $activeSeconds;
        $data['current_page'] = $currentPage;
        $data['total_pages'] = max((int) $data['total_pages'], $totalPages);
        $data['progress_percent'] = max((int) $data['progress_percent'], $clientProgress);

        session()->put($sessionKey, $data);

        return response()->json([
            'success' => true,
            'logged_in' => false,
            'study_time_seconds' => $data['study_time_seconds'],
            'progress_percent' => $data['progress_percent'],
            'current_page' => $data['current_page'],
            'total_pages' => $data['total_pages'],
            'completed' => ($data['progress_percent'] >= 100),
        ]);
    }
}
