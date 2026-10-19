<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    use HasFactory;
    
    public const TYPE_COURSE = 'course';
    public const TYPE_TEST = 'test';

    protected $fillable = ['type', 'name', 'slug', 'seo_title', 'seo_description'];

    public static function types(): array
    {
        return [
            self::TYPE_COURSE => 'Khóa học',
            self::TYPE_TEST => 'Bài kiểm tra',
        ];
    }

    public function scopeCourse($query)
    {
        return $query->where('type', self::TYPE_COURSE);
    }

    public function scopeTest($query)
    {
        return $query->where('type', self::TYPE_TEST);
    }

    public function posts()
    {
        return $this->belongsToMany(Post::class);
    }

    public function tests()
    {
        return $this->belongsToMany(Test::class, 'test_topic');
    }
}
