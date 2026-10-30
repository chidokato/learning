<?php

namespace App\Imports;

use App\Models\Department;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToCollection;

class UserImport implements ToCollection
{
    public int $createdCount = 0;
    public int $updatedCount = 0;
    public int $skippedCount = 0;
    public array $errors = [];

    protected bool $updateExisting;
    protected bool $autoCreateDepartment;
    protected string $defaultPassword;
    protected int $defaultPermission;

    public function __construct(
        bool $updateExisting = true,
        bool $autoCreateDepartment = true,
        string $defaultPassword = '123456',
        int $defaultPermission = 6
    ) {
        $this->updateExisting = $updateExisting;
        $this->autoCreateDepartment = $autoCreateDepartment;
        $this->defaultPassword = $defaultPassword;
        $this->defaultPermission = $defaultPermission;
    }

    public function collection(Collection $rows)
    {
        // Cache departments for fast lookup
        $departments = Department::all();

        foreach ($rows as $index => $row) {
            $rowNum = $index + 1;

            $colUser = isset($row[0]) ? trim((string) $row[0]) : '';
            $colPass = isset($row[1]) ? trim((string) $row[1]) : '';
            $colMaNv = isset($row[2]) ? trim((string) $row[2]) : '';
            $colName = isset($row[3]) ? trim((string) $row[3]) : '';
            $colJob  = isset($row[4]) ? trim((string) $row[4]) : '';
            $colDept = isset($row[5]) ? trim((string) $row[5]) : '';
            $colMail = isset($row[6]) ? trim((string) $row[6]) : '';

            // Bỏ qua dòng trống hoàn toàn
            if ($colUser === '' && $colName === '' && $colMail === '' && $colMaNv === '') {
                continue;
            }

            // Bỏ qua dòng tiêu đề
            $lowerUser = mb_strtolower($colUser, 'UTF-8');
            $lowerName = mb_strtolower($colName, 'UTF-8');
            $lowerMail = mb_strtolower($colMail, 'UTF-8');
            if (
                $index === 0 ||
                $lowerUser === 'user' ||
                $lowerUser === 'tài khoản' ||
                $lowerName === 'họ tên' ||
                $lowerName === 'họ và tên' ||
                $lowerMail === 'email'
            ) {
                continue;
            }

            // Xác định Email
            $email = '';
            if ($colMail !== '' && filter_var($colMail, FILTER_VALIDATE_EMAIL)) {
                $email = $colMail;
            } elseif ($colUser !== '' && filter_var($colUser, FILTER_VALIDATE_EMAIL)) {
                $email = $colUser;
            } elseif ($colMail !== '') {
                // Email có nhập nhưng sai định dạng
                $this->skippedCount++;
                $this->errors[] = "Dòng {$rowNum}: Email '{$colMail}' không đúng định dạng.";
                continue;
            } else {
                // Không có email, tạo email theo username
                $fallbackUsername = $colUser ?: ($colMaNv ?: Str::slug($colName, ''));
                if ($fallbackUsername !== '') {
                    $email = strtolower($fallbackUsername) . '@dxmb.vn';
                } else {
                    $this->skippedCount++;
                    $this->errors[] = "Dòng {$rowNum}: Thiếu thông tin Email hoặc tài khoản để nhận diện.";
                    continue;
                }
            }

            // Họ tên
            $name = $colName !== '' ? $colName : ($colUser ?: 'Người dùng ' . ($colMaNv ?: $email));

            // Xác định phòng ban
            $departmentId = null;
            if ($colDept !== '') {
                $lowerDept = mb_strtolower($colDept, 'UTF-8');
                $matchedDept = $departments->first(function ($dept) use ($lowerDept) {
                    return mb_strtolower($dept->name, 'UTF-8') === $lowerDept
                        || ($dept->code && mb_strtolower($dept->code, 'UTF-8') === $lowerDept);
                });

                if (! $matchedDept) {
                    // Thử tìm gần đúng
                    $matchedDept = $departments->first(function ($dept) use ($lowerDept) {
                        return Str::contains(mb_strtolower($dept->name, 'UTF-8'), $lowerDept)
                            || ($dept->code && Str::contains(mb_strtolower($dept->code, 'UTF-8'), $lowerDept));
                    });
                }

                if (! $matchedDept && $this->autoCreateDepartment) {
                    // Tự động tạo phòng ban mới nếu chưa có
                    $matchedDept = Department::create([
                        'name' => $colDept,
                        'slug' => Str::slug($colDept),
                        'sort_order' => $departments->count() + 1,
                        'is_active' => true,
                    ]);
                    $departments->push($matchedDept);
                }

                if ($matchedDept) {
                    $departmentId = $matchedDept->id;
                }
            }

            // Kiểm tra user đã tồn tại chưa (tìm theo email, hoặc mã nhân viên, hoặc username)
            $existingUser = User::where('email', $email)
                ->when($colMaNv !== '', function ($q) use ($colMaNv) {
                    $q->orWhere('employee_code', $colMaNv);
                })
                ->when($colUser !== '', function ($q) use ($colUser) {
                    $q->orWhere('username', $colUser);
                })
                ->first();

            if ($existingUser) {
                if ($this->updateExisting) {
                    $updateData = [
                        'name' => $name,
                        'job_title' => $colJob ?: $existingUser->job_title,
                        'department_id' => $departmentId ?? $existingUser->department_id,
                        'employee_code' => $colMaNv ?: $existingUser->employee_code,
                        'username' => $colUser ?: $existingUser->username,
                    ];

                    if ($colPass !== '') {
                        $updateData['password'] = Hash::make($colPass);
                    }

                    $existingUser->update($updateData);
                    $this->updatedCount++;
                } else {
                    $this->skippedCount++;
                }
            } else {
                // Tạo user mới
                $password = $colPass !== '' ? $colPass : $this->defaultPassword;

                User::create([
                    'name' => $name,
                    'email' => $email,
                    'username' => $colUser ?: null,
                    'employee_code' => $colMaNv ?: null,
                    'job_title' => $colJob ?: null,
                    'department_id' => $departmentId,
                    'password' => Hash::make($password),
                    'permission' => $this->defaultPermission,
                    'is_active' => true,
                ]);

                $this->createdCount++;
            }
        }
    }
}
