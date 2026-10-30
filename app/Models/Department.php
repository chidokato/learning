<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

class Department extends Model
{
    use HasFactory;

    protected $fillable = [
        'parent_id',
        'name',
        'code',
        'slug',
        'description',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id')
            ->orderBy('sort_order')
            ->orderBy('name');
    }

    public function childrenTree(): HasMany
    {
        return $this->children()->with('childrenTree');
    }

    public function getChildrenTreeAttribute()
    {
        return $this->getRelationValue('childrenTree');
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'department_id');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Get all descendant department IDs (recursive).
     */
    public function getAllDescendantIds(): array
    {
        $ids = [];
        foreach ($this->children as $child) {
            $ids[] = $child->id;
            $ids = array_merge($ids, $child->getAllDescendantIds());
        }
        return $ids;
    }

    /**
     * Total users count including all sub-departments.
     */
    public function getTotalUsersCountAttribute(): int
    {
        $allIds = array_merge([$this->id], $this->getAllDescendantIds());
        return User::whereIn('department_id', $allIds)->count();
    }

    /**
     * Get department hierarchy breadcrumb name.
     */
    public function getBreadcrumbAttribute(): string
    {
        $trail = [$this->name];
        $current = $this;
        while ($current->parent) {
            $current = $current->parent;
            array_unshift($trail, $current->name);
        }
        return implode(' » ', $trail);
    }

    /**
     * Get tree options formatted for select dropdowns.
     */
    public static function getTreeOptions(?int $excludeId = null): array
    {
        $roots = self::query()
            ->whereNull('parent_id')
            ->orderBy('sort_order')
            ->orderBy('name')
            ->with('childrenTree')
            ->get();

        return self::formatTreeOptions($roots, 0, $excludeId);
    }

    protected static function formatTreeOptions($departments, int $level = 0, ?int $excludeId = null): array
    {
        $options = [];
        foreach ($departments as $dept) {
            if ($excludeId && (int) $dept->id === (int) $excludeId) {
                continue;
            }
            $prefix = str_repeat('— ', $level);
            $code = $dept->code ? " [{$dept->code}]" : '';
            $options[$dept->id] = $prefix . $dept->name . $code;

            if ($dept->children_tree && $dept->children_tree->isNotEmpty()) {
                $options += self::formatTreeOptions($dept->children_tree, $level + 1, $excludeId);
            }
        }
        return $options;
    }
}
