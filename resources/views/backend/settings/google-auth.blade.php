@extends('backend.layouts.app')

@section('title', 'Cấu hình Google OAuth')
@section('page_title', 'Cấu hình Google OAuth')
@section('breadcrumb', 'Google OAuth')

@section('content')
<div class="row">
    <div class="col-xl-8 col-lg-7">
        <!-- Trạng thái Cơ sở dữ liệu (Gọn gàng) -->
        <div class="card mb-3 {{ $hasGoogleIdColumn ? 'border-success' : 'border-danger' }} shadow-sm">
            <div class="card-body py-2 px-3">
                <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                    <div class="d-flex align-items-center gap-2">
                        <i class="{{ $hasGoogleIdColumn ? 'ri-checkbox-circle-fill text-success' : 'ri-alert-fill text-danger' }} fs-18"></i>
                        <div class="fs-13">
                            <span class="fw-semibold">Cơ sở dữ liệu:</span>
                            @if ($hasGoogleIdColumn)
                                <span class="text-success ms-1">Bảng <code>users</code> đã có cột <code>google_id</code> (Sẵn sàng)</span>
                            @else
                                <span class="text-danger ms-1">Bảng <code>users</code> chưa có cột <code>google_id</code></span>
                            @endif
                        </div>
                    </div>

                    @if (!$hasGoogleIdColumn)
                        <form action="{{ route('backend.google-auth.fix-db') }}" method="POST" class="m-0">
                            @csrf
                            <button type="submit" class="btn btn-danger btn-sm px-3 py-1 fs-12 fw-semibold shadow-sm">
                                <i class="ri-tools-fill me-1"></i> Khởi tạo cột google_id
                            </button>
                        </form>
                    @else
                        <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1 fs-11">
                            <i class="ri-check-line me-1"></i> Sẵn sàng
                        </span>
                    @endif
                </div>
            </div>
        </div>

        <!-- Form cấu hình Google API (Thiết kế tinh gọn) -->
        <div class="card shadow-sm border-0">
            <div class="card-header bg-light-subtle d-flex align-items-center justify-content-between py-2 px-3 border-bottom">
                <div class="d-flex align-items-center gap-2">
                    <i class="ri-google-fill text-primary fs-18"></i>
                    <h6 class="card-title mb-0 fw-bold fs-14">Cấu hình Google OAuth</h6>
                </div>
                <div class="form-check form-switch mb-0">
                    <input class="form-check-input" type="checkbox" name="is_enabled" id="switchEnabled" form="googleAuthForm" value="1" {{ !empty($config['is_enabled']) ? 'checked' : '' }}>
                    <label class="form-check-label fs-13 fw-semibold ms-1" for="switchEnabled">Kích hoạt</label>
                </div>
            </div>

            <form action="{{ route('backend.google-auth.update') }}" method="POST" id="googleAuthForm">
                @csrf
                <div class="card-body p-3">
                    <!-- Google Client ID -->
                    <div class="mb-3">
                        <label for="client_id" class="form-label fs-13 fw-semibold mb-1">
                            Google Client ID <span class="text-danger">*</span>
                        </label>
                        <div class="input-group input-group-sm">
                            <span class="input-group-text bg-light"><i class="ri-key-2-line"></i></span>
                            <input type="text" 
                                   id="client_id" 
                                   name="client_id" 
                                   class="form-control @error('client_id') is-invalid @enderror" 
                                   value="{{ old('client_id', $config['client_id'] ?? '') }}" 
                                   placeholder="Ví dụ: 1234567890-abcdef.apps.googleusercontent.com" 
                                   required>
                        </div>
                        <small class="text-muted fs-11">Lấy từ trang Credentials trên Google Cloud Console.</small>
                        @error('client_id')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Google Client Secret -->
                    <div class="mb-3">
                        <label for="client_secret" class="form-label fs-13 fw-semibold mb-1">
                            Google Client Secret <span class="text-danger">*</span>
                        </label>
                        <div class="input-group input-group-sm">
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
                        <small class="text-muted fs-11">Mã bảo mật lưu trữ an toàn trên máy chủ.</small>
                        @error('client_secret')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Callback URL Tùy chỉnh -->
                    <div class="mb-2">
                        <label for="redirect_uri" class="form-label fs-13 fw-semibold mb-1">
                            Authorized Redirect URI (Callback URL)
                        </label>
                        <div class="input-group input-group-sm">
                            <span class="input-group-text bg-light"><i class="ri-link"></i></span>
                            <input type="url" 
                                   id="redirect_uri" 
                                   name="redirect_uri" 
                                   class="form-control @error('redirect_uri') is-invalid @enderror" 
                                   value="{{ old('redirect_uri', $config['redirect_uri'] ?? $liveCallback) }}" 
                                   placeholder="{{ $liveCallback }}">
                        </div>
                        <small class="text-muted fs-11">Phải trùng khớp 100% với Redirect URI đã khai báo trên Google Cloud Console.</small>
                        @error('redirect_uri')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="card-footer bg-light-subtle d-flex align-items-center justify-content-between py-2 px-3">
                    <a href="{{ route('backend.admin.dashboard') }}" class="btn btn-outline-secondary btn-sm px-3">
                        <i class="ri-arrow-left-line me-1"></i> Quay lại
                    </a>
                    <button type="submit" class="btn btn-primary btn-sm px-4 fw-semibold shadow-sm">
                        <i class="ri-save-3-line me-1"></i> Lưu cấu hình
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Cột phụ: Thông tin copy & Hướng dẫn Google Console -->
    <div class="col-xl-4 col-lg-5">
        <!-- Thông số khai báo Google Cloud Console -->
        <div class="card shadow-sm border-0 mb-3">
            <div class="card-header bg-primary text-white py-2 px-3">
                <h6 class="card-title text-white mb-0 fs-13 fw-bold">
                    <i class="ri-file-copy-2-line me-1"></i> Thông số Google Cloud Console
                </h6>
            </div>
            <div class="card-body p-3">
                <!-- 1. Authorized JavaScript origins -->
                <div class="mb-2">
                    <label class="form-label fs-11 fw-bold text-uppercase text-muted mb-1">
                        1. Authorized JavaScript origins
                    </label>
                    <div class="input-group input-group-sm">
                        <input type="text" class="form-control font-monospace bg-light fs-12" id="originUrl" value="{{ $liveOrigin }}" readonly>
                        <button class="btn btn-outline-primary btn-sm" type="button" onclick="copyToClipboard('originUrl', this)">
                            <i class="ri-file-copy-line"></i> Copy
                        </button>
                    </div>
                </div>

                <!-- 2. Authorized redirect URIs (Live) -->
                <div class="mb-2">
                    <label class="form-label fs-11 fw-bold text-uppercase text-muted mb-1">
                        2. Authorized redirect URIs (Live)
                    </label>
                    <div class="input-group input-group-sm">
                        <input type="text" class="form-control font-monospace bg-light fs-12" id="callbackLiveUrl" value="{{ $liveCallback }}" readonly>
                        <button class="btn btn-outline-primary btn-sm" type="button" onclick="copyToClipboard('callbackLiveUrl', this)">
                            <i class="ri-file-copy-line"></i> Copy
                        </button>
                    </div>
                    <small class="text-success fs-11"><i class="ri-checkbox-circle-line me-1"></i> Bắt buộc cho tên miền chính</small>
                </div>

                <!-- 3. Local callback (nếu test localhost) -->
                @if(!$isLive)
                <div class="mb-1">
                    <label class="form-label fs-11 fw-bold text-uppercase text-muted mb-1">
                        3. Authorized redirect URIs (Local)
                    </label>
                    <div class="input-group input-group-sm">
                        <input type="text" class="form-control font-monospace bg-light fs-12" id="callbackLocalUrl" value="{{ $currentCallback }}" readonly>
                        <button class="btn btn-outline-secondary btn-sm" type="button" onclick="copyToClipboard('callbackLocalUrl', this)">
                            <i class="ri-file-copy-line"></i> Copy
                        </button>
                    </div>
                </div>
                @endif
            </div>
        </div>

        <!-- Hướng dẫn 4 bước cấu hình -->
        <div class="card shadow-sm border-0">
            <div class="card-header bg-light-subtle py-2 px-3">
                <h6 class="card-title mb-0 fs-13 fw-bold">
                    <i class="ri-guide-line me-1 text-primary"></i> 4 Bước cấu hình Google
                </h6>
            </div>
            <div class="card-body p-3">
                <ol class="ps-3 mb-0 text-muted fs-12" style="line-height: 1.6;">
                    <li class="mb-1">
                        Vào <a href="https://console.cloud.google.com/apis/credentials" target="_blank" class="text-primary fw-semibold text-decoration-underline">Google Credentials <i class="ri-external-link-line"></i></a>.
                    </li>
                    <li class="mb-1">
                        Bấm <strong>Create Credentials</strong> &rarr; <strong>OAuth Client ID</strong>.
                    </li>
                    <li class="mb-1">
                        Chọn Application type: <strong>Web application</strong>.
                    </li>
                    <li class="mb-0">
                        Dán <strong>Origins</strong> và <strong>Redirect URIs</strong> ở trên vào &rarr; Lưu &rarr; Dán Client ID & Secret vào đây!
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
