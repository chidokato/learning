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
        'progress_percent',
        'completed_at',
    ];

    protected $casts = [
        'last_learned_at' => 'datetime',
        'completed_at' => 'datetime',
        'study_time_seconds' => 'integer',
        'current_page' => 'integer',
        'total_pages' => 'integer',
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
}
