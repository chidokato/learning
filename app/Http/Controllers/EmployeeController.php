<?php

namespace App\Http\Controllers;

use App\Models\SharedDbConfig;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\View;

class EmployeeController extends Controller
{
    public function index(Request $request): View
    {
        $config = SharedDbConfig::findActiveForTable('employees');

        $errorMessage = null;
        $employees = new LengthAwarePaginator([], 0, 20);
        $departmentsMap = [];
        $managersMap = [];
        $positionsList = [];
        $statusesList = [];
        $columns = [];
        $tableName = ($config && $config->hasSharedTable('employees'))
            ? 'employees'
            : ($config ? ($config->getTableNames()[0] ?? 'employees') : 'employees');

        if (! $config) {
            $errorMessage = 'Chưa có cấu hình DB dùng chung nào đang bật cho bảng "employees". Vui lòng kiểm tra mục Hệ thống -> DB chung.';
            return view('backend.employees.index', compact(
                'config',
                'employees',
                'departmentsMap',
                'managersMap',
                'positionsList',
                'statusesList',
                'columns',
                'tableName',
                'errorMessage'
            ));
        }

        try {
            $connection = $config->connectSharedDb();
            $schema = Schema::connection($config->getConnectionNameKey());

            if (! $schema->hasTable($tableName)) {
                $errorMessage = "Không tìm thấy bảng `{$tableName}` trong Database dùng chung `{$config->database}`.";
            } else {
                $columns = $schema->getColumnListing($tableName);
                $query = $connection->table($tableName);

                // Lấy map phòng ban từ DB dùng chung nếu có bảng departments
                if ($schema->hasTable('departments')) {
                    $departmentsMap = $connection->table('departments')
                        ->pluck('name', 'id')
                        ->toArray();
                }

                // Lấy danh sách chức vụ & trạng thái để lọc
                if (in_array('position', $columns, true)) {
                    $positionsList = $connection->table($tableName)
                        ->whereNotNull('position')
                        ->where('position', '!=', '')
                        ->distinct()
                        ->pluck('position')
                        ->toArray();
                }

                if (in_array('status', $columns, true)) {
                    $statusesList = $connection->table($tableName)
                        ->whereNotNull('status')
                        ->where('status', '!=', '')
                        ->distinct()
                        ->pluck('status')
                        ->toArray();
                }

                // Tìm kiếm từ khóa
                if ($request->filled('search')) {
                    $keyword = trim($request->input('search'));
                    $searchableCols = array_intersect(
                        ['name', 'employee_code', 'email', 'phone', 'position', 'level', 'evaluation_type', 'id'],
                        $columns
                    );

                    if (! empty($searchableCols)) {
                        $query->where(function ($q) use ($searchableCols, $keyword) {
                            foreach ($searchableCols as $col) {
                                $q->orWhere($col, 'like', "%{$keyword}%");
                            }
                        });
                    }
                }

                // Lọc theo phòng ban
                if ($request->filled('department_id') && in_array('department_id', $columns, true)) {
                    $query->where('department_id', $request->input('department_id'));
                }

                // Lọc theo chức vụ
                if ($request->filled('position') && in_array('position', $columns, true)) {
                    $query->where('position', $request->input('position'));
                }

                // Lọc theo trạng thái
                if ($request->filled('status')) {
                    $statusFilter = $request->input('status');
                    if ($statusFilter === 'deleted' && in_array('deleted_at', $columns, true)) {
                        $query->whereNotNull('deleted_at');
                    } elseif (in_array('status', $columns, true)) {
                        $query->where('status', $statusFilter);
                    }
                }

                $perPage = (int) $request->input('per_page', 20);
                if ($perPage <= 0 || $perPage > 200) {
                    $perPage = 20;
                }

                if (in_array('id', $columns, true)) {
                    $query->orderByDesc('id');
                }

                $employees = $query->paginate($perPage)->withQueryString();

                // Map tên quản lý trực tiếp (manager_id, manager_l2_id)
                if (in_array('id', $columns, true) && in_array('name', $columns, true)) {
                    $managerIds = collect($employees->items())
                        ->flatMap(fn ($emp) => [$emp->manager_id ?? null, $emp->manager_l2_id ?? null])
                        ->filter()
                        ->unique()
                        ->values()
                        ->toArray();

                    if (! empty($managerIds)) {
                        $managersMap = $connection->table($tableName)
                            ->whereIn('id', $managerIds)
                            ->pluck('name', 'id')
                            ->toArray();
                    }
                }
            }
        } catch (\Throwable $e) {
            $errorMessage = 'Lỗi kết nối tới DB dùng chung: ' . $e->getMessage();
        }

        return view('backend.employees.index', compact(
            'config',
            'employees',
            'departmentsMap',
            'managersMap',
            'positionsList',
            'statusesList',
            'columns',
            'tableName',
            'errorMessage'
        ));
    }
}
