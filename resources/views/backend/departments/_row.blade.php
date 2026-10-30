<tr>
    <td>
        <div class="d-flex align-items-center">
            @if ($level > 0)
                <span class="text-muted font-monospace me-2" style="white-space: pre;">{{ str_repeat('    ', $level - 1) }}└── </span>
            @endif
            <div>
                <div class="d-flex align-items-center gap-2">
                    <span class="fw-semibold text-dark">{{ $department->name }}</span>
                    @if ($level === 0)
                        <span class="badge bg-primary-subtle text-primary border border-primary border-opacity-25" style="font-size: 11px;">Gốc</span>
                    @else
                        <span class="badge bg-info-subtle text-info border border-info border-opacity-25" style="font-size: 10px;">Cấp {{ $level + 1 }}</span>
                    @endif
                </div>
                @if ($department->description)
                    <div class="text-muted small mt-1 text-truncate" style="max-width: 380px;">{{ $department->description }}</div>
                @endif
            </div>
        </div>
    </td>
    <td>
        @if ($department->code)
            <span class="badge bg-secondary-subtle text-dark border font-monospace px-2 py-1 fs-12">{{ $department->code }}</span>
        @else
            <span class="text-muted small">—</span>
        @endif
    </td>
    <td>
        @php
            $directUsers = $department->users->count();
            $totalUsers = $department->total_users_count;
        @endphp
        <a href="{{ route('backend.users.index', ['department_id' => $department->id]) }}" class="badge bg-success-subtle text-success border border-success border-opacity-25 text-decoration-none py-1 px-2 fs-12" title="Xem danh sách nhân viên phòng ban này">
            <i class="ri-user-line me-1"></i> {{ $directUsers }} nhân sự
            @if ($totalUsers > $directUsers)
                <span class="text-secondary fw-normal">({{ $totalUsers }} tổng)</span>
            @endif
        </a>
    </td>
    <td>
        <input
            type="number"
            min="0"
            class="form-control form-control-sm sort-order-input"
            style="width: 80px;"
            value="{{ $department->sort_order }}"
            data-update-sort-order
            data-url="{{ route('backend.departments.update-sort-order', $department) }}"
            data-initial-value="{{ $department->sort_order }}"
        >
    </td>
    <td>
        <div class="d-inline-flex align-items-center gap-2">
            <button
                type="button"
                class="status-toggle {{ $department->is_active ? 'is-active' : 'is-inactive' }}"
                data-toggle-status
                data-url="{{ route('backend.departments.toggle-status', $department) }}"
                aria-pressed="{{ $department->is_active ? 'true' : 'false' }}"
            ></button>
            <span class="status-toggle-label {{ $department->is_active ? 'text-success' : 'text-danger' }}" data-status-label>
                {{ $department->is_active ? 'Hiển thị' : 'Ẩn' }}
            </span>
        </div>
    </td>
    <td class="text-end">
        <div class="d-inline-flex align-items-center gap-1">
            <a href="{{ route('backend.departments.create', ['parent_id' => $department->id]) }}" class="btn btn-sm btn-soft-info" title="Thêm phòng ban trực thuộc">
                <i class="ri-add-line"></i> Con
            </a>
            <a href="{{ route('backend.departments.edit', $department) }}" class="btn btn-sm btn-soft-warning" title="Chỉnh sửa">
                <i class="ri-pencil-line"></i> Sửa
            </a>
            <form action="{{ route('backend.departments.destroy', $department) }}" method="POST" class="d-inline" data-confirm-delete data-confirm-message="Bạn có chắc muốn xóa phòng ban '{{ $department->name }}'?">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-sm btn-soft-danger" title="Xóa">
                    <i class="ri-delete-bin-line"></i> Xóa
                </button>
            </form>
        </div>
    </td>
</tr>

@if ($department->children_tree && $department->children_tree->isNotEmpty())
    @foreach ($department->children_tree as $child)
        @include('backend.departments._row', ['department' => $child, 'level' => $level + 1])
    @endforeach
@endif
