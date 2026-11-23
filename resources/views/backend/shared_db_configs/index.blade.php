@extends('backend.layouts.app')

@section('title', 'Cấu hình DB dùng chung')
@section('page_title', 'Cấu hình DB dùng chung')
@section('breadcrumb', 'Cấu hình DB dùng chung')

@section('content')
    <div class="card">
        <div class="card-header d-flex flex-wrap align-items-center justify-content-between gap-3">
            <div>
                <h4 class="card-title mb-1">
                    <i class="ri-database-2-line text-primary me-1"></i> Danh sách kết nối & Bảng DB dùng chung
                </h4>
                <p class="text-muted mb-0 small">
                    Quản lý các kết nối tới Database khác để dùng chung bảng dữ liệu. Hỗ trợ kiểm tra kết nối và xem trước dữ liệu bảng.
                </p>
            </div>
            <div>
                <a href="{{ route('backend.shared-db-configs.create') }}" class="btn btn-primary">
                    <i class="ri-add-line align-bottom me-1"></i> Thêm cấu hình DB mới
                </a>
            </div>
        </div>

        <div class="card-body">
            @if ($configs->isEmpty())
                <div class="text-center py-5 text-muted">
                    <div class="fs-1 text-primary mb-2">
                        <i class="ri-database-2-line"></i>
                    </div>
                    <h5>Chưa có cấu hình DB dùng chung nào</h5>
                    <p class="text-muted mb-3">Bạn có thể chủ động thêm thông tin kết nối (Host, Port, Database, Username, Password, Tên bảng) để dùng chung bảng từ DB khác.</p>
                    <a href="{{ route('backend.shared-db-configs.create') }}" class="btn btn-sm btn-primary">
                        <i class="ri-add-line align-bottom me-1"></i> Thêm cấu hình đầu tiên
                    </a>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 50px;">#</th>
                                <th>Tên cấu hình / Mã gọi</th>
                                <th>Máy chủ & Database</th>
                                <th>Bảng dùng chung</th>
                                <th>Tài khoản DB</th>
                                <th style="width: 130px;">Trạng thái</th>
                                <th class="text-end" style="width: 240px;">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($configs as $item)
                                <tr>
                                    <td>{{ $loop->iteration + $configs->firstItem() - 1 }}</td>
                                    <td>
                                        <div class="fw-semibold text-dark">{{ $item->name }}</div>
                                        <div class="small text-muted">
                                            Mã code: <code class="text-primary">{{ $item->code }}</code>
                                        </div>
                                        @if ($item->description)
                                            <div class="small text-muted text-truncate" style="max-width: 240px;" title="{{ $item->description }}">
                                                {{ $item->description }}
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        <div>
                                            <span class="badge bg-info-subtle text-info text-uppercase me-1">{{ $item->driver }}</span>
                                            <span class="fw-medium">{{ $item->host }}:{{ $item->port }}</span>
                                        </div>
                                        <div class="small text-muted mt-1">
                                            DB: <strong class="text-dark">{{ $item->database }}</strong>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-wrap gap-1">
                                            @foreach ($item->getTableNames() as $tblName)
                                                <span class="badge bg-primary-subtle text-primary fs-12 px-2 py-1">
                                                    <i class="ri-table-line me-1"></i>{{ $item->prefix }}{{ $tblName }}
                                                </span>
                                            @endforeach
                                        </div>
                                    </td>
                                    <td>
                                        <div class="small">
                                            <i class="ri-user-line text-muted me-1"></i>{{ $item->username }}
                                        </div>
                                        <div class="small text-muted">
                                            Charset: {{ $item->charset }}
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-check form-switch">
                                            <input
                                                class="form-check-input js-toggle-status"
                                                type="checkbox"
                                                role="switch"
                                                data-url="{{ route('backend.shared-db-configs.toggle-status', $item) }}"
                                                {{ $item->is_active ? 'checked' : '' }}
                                            >
                                            <span class="badge {{ $item->is_active ? 'bg-success-subtle text-success' : 'bg-secondary-subtle text-secondary' }} js-status-label">
                                                {{ $item->is_active ? 'Đang bật' : 'Tạm tắt' }}
                                            </span>
                                        </div>
                                    </td>
                                    <td class="text-end">
                                        <div class="d-flex justify-content-end gap-1">
                                            <button
                                                type="button"
                                                class="btn btn-sm btn-soft-success js-test-row-connection"
                                                data-id="{{ $item->id }}"
                                                data-name="{{ $item->name }}"
                                                title="Kiểm tra kết nối & Xem dữ liệu bảng"
                                            >
                                                <i class="ri-plug-line me-1"></i> Kiểm tra / Xem bảng
                                            </button>
                                            <a href="{{ route('backend.shared-db-configs.edit', $item) }}" class="btn btn-sm btn-soft-info" title="Chỉnh sửa">
                                                <i class="ri-pencil-fill"></i>
                                            </a>
                                            <form action="{{ route('backend.shared-db-configs.destroy', $item) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa cấu hình DB dùng chung này?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-soft-danger" title="Xóa">
                                                    <i class="ri-delete-bin-fill"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    {{ $configs->links('pagination::bootstrap-5') }}
                </div>
            @endif
        </div>
    </div>

    <!-- Modal Xem trước dữ liệu bảng dùng chung -->
    <div class="modal fade" id="sharedDbPreviewModal" tabindex="-1" aria-labelledby="sharedDbPreviewModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h5 class="modal-title" id="sharedDbPreviewModalLabel">
                        <i class="ri-database-2-line text-primary me-1"></i> Kết quả kiểm tra kết nối & Xem trước bảng
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="sharedDbPreviewBody">
                    <div class="text-center py-4">
                        <div class="spinner-border text-primary" role="status"></div>
                        <p class="mt-2 text-muted mb-0">Đang kết nối tới Database...</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

    // Toggle status
    document.querySelectorAll('.js-toggle-status').forEach(function (checkbox) {
        checkbox.addEventListener('change', function () {
            const url = this.getAttribute('data-url');
            const label = this.closest('.form-switch').querySelector('.js-status-label');

            fetch(url, {
                method: 'PATCH',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                }
            })
            .then(res => res.json())
            .then(data => {
                if (label) {
                    label.textContent = data.label;
                    label.className = 'badge js-status-label ' + (data.is_active ? 'bg-success-subtle text-success' : 'bg-secondary-subtle text-secondary');
                }
            })
            .catch(() => {
                alert('Không thể cập nhật trạng thái.');
                this.checked = !this.checked;
            });
        });
    });

    // Test connection & preview table
    const previewModalEl = document.getElementById('sharedDbPreviewModal');
    const previewModal = previewModalEl ? new bootstrap.Modal(previewModalEl) : null;
    const previewBody = document.getElementById('sharedDbPreviewBody');

    document.querySelectorAll('.js-test-row-connection').forEach(function (btn) {
        btn.addEventListener('click', function () {
            const configId = this.getAttribute('data-id');
            const configName = this.getAttribute('data-name');

            if (previewModal) {
                document.getElementById('sharedDbPreviewModalLabel').innerHTML =
                    `<i class="ri-database-2-line text-primary me-1"></i> Kiểm tra kết nối: <strong>${escapeHtml(configName)}</strong>`;
                previewBody.innerHTML = `
                    <div class="text-center py-5">
                        <div class="spinner-border text-primary" role="status"></div>
                        <p class="mt-2 text-muted mb-0">Đang kiểm tra kết nối và tải cấu trúc bảng...</p>
                    </div>
                `;
                previewModal.show();
            }

            fetch("{{ route('backend.shared-db-configs.test-connection') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                },
                body: JSON.stringify({ config_id: configId })
            })
            .then(async res => {
                const data = await res.json();
                renderPreviewResult(data, res.ok);
            })
            .catch(err => {
                renderPreviewResult({
                    success: false,
                    message: 'Lỗi hệ thống khi gửi yêu cầu kiểm tra: ' + err.message
                }, false);
            });
        });
    });

    function renderPreviewResult(data, isOk) {
        if (!previewBody) return;

        if (!data.success) {
            previewBody.innerHTML = `
                <div class="alert alert-danger mb-0">
                    <h6 class="alert-heading fw-bold"><i class="ri-error-warning-line me-1"></i> Kết nối không thành công</h6>
                    <p class="mb-0">${escapeHtml(data.message || 'Không thể kết nối.')}</p>
                </div>
            `;
            return;
        }

        const tables = data.tables || [{
            table_name: data.table_name,
            columns: data.columns || [],
            total_rows: data.total_rows || 0,
            sample_rows: data.sample_rows || []
        }];

        let tablesHtml = tables.map(tbl => {
            const columns = tbl.columns || [];
            const rows = tbl.sample_rows || [];
            let columnsBadgeHtml = columns.map(col => `<code class="badge bg-light text-dark border me-1 mb-1 fs-12">${escapeHtml(col)}</code>`).join('');

            let tableHtml = '';
            if (rows.length === 0) {
                tableHtml = `<div class="alert alert-info mb-0">Bảng <strong>${escapeHtml(tbl.table_name)}</strong> hiện chưa có bản ghi nào (0 dòng).</div>`;
            } else {
                let thead = columns.map(col => `<th class="text-nowrap">${escapeHtml(col)}</th>`).join('');
                let tbody = rows.map(row => {
                    let tds = columns.map(col => {
                        let val = row[col];
                        if (val === null || val === undefined) {
                            return `<td class="text-muted fst-italic">NULL</td>`;
                        }
                        let str = typeof val === 'object' ? JSON.stringify(val) : String(val);
                        if (str.length > 80) str = str.substring(0, 80) + '...';
                        return `<td class="text-nowrap">${escapeHtml(str)}</td>`;
                    }).join('');
                    return `<tr>${tds}</tr>`;
                }).join('');

                tableHtml = `
                    <div class="table-responsive border rounded">
                        <table class="table table-sm table-striped table-hover mb-0">
                            <thead class="table-light">
                                <tr>${thead}</tr>
                            </thead>
                            <tbody>${tbody}</tbody>
                        </table>
                    </div>
                `;
            }

            return `
                <div class="card border mb-3">
                    <div class="card-header bg-light d-flex align-items-center justify-content-between py-2">
                        <h6 class="mb-0 fw-bold text-primary">
                            <i class="ri-table-line me-1"></i> Bảng: <code>${escapeHtml(tbl.table_name)}</code>
                        </h6>
                        <span class="badge bg-primary">${tbl.total_rows} bản ghi</span>
                    </div>
                    <div class="card-body">
                        <div class="mb-2">
                            <div class="small fw-semibold mb-1">Danh sách cột (${columns.length} cột):</div>
                            <div>${columnsBadgeHtml}</div>
                        </div>
                        <div>
                            <div class="small fw-semibold mb-1">Xem trước dữ liệu mẫu:</div>
                            ${tableHtml}
                        </div>
                    </div>
                </div>
            `;
        }).join('');

        previewBody.innerHTML = `
            <div class="alert alert-success d-flex align-items-center justify-content-between">
                <div>
                    <i class="ri-checkbox-circle-line fs-18 align-middle me-1"></i>
                    <strong>${escapeHtml(data.message)}</strong>
                </div>
                <span class="badge bg-success">${tables.length} bảng / Tổng ${data.total_rows} dòng</span>
            </div>
            ${tablesHtml}
        `;
    }

    function escapeHtml(str) {
        return String(str ?? '')
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');
    }
});
</script>
@endpush
