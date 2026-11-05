@csrf

@if(isset($user) && $user->exists)
    @method('PUT')
@endif

@php
    $isEdit = isset($user) && $user->exists;
    $avatarImage = old('existing_avatar', $user->avatar ?? '');
    $currentPermission = (int) old('permission', $user->permission ?? 6);
    $isActive = (bool) old('is_active', $user->is_active ?? true);
    $isSelf = $isEdit && (auth()->id() === $user->id);
@endphp

<!-- Top Action Toolbar -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body py-3">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
            <div class="d-flex align-items-center gap-2">
                <a href="{{ route('backend.users.index') }}" class="btn btn-sm btn-outline-secondary">
                    <i class="ri-arrow-left-line align-bottom me-1"></i> Quay lại
                </a>
                <div class="vr mx-1 d-none d-sm-block"></div>
                <div class="d-flex align-items-center">
                    @if ($isEdit)
                        <span class="badge bg-info-subtle text-info border border-info-subtle fs-12 py-1 px-2">
                            <i class="ri-user-settings-line me-1"></i> Chỉnh sửa: <strong>{{ $user->name }}</strong>
                        </span>
                        @if ($isSelf)
                            <span class="badge bg-warning-subtle text-warning border border-warning-subtle fs-12 py-1 px-2 ms-2">
                                <i class="ri-shield-user-line me-1"></i> Tài khoản của bạn
                            </span>
                        @endif
                    @else
                        <span class="badge bg-primary-subtle text-primary border border-primary-subtle fs-12 py-1 px-2">
                            <i class="ri-user-add-line me-1"></i> Thêm người dùng mới
                        </span>
                    @endif
                </div>
            </div>

            <div class="d-flex align-items-center gap-2">
                <a href="{{ route('backend.users.index') }}" class="btn btn-sm btn-light">Hủy bỏ</a>
                <button type="submit" form="user-form" class="btn btn-sm btn-primary px-3 shadow-sm">
                    <i class="ri-save-3-line align-bottom me-1"></i> {{ $submitLabel ?? ($isEdit ? 'Lưu thay đổi' : 'Tạo người dùng') }}
                </button>
            </div>
        </div>
    </div>
</div>

@if (isset($errors) && $errors->any())
    <div class="alert alert-danger alert-dismissible fade show shadow-sm mb-4" role="alert">
        <div class="d-flex align-items-start">
            <i class="ri-error-warning-fill fs-18 text-danger me-2 mt-1"></i>
            <div>
                <h6 class="alert-heading fs-14 fw-semibold mb-1">Vui lòng kiểm tra lại thông tin:</h6>
                <ul class="mb-0 ps-3 small">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="row">
    <!-- Main Left Column -->
    <div class="col-xl-8 col-lg-7">
        <!-- Section 1: Account Information -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white border-bottom-dashed py-3">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0 me-3">
                        <div class="avatar-xs">
                            <span class="avatar-title bg-primary-subtle text-primary rounded-circle fs-16">
                                <i class="ri-shield-keyhole-line"></i>
                            </span>
                        </div>
                    </div>
                    <div class="flex-grow-1">
                        <h5 class="card-title mb-0 fs-15 fw-bold text-dark">Thông tin tài khoản & Đăng nhập</h5>
                        <p class="text-muted small mb-0">Các thông tin cơ bản để định danh và bảo mật tài khoản</p>
                    </div>
                </div>
            </div>

            <div class="card-body p-4">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="name" class="form-label fw-semibold">Họ và tên <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0 text-muted">
                                <i class="ri-user-3-line"></i>
                            </span>
                            <input
                                type="text"
                                class="form-control border-start-0 ps-1 @error('name') is-invalid @enderror"
                                id="name"
                                name="name"
                                value="{{ old('name', $user->name ?? '') }}"
                                placeholder="Ví dụ: Nguyễn Văn Tuấn"
                                required
                            >
                            @error('name')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label for="email" class="form-label fw-semibold">Email đăng nhập <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0 text-muted">
                                <i class="ri-mail-line"></i>
                            </span>
                            <input
                                type="email"
                                class="form-control border-start-0 ps-1 @error('email') is-invalid @enderror"
                                id="email"
                                name="email"
                                value="{{ old('email', $user->email ?? '') }}"
                                placeholder="Ví dụ: nguyenvantuan@company.com"
                                required
                            >
                            @error('email')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-text text-muted small">Email dùng để đăng nhập và nhận thông báo từ hệ thống.</div>
                    </div>

                    <div class="col-md-6">
                        <label for="username" class="form-label fw-semibold">Tên tài khoản (Username)</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0 text-muted">
                                <i class="ri-at-line"></i>
                            </span>
                            <input
                                type="text"
                                class="form-control border-start-0 ps-1 @error('username') is-invalid @enderror"
                                id="username"
                                name="username"
                                value="{{ old('username', $user->username ?? '') }}"
                                placeholder="Ví dụ: tuannv"
                            >
                            @error('username')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-text text-muted small">Viết liền không dấu, dùng để liên kết hồ sơ.</div>
                    </div>

                    <div class="col-md-6">
                        <label for="employee_code" class="form-label fw-semibold">Mã nhân viên (Mã NV)</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0 text-muted">
                                <i class="ri-barcode-box-line"></i>
                            </span>
                            <input
                                type="text"
                                class="form-control border-start-0 ps-1 @error('employee_code') is-invalid @enderror"
                                id="employee_code"
                                name="employee_code"
                                value="{{ old('employee_code', $user->employee_code ?? '') }}"
                                placeholder="Ví dụ: DXMB001"
                            >
                            @error('employee_code')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-text text-muted small">Mã số nhân sự theo quy chuẩn nội bộ công ty.</div>
                    </div>
                </div>

                <!-- Password Sub-section -->
                @if (!$isEdit)
                    <div class="border-top pt-4 mt-4">
                        <div class="d-flex align-items-center mb-3">
                            <i class="ri-lock-password-line text-primary fs-18 me-2"></i>
                            <h6 class="fs-14 fw-bold text-dark mb-0">Thiết lập mật khẩu</h6>
                        </div>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="password" class="form-label fw-semibold">Mật khẩu ban đầu <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 text-muted">
                                        <i class="ri-lock-line"></i>
                                    </span>
                                    <input
                                        type="password"
                                        class="form-control border-start-0 border-end-0 ps-1 @error('password') is-invalid @enderror"
                                        id="password"
                                        name="password"
                                        autocomplete="new-password"
                                        placeholder="Tối thiểu 6 ký tự"
                                        required
                                    >
                                    <button class="btn btn-outline-secondary border-start-0 toggle-password-btn" type="button" data-target="password" title="Hiện/ẩn mật khẩu">
                                        <i class="ri-eye-line"></i>
                                    </button>
                                    @error('password')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="password_confirmation" class="form-label fw-semibold">Xác nhận mật khẩu <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 text-muted">
                                        <i class="ri-lock-check-line"></i>
                                    </span>
                                    <input
                                        type="password"
                                        class="form-control border-start-0 border-end-0 ps-1"
                                        id="password_confirmation"
                                        name="password_confirmation"
                                        autocomplete="new-password"
                                        placeholder="Nhập lại mật khẩu"
                                        required
                                    >
                                    <button class="btn btn-outline-secondary border-start-0 toggle-password-btn" type="button" data-target="password_confirmation" title="Hiện/ẩn mật khẩu">
                                        <i class="ri-eye-line"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="alert alert-light border border-dashed text-muted py-2 px-3 mb-0 small">
                                    <i class="ri-information-line text-primary me-1"></i> Mật khẩu phải có độ dài <strong>tối thiểu 6 ký tự</strong>. Sau khi tạo, người dùng có thể đổi lại mật khẩu cá nhân.
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="border-top pt-4 mt-4">
                        <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-3">
                            <div class="d-flex align-items-center">
                                <i class="ri-lock-password-line text-warning fs-18 me-2"></i>
                                <div>
                                    <h6 class="fs-14 fw-bold text-dark mb-0">Đổi mật khẩu người dùng</h6>
                                    <small class="text-muted">Mật khẩu hiện tại đang được giữ nguyên. Chỉ bật nếu muốn cấp mật khẩu mới.</small>
                                </div>
                            </div>
                            <div class="form-check form-switch form-switch-md">
                                <input class="form-check-input" type="checkbox" id="toggle-password-change" role="switch">
                                <label class="form-check-label fw-semibold text-primary" for="toggle-password-change">Đổi mật khẩu</label>
                            </div>
                        </div>

                        <div id="password-change-fields" class="row g-3 d-none bg-light p-3 rounded-3 border">
                            <div class="col-md-6">
                                <label for="password" class="form-label fw-semibold">Mật khẩu mới <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white border-end-0 text-muted">
                                        <i class="ri-lock-line"></i>
                                    </span>
                                    <input
                                        type="password"
                                        class="form-control border-start-0 border-end-0 ps-1 @error('password') is-invalid @enderror"
                                        id="password"
                                        name="password"
                                        autocomplete="new-password"
                                        placeholder="Mật khẩu mới (tối thiểu 6 ký tự)"
                                        disabled
                                    >
                                    <button class="btn btn-outline-secondary border-start-0 toggle-password-btn" type="button" data-target="password" title="Hiện/ẩn mật khẩu">
                                        <i class="ri-eye-line"></i>
                                    </button>
                                    @error('password')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="password_confirmation" class="form-label fw-semibold">Xác nhận mật khẩu mới <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white border-end-0 text-muted">
                                        <i class="ri-lock-check-line"></i>
                                    </span>
                                    <input
                                        type="password"
                                        class="form-control border-start-0 border-end-0 ps-1"
                                        id="password_confirmation"
                                        name="password_confirmation"
                                        autocomplete="new-password"
                                        placeholder="Nhập lại mật khẩu mới"
                                        disabled
                                    >
                                    <button class="btn btn-outline-secondary border-start-0 toggle-password-btn" type="button" data-target="password_confirmation" title="Hiện/ẩn mật khẩu">
                                        <i class="ri-eye-line"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Section 2: Department & Role -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white border-bottom-dashed py-3">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0 me-3">
                        <div class="avatar-xs">
                            <span class="avatar-title bg-info-subtle text-info rounded-circle fs-16">
                                <i class="ri-building-line"></i>
                            </span>
                        </div>
                    </div>
                    <div class="flex-grow-1">
                        <h5 class="card-title mb-0 fs-15 fw-bold text-dark">Phòng ban & Phân quyền hệ thống</h5>
                        <p class="text-muted small mb-0">Xác định đơn vị trực thuộc, chức danh và vai trò truy cập của người dùng</p>
                    </div>
                </div>
            </div>

            <div class="card-body p-4">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="department_id" class="form-label fw-semibold">Phòng ban trực thuộc</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0 text-muted">
                                <i class="ri-community-line"></i>
                            </span>
                            <select class="form-select border-start-0 ps-1 @error('department_id') is-invalid @enderror" id="department_id" name="department_id">
                                <option value="">-- Chưa gán phòng ban --</option>
                                @if (isset($departmentOptions))
                                    @foreach ($departmentOptions as $deptId => $deptLabel)
                                        <option value="{{ $deptId }}" {{ (string) old('department_id', $user->department_id ?? '') === (string) $deptId ? 'selected' : '' }}>
                                            {{ $deptLabel }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                            @error('department_id')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-text text-muted small">Cây sơ đồ tổ chức phòng ban và chi nhánh.</div>
                    </div>

                    <div class="col-md-6">
                        <label for="job_title" class="form-label fw-semibold">Chức danh / Vị trí</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0 text-muted">
                                <i class="ri-briefcase-line"></i>
                            </span>
                            <input
                                type="text"
                                class="form-control border-start-0 ps-1 @error('job_title') is-invalid @enderror"
                                id="job_title"
                                name="job_title"
                                value="{{ old('job_title', $user->job_title ?? '') }}"
                                placeholder="Ví dụ: Giám đốc kinh doanh, Chuyên viên tư vấn..."
                            >
                            @error('job_title')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-text text-muted small">Chức vụ hiển thị trong danh bạ và hồ sơ.</div>
                    </div>

                    <div class="col-12">
                        <label for="permission" class="form-label fw-semibold">Vai trò & Quyền hạn (Permission) <span class="text-danger">*</span></label>
                        <div class="input-group mb-2">
                            <span class="input-group-text bg-light border-end-0 text-muted">
                                <i class="ri-shield-user-line"></i>
                            </span>
                            <select class="form-select border-start-0 ps-1 fw-medium @error('permission') is-invalid @enderror" id="permission" name="permission" required>
                                <option value="1" {{ $currentPermission === 1 ? 'selected' : '' }}>1. Quản trị viên cấp cao (Super Admin)</option>
                                <option value="2" {{ $currentPermission === 2 ? 'selected' : '' }}>2. Quản trị viên (Admin)</option>
                                <option value="3" {{ $currentPermission === 3 ? 'selected' : '' }}>3. Quản lý (Moderator)</option>
                                <option value="4" {{ $currentPermission === 4 ? 'selected' : '' }}>4. Giảng viên (Instructor)</option>
                                <option value="5" {{ $currentPermission === 5 ? 'selected' : '' }}>5. Học viên (Student)</option>
                                <option value="6" {{ $currentPermission === 6 ? 'selected' : '' }}>6. Khách vãng lai (Guest)</option>
                            </select>
                            @error('permission')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Dynamic Role Description Callout -->
                        <div id="role-description-box" class="p-3 rounded-3 border bg-light mt-2 transition-all">
                            <div class="d-flex align-items-start">
                                <span class="badge me-2 mt-1 fs-11" id="role-badge">Vai trò</span>
                                <div>
                                    <div class="fw-bold fs-13 text-dark mb-1" id="role-title">Tên vai trò</div>
                                    <div class="text-muted small mb-0" id="role-desc">Mô tả đặc quyền của vai trò trong hệ thống.</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Section 3: Contact & Seller Profile -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white border-bottom-dashed py-3">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0 me-3">
                        <div class="avatar-xs">
                            <span class="avatar-title bg-success-subtle text-success rounded-circle fs-16">
                                <i class="ri-contacts-book-2-line"></i>
                            </span>
                        </div>
                    </div>
                    <div class="flex-grow-1">
                        <h5 class="card-title mb-0 fs-15 fw-bold text-dark">Thông tin liên hệ & Hồ sơ Seller</h5>
                        <p class="text-muted small mb-0">Thông tin liên lạc và hiển thị trong mục Chuyên viên / Seller tại trang chi tiết</p>
                    </div>
                </div>
            </div>

            <div class="card-body p-4">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label for="phone" class="form-label fw-semibold">Số điện thoại chính</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0 text-muted">
                                <i class="ri-phone-line"></i>
                            </span>
                            <input
                                type="text"
                                class="form-control border-start-0 ps-1 @error('phone') is-invalid @enderror"
                                id="phone"
                                name="phone"
                                value="{{ old('phone', $user->phone ?? '') }}"
                                placeholder="0912 345 678"
                            >
                            @error('phone')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        <label for="secondary_phone" class="form-label fw-semibold">Số điện thoại phụ</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0 text-muted">
                                <i class="ri-phone-find-line"></i>
                            </span>
                            <input
                                type="text"
                                class="form-control border-start-0 ps-1 @error('secondary_phone') is-invalid @enderror"
                                id="secondary_phone"
                                name="secondary_phone"
                                value="{{ old('secondary_phone', $user->secondary_phone ?? '') }}"
                                placeholder="Số liên hệ dự phòng"
                            >
                            @error('secondary_phone')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        <label for="whatsapp_phone" class="form-label fw-semibold">Số WhatsApp</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0 text-success">
                                <i class="ri-whatsapp-line"></i>
                            </span>
                            <input
                                type="text"
                                class="form-control border-start-0 ps-1 @error('whatsapp_phone') is-invalid @enderror"
                                id="whatsapp_phone"
                                name="whatsapp_phone"
                                value="{{ old('whatsapp_phone', $user->whatsapp_phone ?? '') }}"
                                placeholder="0912 345 678"
                            >
                            @error('whatsapp_phone')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-12">
                        <label for="address" class="form-label fw-semibold">Địa chỉ liên hệ</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0 text-muted">
                                <i class="ri-map-pin-line"></i>
                            </span>
                            <input
                                type="text"
                                class="form-control border-start-0 ps-1 @error('address') is-invalid @enderror"
                                id="address"
                                name="address"
                                value="{{ old('address', $user->address ?? '') }}"
                                placeholder="Ví dụ: Tòa nhà Indochine, Số 123 Đường ABC, Hà Nội"
                            >
                            @error('address')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-12">
                        <label for="bio" class="form-label fw-semibold">Mô tả / Giới thiệu seller</label>
                        <textarea
                            class="form-control @error('bio') is-invalid @enderror"
                            id="bio"
                            name="bio"
                            rows="3"
                            placeholder="Giới thiệu kinh nghiệm, lĩnh vực phụ trách của chuyên viên (Hiển thị tại box Contact Sellers)..."
                        >{{ old('bio', $user->bio ?? '') }}</textarea>
                        @error('bio')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Right Sidebar Column -->
    <div class="col-xl-4 col-lg-5">
        <!-- Card 1: Avatar Profile Card -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white border-bottom-dashed py-3">
                <div class="d-flex align-items-center">
                    <i class="ri-image-add-line text-primary fs-18 me-2"></i>
                    <h5 class="card-title mb-0 fs-15 fw-bold text-dark">Ảnh đại diện (Avatar)</h5>
                </div>
            </div>

            <div class="card-body p-4 text-center">
                <input type="hidden" name="remove_avatar" id="remove_avatar" value="0">
                <input type="hidden" name="existing_avatar" value="{{ $avatarImage }}">
                <input type="file" id="avatar_file" name="avatar_file" class="d-none" accept="image/png,image/jpeg,image/webp,image/gif">

                <div class="avatar-upload-wrapper mx-auto mb-3">
                    <div
                        class="avatar-preview-box rounded-circle mx-auto d-flex align-items-center justify-content-center position-relative overflow-hidden cursor-pointer image-upload-trigger"
                        data-input="avatar_file"
                        id="avatar-dropzone"
                        title="Nhấp để tải hoặc thay đổi ảnh"
                    >
                        @if ($avatarImage)
                            <img src="{{ asset($avatarImage) }}" alt="Avatar" class="avatar-img-preview w-100 h-100 object-fit-cover" id="avatar-img-element">
                        @else
                            <div class="avatar-empty-placeholder text-center text-muted" id="avatar-placeholder-element">
                                <div class="avatar-icon-circle mx-auto mb-1">
                                    <i class="ri-camera-3-line fs-24"></i>
                                </div>
                                <span class="fs-12 fw-medium d-block text-secondary">Chọn ảnh</span>
                            </div>
                        @endif

                        <div class="avatar-hover-overlay position-absolute w-100 h-100 d-flex flex-column align-items-center justify-content-center text-white">
                            <i class="ri-camera-fill fs-20 mb-1"></i>
                            <span class="fs-11 fw-medium">Đổi ảnh</span>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-center gap-2 mb-2">
                    <button type="button" class="btn btn-sm btn-soft-primary image-upload-trigger" data-input="avatar_file">
                        <i class="ri-upload-2-line align-bottom me-1"></i> Tải ảnh lên
                    </button>
                    <button
                        type="button"
                        class="btn btn-sm btn-soft-danger image-remove-trigger {{ $avatarImage ? '' : 'd-none' }}"
                        data-input="avatar_file"
                        data-remove="remove_avatar"
                        id="btn-remove-avatar"
                    >
                        <i class="ri-delete-bin-line align-bottom me-1"></i> Xóa ảnh
                    </button>
                </div>

                @error('avatar_file')
                    <div class="text-danger small mt-2">{{ $message }}</div>
                @enderror

                <div class="text-muted small mt-2">
                    <i class="ri-information-line me-1"></i> Định dạng: JPG, PNG, WEBP (Tối đa 2MB). Khuyên dùng ảnh vuông tỉ lệ 1:1.
                </div>
            </div>
        </div>

        <!-- Card 2: Account Status Card -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white border-bottom-dashed py-3">
                <div class="d-flex align-items-center">
                    <i class="ri-toggle-line text-primary fs-18 me-2"></i>
                    <h5 class="card-title mb-0 fs-15 fw-bold text-dark">Trạng thái tài khoản</h5>
                </div>
            </div>

            <div class="card-body p-4">
                <div class="d-flex align-items-center justify-content-between p-3 rounded-3 bg-light border mb-2">
                    <div>
                        <div class="fw-bold fs-14 text-dark mb-0">Kích hoạt tài khoản</div>
                        <small class="text-muted">Cho phép đăng nhập hệ thống</small>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <div class="form-check form-switch form-switch-lg mb-0">
                            <input
                                class="form-check-input cursor-pointer"
                                type="checkbox"
                                role="switch"
                                id="is_active"
                                name="is_active"
                                value="1"
                                {{ $isActive ? 'checked' : '' }}
                                @if ($isSelf) disabled title="Không thể tự khóa tài khoản của bạn" @endif
                            >
                        </div>
                    </div>
                </div>

                <div class="d-flex align-items-center justify-content-between mt-2 pt-1">
                    <span class="text-muted small">Tình trạng hiện tại:</span>
                    <span id="account-status-badge" class="badge {{ $isActive ? 'bg-success-subtle text-success' : 'bg-danger-subtle text-danger' }} fs-12 px-2 py-1">
                        <i class="{{ $isActive ? 'ri-checkbox-circle-fill' : 'ri-close-circle-fill' }} me-1"></i>
                        <span id="account-status-text">{{ $isActive ? 'Đang hoạt động' : 'Tạm khóa' }}</span>
                    </span>
                </div>

                @if ($isSelf)
                    <div class="alert alert-warning py-2 px-3 mt-3 mb-0 small">
                        <i class="ri-alert-line me-1"></i> Bạn đang đăng nhập tài khoản này nên hệ thống không cho phép tự khóa.
                    </div>
                @else
                    <div class="text-muted small mt-2">
                        <i class="ri-error-warning-line text-warning me-1"></i> Nếu tắt, người dùng sẽ bị đăng xuất ngay và không thể đăng nhập cho đến khi được mở lại.
                    </div>
                @endif
            </div>
        </div>

        <!-- Card 3: Sticky Quick Action Card -->
        <div class="card border-0 shadow-sm mb-4 sticky-action-card">
            <div class="card-header bg-white border-bottom-dashed py-3">
                <div class="d-flex align-items-center">
                    <i class="ri-save-3-line text-primary fs-18 me-2"></i>
                    <h5 class="card-title mb-0 fs-15 fw-bold text-dark">Thao tác lưu</h5>
                </div>
            </div>

            <div class="card-body p-4">
                <button type="submit" form="user-form" class="btn btn-primary w-100 py-2 fs-15 shadow-sm mb-2 fw-semibold">
                    <i class="ri-check-line align-middle me-1"></i> {{ $submitLabel ?? ($isEdit ? 'Lưu thay đổi' : 'Tạo người dùng mới') }}
                </button>
                <a href="{{ route('backend.users.index') }}" class="btn btn-soft-secondary w-100 py-2">
                    <i class="ri-arrow-left-line align-middle me-1"></i> Quay lại danh sách
                </a>

                <div class="text-center text-muted small mt-3 pt-2 border-top">
                    @if ($isEdit)
                        <i class="ri-history-line me-1"></i> Cập nhật gần nhất: <strong>{{ $user->updated_at ? $user->updated_at->format('H:i - d/m/Y') : 'Chưa có' }}</strong>
                    @else
                        <i class="ri-shield-check-line text-success me-1"></i> Kiểm tra đầy đủ mục (<span class="text-danger">*</span>) trước khi lưu.
                    @endif
                </div>
            </div>
        </div>

        <!-- Card 4: Quick Guidelines Card -->
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-bottom-dashed py-3">
                <div class="d-flex align-items-center">
                    <i class="ri-lightbulb-line text-warning fs-18 me-2"></i>
                    <h5 class="card-title mb-0 fs-15 fw-bold text-dark">Hướng dẫn & Lưu ý</h5>
                </div>
            </div>

            <div class="card-body p-4">
                <ul class="list-unstyled mb-0 d-flex flex-column gap-3 small text-muted">
                    <li class="d-flex align-items-start">
                        <i class="ri-mail-check-line text-primary fs-16 me-2 flex-shrink-0 mt-0"></i>
                        <div><strong>Email đăng nhập:</strong> Phải là duy nhất trong toàn hệ thống để nhân viên truy cập dashboard.</div>
                    </li>
                    <li class="d-flex align-items-start">
                        <i class="ri-shield-keyhole-line text-success fs-16 me-2 flex-shrink-0 mt-0"></i>
                        <div><strong>Mật khẩu:</strong> Tối thiểu 6 ký tự. Nên kết hợp chữ và số để đảm bảo tính an toàn.</div>
                    </li>
                    <li class="d-flex align-items-start">
                        <i class="ri-user-star-line text-info fs-16 me-2 flex-shrink-0 mt-0"></i>
                        <div><strong>Hồ sơ Seller:</strong> Thông tin SĐT, WhatsApp và mô tả sẽ hiển thị ở box liên hệ chuyên viên tại trang dự án.</div>
                    </li>
                    <li class="d-flex align-items-start">
                        <i class="ri-building-line text-warning fs-16 me-2 flex-shrink-0 mt-0"></i>
                        <div><strong>Phòng ban:</strong> Giúp phân loại theo cây nhân sự và báo cáo học tập theo bộ phận.</div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<style>
    /* Styling for User Form Optimization */
    .avatar-preview-box {
        width: 140px;
        height: 140px;
        border: 3px solid #e9ebec;
        background-color: #f8f9fa;
        transition: all 0.25s ease-in-out;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    }
    .avatar-preview-box:hover {
        border-color: #405189;
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(64, 81, 137, 0.15);
    }
    .avatar-icon-circle {
        width: 50px;
        height: 50px;
        line-height: 50px;
        border-radius: 50%;
        background-color: #ebf0f7;
        color: #405189;
    }
    .avatar-hover-overlay {
        background-color: rgba(64, 81, 137, 0.7);
        opacity: 0;
        transition: opacity 0.2s ease-in-out;
    }
    .avatar-preview-box:hover .avatar-hover-overlay {
        opacity: 1;
    }
    .avatar-upload-wrapper.is-dragover .avatar-preview-box {
        border-color: #0ab39c;
        background-color: #e8faf7;
        transform: scale(1.05);
    }
    @media (min-width: 1200px) {
        .sticky-action-card {
            position: sticky;
            top: 85px;
            z-index: 5;
        }
    }
    .cursor-pointer {
        cursor: pointer;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // 1. Password Visibility Toggle
        document.querySelectorAll('.toggle-password-btn').forEach(function (button) {
            button.addEventListener('click', function () {
                var targetId = button.getAttribute('data-target');
                var input = document.getElementById(targetId);
                var icon = button.querySelector('i');
                if (!input) return;

                if (input.type === 'password') {
                    input.type = 'text';
                    if (icon) {
                        icon.classList.remove('ri-eye-line');
                        icon.classList.add('ri-eye-off-line');
                    }
                } else {
                    input.type = 'password';
                    if (icon) {
                        icon.classList.remove('ri-eye-off-line');
                        icon.classList.add('ri-eye-line');
                    }
                }
            });
        });

        // 2. Toggle Password Change on Edit
        var togglePasswordChange = document.getElementById('toggle-password-change');
        var passwordFieldsContainer = document.getElementById('password-change-fields');
        if (togglePasswordChange && passwordFieldsContainer) {
            togglePasswordChange.addEventListener('change', function () {
                var passwordInput = document.getElementById('password');
                var passwordConfirmInput = document.getElementById('password_confirmation');

                if (this.checked) {
                    passwordFieldsContainer.classList.remove('d-none');
                    if (passwordInput) {
                        passwordInput.removeAttribute('disabled');
                        passwordInput.focus();
                    }
                    if (passwordConfirmInput) {
                        passwordConfirmInput.removeAttribute('disabled');
                    }
                } else {
                    passwordFieldsContainer.classList.add('d-none');
                    if (passwordInput) {
                        passwordInput.setAttribute('disabled', 'disabled');
                        passwordInput.value = '';
                    }
                    if (passwordConfirmInput) {
                        passwordConfirmInput.setAttribute('disabled', 'disabled');
                        passwordConfirmInput.value = '';
                    }
                }
            });
        }

        // 3. Avatar Upload Trigger & Drag-and-Drop
        var avatarInput = document.getElementById('avatar_file');
        var avatarDropzone = document.getElementById('avatar-dropzone');
        var removeAvatarField = document.getElementById('remove_avatar');
        var removeAvatarBtn = document.getElementById('btn-remove-avatar');

        document.querySelectorAll('.image-upload-trigger').forEach(function (btn) {
            btn.addEventListener('click', function () {
                if (avatarInput) avatarInput.click();
            });
        });

        function handleAvatarFile(file) {
            if (!file || !avatarDropzone) return;

            // Check file type
            if (!file.type.match('image.*')) {
                alert('Vui lòng chọn file hình ảnh hợp lệ (JPG, PNG, WEBP).');
                return;
            }

            // Check file size (max 2MB)
            if (file.size > 2 * 1024 * 1024) {
                alert('Kích thước ảnh không được vượt quá 2MB.');
                return;
            }

            if (removeAvatarField) {
                removeAvatarField.value = '0';
            }

            var reader = new FileReader();
            reader.onload = function (e) {
                avatarDropzone.innerHTML = '<img src="' + e.target.result + '" class="avatar-img-preview w-100 h-100 object-fit-cover" alt="Preview">' +
                    '<div class="avatar-hover-overlay position-absolute w-100 h-100 d-flex flex-column align-items-center justify-content-center text-white">' +
                    '<i class="ri-camera-fill fs-20 mb-1"></i><span class="fs-11 fw-medium">Đổi ảnh</span></div>';

                if (removeAvatarBtn) {
                    removeAvatarBtn.classList.remove('d-none');
                }
            };
            reader.readAsDataURL(file);
        }

        if (avatarInput) {
            avatarInput.addEventListener('change', function (e) {
                if (e.target.files && e.target.files[0]) {
                    handleAvatarFile(e.target.files[0]);
                }
            });
        }

        if (avatarDropzone) {
            var wrapper = avatarDropzone.closest('.avatar-upload-wrapper');

            ['dragenter', 'dragover'].forEach(function (eventName) {
                avatarDropzone.addEventListener(eventName, function (e) {
                    e.preventDefault();
                    e.stopPropagation();
                    if (wrapper) wrapper.classList.add('is-dragover');
                }, false);
            });

            ['dragleave', 'drop'].forEach(function (eventName) {
                avatarDropzone.addEventListener(eventName, function (e) {
                    e.preventDefault();
                    e.stopPropagation();
                    if (wrapper) wrapper.classList.remove('is-dragover');
                }, false);
            });

            avatarDropzone.addEventListener('drop', function (e) {
                var dt = e.dataTransfer;
                var files = dt.files;
                if (files && files.length > 0) {
                    avatarInput.files = files;
                    handleAvatarFile(files[0]);
                }
            }, false);
        }

        // Remove Avatar
        if (removeAvatarBtn) {
            removeAvatarBtn.addEventListener('click', function () {
                if (avatarInput) avatarInput.value = '';
                if (removeAvatarField) removeAvatarField.value = '1';

                if (avatarDropzone) {
                    avatarDropzone.innerHTML =
                        '<div class="avatar-empty-placeholder text-center text-muted" id="avatar-placeholder-element">' +
                        '<div class="avatar-icon-circle mx-auto mb-1"><i class="ri-camera-3-line fs-24"></i></div>' +
                        '<span class="fs-12 fw-medium d-block text-secondary">Chọn ảnh</span></div>' +
                        '<div class="avatar-hover-overlay position-absolute w-100 h-100 d-flex flex-column align-items-center justify-content-center text-white">' +
                        '<i class="ri-camera-fill fs-20 mb-1"></i><span class="fs-11 fw-medium">Chọn ảnh</span></div>';
                }

                removeAvatarBtn.classList.add('d-none');
            });
        }

        // 4. Interactive Permission Role Descriptions
        var roleMeta = {
            1: {
                title: 'Quản trị viên cấp cao (Super Admin)',
                desc: 'Có toàn quyền tối cao trên toàn bộ hệ thống, quản trị phân quyền, cấu hình hệ thống và quản lý toàn bộ dữ liệu nhân sự.',
                badgeText: 'Super Admin',
                badgeClass: 'bg-danger-subtle text-danger border border-danger-subtle'
            },
            2: {
                title: 'Quản trị viên (Admin)',
                desc: 'Quản trị danh mục, khóa học, đề thi, tin tức, phê duyệt tài khoản và quản lý thông tin các phòng ban.',
                badgeText: 'Admin',
                badgeClass: 'bg-primary-subtle text-primary border border-primary-subtle'
            },
            3: {
                title: 'Quản lý (Moderator)',
                desc: 'Điều phối nội dung đào tạo, quản lý tiến độ học tập của nhân viên thuộc phạm vi phụ trách và xuất báo cáo.',
                badgeText: 'Moderator',
                badgeClass: 'bg-warning-subtle text-warning border border-warning-subtle'
            },
            4: {
                title: 'Giảng viên (Instructor)',
                desc: 'Biên soạn nội dung bài giảng, tạo ngân hàng câu hỏi, thiết lập đề thi, chấm điểm và đánh giá học viên.',
                badgeText: 'Instructor',
                badgeClass: 'bg-info-subtle text-info border border-info-subtle'
            },
            5: {
                title: 'Học viên (Student)',
                desc: 'Tham gia các khóa đào tạo nội bộ được chỉ định, thực hiện bài kiểm tra định kỳ và tra cứu kết quả cá nhân.',
                badgeText: 'Student',
                badgeClass: 'bg-success-subtle text-success border border-success-subtle'
            },
            6: {
                title: 'Khách vãng lai (Guest)',
                desc: 'Tài khoản có quyền hạn cơ bản nhất, chỉ có thể xem các thông tin công khai trong hệ thống.',
                badgeText: 'Guest',
                badgeClass: 'bg-secondary-subtle text-secondary border border-secondary-subtle'
            }
        };

        var permissionSelect = document.getElementById('permission');
        var roleTitleEl = document.getElementById('role-title');
        var roleDescEl = document.getElementById('role-desc');
        var roleBadgeEl = document.getElementById('role-badge');

        function updateRoleInfo(roleId) {
            var meta = roleMeta[roleId] || roleMeta[6];
            if (roleTitleEl) roleTitleEl.textContent = meta.title;
            if (roleDescEl) roleDescEl.textContent = meta.desc;
            if (roleBadgeEl) {
                roleBadgeEl.textContent = meta.badgeText;
                roleBadgeEl.className = 'badge me-2 mt-1 fs-11 ' + meta.badgeClass;
            }
        }

        if (permissionSelect) {
            updateRoleInfo(permissionSelect.value);
            permissionSelect.addEventListener('change', function () {
                updateRoleInfo(this.value);
            });
        }

        // 5. Account Status Badge Live Toggle
        var statusCheckbox = document.getElementById('is_active');
        var statusBadge = document.getElementById('account-status-badge');
        var statusText = document.getElementById('account-status-text');

        if (statusCheckbox && statusBadge && statusText) {
            statusCheckbox.addEventListener('change', function () {
                if (this.checked) {
                    statusBadge.className = 'badge bg-success-subtle text-success fs-12 px-2 py-1';
                    statusBadge.innerHTML = '<i class="ri-checkbox-circle-fill me-1"></i><span id="account-status-text">Đang hoạt động</span>';
                } else {
                    statusBadge.className = 'badge bg-danger-subtle text-danger fs-12 px-2 py-1';
                    statusBadge.innerHTML = '<i class="ri-close-circle-fill me-1"></i><span id="account-status-text">Tạm khóa</span>';
                }
            });
        }
    });
</script>
