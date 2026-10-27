@extends('backend.layouts.app')

@section('title', 'Cấu hình Google OAuth')
@section('page_title', 'Cấu hình Google OAuth')
@section('breadcrumb', 'Google OAuth')

@section('content')
<div class="row">
    <div class="col-xl-8 col-lg-7">
        <!-- Trạng thái Cơ sở dữ liệu -->
        <div class="card mb-4 {{ $hasGoogleIdColumn ? 'border-success' : 'border-danger' }} shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                    <div class="d-flex align-items-center gap-3">
                        <div class="avatar-sm flex-shrink-0">
                            <span class="avatar-title bg-{{ $hasGoogleIdColumn ? 'success' : 'danger' }}-subtle text-{{ $hasGoogleIdColumn ? 'success' : 'danger' }} rounded-circle fs-3 p-2">
                                <i class="{{ $hasGoogleIdColumn ? 'ri-database-2-line' : 'ri-error-warning-line' }}"></i>
                            </span>
                        </div>
                        <div>
                            <h5 class="mb-1 fw-bold">Trạng thái Cơ sở dữ liệu: Cột <code>google_id</code></h5>
                            @if ($hasGoogleIdColumn)
                                <p class="text-success mb-0 fs-13">
                                    <i class="ri-checkbox-circle-fill me-1"></i> Bảng <code>users</code> đã có cột <code>google_id</code>. Tính năng đăng nhập Google sẵn sàng hoạt động.
                                </p>
                            @else
                                <p class="text-danger mb-0 fs-13">
                                    <i class="ri-alert-fill me-1"></i> Bảng <code>users</code> <strong>chưa có</strong> cột <code>google_id</code> (sẽ gây lỗi SQL 1054 khi người dùng đăng nhập).
                                </p>
                            @endif
                        </div>
                    </div>

                    @if (!$hasGoogleIdColumn)
                        <form action="{{ route('backend.google-auth.fix-db') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-danger btn-sm px-3 fw-semibold shadow-sm">
                                <i class="ri-tools-fill me-1"></i> Khởi tạo cột google_id ngay
                            </button>
                        </form>
                    @else
                        <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-2 fs-12">
                            <i class="ri-check-line me-1"></i> Sẵn sàng
                        </span>
                    @endif
                </div>
            </div>
        </div>

        <!-- Form cấu hình Google API -->
        <div class="card shadow-sm border-0">
            <div class="card-header bg-light-subtle d-flex align-items-center justify-content-between py-3">
                <div class="d-flex align-items-center gap-2">
                    <span class="avatar-title bg-primary-subtle text-primary rounded p-2 fs-4">
                        <i class="ri-google-fill"></i>
                    </span>
                    <div>
                        <h5 class="card-title mb-0 fw-bold">Thông tin xác thực Google OAuth 2.0</h5>
                        <p class="text-muted small mb-0">Cấu hình Client ID & Secret để học viên có thể đăng nhập bằng tài khoản Gmail</p>
                    </div>
                </div>
                <div class="form-check form-switch form-switch-md">
                    <input class="form-check-input" type="checkbox" name="is_enabled" id="switchEnabled" form="googleAuthForm" value="1" {{ !empty($config['is_enabled']) ? 'checked' : '' }}>
                    <label class="form-check-label fw-semibold" for="switchEnabled">Kích hoạt</label>
                </div>
            </div>

            <form action="{{ route('backend.google-auth.update') }}" method="POST" id="googleAuthForm">
                @csrf
                <div class="card-body p-4">
                    <!-- Google Client ID -->
                    <div class="mb-4">
                        <label for="client_id" class="form-label fw-semibold">
                            Google Client ID <span class="text-danger">*</span>
                        </label>
                        <div class="input-group">
                            <span class="input-group-text bg-light"><i class="ri-key-2-line"></i></span>
                            <input type="text" 
                                   id="client_id" 
                                   name="client_id" 
                                   class="form-control @error('client_id') is-invalid @enderror" 
                                   value="{{ old('client_id', $config['client_id'] ?? '') }}" 
                                   placeholder="Ví dụ: 1234567890-abcdef.apps.googleusercontent.com" 
                                   required>
                        </div>
                        <small class="text-muted">Nhận từ trang Credentials trên Google Cloud Console của dự án.</small>
                        @error('client_id')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Google Client Secret -->
                    <div class="mb-4">
                        <label for="client_secret" class="form-label fw-semibold">
                            Google Client Secret <span class="text-danger">*</span>
                        </label>
                        <div class="input-group">
                            <span class="input-group-text bg-light"><i class="ri-shield-keyhole-line"></i></span>
                            <input type="password" 
                                   id="client_secret" 
                                   name="client_secret" 
                                   class="form-control @error('client_secret') is-invalid @enderror" 
                                   value="{{ old('client_secret', $config['client_secret'] ?? '') }}" 
                                   placeholder="Nhập Google Client Secret..." 
                                   required>
                            <button class="btn btn-outline-secondary" type="button" onclick="toggleSecret()" title="Hiện/Ẩn Secret">
                                <i class="ri-eye-line" id="toggleIcon"></i>
                            </button>
                        </div>
                        <small class="text-muted">Mã khóa bảo mật chỉ lưu trên máy chủ và không công khai.</small>
                        @error('client_secret')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Callback URL Tùy chỉnh -->
                    <div class="mb-3">
                        <label for="redirect_uri" class="form-label fw-semibold">
                            Authorized Redirect URI (Callback URL)
                        </label>
                        <div class="input-group">
                            <span class="input-group-text bg-light"><i class="ri-link"></i></span>
                            <input type="url" 
                                   id="redirect_uri" 
                                   name="redirect_uri" 
                                   class="form-control @error('redirect_uri') is-invalid @enderror" 
                                   value="{{ old('redirect_uri', $config['redirect_uri'] ?? $liveCallback) }}" 
                                   placeholder="{{ $liveCallback }}">
                        </div>
                        <small class="text-muted">Mặc định nên dùng: <code>{{ $liveCallback }}</code>. URL này <strong>bắt buộc phải trùng khớp 100%</strong> với URI khai báo trên Google Cloud Console.</small>
                        @error('redirect_uri')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="card-footer bg-light-subtle d-flex align-items-center justify-content-between p-3">
                    <a href="{{ route('backend.admin.dashboard') }}" class="btn btn-outline-secondary px-3">
                        <i class="ri-arrow-left-line me-1"></i> Quay lại Dashboard
                    </a>
                    <button type="submit" class="btn btn-primary px-4 fw-semibold shadow-sm">
                        <i class="ri-save-3-line me-1"></i> Lưu cấu hình Google
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Cột phụ: Thông tin copy & Hướng dẫn Google Console -->
    <div class="col-xl-4 col-lg-5">
        <!-- Thông số khai báo Google Cloud Console -->
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-primary text-white py-3">
                <h5 class="card-title text-white mb-0 fs-15 fw-bold">
                    <i class="ri-file-copy-2-line me-1"></i> Thông số Google Cloud Console
                </h5>
            </div>
            <div class="card-body p-3">
                <p class="text-muted small mb-3">Sao chép các địa chỉ URL dưới đây và dán vào mục <strong>OAuth 2.0 Client ID</strong> trên Google Cloud:</p>

                <!-- 1. Authorized JavaScript origins -->
                <div class="mb-3">
                    <label class="form-label small fw-bold text-uppercase text-muted mb-1">
                        1. Authorized JavaScript origins
                    </label>
                    <div class="input-group input-group-sm">
                        <input type="text" class="form-control font-monospace bg-light" id="originUrl" value="{{ $liveOrigin }}" readonly>
                        <button class="btn btn-outline-primary" type="button" onclick="copyToClipboard('originUrl', this)">
                            <i class="ri-file-copy-line"></i> Copy
                        </button>
                    </div>
                </div>

                <!-- 2. Authorized redirect URIs (Live) -->
                <div class="mb-3">
                    <label class="form-label small fw-bold text-uppercase text-muted mb-1">
                        2. Authorized redirect URIs (Live)
                    </label>
                    <div class="input-group input-group-sm">
                        <input type="text" class="form-control font-monospace bg-light" id="callbackLiveUrl" value="{{ $liveCallback }}" readonly>
                        <button class="btn btn-outline-primary" type="button" onclick="copyToClipboard('callbackLiveUrl', this)">
                            <i class="ri-file-copy-line"></i> Copy
                        </button>
                    </div>
                    <small class="text-success fs-12"><i class="ri-checkbox-circle-line me-1"></i> Bắt buộc cho tên miền chính thức</small>
                </div>

                <!-- 3. Local callback (nếu test localhost) -->
                @if(!$isLive)
                <div class="mb-2">
                    <label class="form-label small fw-bold text-uppercase text-muted mb-1">
                        3. Authorized redirect URIs (Local Dev)
                    </label>
                    <div class="input-group input-group-sm">
                        <input type="text" class="form-control font-monospace bg-light" id="callbackLocalUrl" value="{{ $currentCallback }}" readonly>
                        <button class="btn btn-outline-secondary" type="button" onclick="copyToClipboard('callbackLocalUrl', this)">
                            <i class="ri-file-copy-line"></i> Copy
                        </button>
                    </div>
                    <small class="text-muted fs-12">Dùng khi chạy thử trên máy tính lập trình</small>
                </div>
                @endif
            </div>
        </div>

        <!-- Hướng dẫn 4 bước cấu hình -->
        <div class="card shadow-sm border-0">
            <div class="card-header bg-light-subtle py-3">
                <h5 class="card-title mb-0 fs-15 fw-bold">
                    <i class="ri-guide-line me-1 text-primary"></i> 4 Bước lấy mã Google
                </h5>
            </div>
            <div class="card-body p-3">
                <ol class="ps-3 mb-0 text-muted fs-13" style="line-height: 1.7;">
                    <li class="mb-2">
                        Mở <a href="https://console.cloud.google.com/apis/credentials" target="_blank" class="text-primary fw-semibold text-decoration-underline">Google Cloud Credentials <i class="ri-external-link-line"></i></a>.
                    </li>
                    <li class="mb-2">
                        Chọn dự án của bạn &rarr; Bấm <strong>Create Credentials</strong> &rarr; <strong>OAuth Client ID</strong>.
                    </li>
                    <li class="mb-2">
                        Chọn Application type: <strong>Web application</strong>.
                    </li>
                    <li class="mb-2">
                        Dán <strong>Authorized JavaScript origins</strong> và <strong>Authorized redirect URIs</strong> từ khung bên trên vào Google.
                    </li>
                    <li class="mb-0">
                        Bấm <strong>Create</strong>, copy <strong>Client ID</strong> & <strong>Client Secret</strong> dán vào form bên trái và bấm <strong>Lưu cấu hình</strong>.
                    </li>
                </ol>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function toggleSecret() {
        var input = document.getElementById('client_secret');
        var icon = document.getElementById('toggleIcon');
        if (!input || !icon) return;

        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.remove('ri-eye-line');
            icon.classList.add('ri-eye-off-line');
        } else {
            input.type = 'password';
            icon.classList.remove('ri-eye-off-line');
            icon.classList.add('ri-eye-line');
        }
    }

    function copyToClipboard(elementId, btn) {
        var copyText = document.getElementById(elementId);
        if (!copyText) return;

        navigator.clipboard.writeText(copyText.value).then(function() {
            var oldHtml = btn.innerHTML;
            btn.innerHTML = '<i class="ri-check-line text-success"></i> Đã copy!';
            btn.classList.add('btn-success');
            btn.classList.remove('btn-outline-primary', 'btn-outline-secondary');
            setTimeout(function() {
                btn.innerHTML = oldHtml;
                btn.classList.remove('btn-success');
                btn.classList.add('btn-outline-primary');
            }, 2000);
        }).catch(function(err) {
            alert('Không thể sao chép: ' + err);
        });
    }
</script>
@endpush
