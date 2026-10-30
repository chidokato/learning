@extends('backend.layouts.app')

@section('title', 'User')
@section('page_title', 'User')
@section('breadcrumb', 'User')

@section('content')
    <div class="card">
        <div class="card-header d-flex flex-wrap align-items-center justify-content-between gap-2">
            <div>
                <h4 class="card-title mb-0">Danh sách người dùng</h4>
                <p class="text-muted small mb-0">Quản lý tài khoản, phân quyền và gán phòng ban nhân sự.</p>
            </div>
            <div class="d-flex align-items-center gap-2">
                <a href="{{ route('backend.departments.index') }}" class="btn btn-soft-secondary">
                    <i class="ri-building-line align-bottom me-1"></i> Quản lý phòng ban
                </a>
                <a href="{{ route('backend.users.create') }}" class="btn btn-primary">
                    <i class="ri-user-add-line align-bottom me-1"></i> Thêm user
                </a>
            </div>
        </div>

        <div class="card-body border-bottom bg-light bg-opacity-25">
            <form action="{{ route('backend.users.index') }}" method="GET" class="row g-2 align-items-center">
                <div class="col-md-4">
                    <div class="input-group">
                        <span class="input-group-text"><i class="ri-search-line"></i></span>
                        <input
                            type="text"
                            name="search"
                            class="form-control"
                            placeholder="Tìm kiếm theo tên, email, sđt..."
                            value="{{ request('search') }}"
                        >
                    </div>
                </div>

                <div class="col-md-3">
                    <select name="department_id" class="form-select">
                        <option value="">-- Tất cả phòng ban --</option>
                        @if (isset($departmentOptions))
                            @foreach ($departmentOptions as $deptId => $deptLabel)
                                <option value="{{ $deptId }}" {{ (string) request('department_id') === (string) $deptId ? 'selected' : '' }}>
                                    {{ $deptLabel }}
                                </option>
                            @endforeach
                        @endif
                    </select>
                </div>

                <div class="col-md-2">
                    <select name="permission" class="form-select">
                        <option value="">-- Tất cả phân quyền --</option>
                        <option value="1" {{ request('permission') == 1 ? 'selected' : '' }}>Super Admin</option>
                        <option value="2" {{ request('permission') == 2 ? 'selected' : '' }}>Admin</option>
                        <option value="3" {{ request('permission') == 3 ? 'selected' : '' }}>Moderator</option>
                        <option value="4" {{ request('permission') == 4 ? 'selected' : '' }}>Instructor</option>
                        <option value="5" {{ request('permission') == 5 ? 'selected' : '' }}>Student</option>
                        <option value="6" {{ request('permission') == 6 ? 'selected' : '' }}>Guest</option>
                    </select>
                </div>

                <div class="col-md-1">
                    <select name="per_page" class="form-select" title="Số dòng mỗi trang">
                        <option value="10" {{ request('per_page', 20) == 10 ? 'selected' : '' }}>10 / trang</option>
                        <option value="20" {{ request('per_page', 20) == 20 ? 'selected' : '' }}>20 / trang</option>
                        <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50 / trang</option>
                        <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100 / trang</option>
                    </select>
                </div>

                <div class="col-md-2 d-flex gap-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="ri-filter-line me-1"></i> Lọc
                    </button>
                    @if (request()->hasAny(['search', 'department_id', 'permission', 'per_page']))
                        <a href="{{ route('backend.users.index') }}" class="btn btn-soft-danger" title="Xóa bộ lọc">
                            <i class="ri-close-line"></i>
                        </a>
                    @endif
                </div>
            </form>
        </div>

        {{-- Thanh công cụ thao tác hàng loạt (Bulk Actions Toolbar) --}}
        <div id="bulk-toolbar" class="card-body bg-primary bg-opacity-10 border-bottom d-none py-2 px-3">
            <div class="d-flex align-items-center justify-content-between gap-3 flex-nowrap">
                <div class="d-flex align-items-center gap-2 text-nowrap">
                    <span class="badge bg-primary fs-12 px-2 py-1">
                        <i class="ri-checkbox-circle-line me-1"></i> Đã chọn <strong id="bulk-selected-count">0</strong> người
                    </span>
                    <span class="text-muted small d-none d-md-inline">Cập nhật phòng ban cho người đã chọn:</span>
                </div>

                <div class="d-flex align-items-center gap-2 flex-nowrap ms-auto">
                    <select id="bulk-department-select" class="form-select form-select-sm" style="width: 260px;">
                        <option value="">-- Chọn phòng ban gán hàng loạt --</option>
                        <option value="none" class="text-danger fw-semibold">❌ Gỡ khỏi phòng ban (Để trống)</option>
                        @if (isset($departmentOptions))
                            @foreach ($departmentOptions as $deptId => $deptLabel)
                                <option value="{{ $deptId }}">{{ $deptLabel }}</option>
                            @endforeach
                        @endif
                    </select>

                    <button type="button" id="btn-apply-bulk" class="btn btn-sm btn-primary text-nowrap">
                        <i class="ri-check-line align-bottom me-1"></i> Áp dụng hàng loạt
                    </button>

                    <button type="button" id="btn-clear-bulk" class="btn btn-sm btn-outline-secondary text-nowrap">
                        Bỏ chọn
                    </button>
                </div>
            </div>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" id="users-table">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 40px;" class="text-center">
                                <input type="checkbox" id="check-all" class="form-check-input" title="Chọn tất cả">
                            </th>
                            <th style="width: 60px;">ID</th>
                            <th>Họ và tên</th>
                            <th style="min-width: 200px;">Phòng ban</th>
                            <th>Chức danh</th>
                            <th>Số điện thoại</th>
                            <th>Email</th>
                            <th>Quyền</th>
                            <th>Ngày tạo</th>
                            <th class="text-end" style="width: 140px;">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $user)
                            <tr id="user-row-{{ $user->id }}" class="user-row">
                                <td class="text-center">
                                    <input
                                        type="checkbox"
                                        class="form-check-input user-checkbox"
                                        value="{{ $user->id }}"
                                        data-name="{{ $user->name }}"
                                    >
                                </td>
                                <td>{{ $user->id }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        @if ($user->avatar)
                                            <img src="{{ asset($user->avatar) }}" alt="" class="rounded-circle avatar-xs me-2 object-fit-cover">
                                        @else
                                            <div class="avatar-xs me-2">
                                                <span class="avatar-title rounded-circle bg-soft-primary text-primary fs-12">
                                                    {{ mb_substr($user->name, 0, 1) }}
                                                </span>
                                            </div>
                                        @endif
                                        <span class="fw-medium">{{ $user->name }}</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-inline-flex align-items-center gap-1">
                                        <span class="user-dept-container" id="user-dept-{{ $user->id }}">
                                            @if ($user->department)
                                                <a href="{{ route('backend.users.index', ['department_id' => $user->department_id]) }}" class="badge bg-primary-subtle text-primary border border-primary border-opacity-25 text-decoration-none py-1 px-2" title="{{ $user->department->breadcrumb }}">
                                                    <i class="ri-building-line me-1"></i>{{ $user->department->name }}
                                                </a>
                                            @else
                                                <span class="text-muted small">—</span>
                                            @endif
                                        </span>
                                        <button
                                            type="button"
                                            class="btn btn-sm btn-link text-muted p-0 opacity-75 quick-edit-dept-btn"
                                            data-user-id="{{ $user->id }}"
                                            data-user-name="{{ $user->name }}"
                                            data-current-dept="{{ $user->department_id ?? '' }}"
                                            title="Đổi nhanh phòng ban cho {{ $user->name }}"
                                            style="line-height: 1;"
                                        >
                                            <i class="ri-edit-line fs-14"></i>
                                        </button>
                                    </div>
                                </td>
                                <td>{{ $user->job_title ?? '—' }}</td>
                                <td>{{ $user->phone ?? '—' }}</td>
                                <td>{{ $user->email }}</td>
                                <td><span class="badge bg-secondary">{{ $user->permission_label }}</span></td>
                                <td>{{ $user->created_at ? $user->created_at->format('d/m/Y H:i') : '' }}</td>
                                <td class="text-end">
                                    <a href="{{ route('backend.users.edit', $user) }}" class="btn btn-sm btn-soft-warning">Sửa</a>
                                    <form action="{{ route('backend.users.destroy', $user) }}" method="POST" class="d-inline" data-confirm-delete data-confirm-message="Bạn có chắc muốn xóa user này?">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-soft-danger">Xóa</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="text-center text-muted py-5">
                                    <i class="ri-user-unfollow-line fs-2 mb-2 d-block text-secondary"></i>
                                    Không tìm thấy user nào phù hợp.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mt-3">
                <div class="text-muted small">
                    Hiển thị từ <strong>{{ $users->firstItem() ?? 0 }}</strong> đến <strong>{{ $users->lastItem() ?? 0 }}</strong> trên tổng số <strong>{{ $users->total() }}</strong> nhân sự
                </div>
                <div>
                    {{ $users->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    var checkAll = document.getElementById('check-all');
    var checkboxes = document.querySelectorAll('.user-checkbox');
    var bulkToolbar = document.getElementById('bulk-toolbar');
    var selectedCountSpan = document.getElementById('bulk-selected-count');
    var bulkDeptSelect = document.getElementById('bulk-department-select');
    var btnApplyBulk = document.getElementById('btn-apply-bulk');
    var btnClearBulk = document.getElementById('btn-clear-bulk');
    var csrfToken = document.querySelector('meta[name="csrf-token"]') ? document.querySelector('meta[name="csrf-token"]').getAttribute('content') : '';
    var bulkUrl = "{{ route('backend.users.bulk-department') }}";

    // Danh sách phòng ban cho Quick Edit
    var departmentOptions = {
        "": "-- Không có phòng ban (Gỡ) --",
        @if (isset($departmentOptions))
            @foreach ($departmentOptions as $deptId => $deptLabel)
                "{{ $deptId }}": {!! json_encode($deptLabel) !!},
            @endforeach
        @endif
    };

    function updateToolbar() {
        var checked = document.querySelectorAll('.user-checkbox:checked');
        var count = checked.length;
        if (selectedCountSpan) {
            selectedCountSpan.textContent = count;
        }

        if (count > 0) {
            bulkToolbar.classList.remove('d-none');
            bulkToolbar.classList.add('d-block');
        } else {
            bulkToolbar.classList.add('d-none');
            bulkToolbar.classList.remove('d-block');
        }

        if (checkAll) {
            checkAll.checked = (count > 0 && count === checkboxes.length);
            checkAll.indeterminate = (count > 0 && count < checkboxes.length);
        }

        // Highlight selected rows
        checkboxes.forEach(function (cb) {
            var row = cb.closest('tr');
            if (row) {
                if (cb.checked) {
                    row.classList.add('table-primary');
                } else {
                    row.classList.remove('table-primary');
                }
            }
        });
    }

    if (checkAll) {
        checkAll.addEventListener('change', function () {
            checkboxes.forEach(function (cb) {
                cb.checked = checkAll.checked;
            });
            updateToolbar();
        });
    }

    checkboxes.forEach(function (cb) {
        cb.addEventListener('change', updateToolbar);
    });

    if (btnClearBulk) {
        btnClearBulk.addEventListener('click', function () {
            checkboxes.forEach(function (cb) {
                cb.checked = false;
            });
            updateToolbar();
        });
    }

    // Xử lý nút áp dụng hàng loạt
    if (btnApplyBulk) {
        btnApplyBulk.addEventListener('click', function () {
            var checked = document.querySelectorAll('.user-checkbox:checked');
            if (checked.length === 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Chưa chọn người dùng',
                    text: 'Vui lòng tích chọn ít nhất một người dùng trong bảng.',
                });
                return;
            }

            var deptVal = bulkDeptSelect.value;
            if (deptVal === '') {
                Swal.fire({
                    icon: 'warning',
                    title: 'Chưa chọn phòng ban',
                    text: 'Vui lòng chọn phòng ban muốn gán từ danh sách xổ xuống.',
                });
                return;
            }

            var deptText = bulkDeptSelect.options[bulkDeptSelect.selectedIndex].text;
            var userIds = Array.from(checked).map(function (cb) { return cb.value; });

            var confirmMsg = (deptVal === 'none')
                ? 'Bạn có chắc muốn GỠ KHỎI PHÒNG BAN cho ' + userIds.length + ' người dùng đã chọn?'
                : 'Bạn có chắc muốn chuyển ' + userIds.length + ' người dùng đã chọn vào:\n\n"' + deptText + '"?';

            Swal.fire({
                title: 'Xác nhận sửa hàng loạt',
                text: confirmMsg,
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Đồng ý cập nhật',
                cancelButtonText: 'Hủy bỏ',
                confirmButtonColor: '#405189',
                cancelButtonColor: '#74788d'
            }).then(function (result) {
                if (!result.isConfirmed) return;

                btnApplyBulk.disabled = true;
                btnApplyBulk.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Đang lưu...';

                fetch(bulkUrl, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        user_ids: userIds,
                        department_id: deptVal
                    })
                })
                .then(function (res) {
                    if (!res.ok) {
                        return res.json().then(function (err) { throw new Error(err.message || 'Lỗi server'); });
                    }
                    return res.json();
                })
                .then(function (data) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Thành công',
                        text: data.message,
                        timer: 1600,
                        showConfirmButton: false
                    }).then(function () {
                        window.location.reload();
                    });
                })
                .catch(function (err) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Có lỗi xảy ra',
                        text: err.message || 'Không thể cập nhật phòng ban.'
                    });
                })
                .finally(function () {
                    btnApplyBulk.disabled = false;
                    btnApplyBulk.innerHTML = '<i class="ri-check-line align-bottom me-1"></i> Áp dụng hàng loạt';
                });
            });
        });
    }

    // Đổi nhanh phòng ban cho 1 người (Quick Edit icon)
    document.querySelectorAll('.quick-edit-dept-btn').forEach(function (btn) {
        btn.addEventListener('click', function () {
            var userId = btn.getAttribute('data-user-id');
            var userName = btn.getAttribute('data-user-name');
            var currentDept = btn.getAttribute('data-current-dept');

            Swal.fire({
                title: 'Đổi phòng ban: ' + userName,
                input: 'select',
                inputOptions: departmentOptions,
                inputValue: currentDept || '',
                showCancelButton: true,
                confirmButtonText: 'Lưu thay đổi',
                cancelButtonText: 'Hủy',
                confirmButtonColor: '#405189',
                cancelButtonColor: '#74788d',
                inputValidator: function (value) {
                    return null;
                }
            }).then(function (result) {
                if (!result.isConfirmed) return;

                var selectedDept = result.value;

                fetch(bulkUrl, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        user_ids: [userId],
                        department_id: selectedDept === '' ? 'none' : selectedDept
                    })
                })
                .then(function (res) { return res.json(); })
                .then(function (data) {
                    if (data.success) {
                        var container = document.getElementById('user-dept-' + userId);
                        if (container) {
                            if (data.department_id) {
                                container.innerHTML = '<a href="{{ route("backend.users.index") }}?department_id=' + data.department_id + '" class="badge bg-primary-subtle text-primary border border-primary border-opacity-25 text-decoration-none py-1 px-2"><i class="ri-building-line me-1"></i>' + data.department_name + '</a>';
                            } else {
                                container.innerHTML = '<span class="text-muted small">—</span>';
                            }
                        }
                        btn.setAttribute('data-current-dept', data.department_id || '');

                        if (window.showBackendToast) {
                            window.showBackendToast('success', 'Thành công', data.message);
                        } else {
                            Swal.fire({
                                icon: 'success',
                                title: 'Thành công',
                                text: data.message,
                                timer: 1500,
                                showConfirmButton: false
                            });
                        }
                    } else {
                        throw new Error(data.message || 'Lỗi xử lý');
                    }
                })
                .catch(function (err) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Thất bại',
                        text: err.message || 'Không thể cập nhật phòng ban.'
                    });
                });
            });
        });
    });
});
</script>
@endpush
