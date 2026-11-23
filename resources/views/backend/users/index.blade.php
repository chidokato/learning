@extends('backend.layouts.app')

@section('title', 'Tài khoản')
@section('page_title', 'Tài khoản')
@section('breadcrumb', 'Tài khoản')

@section('content')
    <div class="card">
        <div class="card-header d-flex flex-wrap align-items-center justify-content-between gap-2">
            <div>
                <h4 class="card-title mb-0">Danh sách tài khoản</h4>
                <p class="text-muted small mb-0">Quản lý thông tin đăng nhập và đồng bộ liên kết với nhân sự qua Mã nhân viên.</p>
            </div>

            <div class="d-flex gap-2">
                <form action="{{ route('backend.users.index') }}" method="GET" class="d-flex position-relative">
                    <input
                        type="text"
                        name="search"
                        class="form-control"
                        placeholder="Tìm theo mã NV, tên, email, SĐT..."
                        value="{{ $search ?? '' }}"
                        style="min-width: 260px;"
                    >
                    @if(isset($search) && $search !== '')
                        <a href="{{ route('backend.users.index') }}" class="position-absolute end-0 top-50 translate-middle-y text-muted me-2 text-decoration-none" title="Xóa tìm kiếm">
                            <i class="ri-close-line"></i>
                        </a>
                    @endif
                </form>
                <a href="{{ route('backend.users.create') }}" class="btn btn-primary text-nowrap">
                    <i class="ri-add-line align-bottom me-1"></i> Thêm tài khoản
                </a>
            </div>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-nowrap table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Mã NV</th>
                            <th>Tên NV (DB chung)</th>
                            <th>Phòng ban</th>
                            <th>Tên tài khoản</th>
                            <th>Số điện thoại</th>
                            <th>Email</th>
                            <th>Quyền</th>
                            <th>Ngày tạo</th>
                            <th>Trạng thái</th>
                            <th class="text-end">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $user)
                            @php
                                $empCode = trim((string) ($user->employee_code ?? ''));
                                if ($empCode === '' && !empty($user->username) && isset($employeesByCode[trim((string) $user->username)])) {
                                    $empCode = trim((string) $user->username);
                                }
                                $linkedEmp = ($empCode !== '' && isset($employeesByCode[$empCode])) ? $employeesByCode[$empCode] : null;
                                $deptName = $linkedEmp->department_name ?? ($user->department->name ?? '');
                            @endphp
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>
                                    @if ($empCode !== '')
                                        <span class="badge bg-secondary-subtle text-dark border font-monospace fs-12">
                                            {{ $empCode }}
                                        </span>
                                    @else
                                        <span class="text-muted small">—</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($linkedEmp)
                                        <span class="fw-medium text-dark">{{ $linkedEmp->name }}</span>
                                    @else
                                        <span class="text-muted small">—</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($deptName)
                                        <span class="badge bg-primary-subtle text-primary border border-primary border-opacity-25">
                                            {{ $deptName }}
                                        </span>
                                    @else
                                        <span class="text-muted small">—</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        @if ($user->avatar)
                                            <img src="{{ \Illuminate\Support\Str::startsWith($user->avatar, ['http://', 'https://']) ? $user->avatar : asset($user->avatar) }}" alt="" class="rounded-circle avatar-xxs me-2 object-fit-cover">
                                        @endif
                                        <span class="fw-medium">{{ $user->name }}</span>
                                    </div>
                                </td>
                                <td>{{ $user->phone ?: ($linkedEmp->phone ?? '—') }}</td>
                                <td>{{ $user->email }}</td>
                                <td><span class="badge bg-secondary">{{ $user->permission_label }}</span></td>
                                <td>{{ $user->created_at ? $user->created_at->format('d/m/Y H:i') : '' }}</td>
                                <td>
                                    <button
                                        type="button"
                                        class="status-toggle {{ $user->is_active ? 'is-active' : 'is-inactive' }}"
                                        data-toggle-status
                                        data-url="{{ route('backend.users.toggle-status', $user) }}"
                                        aria-pressed="{{ $user->is_active ? 'true' : 'false' }}"
                                        @if (auth()->id() === $user->id) disabled title="Không thể tự khóa tài khoản của chính mình" @endif
                                    ></button>
                                </td>
                                <td class="text-end">
                                    <a href="{{ route('backend.users.edit', $user) }}" class="btn btn-sm btn-soft-warning">Sửa</a>
                                    <form action="{{ route('backend.users.destroy', $user) }}" method="POST" class="d-inline" data-confirm-delete data-confirm-message="Bạn có chắc muốn xóa tài khoản này?">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-soft-danger">Xóa</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="11" class="text-center text-muted py-4">Chưa có tài khoản nào.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mt-3">
                <div class="text-muted small">
                    Hiển thị từ <strong>{{ $users->firstItem() ?? 0 }}</strong> đến <strong>{{ $users->lastItem() ?? 0 }}</strong> trên tổng số <strong>{{ $users->total() }}</strong> tài khoản
                </div>
                <div>
                    {{ $users->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>
@endsection
