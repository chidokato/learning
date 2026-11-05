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
        $pdfReady = $request->boolean('pdf_ready', false);

        $rawSlides = $request->input('completed_slides', []);
        if (is_string($rawSlides)) {
            $rawSlides = json_decode($rawSlides, true) ?? [];
        }
        $clientCompletedSlides = is_array($rawSlides) ? array_map('intval', $rawSlides) : [];

        if (auth()->check()) {
            $userId = auth()->id();

            $history = UserCourseHistory::firstOrCreate(
                ['user_id' => $userId, 'post_id' => $post->id],
                [
                    'last_learned_at' => now(),
                    'study_time_seconds' => 0,
                    'current_page' => 1,
                    'total_pages' => $totalPages,
                    'completed_slides' => [],
                    'progress_percent' => 0,
                ]
            );

            // Cập nhật tổng số slide chính xác theo tài liệu hiện tại:
            // Không dùng max() vì khi cập nhật PDF có ít trang hơn (vd từ 35 xuống 34 trang),
            // hàm max() sẽ làm kẹt số trang cũ khiến học viên không thể đạt 100%.
            if ($pdfReady && $totalPages > 0) {
                $history->total_pages = $totalPages;
            } elseif ($totalPages > 1) {
                $history->total_pages = $totalPages;
            } elseif (empty($history->total_pages) && $totalPages > 0) {
                $history->total_pages = $totalPages;
            }

            // Đảm bảo current_page không vượt quá total_pages
            if ($history->total_pages > 0 && $currentPage > $history->total_pages) {
                $currentPage = $history->total_pages;
            }

            // Cộng dồn thời gian học thực tế
            $history->study_time_seconds = ((int) $history->study_time_seconds) + $activeSeconds;
            $history->current_page = $currentPage;
            $history->last_learned_at = now();

            // Hợp nhất danh sách slide đã đọc xong (mỗi slide tối thiểu 5s)
            $existingSlides = $history->completed_slides_array;
            $allCompletedSlides = array_values(array_unique(array_filter(
                array_merge($existingSlides, $clientCompletedSlides),
                fn ($p) => $p >= 1 && ($history->total_pages <= 0 || $p <= $history->total_pages)
            )));
            sort($allCompletedSlides);
            $history->completed_slides = $allCompletedSlides;

            $completedSlidesCount = count($allCompletedSlides);
            $minRequiredSeconds = $history->total_pages * 5;

            // Đã xem hết tất cả các slide của bài học
            $isAllSlidesRead = ($history->total_pages > 0 && (
                $completedSlidesCount >= $history->total_pages ||
                ($currentPage >= $history->total_pages && $completedSlidesCount >= ($history->total_pages - 1))
            ));
            $isSufficientTime = ($history->study_time_seconds >= $minRequiredSeconds);

            $calculatedPercent = $history->total_pages > 0
                ? (int) round(($completedSlidesCount / $history->total_pages) * 100)
                : 0;

            if ($isAllSlidesRead) {
                // Đã đọc xong tất cả các slide -> Hoàn thành 100%
                $history->progress_percent = 100;
                $history->current_page = $history->total_pages;
                if (! $history->completed_at) {
                    $history->completed_at = now();
                }
                if ($history->study_time_seconds < $minRequiredSeconds) {
                    $history->study_time_seconds = $minRequiredSeconds;
                }
            } else {
                // Chưa hoàn thành tất cả các slide -> tối đa 99%
                $history->progress_percent = min(99, $calculatedPercent);
                $history->completed_at = null;
            }

            $history->save();

            return response()->json([
                'success' => true,
                'logged_in' => true,
                'study_time_seconds' => $history->study_time_seconds,
                'formatted_time' => $history->formatted_study_time,
                'progress_percent' => $history->progress_percent,
                'completed_slides' => $history->completed_slides_array,
                'completed_count' => $completedSlidesCount,
                'min_required_seconds' => $minRequiredSeconds,
                'is_all_slides_read' => $isAllSlidesRead,
                'is_sufficient_time' => $isSufficientTime,
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
            'completed_slides' => [],
            'progress_percent' => 0,
            'completed_at' => null,
        ]);

        $data['study_time_seconds'] = ((int) ($data['study_time_seconds'] ?? 0)) + $activeSeconds;
        $data['current_page'] = $currentPage;
        if ($pdfReady && $totalPages > 0) {
            $data['total_pages'] = $totalPages;
        } elseif ($totalPages > 1) {
            $data['total_pages'] = $totalPages;
        }

        if (!empty($data['total_pages']) && $data['current_page'] > $data['total_pages']) {
            $data['current_page'] = $data['total_pages'];
        }

        $guestExisting = is_array($data['completed_slides'] ?? null) ? $data['completed_slides'] : [];
        $guestMerged = array_values(array_unique(array_filter(
            array_merge($guestExisting, $clientCompletedSlides),
            fn ($p) => $p >= 1 && ($data['total_pages'] <= 0 || $p <= $data['total_pages'])
        )));
        sort($guestMerged);
        $data['completed_slides'] = $guestMerged;

        $completedSlidesCount = count($guestMerged);
        $minRequiredSeconds = $data['total_pages'] * 5;
        $isAllSlidesRead = ($data['total_pages'] > 0 && (
            $completedSlidesCount >= $data['total_pages'] ||
            ($currentPage >= $data['total_pages'] && $completedSlidesCount >= ($data['total_pages'] - 1))
        ));
        $isSufficientTime = ($data['study_time_seconds'] >= $minRequiredSeconds);
        $calculatedPercent = $data['total_pages'] > 0
            ? (int) round(($completedSlidesCount / $data['total_pages'] * 100))
            : 0;

        if ($isAllSlidesRead) {
            $data['progress_percent'] = 100;
            $data['current_page'] = $data['total_pages'];
            $data['completed_at'] = now()->toIso8601String();
            if ($data['study_time_seconds'] < $minRequiredSeconds) {
                $data['study_time_seconds'] = $minRequiredSeconds;
            }
        } else {
            $data['progress_percent'] = min(99, $calculatedPercent);
            $data['completed_at'] = null;
        }

        session()->put($sessionKey, $data);

        return response()->json([
            'success' => true,
            'logged_in' => false,
            'study_time_seconds' => $data['study_time_seconds'],
            'progress_percent' => $data['progress_percent'],
            'completed_slides' => $guestMerged,
            'completed_count' => $completedSlidesCount,
            'min_required_seconds' => $minRequiredSeconds,
            'is_all_slides_read' => $isAllSlidesRead,
            'is_sufficient_time' => $isSufficientTime,
            'current_page' => $data['current_page'],
            'total_pages' => $data['total_pages'],
            'completed' => ($data['progress_percent'] >= 100),
        ]);
    }
}
