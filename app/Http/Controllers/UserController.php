<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(Request $request): View
    {
        $query = User::query()->with('department');

        if ($request->filled('department_id')) {
            $department = Department::find($request->input('department_id'));
            if ($department) {
                $deptIds = array_merge([$department->id], $department->getAllDescendantIds());
                $query->whereIn('department_id', $deptIds);
            }
        }

        if ($request->filled('search')) {
            $keyword = trim($request->input('search'));
            $query->where(function ($q) use ($keyword) {
                $q->where('name', 'like', "%{$keyword}%")
                    ->orWhere('email', 'like', "%{$keyword}%")
                    ->orWhere('phone', 'like', "%{$keyword}%")
                    ->orWhere('job_title', 'like', "%{$keyword}%");
            });
        }

        if ($request->filled('permission')) {
            $query->where('permission', $request->input('permission'));
        }

        $perPage = (int) $request->input('per_page', 20);
        if ($perPage <= 0 || $perPage > 200) {
            $perPage = 20;
        }

        $users = $query->latest()->paginate($perPage)->withQueryString();
        $departmentOptions = Department::getTreeOptions();

        return view('backend.users.index', compact('users', 'departmentOptions'));
    }

    public function create(): View
    {
        $departmentOptions = Department::getTreeOptions();

        return view('backend.users.create', compact('departmentOptions'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'department_id' => ['nullable', 'exists:departments,id'],
            'job_title' => ['nullable', 'string', 'max:255'],
            'bio' => ['nullable', 'string'],
            'address' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'secondary_phone' => ['nullable', 'string', 'max:50'],
            'whatsapp_phone' => ['nullable', 'string', 'max:50'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'avatar_file' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,gif', 'max:2048'],
            'remove_avatar' => ['nullable'],
            'permission' => ['required', 'integer', 'in:1,2,3,4,5,6'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);

        $avatarPath = null;

        if ($request->hasFile('avatar_file')) {
            $avatarPath = $this->storeAvatar($request->file('avatar_file'));
        }

        User::create([
            'name' => $validated['name'],
            'department_id' => $validated['department_id'] ?? null,
            'job_title' => $validated['job_title'] ?? null,
            'bio' => $validated['bio'] ?? null,
            'address' => $validated['address'] ?? null,
            'phone' => $validated['phone'] ?? null,
            'secondary_phone' => $validated['secondary_phone'] ?? null,
            'whatsapp_phone' => $validated['whatsapp_phone'] ?? null,
            'avatar' => $avatarPath,
            'permission' => $validated['permission'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()
            ->route('backend.users.index')
            ->with('success', 'Them user thanh cong.');
    }

    public function edit(User $user): View
    {
        $departmentOptions = Department::getTreeOptions();

        return view('backend.users.edit', compact('user', 'departmentOptions'));
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'department_id' => ['nullable', 'exists:departments,id'],
            'job_title' => ['nullable', 'string', 'max:255'],
            'bio' => ['nullable', 'string'],
            'address' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'secondary_phone' => ['nullable', 'string', 'max:50'],
            'whatsapp_phone' => ['nullable', 'string', 'max:50'],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user->id),
            ],
            'avatar_file' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,gif', 'max:2048'],
            'remove_avatar' => ['nullable'],
            'permission' => ['required', 'integer', 'in:1,2,3,4,5,6'],
            'password' => ['nullable', 'string', 'min:6', 'confirmed'],
        ]);

        $avatarPath = $user->avatar;

        if ($request->boolean('remove_avatar') && $avatarPath) {
            $this->deleteAvatarIfExists($avatarPath);
            $avatarPath = null;
        }

        if ($request->hasFile('avatar_file')) {
            $this->deleteAvatarIfExists($avatarPath);
            $avatarPath = $this->storeAvatar($request->file('avatar_file'));
        }

        $data = [
            'name' => $validated['name'],
            'department_id' => $validated['department_id'] ?? null,
            'job_title' => $validated['job_title'] ?? null,
            'bio' => $validated['bio'] ?? null,
            'address' => $validated['address'] ?? null,
            'phone' => $validated['phone'] ?? null,
            'secondary_phone' => $validated['secondary_phone'] ?? null,
            'whatsapp_phone' => $validated['whatsapp_phone'] ?? null,
            'avatar' => $avatarPath,
            'permission' => $validated['permission'],
            'email' => $validated['email'],
        ];

        if (! empty($validated['password'])) {
            $data['password'] = Hash::make($validated['password']);
        }

        $user->update($data);

        return redirect()
            ->route('backend.users.index')
            ->with('success', 'Cap nhat user thanh cong.');
    }

    public function destroy(User $user): RedirectResponse
    {
        if (auth()->id() === $user->id) {
            return redirect()
                ->route('backend.users.index')
                ->with('error', 'Khong the xoa tai khoan dang dang nhap.');
        }

        $this->deleteAvatarIfExists($user->avatar);
        $user->delete();

        return redirect()
            ->route('backend.users.index')
            ->with('success', 'Xoa user thanh cong.');
    }

    protected function storeAvatar($file): string
    {
        $directory = public_path('uploads/users');

        if (! File::isDirectory($directory)) {
            File::makeDirectory($directory, 0755, true);
        }

        $filename = 'avatar-' . Str::random(20) . '.' . strtolower($file->getClientOriginalExtension());
        $file->move($directory, $filename);

        return 'uploads/users/' . $filename;
    }

    protected function deleteAvatarIfExists(?string $path): void
    {
        if (! $path || ! Str::startsWith($path, 'uploads/users/')) {
            return;
        }

        $fullPath = public_path($path);

        if (File::exists($fullPath)) {
            File::delete($fullPath);
        }
    }

    public function quickAdd(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => 'user_' . Str::random(10) . '@example.com', // Auto generated email
            'password' => Hash::make(Str::random(16)),
            'permission' => 4, // Instructor
        ]);

        return response()->json([
            'success' => true,
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
            ]
        ]);
    }

    public function bulkUpdateDepartment(Request $request)
    {
        $validated = $request->validate([
            'user_ids' => ['required', 'array', 'min:1'],
            'user_ids.*' => ['integer', 'exists:users,id'],
            'department_id' => ['nullable'],
        ]);

        $departmentId = $request->input('department_id');
        if ($departmentId === 'none' || $departmentId === '' || $departmentId === 'null') {
            $departmentId = null;
        } else {
            $departmentId = (int) $departmentId;
            if (! Department::where('id', $departmentId)->exists()) {
                if ($request->wantsJson()) {
                    return response()->json(['success' => false, 'message' => 'Phòng ban không tồn tại.'], 422);
                }
                return redirect()->back()->with('error', 'Phòng ban được chọn không tồn tại.');
            }
        }

        $userIds = $validated['user_ids'];
        $count = User::whereIn('id', $userIds)->update([
            'department_id' => $departmentId,
        ]);

        $dept = $departmentId ? Department::find($departmentId) : null;
        $deptName = $dept ? $dept->name : 'Không có phòng ban (Đã gỡ)';

        $message = "Đã cập nhật phòng ban [{$deptName}] cho {$count} người dùng thành công.";

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => $message,
                'count' => $count,
                'department_id' => $departmentId,
                'department_name' => $deptName,
                'department_breadcrumb' => $dept ? $dept->breadcrumb : '',
            ]);
        }

        return redirect()->back()->with('success', $message);
    }
}
