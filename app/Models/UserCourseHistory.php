<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserCourseHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'post_id',
        'last_learned_at',
        'study_time_seconds',
        'current_page',
        'total_pages',
        'completed_slides',
        'progress_percent',
        'completed_at',
    ];

    protected $casts = [
        'last_learned_at' => 'datetime',
        'completed_at' => 'datetime',
        'study_time_seconds' => 'integer',
        'current_page' => 'integer',
        'total_pages' => 'integer',
        'completed_slides' => 'array',
        'progress_percent' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    /**
     * Kiểm tra trạng thái hoàn thành khóa học:
     * - Có completed_at
     * - Hoặc progress_percent >= 100
     * - Hoặc đã đọc đến trang cuối (current_page >= total_pages)
     */
    public function getIsCompletedAttribute(): bool
    {
        return (bool) ($this->completed_at 
            || ($this->progress_percent ?? 0) >= 100 
            || ($this->total_pages > 0 && ($this->current_page ?? 0) >= $this->total_pages));
    }

    /**
     * Lấy tiến độ phần trăm hiển thị (nếu đã hoàn thành thì luôn là 100%)
     */
    public function getEffectiveProgressPercentAttribute(): int
    {
        if ($this->is_completed) {
            return 100;
        }

        return (int) ($this->progress_percent ?? 0);
    }

    /**
     * Định dạng thời gian học thân thiện (ví dụ: "1 giờ 25 phút", "45 phút", "30 giây")
     */
    public function getFormattedStudyTimeAttribute(): string
    {
        $seconds = (int) ($this->study_time_seconds ?? 0);
        if ($seconds < 60) {
            return "{$seconds} giây";
        }

        $minutes = (int) floor($seconds / 60);
        $remainingSeconds = $seconds % 60;

        if ($minutes < 60) {
            return $remainingSeconds > 0 ? "{$minutes} phút {$remainingSeconds}s" : "{$minutes} phút";
        }

        $hours = (int) floor($minutes / 60);
        $remMinutes = $minutes % 60;

        return $remMinutes > 0 ? "{$hours} giờ {$remMinutes} phút" : "{$hours} giờ";
    }

    /**
     * Danh sách slide đã đọc xong (mảng số nguyên các trang)
     */
    public function getCompletedSlidesArrayAttribute(): array
    {
        $slides = $this->completed_slides;
        if (is_array($slides)) {
            return array_values(array_unique(array_filter(array_map('intval', $slides))));
        }
        if (is_string($slides) && ! empty($slides)) {
            $decoded = json_decode($slides, true);
            if (is_array($decoded)) {
                return array_values(array_unique(array_filter(array_map('intval', $decoded))));
            }
        }
        return [];
    }
}
