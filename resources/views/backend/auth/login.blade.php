<!doctype html>
<html lang="vi" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable" data-theme="default" data-theme-colors="default">
<head>
    <meta charset="utf-8" />
    <title>Đăng nhập Quản trị | INDOCHINE</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Trang đăng nhập khu vực quản trị hệ thống đào tạo INDOCHINE." />
    <meta name="author" content="INDOCHINE" />
    <link rel="shortcut icon" href="{{ $siteSetting->favicon_url ?? asset('admin-assets/images/favicon.ico') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

    <script src="{{ asset('admin-assets/js/layout.js') }}"></script>
    <link href="{{ asset('admin-assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('admin-assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('admin-assets/css/app.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('admin-assets/css/custom.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('admin-assets/css/backend-admin.css') }}?v={{ time() }}" rel="stylesheet" type="text/css" />

    <style>
        .indochine-brand {
            letter-spacing: 0.08em;
        }

        .indochine-brand span {
            color: #0ab39c;
        }

        .auth-one-bg {
            background-image:
                linear-gradient(135deg, rgba(10, 179, 156, 0.92), rgba(64, 81, 137, 0.88)),
                url('{{ asset('images/slider/slider-5.jpg') }}');
            background-size: cover;
            background-position: center;
        }

        .feature-note {
            background: rgba(255, 255, 255, 0.12);
            border: 1px solid rgba(255, 255, 255, 0.18);
            border-radius: 1rem;
            padding: 1rem 1.25rem;
            color: rgba(255, 255, 255, 0.92);
        }
    </style>
</head>
<body>
    <div class="auth-page-wrapper auth-bg-cover py-5 d-flex justify-content-center align-items-center min-vh-100">
        <div class="bg-overlay"></div>

        <div class="auth-page-content overflow-hidden pt-lg-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xxl-10 col-lg-11">
                        <div class="card overflow-hidden border-0 shadow-lg">
                            <div class="row g-0">
                                <div class="col-lg-6">
                                    <div class="p-lg-5 p-4 auth-one-bg h-100">
                                        <div class="bg-overlay opacity-50"></div>
                                        <div class="position-relative h-100 d-flex flex-column">
                                            <div class="mb-4">
                                                <a href="{{ route('frontend.home') }}" class="d-inline-block text-white text-decoration-none">
                                                    <h2 class="indochine-brand mb-0 text-white fw-bold">INDO<span>CHINE</span></h2>
                                                </a>
                                            </div>

                                            <div class="mt-auto text-white">
                                                <span class="badge bg-light-subtle text-success text-uppercase mb-3">HỆ THỐNG ĐÀO TẠO NỘI BỘ</span>
                                                <h1 class="display-6 fw-semibold text-white mb-3">Hệ thống quản lý đào tạo & đánh giá năng lực</h1>
                                                <p class="fs-15 text-white text-opacity-75 mb-4">
                                                    Khu vực dành cho quản trị viên quản lý khóa học, bài thi, bài kiểm tra, theo dõi tiến độ học tập và đồng bộ hồ sơ nhân sự INDOCHINE.
                                                </p>

                                                <div class="feature-note mb-4">
                                                    <div class="d-flex align-items-start gap-3">
                                                        <i class="ri-shield-check-line fs-3"></i>
                                                        <div>
                                                            <h5 class="text-white mb-2">Bảo mật và an toàn</h5>
                                                            <p class="mb-0">Hệ thống chỉ cho phép các tài khoản nội bộ INDOCHINE có phân quyền được phép truy cập và vận hành dữ liệu.</p>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row text-center g-3">
                                                    <div class="col-4">
                                                        <h4 class="text-white mb-1"><i class="ri-book-open-line"></i></h4>
                                                        <p class="mb-0 text-white text-opacity-75 small">Khóa học</p>
                                                    </div>
                                                    <div class="col-4">
                                                        <h4 class="text-white mb-1"><i class="ri-file-list-3-line"></i></h4>
                                                        <p class="mb-0 text-white text-opacity-75 small">Bài kiểm tra</p>
                                                    </div>
                                                    <div class="col-4">
                                                        <h4 class="text-white mb-1"><i class="ri-team-line"></i></h4>
                                                        <p class="mb-0 text-white text-opacity-75 small">Nhân sự</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="p-lg-5 p-4">
                                        <div>
                                            <h5 class="text-primary">Đăng nhập quản trị</h5>
                                            <p class="text-muted">Nhập thông tin tài khoản để vào hệ thống quản trị INDOCHINE.</p>
                                        </div>

                                        <div class="mt-4">
                                            @if ($errors->any())
                                                <div class="alert alert-danger mb-3" role="alert">
                                                    <i class="ri-error-warning-line me-1 align-middle"></i>
                                                    {{ $errors->first() ?: 'Đăng nhập thất bại. Vui lòng kiểm tra lại thông tin.' }}
                                                </div>
                                            @endif

                                            <form action="{{ route('backend.admin.authenticate') }}" method="POST">
                                                @csrf
                                                <div class="mb-3">
                                                    <label for="email" class="form-label">Mã nhân viên, Email hoặc Số điện thoại</label>
                                                    <input
                                                        type="text"
                                                        class="form-control @error('email') is-invalid @enderror"
                                                        id="email"
                                                        name="email"
                                                        value="{{ old('email') }}"
                                                        placeholder="Nhập mã nhân viên, email hoặc số điện thoại..."
                                                        autocomplete="username"
                                                        required
                                                    >
                                                    @error('email')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label" for="password-input">Mật khẩu</label>
                                                    <div class="position-relative auth-pass-inputgroup mb-3">
                                                        <input
                                                            type="password"
                                                            class="form-control pe-5 password-input @error('password') is-invalid @enderror"
                                                            id="password-input"
                                                            name="password"
                                                            autocomplete="current-password"
                                                            placeholder="Nhập mật khẩu"
                                                            required
                                                        >
                                                        <button class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon shadow-none" type="button" id="password-addon">
                                                            <i class="ri-eye-fill align-middle"></i>
                                                        </button>
                                                    </div>
                                                    @error('password')
                                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value="1" id="auth-remember-check" name="remember">
                                                    <label class="form-check-label" for="auth-remember-check">Ghi nhớ đăng nhập</label>
                                                </div>

                                                <div class="mt-4">
                                                    <button class="btn btn-success w-100" type="submit">Đăng nhập vào hệ thống</button>
                                                </div>
                                            </form>

                                            @if (\App\Services\GoogleAuthConfigService::get('is_enabled', true))
                                                <div class="d-flex align-items-center mt-3">
                                                    <hr class="flex-grow-1">
                                                    <span class="px-3 text-muted small text-uppercase">Hoặc đăng nhập bằng</span>
                                                    <hr class="flex-grow-1">
                                                </div>
                                                <div class="mt-3 text-center">
                                                    <a href="{{ route('auth.google') }}" class="text-decoration-none">
                                                        <button type="button" class="btn btn-light w-100 d-flex justify-content-center align-items-center shadow-sm border rounded-pill" style="height: 46px;">
                                                            <img src="https://img.icons8.com/color/48/000000/google-logo.png" alt="Google Logo" class="me-2" width="22" height="22">
                                                            <span class="fw-semibold text-dark">Đăng nhập bằng GOOGLE</span>
                                                        </button>
                                                    </a>
                                                </div>
                                            @endif
                                        </div>

                                        <div class="mt-4 text-center">
                                            <p class="mb-0">Quay lại trang học tập? <a href="{{ route('frontend.home') }}" class="fw-semibold text-primary text-decoration-underline">Về trang chủ INDOCHINE</a></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <footer class="footer border-0">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-center">
                            <p class="mb-0 text-muted">
                                &copy; <script>document.write(new Date().getFullYear())</script> INDOCHINE Admin
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    </div>

    <script src="{{ asset('admin-assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('admin-assets/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('admin-assets/libs/node-waves/waves.min.js') }}"></script>
    <script src="{{ asset('admin-assets/libs/feather-icons/feather.min.js') }}"></script>
    <script src="{{ asset('admin-assets/js/pages/plugins/lord-icon-2.1.0.js') }}"></script>
    <script src="{{ asset('admin-assets/js/plugins.js') }}"></script>
    <script src="{{ asset('admin-assets/js/pages/password-addon.init.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @php
        $backendNotice = session('account_notice');
        if (!$backendNotice && isset($errors) && $errors->has('email') && (str_contains($errors->first('email'), 'lưu hành nội bộ') || str_contains($errors->first('email'), 'liên hệ admin'))) {
            $backendNotice = $errors->first('email');
        } elseif (!$backendNotice && session('error') && (str_contains(session('error'), 'lưu hành nội bộ') || str_contains(session('error'), 'liên hệ admin'))) {
            $backendNotice = session('error');
        }
    @endphp
    @if($backendNotice)
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            Swal.fire({
                icon: 'warning',
                title: 'Thông báo',
                html: '<div style="font-size: 15.5px; line-height: 1.6; color: #374151; font-weight: 500; padding: 4px 0;">{!! addslashes($backendNotice) !!}</div>',
                confirmButtonColor: '#0ab39c',
                confirmButtonText: 'Đã hiểu',
                allowOutsideClick: false
            });
        });
    </script>
    @endif
</body>
</html>
