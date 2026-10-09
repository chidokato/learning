<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    use HasFactory;
    
    protected $fillable = ['name', 'slug', 'seo_title', 'seo_description'];

    public function posts()
    {
        return $this->belongsToMany(Post::class);
    }
}
