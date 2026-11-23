<?php

namespace App\Http\Controllers;

use App\Exports\UserSampleExport;
use App\Imports\UserImport;
use App\Models\Department;
use App\Models\SharedDbConfig;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;

class UserController extends Controller
{
    /**
     * Lấy danh sách nhân sự và phòng ban từ DB dùng chung (bảng employees & departments)
     */
    protected function getSharedEmployeesData(): array
    {
        $employees = collect();
        $employeesByCode = [];
        $departmentsMap = [];

        try {
            $config = SharedDbConfig::findActiveForTable('employees');
            if ($config) {
                $connection = $config->connectSharedDb();
                $schema = Schema::connection($config->getConnectionNameKey());
                $empTable = $config->hasSharedTable('employees') ? 'employees' : ($config->getTableNames()[0] ?? 'employees');

                if ($schema->hasTable('departments')) {
                    $departmentsMap = $connection->table('departments')
                        ->pluck('name', 'id')
                        ->toArray();
                }

                if ($schema->hasTable($empTable)) {
                    $empColumns = $schema->getColumnListing($empTable);
                    $query = $connection->table($empTable);

                    if (in_array('deleted_at', $empColumns, true)) {
                        $query->whereNull('deleted_at');
                    }

                    $rows = $query->orderBy('name')->get();

                    foreach ($rows as $row) {
                        $deptId = $row->department_id ?? null;
                        $row->department_name = ($deptId && isset($departmentsMap[$deptId]))
                            ? $departmentsMap[$deptId]
                            : null;

                        $employees->push($row);

                        $code = trim((string) ($row->employee_code ?? ''));
                        if ($code !== '') {
                            $employeesByCode[$code] = $row;
                        }
                    }
                }
            }
        } catch (\Throwable $e) {
            // Bỏ qua nếu kết nối DB chung gặp sự cố
        }

        return [
            'employees' => $employees,
            'employeesByCode' => $employeesByCode,
            'departmentsMap' => $departmentsMap,
        ];
    }

    /**
     * Tự động liên kết các tài khoản đã có với bảng employees bên DB chung
     * dựa theo: employee_code, username (nếu lưu mã NV ở cột username), email hoặc họ tên.
     */
    protected function autoLinkUsersWithSharedEmployees(Collection $employees, array $employeesByCode): void
    {
        if ($employees->isEmpty()) {
            return;
        }

        // Danh sách mã NV đã được gắn trong bảng users
        $usedCodes = User::query()
            ->whereNotNull('employee_code')
            ->where('employee_code', '!=', '')
            ->pluck('employee_code', 'id')
            ->map(fn ($v) => trim((string) $v))
            ->toArray();

        $usedCodesSet = array_flip($usedCodes);

        // Map phụ theo email và theo họ tên (chữ thường)
        $empByEmail = [];
        $empByName = [];
        foreach ($employees as $emp) {
            $code = trim((string) ($emp->employee_code ?? ''));
            if ($code === '') {
                continue;
            }
            $mail = mb_strtolower(trim((string) ($emp->email ?? '')), 'UTF-8');
            if ($mail !== '') {
                $empByEmail[$mail] = $code;
            }
            $normName = mb_strtolower(trim((string) ($emp->name ?? '')), 'UTF-8');
            if ($normName !== '') {
                $empByName[$normName][] = $code;
            }
        }

        $unlinkedUsers = User::query()
            ->where(function ($q) {
                $q->whereNull('employee_code')->orWhere('employee_code', '');
            })
            ->get();

        foreach ($unlinkedUsers as $u) {
            $matchedCode = null;

            // 1. Nếu cột username đang chứa mã nhân viên trùng với DB chung
            $uname = trim((string) ($u->username ?? ''));
            if ($uname !== '' && isset($employeesByCode[$uname])) {
                $matchedCode = $uname;
            }

            // 2. Nếu email trùng với email của nhân sự bên DB chung
            if (! $matchedCode && ! empty($u->email)) {
                $uMail = mb_strtolower(trim((string) $u->email), 'UTF-8');
                if (isset($empByEmail[$uMail])) {
                    $matchedCode = $empByEmail[$uMail];
                } elseif (str_contains($uMail, '@')) {
                    // Trường hợp email dạng 990200000489@hcc.local
                    $localPart = explode('@', $uMail)[0];
                    if (isset($employeesByCode[$localPart])) {
                        $matchedCode = $localPart;
                    }
                }
            }

            // 3. Nếu họ tên trùng khớp duy nhất với nhân sự bên DB chung
            if (! $matchedCode && ! empty($u->name)) {
                $uName = mb_strtolower(trim((string) $u->name), 'UTF-8');
                if (isset($empByName[$uName]) && count($empByName[$uName]) === 1) {
                    $matchedCode = $empByName[$uName][0];
                }
            }

            if ($matchedCode && ! isset($usedCodesSet[$matchedCode])) {
                $u->update(['employee_code' => $matchedCode]);
                $usedCodesSet[$matchedCode] = $u->id;
            }
        }
    }

    public function index(Request $request): View
    {
        $search = trim((string) $request->input('search', ''));
        $sharedData = $this->getSharedEmployeesData();
        $employeesByCode = $sharedData['employeesByCode'];

        $this->autoLinkUsersWithSharedEmployees($sharedData['employees'], $employeesByCode);

        $query = User::query()->with('department');

        if ($search !== '') {
            // Tìm các mã nhân viên bên DB chung có tên hoặc mã khớp từ khóa
            $matchedCodes = collect($sharedData['employees'])
                ->filter(function ($emp) use ($search) {
                    return stripos((string) ($emp->employee_code ?? ''), $search) !== false
                        || stripos((string) ($emp->name ?? ''), $search) !== false;
                })
                ->pluck('employee_code')
                ->filter()
                ->values()
                ->toArray();

            $query->where(function ($q) use ($search, $matchedCodes) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhere('employee_code', 'like', "%{$search}%");

                if (! empty($matchedCodes)) {
                    $q->orWhereIn('employee_code', $matchedCodes);
                }
            });
        }

        $users = $query->latest()->paginate(15)->withQueryString();

        return view('backend.users.index', compact('users', 'search', 'employeesByCode'));
    }

    public function create(): View
    {
        $sharedData = $this->getSharedEmployeesData();
        $employees = $sharedData['employees'];

        return view('backend.users.create', compact('employees'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->merge([
            'employee_code' => trim((string) $request->input('employee_code', '')) ?: null,
        ]);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'employee_code' => ['nullable', 'string', 'max:100', 'unique:users,employee_code'],
            'phone' => ['nullable', 'string', 'max:50'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'avatar_file' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,gif', 'max:2048'],
            'remove_avatar' => ['nullable'],
            'permission' => ['required', 'integer', 'in:1,2,3,4,5,6'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ], [
            'employee_code.unique' => 'Nhân viên này (Mã NV) đã được liên kết với một tài khoản khác.',
            'email.unique' => 'Email này đã tồn tại trên hệ thống.',
        ]);

        $avatarPath = null;

        if ($request->hasFile('avatar_file')) {
            $avatarPath = $this->storeAvatar($request->file('avatar_file'));
        }

        User::create([
            'name' => $validated['name'],
            'employee_code' => $validated['employee_code'] ?? null,
            'phone' => $validated['phone'] ?? null,
            'avatar' => $avatarPath,
            'permission' => $validated['permission'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'is_active' => true,
        ]);

        return redirect()
            ->route('backend.users.index')
            ->with('success', 'Thêm tài khoản thành công.');
    }

    public function edit(User $user): View
    {
        $sharedData = $this->getSharedEmployeesData();
        $employees = $sharedData['employees'];
        $employeesByCode = $sharedData['employeesByCode'];

        if (empty($user->employee_code)) {
            $this->autoLinkUsersWithSharedEmployees($employees, $employeesByCode);
            $user->refresh();
        }

        return view('backend.users.edit', compact('user', 'employees'));
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        $request->merge([
            'employee_code' => trim((string) $request->input('employee_code', '')) ?: null,
        ]);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'employee_code' => [
                'nullable',
                'string',
                'max:100',
                Rule::unique('users', 'employee_code')->ignore($user->id),
            ],
            'phone' => ['nullable', 'string', 'max:50'],
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
        ], [
            'employee_code.unique' => 'Nhân viên này (Mã NV) đã được liên kết với một tài khoản khác.',
            'email.unique' => 'Email này đã tồn tại trên hệ thống.',
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
            'employee_code' => $validated['employee_code'] ?? null,
            'phone' => $validated['phone'] ?? null,
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
            ->with('success', 'Cập nhật tài khoản thành công.');
    }

    public function destroy(User $user): RedirectResponse
    {
        if (auth()->id() === $user->id) {
            return redirect()
                ->route('backend.users.index')
                ->with('error', 'Không thể xóa tài khoản đang đăng nhập.');
        }

        $this->deleteAvatarIfExists($user->avatar);
        $user->delete();

        return redirect()
            ->route('backend.users.index')
            ->with('success', 'Xóa tài khoản thành công.');
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
            'email' => 'user_' . Str::random(10) . '@example.com',
            'password' => Hash::make(Str::random(16)),
            'permission' => 4,
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
        }

        $userIds = $validated['user_ids'];
        $count = User::whereIn('id', $userIds)->update([
            'department_id' => $departmentId,
        ]);

        $dept = $departmentId ? Department::find($departmentId) : null;
        $deptName = $dept ? $dept->name : 'Không có phòng ban (Đã gỡ)';
        $message = "Đã cập nhật phòng ban [{$deptName}] cho {$count} tài khoản thành công.";

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

    public function downloadSampleExcel()
    {
        return Excel::download(new UserSampleExport(), 'mau_nhap_nguoi_dung.xlsx');
    }

    public function importExcel(Request $request)
    {
        $request->validate([
            'file' => ['required', 'file', 'mimes:xlsx,xls,csv', 'max:10240'],
        ]);

        try {
            $updateExisting = $request->boolean('update_existing', true);
            $autoCreateDept = $request->boolean('auto_create_department', true);
            $defaultPassword = $request->input('default_password', '123456');

            $import = new UserImport($updateExisting, $autoCreateDept, $defaultPassword ?: '123456');
            Excel::import($import, $request->file('file'));

            $msg = "Nhập dữ liệu thành công! Thêm mới: {$import->createdCount}, Cập nhật: {$import->updatedCount}";
            if ($import->skippedCount > 0) {
                $msg .= ", Bỏ qua/lỗi: {$import->skippedCount}";
            }

            return redirect()
                ->route('backend.users.index')
                ->with('success', $msg);
        } catch (\Throwable $e) {
            return redirect()
                ->back()
                ->with('error', 'Có lỗi xảy ra khi xử lý file Excel: ' . $e->getMessage());
        }
    }

    public function toggleStatus(User $user): JsonResponse
    {
        if (auth()->id() === $user->id) {
            return response()->json([
                'success' => false,
                'message' => 'Bạn không thể tự khóa tài khoản đang đăng nhập của chính mình.',
            ], 422);
        }

        $user->update(['is_active' => ! $user->is_active]);

        if (! $user->is_active && method_exists($user, 'tokens')) {
            $user->tokens()->delete();
        }

        return response()->json([
            'is_active' => $user->is_active,
            'label' => $user->is_active ? 'Hoạt động' : 'Đã khóa',
            'message' => $user->is_active
                ? "Đã kích hoạt tài khoản của {$user->name}."
                : "Đã khóa tài khoản {$user->name}. Người dùng này sẽ bị đăng xuất khỏi hệ thống ngay lập tức.",
        ]);
    }
}
