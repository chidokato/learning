<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'subtitle',
        'button_text',
        'button_link',
        'image',
        'sort_order',
        'is_active',
    ];

    public function getImageUrlAttribute()
    {
        if (!$this->image) {
            return asset('assets/img/hero/hero-14-1.png');
        }
        
        // If it starts with 'uploads/', it's directly in the public folder
        if (str_starts_with($this->image, 'uploads/')) {
            return asset($this->image);
        }
        
        // Fallback for old images saved via storage symlink
        return asset('storage/' . $this->image);
    }
}
