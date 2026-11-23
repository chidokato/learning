@extends('backend.layouts.app')

@section('title', 'Người dùng (DB chung)')
@section('page_title', 'Người dùng')
@section('breadcrumb', 'Người dùng')

@php
    $positionLabels = [
        'employee' => 'Nhân viên',
        'team_leader' => 'Trưởng nhóm (Team Leader)',
        'manager' => 'Trưởng phòng (Manager)',
        'director' => 'Giám đốc (Director)',
    ];

    $statusLabels = [
        'active' => ['label' => 'Chính thức / Đang làm', 'class' => 'bg-success-subtle text-success border-success'],
        'probation' => ['label' => 'Thử việc', 'class' => 'bg-warning-subtle text-warning border-warning'],
        'resigned' => ['label' => 'Đã nghỉ việc', 'class' => 'bg-danger-subtle text-danger border-danger'],
        'inactive' => ['label' => 'Nghỉ việc / Tạm ngưng', 'class' => 'bg-danger-subtle text-danger border-danger'],
    ];

    $evalLabels = [
        'office' => 'Khối Văn phòng',
        'sale' => 'Khối Kinh doanh',
    ];
@endphp

@section('content')
    <div class="card">
        <div class="card-header d-flex flex-wrap align-items-center justify-content-between gap-2">
            <div>
                <h4 class="card-title mb-1 d-flex align-items-center gap-2">
                    <span>Danh sách nhân sự (Bảng <code>{{ $tableName }}</code> - DB dùng chung)</span>
                    <span class="badge bg-info-subtle text-info border border-info border-opacity-25 fs-11 fw-normal">
                        <i class="ri-eye-line me-1"></i>Chế độ chỉ xem
                    </span>
                </h4>
                <p class="text-muted small mb-0">
                    Dữ liệu đồng bộ trực tiếp từ Database dùng chung
                    @if ($config)
                        (<strong>{{ $config->name }}</strong> — <code>{{ $config->host }}:{{ $config->port }}/{{ $config->database }}</code>).
                    @endif
                    Chỉ hỗ trợ tra cứu và tìm kiếm, không thêm/sửa/xóa tại đây.
                </p>
            </div>
            @if ($config)
                <div class="d-flex align-items-center gap-2">
                    <span class="badge bg-light text-dark border px-2 py-1 fs-12">
                        <i class="ri-database-2-line text-primary me-1"></i>
                        Tổng số: <strong>{{ $employees->total() }}</strong> bản ghi
                    </span>
                </div>
            @endif
        </div>

        @if ($errorMessage)
            <div class="card-body">
                <div class="alert alert-danger mb-0 d-flex align-items-center justify-content-between flex-wrap gap-2">
                    <div>
                        <i class="ri-error-warning-line fs-18 align-middle me-1"></i>
                        {{ $errorMessage }}
                    </div>
                    <a href="{{ route('backend.shared-db-configs.index') }}" class="btn btn-sm btn-outline-danger">
                        <i class="ri-settings-3-line me-1"></i> Kiểm tra cấu hình DB chung
                    </a>
                </div>
            </div>
        @else
            <div class="card-body border-bottom bg-light bg-opacity-25">
                <form action="{{ route('backend.employees.index') }}" method="GET" class="row g-2 align-items-center">
                    <div class="col-md-3">
                        <div class="input-group">
                            <span class="input-group-text"><i class="ri-search-line"></i></span>
                            <input
                                type="text"
                                name="search"
                                class="form-control"
                                placeholder="Tìm theo mã NV, họ tên, email, SĐT..."
                                value="{{ request('search') }}"
                            >
                        </div>
                    </div>

                    @if (!empty($departmentsMap))
                        <div class="col-md-2">
                            <select name="department_id" class="form-select">
                                <option value="">-- Tất cả phòng ban --</option>
                                @foreach ($departmentsMap as $deptId => $deptName)
                                    <option value="{{ $deptId }}" {{ (string) request('department_id') === (string) $deptId ? 'selected' : '' }}>
                                        {{ $deptName }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    @endif

                    @if (!empty($positionsList))
                        <div class="col-md-2">
                            <select name="position" class="form-select">
                                <option value="">-- Tất cả chức vụ --</option>
                                @foreach ($positionsList as $pos)
                                    <option value="{{ $pos }}" {{ (string) request('position') === (string) $pos ? 'selected' : '' }}>
                                        {{ $positionLabels[$pos] ?? $pos }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    @endif

                    @if (!empty($statusesList))
                        <div class="col-md-2">
                            <select name="status" class="form-select">
                                <option value="">-- Tất cả trạng thái --</option>
                                @foreach ($statusesList as $st)
                                    <option value="{{ $st }}" {{ (string) request('status') === (string) $st ? 'selected' : '' }}>
                                        {{ $statusLabels[$st]['label'] ?? $st }}
                                    </option>
                                @endforeach
                                @if (in_array('deleted_at', $columns ?? [], true))
                                    <option value="deleted" {{ (string) request('status') === 'deleted' ? 'selected' : '' }}>Đã xóa</option>
                                @endif
                            </select>
                        </div>
                    @endif

                    <div class="col-md-1">
                        <select name="per_page" class="form-select" title="Số dòng mỗi trang">
                            <option value="10" {{ request('per_page', 20) == 10 ? 'selected' : '' }}>10 / trang</option>
                            <option value="20" {{ request('per_page', 20) == 20 ? 'selected' : '' }}>20 / trang</option>
                            <option value="50" {{ request('per_page', 20) == 50 ? 'selected' : '' }}>50 / trang</option>
                            <option value="100" {{ request('per_page', 20) == 100 ? 'selected' : '' }}>100 / trang</option>
                        </select>
                    </div>

                    <div class="col-md-2 d-flex gap-2">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="ri-search-line me-1"></i> Tìm kiếm
                        </button>
                        @if (request()->hasAny(['search', 'department_id', 'position', 'status', 'per_page']))
                            <a href="{{ route('backend.employees.index') }}" class="btn btn-soft-danger" title="Xóa bộ lọc">
                                <i class="ri-close-line"></i>
                            </a>
                        @endif
                    </div>
                </form>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 65px;">ID</th>
                                <th style="width: 140px;">Mã nhân viên</th>
                                <th>Họ và tên</th>
                                <th>Phòng ban</th>
                                <th>Chức vụ / Khối</th>
                                <th>Quản lý</th>
                                <th>Liên hệ</th>
                                <th>Ngày vào làm</th>
                                <th style="width: 150px;">Trạng thái</th>
                                <th style="width: 110px;">Đã xóa</th>
                                <th class="text-end" style="width: 90px;">Chi tiết</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($employees as $emp)
                                @php
                                    $deptName = isset($emp->department_id) ? ($departmentsMap[$emp->department_id] ?? ('ID #' . $emp->department_id)) : null;
                                    $posKey = $emp->position ?? null;
                                    $posLabel = $posKey ? ($positionLabels[$posKey] ?? $posKey) : null;
                                    $evalKey = $emp->evaluation_type ?? null;
                                    $evalLabel = $evalKey ? ($evalLabels[$evalKey] ?? $evalKey) : null;
                                    $stKey = $emp->status ?? null;
                                    $stConfig = $stKey && isset($statusLabels[$stKey])
                                        ? $statusLabels[$stKey]
                                        : ['label' => $stKey ?: '—', 'class' => 'bg-secondary-subtle text-secondary border-secondary'];
                                    $manager1 = !empty($emp->manager_id) ? ($managersMap[$emp->manager_id] ?? ('ID #' . $emp->manager_id)) : null;
                                    $manager2 = !empty($emp->manager_l2_id) ? ($managersMap[$emp->manager_l2_id] ?? ('ID #' . $emp->manager_l2_id)) : null;
                                @endphp
                                <tr>
                                    <td class="text-muted fw-medium">#{{ $emp->id ?? '—' }}</td>
                                    <td>
                                        @if (!empty($emp->employee_code))
                                            <span class="badge bg-secondary-subtle text-dark border font-monospace fs-12 px-2 py-1">
                                                {{ $emp->employee_code }}
                                            </span>
                                        @else
                                            <span class="text-muted small">—</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-xs me-2 flex-shrink-0">
                                                <span class="avatar-title rounded-circle bg-soft-primary text-primary fs-12 fw-semibold">
                                                    {{ mb_substr($emp->name ?? 'U', 0, 1) }}
                                                </span>
                                            </div>
                                            <div>
                                                <div class="fw-semibold text-dark">{{ $emp->name ?? '—' }}</div>
                                                @if (!empty($emp->level))
                                                    <span class="badge bg-info-subtle text-info border border-info border-opacity-25 mt-1" style="font-size: 10px;">
                                                        Level: {{ $emp->level }}
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        @if ($deptName)
                                            <a href="{{ route('backend.employees.index', array_merge(request()->except('page'), ['department_id' => $emp->department_id])) }}"
                                               class="badge bg-primary-subtle text-primary border border-primary border-opacity-25 text-decoration-none py-1 px-2">
                                                <i class="ri-building-line me-1"></i>{{ $deptName }}
                                            </a>
                                        @else
                                            <span class="text-muted small">—</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($posLabel)
                                            <div class="fw-medium text-dark">{{ $posLabel }}</div>
                                        @endif
                                        @if ($evalLabel)
                                            <div class="small text-muted">{{ $evalLabel }}</div>
                                        @endif
                                        @if (!$posLabel && !$evalLabel)
                                            <span class="text-muted small">—</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($manager1 || $manager2)
                                            @if ($manager1)
                                                <div class="small">
                                                    <span class="text-muted">QL1:</span> <span class="fw-medium">{{ $manager1 }}</span>
                                                </div>
                                            @endif
                                            @if ($manager2)
                                                <div class="small">
                                                    <span class="text-muted">QL2:</span> <span class="fw-medium">{{ $manager2 }}</span>
                                                </div>
                                            @endif
                                        @else
                                            <span class="text-muted small">—</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if (!empty($emp->email) || !empty($emp->phone))
                                            @if (!empty($emp->email))
                                                <div class="small"><i class="ri-mail-line text-muted me-1"></i>{{ $emp->email }}</div>
                                            @endif
                                            @if (!empty($emp->phone))
                                                <div class="small"><i class="ri-phone-line text-muted me-1"></i>{{ $emp->phone }}</div>
                                            @endif
                                        @else
                                            <span class="text-muted small">—</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if (!empty($emp->join_date))
                                            <span class="small">{{ \Illuminate\Support\Carbon::parse($emp->join_date)->format('d/m/Y') }}</span>
                                        @else
                                            <span class="text-muted small">—</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge {{ $stConfig['class'] }} border border-opacity-25 px-2 py-1">
                                            {{ $stConfig['label'] }}
                                        </span>
                                    </td>
                                    <td>
                                        @if (!empty($emp->deleted_at))
                                            <span class="badge bg-danger-subtle text-danger border border-danger border-opacity-25 px-2 py-1" title="Xóa lúc: {{ \Illuminate\Support\Carbon::parse($emp->deleted_at)->format('d/m/Y H:i') }}">
                                                Đã xóa
                                            </span>
                                        @else
                                            <span class="text-muted small">—</span>
                                        @endif
                                    </td>
                                    <td class="text-end">
                                        <button
                                            type="button"
                                            class="btn btn-sm btn-soft-info js-view-employee"
                                            data-employee="{{ json_encode($emp, JSON_UNESCAPED_UNICODE) }}"
                                            data-department="{{ $deptName ?? '—' }}"
                                            data-manager1="{{ $manager1 ?? '—' }}"
                                            data-manager2="{{ $manager2 ?? '—' }}"
                                            title="Xem chi tiết"
                                        >
                                            <i class="ri-eye-line align-bottom me-1"></i> Xem
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="11" class="text-center text-muted py-5">
                                        <i class="ri-user-search-line fs-2 mb-2 d-block text-secondary"></i>
                                        Không tìm thấy nhân sự nào phù hợp trong bảng <code>{{ $tableName }}</code>.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mt-3">
                    <div class="text-muted small">
                        Hiển thị từ <strong>{{ $employees->firstItem() ?? 0 }}</strong> đến <strong>{{ $employees->lastItem() ?? 0 }}</strong> trên tổng số <strong>{{ $employees->total() }}</strong> nhân sự
                    </div>
                    <div>
                        {{ $employees->links('pagination::bootstrap-4') }}
                    </div>
                </div>
            </div>
        @endif
    </div>

    {{-- Modal Xem chi tiết bản ghi employee --}}
    <div class="modal fade" id="employeeDetailModal" tabindex="-1" aria-labelledby="employeeDetailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h5 class="modal-title d-flex align-items-center gap-2" id="employeeDetailModalLabel">
                        <i class="ri-user-3-line text-primary"></i>
                        <span>Thông tin chi tiết nhân sự</span>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="employeeDetailModalBody">
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    var modalEl = document.getElementById('employeeDetailModal');
    var modal = modalEl ? new bootstrap.Modal(modalEl) : null;
    var modalBody = document.getElementById('employeeDetailModalBody');
    var modalTitle = document.getElementById('employeeDetailModalLabel');

    var fieldLabels = {
        id: 'ID',
        employee_code: 'Mã nhân viên',
        name: 'Họ và tên',
        email: 'Email',
        phone: 'Số điện thoại',
        department_id: 'Phòng ban',
        manager_id: 'Quản lý trực tiếp (Cấp 1)',
        manager_l2_id: 'Quản lý cấp 2',
        position: 'Chức vụ',
        evaluation_type: 'Khối đánh giá',
        level: 'Cấp bậc (Level)',
        join_date: 'Ngày vào làm',
        leave_date: 'Ngày nghỉ việc',
        status: 'Trạng thái',
        annual_leave_balance: 'Số ngày phép năm còn lại',
        created_at: 'Ngày tạo bản ghi',
        updated_at: 'Cập nhật lần cuối',
        deleted_at: 'Đã xóa'
    };

    function escapeHtml(str) {
        return String(str ?? '')
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');
    }

    document.querySelectorAll('.js-view-employee').forEach(function (btn) {
        btn.addEventListener('click', function () {
            var raw = btn.getAttribute('data-employee');
            if (!raw || !modal || !modalBody) return;

            var emp = {};
            try {
                emp = JSON.parse(raw);
            } catch (e) {
                return;
            }

            var deptName = btn.getAttribute('data-department') || '—';
            var manager1 = btn.getAttribute('data-manager1') || '—';
            var manager2 = btn.getAttribute('data-manager2') || '—';

            if (modalTitle) {
                modalTitle.innerHTML = '<i class="ri-user-3-line text-primary"></i> <span>Chi tiết nhân sự: <strong>' + escapeHtml(emp.name || ('#' + emp.id)) + '</strong></span>';
            }

            var rowsHtml = '';
            Object.keys(emp).forEach(function (key) {
                var label = fieldLabels[key] || key;
                var val = emp[key];
                var displayVal = '';

                if (key === 'deleted_at') {
                    displayVal = val
                        ? '<span class="badge bg-danger-subtle text-danger border border-danger border-opacity-25">Đã xóa</span> <span class="text-muted small ms-1">(' + escapeHtml(val) + ')</span>'
                        : '<span class="text-muted fst-italic">—</span>';
                } else if (key === 'department_id') {
                    displayVal = escapeHtml(deptName) + (val ? ' <span class="text-muted small">(ID: ' + escapeHtml(val) + ')</span>' : '');
                } else if (key === 'manager_id') {
                    displayVal = escapeHtml(manager1) + (val ? ' <span class="text-muted small">(ID: ' + escapeHtml(val) + ')</span>' : '');
                } else if (key === 'manager_l2_id') {
                    displayVal = escapeHtml(manager2) + (val ? ' <span class="text-muted small">(ID: ' + escapeHtml(val) + ')</span>' : '');
                } else if (val === null || val === undefined || val === '') {
                    displayVal = '<span class="text-muted fst-italic">—</span>';
                } else {
                    displayVal = escapeHtml(val);
                }

                rowsHtml += '<tr>' +
                    '<th class="bg-light text-muted fw-medium" style="width: 35%;">' + escapeHtml(label) + ' <code class="ms-1 text-secondary">(' + escapeHtml(key) + ')</code></th>' +
                    '<td>' + displayVal + '</td>' +
                '</tr>';
            });

            modalBody.innerHTML = '<div class="table-responsive"><table class="table table-bordered table-sm mb-0">' + rowsHtml + '</table></div>';
            modal.show();
        });
    });
});
</script>
@endpush
