<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\SharedDbConfig;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class DepartmentController extends Controller
{
    public function index(Request $request): View
    {
        $config = SharedDbConfig::findActiveForTable('departments');

        $errorMessage = null;
        $departments = new LengthAwarePaginator([], 0, 20);
        $parentsMap = [];
        $employeeCounts = [];
        $statusesList = [];
        $columns = [];
        $tableName = ($config && $config->hasSharedTable('departments'))
            ? 'departments'
            : 'departments';

        if (! $config) {
            $errorMessage = 'Chưa có cấu hình DB dùng chung nào đang bật cho bảng "departments". Vui lòng kiểm tra mục Hệ thống -> DB chung.';
            return view('backend.departments.index', compact(
                'config',
                'departments',
                'parentsMap',
                'employeeCounts',
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

                if (in_array('deleted_at', $columns, true)) {
                    $query->whereNull('deleted_at');
                }

                // Map tên phòng ban cha
                $parentsMap = $connection->table($tableName)
                    ->pluck('name', 'id')
                    ->toArray();

                // Đếm số lượng nhân sự theo phòng ban từ bảng employees trong DB chung
                if ($schema->hasTable('employees')) {
                    $empColumns = $schema->getColumnListing('employees');
                    $empQuery = $connection->table('employees')
                        ->selectRaw('department_id, COUNT(*) as aggregate')
                        ->whereNotNull('department_id');

                    if (in_array('deleted_at', $empColumns, true)) {
                        $empQuery->whereNull('deleted_at');
                    }

                    $employeeCounts = $empQuery
                        ->groupBy('department_id')
                        ->pluck('aggregate', 'department_id')
                        ->toArray();
                }

                if (in_array('status', $columns, true)) {
                    $statusesList = $connection->table($tableName)
                        ->when(in_array('deleted_at', $columns, true), fn ($q) => $q->whereNull('deleted_at'))
                        ->whereNotNull('status')
                        ->where('status', '!=', '')
                        ->distinct()
                        ->pluck('status')
                        ->toArray();
                }

                // Tìm kiếm theo mã hoặc tên phòng ban
                $keyword = trim((string) ($request->input('search') ?? $request->input('q') ?? ''));
                if ($keyword !== '') {
                    $searchableCols = array_intersect(['name', 'code', 'id', 'description'], $columns);
                    if (! empty($searchableCols)) {
                        $query->where(function ($q) use ($searchableCols, $keyword) {
                            foreach ($searchableCols as $col) {
                                $q->orWhere($col, 'like', "%{$keyword}%");
                            }
                        });
                    }
                }

                // Lọc theo trạng thái
                if ($request->filled('status') && in_array('status', $columns, true)) {
                    $query->where('status', $request->input('status'));
                }

                $perPage = (int) $request->input('per_page', 20);
                if ($perPage <= 0 || $perPage > 200) {
                    $perPage = 20;
                }

                if (in_array('sort_order', $columns, true)) {
                    $query->orderBy('sort_order');
                }
                if (in_array('id', $columns, true)) {
                    $query->orderBy('id');
                }

                $departments = $query->paginate($perPage)->withQueryString();
            }
        } catch (\Throwable $e) {
            $errorMessage = 'Lỗi kết nối tới DB dùng chung: ' . $e->getMessage();
        }

        return view('backend.departments.index', compact(
            'config',
            'departments',
            'parentsMap',
            'employeeCounts',
            'statusesList',
            'columns',
            'tableName',
            'errorMessage'
        ));
    }

    public function create(Request $request): RedirectResponse
    {
        return redirect()->route('backend.departments.index');
    }

    public function store(Request $request): RedirectResponse
    {
        return redirect()->route('backend.departments.index');
    }

    public function edit(Department $department): RedirectResponse
    {
        return redirect()->route('backend.departments.index');
    }

    public function update(Request $request, Department $department): RedirectResponse
    {
        return redirect()->route('backend.departments.index');
    }

    public function destroy(Department $department): RedirectResponse
    {
        return redirect()->route('backend.departments.index');
    }

    public function toggleStatus(Department $department): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => 'Bảng phòng ban dùng chung chỉ hỗ trợ chế độ xem.',
        ], 403);
    }

    public function updateSortOrder(Request $request, Department $department): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => 'Bảng phòng ban dùng chung chỉ hỗ trợ chế độ xem.',
        ], 403);
    }
}
