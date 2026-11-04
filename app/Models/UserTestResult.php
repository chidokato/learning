<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserTestResult extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'test_id',
        'score',
        'is_passed',
        'duration_seconds',
        'completed_at',
        'user_answers',
    ];

    protected $casts = [
        'is_passed' => 'boolean',
        'duration_seconds' => 'integer',
        'completed_at' => 'datetime',
        'user_answers' => 'array',
    ];

    /**
     * Định dạng thời lượng làm bài (Ví dụ: 12 phút 35 giây, 45 giây, 1 giờ 15 phút)
     */
    public function getFormattedDurationAttribute(): ?string
    {
        if ($this->duration_seconds === null) {
            return null;
        }

        $seconds = (int) $this->duration_seconds;
        if ($seconds < 0) {
            return null;
        }

        if ($seconds < 60) {
            return $seconds . ' giây';
        }

        $hours = floor($seconds / 3600);
        $minutes = floor(($seconds % 3600) / 60);
        $remainingSeconds = $seconds % 60;

        $parts = [];
        if ($hours > 0) {
            $parts[] = $hours . ' giờ';
        }
        if ($minutes > 0) {
            $parts[] = $minutes . ' phút';
        }
        if ($remainingSeconds > 0 && $hours == 0) {
            $parts[] = $remainingSeconds . ' giây';
        }

        return !empty($parts) ? implode(' ', $parts) : '0 giây';
    }

    public function test()
    {
        return $this->belongsTo(Test::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
