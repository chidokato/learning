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
    ];

    protected $casts = [
        'last_learned_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
