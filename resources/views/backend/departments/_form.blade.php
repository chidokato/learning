@csrf

<div class="row">
    <div class="col-xl-9">
        <div class="card border">
            <div class="card-header">
                <h5 class="card-title mb-0">Thông tin phòng ban</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-8">
                        <div class="mb-3">
                            <label for="name" class="form-label">Tên phòng ban <span class="text-danger">*</span></label>
                            <input
                                type="text"
                                id="name"
                                name="name"
                                class="form-control @error('name') is-invalid @enderror"
                                value="{{ old('name', $department->name ?? '') }}"
                                placeholder="Ví dụ: Ban Giám Đốc, Khối Kinh Doanh, Phòng Marketing..."
                                required
                            >
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="mb-3">
                            <label for="code" class="form-label">Mã phòng ban</label>
                            <input
                                type="text"
                                id="code"
                                name="code"
                                class="form-control @error('code') is-invalid @enderror"
                                value="{{ old('code', $department->code ?? '') }}"
                                placeholder="Ví dụ: BGD, KKD, MKT..."
                            >
                            @error('code')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="mb-3">
                            <label for="slug" class="form-label">Slug</label>
                            <input
                                type="text"
                                id="slug"
                                name="slug"
                                class="form-control @error('slug') is-invalid @enderror"
                                value="{{ old('slug', $department->slug ?? '') }}"
                                placeholder="Tự động tạo theo tên phòng ban"
                            >
                            @error('slug')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Mã định danh duy nhất (tự sinh từ tên nếu để trống).</div>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="mb-0">
                            <label for="description" class="form-label">Mô tả / Chức năng nhiệm vụ</label>
                            <textarea
                                id="description"
                                name="description"
                                rows="4"
                                class="form-control @error('description') is-invalid @enderror"
                                placeholder="Mô tả chức năng, vai trò, nhiệm vụ của phòng ban..."
                            >{{ old('description', $department->description ?? '') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3">
        <div class="card border">
            <div class="card-header">
                <h5 class="card-title mb-0">Cấu hình phân cấp</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label for="parent_id" class="form-label">Phòng ban cha (Cấp trên)</label>
                    <select id="parent_id" name="parent_id" class="form-select @error('parent_id') is-invalid @enderror">
                        <option value="">-- Cấp cao nhất (Gốc) --</option>
                        @php
                            $selectedParentId = old('parent_id', $department->parent_id ?? $parentId ?? '');
                        @endphp
                        @foreach ($parentOptions as $id => $label)
                            <option value="{{ $id }}" {{ (string) $selectedParentId === (string) $id ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                    @error('parent_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <div class="form-text">Chọn phòng ban trực tiếp quản lý đơn vị này (để trống nếu là đơn vị gốc).</div>
                </div>

                <div class="mb-3">
                    <label for="sort_order" class="form-label">Thứ tự hiển thị</label>
                    <input
                        type="number"
                        min="0"
                        id="sort_order"
                        name="sort_order"
                        class="form-control @error('sort_order') is-invalid @enderror"
                        value="{{ old('sort_order', $department->sort_order ?? 0) }}"
                    >
                    @error('sort_order')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-check form-switch mt-3">
                    <input
                        class="form-check-input"
                        type="checkbox"
                        id="is_active"
                        name="is_active"
                        value="1"
                        {{ old('is_active', $department->is_active ?? true) ? 'checked' : '' }}
                    >
                    <label class="form-check-label" for="is_active">Đang hoạt động</label>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var nameInput = document.getElementById('name');
        var slugInput = document.getElementById('slug');

        if (!nameInput || !slugInput) {
            return;
        }

        function slugify(value) {
            return value
                .toLowerCase()
                .normalize('NFD')
                .replace(/[\u0300-\u036f]/g, '')
                .replace(/đ/g, 'd')
                .replace(/[^a-z0-9]+/g, '-')
                .replace(/^-+|-+$/g, '');
        }

        var isSlugEdited = slugInput.value.trim() !== '';

        slugInput.addEventListener('input', function() {
            isSlugEdited = slugInput.value.trim() !== '';
        });

        nameInput.addEventListener('input', function() {
            if (!isSlugEdited) {
                slugInput.value = slugify(nameInput.value);
            }
        });
    });
</script>
