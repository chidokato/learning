<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function questions()
    {
        return $this->hasMany(Question::class)->orderBy('order');
    }

    public function post()
    {
        return $this->belongsTo(Post::class, 'post_id');
    }

    public function results()
    {
        return $this->hasMany(UserTestResult::class, 'test_id');
    }

    public function topic()
    {
        return $this->belongsTo(Topic::class, 'topic_id');
    }

    public function topics()
    {
        return $this->belongsToMany(Topic::class, 'test_topic');
    }
}
