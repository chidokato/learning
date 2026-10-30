<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class DepartmentController extends Controller
{
    public function index(Request $request): View
    {
        $departmentTree = Department::query()
            ->whereNull('parent_id')
            ->orderBy('sort_order')
            ->orderBy('name')
            ->with(['childrenTree', 'users'])
            ->get();

        $totalDepartments = Department::count();

        return view('backend.departments.index', compact('departmentTree', 'totalDepartments'));
    }

    public function create(Request $request): View
    {
        $parentId = $request->query('parent_id');
        $parentOptions = $this->getParentOptions();

        return view('backend.departments.create', compact('parentOptions', 'parentId'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'code' => ['nullable', 'string', 'max:50'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:departments,slug'],
            'parent_id' => ['nullable', 'exists:departments,id'],
            'description' => ['nullable', 'string'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]);

        $slugInput = $validated['slug'] ?? '';
        $slug = ! empty($slugInput) ? Str::slug($slugInput) : Str::slug($validated['name']);
        $slug = $this->generateUniqueSlug($slug);

        Department::create([
            'parent_id' => $validated['parent_id'] ?? null,
            'name' => $validated['name'],
            'code' => $validated['code'] ?? null,
            'slug' => $slug,
            'description' => $validated['description'] ?? null,
            'sort_order' => $validated['sort_order'] ?? 0,
            'is_active' => $request->boolean('is_active', true),
        ]);

        return redirect()
            ->route('backend.departments.index')
            ->with('success', 'Thêm phòng ban thành công.');
    }

    public function edit(Department $department): View
    {
        $parentOptions = $this->getParentOptions($department);

        return view('backend.departments.edit', compact('department', 'parentOptions'));
    }

    public function update(Request $request, Department $department): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'code' => ['nullable', 'string', 'max:50'],
            'slug' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('departments', 'slug')->ignore($department->id),
            ],
            'parent_id' => [
                'nullable',
                'exists:departments,id',
                function ($attribute, $value, $fail) use ($department) {
                    if ((int) $value === (int) $department->id) {
                        $fail('Phòng ban cha không thể là chính nó.');
                    }
                    if ($value && $this->isDescendant($department, (int) $value)) {
                        $fail('Phòng ban cha không thể là phòng ban con của chính nó.');
                    }
                },
            ],
            'description' => ['nullable', 'string'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]);

        $slugInput = $validated['slug'] ?? '';
        $slug = ! empty($slugInput) ? Str::slug($slugInput) : Str::slug($validated['name']);
        $slug = $this->generateUniqueSlug($slug, $department->id);

        $department->update([
            'parent_id' => $validated['parent_id'] ?? null,
            'name' => $validated['name'],
            'code' => $validated['code'] ?? null,
            'slug' => $slug,
            'description' => $validated['description'] ?? null,
            'sort_order' => $validated['sort_order'] ?? 0,
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()
            ->route('backend.departments.index')
            ->with('success', 'Cập nhật phòng ban thành công.');
    }

    public function destroy(Department $department): RedirectResponse
    {
        if ($department->children()->exists()) {
            return redirect()
                ->route('backend.departments.index')
                ->with('error', 'Không thể xóa phòng ban đang có phòng ban trực thuộc.');
        }

        if ($department->users()->exists()) {
            return redirect()
                ->route('backend.departments.index')
                ->with('error', 'Không thể xóa phòng ban đang có nhân viên.');
        }

        $department->delete();

        return redirect()
            ->route('backend.departments.index')
            ->with('success', 'Xóa phòng ban thành công.');
    }

    public function toggleStatus(Department $department): JsonResponse
    {
        $department->update(['is_active' => ! $department->is_active]);

        return response()->json([
            'is_active' => $department->is_active,
            'label' => $department->is_active ? 'Hiển thị' : 'Ẩn',
            'message' => 'Cập nhật trạng thái thành công.',
        ]);
    }

    public function updateSortOrder(Request $request, Department $department): JsonResponse
    {
        $validated = $request->validate([
            'sort_order' => ['required', 'integer', 'min:0'],
        ]);

        $department->update(['sort_order' => $validated['sort_order']]);

        return response()->json([
            'sort_order' => $department->sort_order,
            'message' => 'Cập nhật thứ tự thành công.',
        ]);
    }

    protected function getParentOptions(?Department $excludeDepartment = null): array
    {
        $query = Department::query()
            ->whereNull('parent_id')
            ->orderBy('sort_order')
            ->orderBy('name')
            ->with('childrenTree');

        return $this->buildDepartmentOptions($query->get(), 0, $excludeDepartment);
    }

    protected function buildDepartmentOptions($departments, int $level = 0, ?Department $excludeDepartment = null): array
    {
        $result = [];

        foreach ($departments as $dept) {
            if ($excludeDepartment && ((int) $dept->id === (int) $excludeDepartment->id || $this->isDescendant($excludeDepartment, (int) $dept->id))) {
                continue;
            }

            $prefix = str_repeat('— ', $level);
            $codeTag = $dept->code ? " [{$dept->code}]" : '';
            $result[$dept->id] = $prefix . $dept->name . $codeTag;

            if ($dept->children_tree && $dept->children_tree->isNotEmpty()) {
                $result += $this->buildDepartmentOptions($dept->children_tree, $level + 1, $excludeDepartment);
            }
        }

        return $result;
    }

    protected function isDescendant(Department $department, int $targetId): bool
    {
        if (! $department->relationLoaded('childrenTree')) {
            $department->load('childrenTree');
        }

        foreach ($department->children_tree as $child) {
            if ((int) $child->id === $targetId || $this->isDescendant($child, $targetId)) {
                return true;
            }
        }

        return false;
    }

    protected function generateUniqueSlug(string $slug, ?int $ignoreId = null): string
    {
        $originalSlug = $slug;
        $count = 1;

        while (
            Department::query()
                ->where('slug', $slug)
                ->when($ignoreId, fn ($query) => $query->where('id', '!=', $ignoreId))
                ->exists()
        ) {
            $slug = "{$originalSlug}-{$count}";
            $count++;
        }

        return $slug;
    }
}
