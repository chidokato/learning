@extends('backend.layouts.app')

@section('title', 'Phòng ban (DB chung)')
@section('page_title', 'Phòng ban')
@section('breadcrumb', 'Phòng ban')

@php
    $statusLabels = [
        'active' => ['label' => 'Đang hoạt động', 'class' => 'bg-success-subtle text-success border-success'],
        'inactive' => ['label' => 'Ngừng hoạt động', 'class' => 'bg-secondary-subtle text-secondary border-secondary'],
    ];
@endphp

@section('content')
    <div class="card">
        <div class="card-header d-flex flex-wrap align-items-center justify-content-between gap-2">
            <div>
                <h4 class="card-title mb-1 d-flex align-items-center gap-2">
                    <span>Danh sách phòng ban (Bảng <code>{{ $tableName }}</code> - DB dùng chung)</span>
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
                        <i class="ri-building-line text-primary me-1"></i>
                        Tổng số: <strong>{{ $departments->total() }}</strong> phòng ban
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
                <form action="{{ route('backend.departments.index') }}" method="GET" class="row g-2 align-items-center">
                    <div class="col-md-5">
                        <div class="input-group">
                            <span class="input-group-text"><i class="ri-search-line"></i></span>
                            <input
                                type="text"
                                name="search"
                                class="form-control"
                                placeholder="Tìm theo tên hoặc mã phòng ban..."
                                value="{{ request('search', request('q')) }}"
                            >
                        </div>
                    </div>

                    @if (!empty($statusesList))
                        <div class="col-md-3">
                            <select name="status" class="form-select">
                                <option value="">-- Tất cả trạng thái --</option>
                                @foreach ($statusesList as $st)
                                    <option value="{{ $st }}" {{ (string) request('status') === (string) $st ? 'selected' : '' }}>
                                        {{ $statusLabels[$st]['label'] ?? $st }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    @endif

                    <div class="col-md-2">
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
                        @if (request()->hasAny(['search', 'q', 'status', 'per_page']))
                            <a href="{{ route('backend.departments.index') }}" class="btn btn-soft-danger" title="Xóa bộ lọc">
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
                                <th style="width: 70px;">ID</th>
                                <th style="width: 150px;">Mã phòng ban</th>
                                <th>Tên phòng ban</th>
                                <th>Phòng ban cấp trên</th>
                                <th style="width: 160px;">Số nhân sự</th>
                                <th style="width: 110px;">Thứ tự</th>
                                <th style="width: 150px;">Trạng thái</th>
                                <th style="width: 160px;">Ngày cập nhật</th>
                                <th class="text-end" style="width: 100px;">Chi tiết</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($departments as $dept)
                                @php
                                    $parentName = !empty($dept->parent_id)
                                        ? ($parentsMap[$dept->parent_id] ?? ('ID #' . $dept->parent_id))
                                        : null;
                                    $empCount = $employeeCounts[$dept->id] ?? 0;
                                    $stKey = $dept->status ?? null;
                                    $stConfig = $stKey && isset($statusLabels[$stKey])
                                        ? $statusLabels[$stKey]
                                        : ['label' => $stKey ?: '—', 'class' => 'bg-secondary-subtle text-secondary border-secondary'];
                                @endphp
                                <tr>
                                    <td class="text-muted fw-medium">#{{ $dept->id }}</td>
                                    <td>
                                        @if (!empty($dept->code))
                                            <span class="badge bg-secondary-subtle text-dark border font-monospace fs-12 px-2 py-1">
                                                {{ $dept->code }}
                                            </span>
                                        @else
                                            <span class="text-muted small">—</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <i class="ri-building-line text-primary"></i>
                                            <span class="fw-semibold text-dark">{{ $dept->name ?? '—' }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        @if ($parentName)
                                            <span class="badge bg-light text-dark border">{{ $parentName }}</span>
                                        @else
                                            <span class="text-muted small">—</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('backend.employees.index', ['department_id' => $dept->id]) }}"
                                           class="badge bg-primary-subtle text-primary border border-primary border-opacity-25 text-decoration-none py-1 px-2 fs-12"
                                           title="Xem danh sách nhân sự thuộc phòng {{ $dept->name }}">
                                            <i class="ri-team-line me-1"></i> {{ $empCount }} nhân sự
                                        </a>
                                    </td>
                                    <td>{{ $dept->sort_order ?? 0 }}</td>
                                    <td>
                                        <span class="badge {{ $stConfig['class'] }} border border-opacity-25 px-2 py-1">
                                            {{ $stConfig['label'] }}
                                        </span>
                                    </td>
                                    <td>
                                        @if (!empty($dept->updated_at))
                                            <span class="small text-muted">{{ \Illuminate\Support\Carbon::parse($dept->updated_at)->format('d/m/Y H:i') }}</span>
                                        @else
                                            <span class="text-muted small">—</span>
                                        @endif
                                    </td>
                                    <td class="text-end">
                                        <button
                                            type="button"
                                            class="btn btn-sm btn-soft-info js-view-department"
                                            data-department="{{ json_encode($dept, JSON_UNESCAPED_UNICODE) }}"
                                            data-parent="{{ $parentName ?? '—' }}"
                                            data-emp-count="{{ $empCount }}"
                                            title="Xem chi tiết"
                                        >
                                            <i class="ri-eye-line align-bottom me-1"></i> Xem
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center text-muted py-5">
                                        <i class="ri-building-line fs-2 mb-2 d-block text-secondary"></i>
                                        Không tìm thấy phòng ban nào phù hợp trong bảng <code>{{ $tableName }}</code>.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mt-3">
                    <div class="text-muted small">
                        Hiển thị từ <strong>{{ $departments->firstItem() ?? 0 }}</strong> đến <strong>{{ $departments->lastItem() ?? 0 }}</strong> trên tổng số <strong>{{ $departments->total() }}</strong> phòng ban
                    </div>
                    <div>
                        {{ $departments->links('pagination::bootstrap-4') }}
                    </div>
                </div>
            </div>
        @endif
    </div>

    {{-- Modal Xem chi tiết phòng ban --}}
    <div class="modal fade" id="departmentDetailModal" tabindex="-1" aria-labelledby="departmentDetailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h5 class="modal-title d-flex align-items-center gap-2" id="departmentDetailModalLabel">
                        <i class="ri-building-line text-primary"></i>
                        <span>Thông tin chi tiết phòng ban</span>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="departmentDetailModalBody">
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
    var modalEl = document.getElementById('departmentDetailModal');
    var modal = modalEl ? new bootstrap.Modal(modalEl) : null;
    var modalBody = document.getElementById('departmentDetailModalBody');
    var modalTitle = document.getElementById('departmentDetailModalLabel');

    var fieldLabels = {
        id: 'ID',
        parent_id: 'Phòng ban cấp trên',
        code: 'Mã phòng ban',
        name: 'Tên phòng ban',
        sort_order: 'Thứ tự hiển thị',
        status: 'Trạng thái',
        created_at: 'Ngày tạo',
        updated_at: 'Cập nhật lần cuối'
    };

    function escapeHtml(str) {
        return String(str ?? '')
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');
    }

    document.querySelectorAll('.js-view-department').forEach(function (btn) {
        btn.addEventListener('click', function () {
            var raw = btn.getAttribute('data-department');
            if (!raw || !modal || !modalBody) return;

            var dept = {};
            try {
                dept = JSON.parse(raw);
            } catch (e) {
                return;
            }

            var parentName = btn.getAttribute('data-parent') || '—';
            var empCount = btn.getAttribute('data-emp-count') || '0';

            if (modalTitle) {
                modalTitle.innerHTML = '<i class="ri-building-line text-primary"></i> <span>Chi tiết phòng ban: <strong>' + escapeHtml(dept.name || ('#' + dept.id)) + '</strong></span>';
            }

            var rowsHtml = '';
            Object.keys(dept).forEach(function (key) {
                if (key === 'deleted_at') return;
                var label = fieldLabels[key] || key;
                var val = dept[key];
                var displayVal = '';

                if (key === 'parent_id') {
                    displayVal = escapeHtml(parentName) + (val ? ' <span class="text-muted small">(ID: ' + escapeHtml(val) + ')</span>' : '');
                } else if (val === null || val === undefined || val === '') {
                    displayVal = '<span class="text-muted fst-italic">—</span>';
                } else {
                    displayVal = escapeHtml(val);
                }

                rowsHtml += '<tr>' +
                    '<th class="bg-light text-muted fw-medium" style="width: 40%;">' + escapeHtml(label) + ' <code class="ms-1 text-secondary">(' + escapeHtml(key) + ')</code></th>' +
                    '<td>' + displayVal + '</td>' +
                '</tr>';
            });

            rowsHtml += '<tr>' +
                '<th class="bg-light text-muted fw-medium">Số nhân sự trực thuộc</th>' +
                '<td><span class="badge bg-primary">' + escapeHtml(empCount) + ' nhân sự</span></td>' +
            '</tr>';

            modalBody.innerHTML = '<div class="table-responsive"><table class="table table-bordered table-sm mb-0">' + rowsHtml + '</table></div>';
            modal.show();
        });
    });
});
</script>
@endpush
