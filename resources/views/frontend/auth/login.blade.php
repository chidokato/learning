<!doctype html>
<html class="no-js" lang="vi">
<head>
   <meta charset="utf-8">
   <meta http-equiv="x-ua-compatible" content="ie=edge">
   <title>Đăng nhập tài khoản -- Indochine Online Education</title>
   <meta name="description" content="Đăng nhập vào hệ thống Indochine để tiếp tục hành trình học tập.">
   <meta name="viewport" content="width=device-width, initial-scale=1">

   <!-- Place favicon.ico in the root directory -->
   <link rel="shortcut icon" type="image/x-icon" href="{{ $siteSetting->favicon_url ?? asset('assets/img/logo/favicon.png') }}">

   <!-- Google Fonts - Montserrat -->
   <link rel="preconnect" href="https://fonts.googleapis.com">
   <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
   <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

   <!-- CSS Here -->
   <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">        
   <link rel="stylesheet" href="{{ asset('assets/css/font-awesome-pro.css') }}">     
   <link rel="stylesheet" href="{{ asset('assets/css/swiper-bundle.min.css') }}">   
   <link rel="stylesheet" href="{{ asset('assets/css/slick.css') }}">              
   <link rel="stylesheet" href="{{ asset('assets/css/magnific-popup.css') }}">      
   <link rel="stylesheet" href="{{ asset('assets/css/nice-select.css') }}">          
   <link rel="stylesheet" href="{{ asset('assets/css/custom-animation.css') }}">
   <link rel="stylesheet" href="{{ asset('assets/css/spacing.css') }}">          
   <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}?v=1.0.1">   
   <link rel="stylesheet" href="{{ asset('assets/css/course-custom.css') }}?v=1.0.1">   
   <link rel="stylesheet" href="{{ asset('assets/css/header-custom.css') }}?v=1.0.1">   
   <link rel="stylesheet" href="{{ asset('assets/css/auth.css') }}?v=1.0.2">
</head>

<body>
   <!-- back-to-top-start  -->
   <button class="scroll-top scroll-to-target" data-target="html">
      <i class="far fa-angle-double-up"></i>
   </button>
   <!-- back-to-top-end  -->

   @include('frontend.partials.header')

   <main>
      <!-- auth-area-start -->
      <section class="auth-page-area">
         <div class="container">
            <div class="row justify-content-center">
               <div class="col-12">
                  <div class="auth-card-wrap auth-card-login">
                     <div class="auth-card">
                        <div class="auth-header">
                           <div class="auth-badge-icon">
                              <i class="fas fa-user-lock"></i>
                           </div>
                           <h4 class="auth-title">Chào mừng trở lại!</h4>
                           <p class="auth-subtitle">Đăng nhập tài khoản để tiếp tục học tập tại Indochine</p>
                        </div>

                        @if (isset($errors) && $errors->any())
                           <div class="auth-alert auth-alert-danger">
                              <div class="d-flex align-items-start gap-2">
                                 <i class="fas fa-exclamation-circle mt-1 flex-shrink-0"></i>
                                 <div>
                                    <strong class="d-block mb-1">Đăng nhập không thành công</strong>
                                    <ul class="mb-0 ps-3">
                                       @foreach ($errors->all() as $error)
                                          <li>{{ $error }}</li>
                                       @endforeach
                                    </ul>
                                 </div>
                              </div>
                           </div>
                        @endif

                        @if (session('error'))
                           <div class="auth-alert auth-alert-danger">
                              <div class="d-flex align-items-center gap-2">
                                 <i class="fas fa-exclamation-circle flex-shrink-0"></i>
                                 <div>{{ session('error') }}</div>
                              </div>
                           </div>
                        @endif

                        @if (session('warning'))
                           <div class="auth-alert auth-alert-warning">
                              <div class="d-flex align-items-center gap-2">
                                 <i class="fas fa-exclamation-triangle flex-shrink-0"></i>
                                 <div>{{ session('warning') }}</div>
                              </div>
                           </div>
                        @endif

                        @if (session('success'))
                           <div class="auth-alert auth-alert-success">
                              <div class="d-flex align-items-center gap-2">
                                 <i class="fas fa-check-circle flex-shrink-0"></i>
                                 <div>{{ session('success') }}</div>
                              </div>
                           </div>
                        @endif

                        @if (session('info'))
                           <div class="auth-alert auth-alert-info">
                              <div class="d-flex align-items-center gap-2">
                                 <i class="fas fa-info-circle flex-shrink-0"></i>
                                 <div>{{ session('info') }}</div>
                              </div>
                           </div>
                        @endif

                        <form action="{{ route('frontend.login.post') }}" method="POST">
                           @csrf

                           <!-- Email Input -->
                           <div class="auth-field">
                              <label class="auth-label">Email hoặc tên đăng nhập <span class="required">*</span></label>
                              <div class="auth-input-group">
                                 <i class="far fa-envelope auth-input-icon"></i>
                                 <input type="email" name="email" value="{{ old('email') }}" class="auth-input-control" placeholder="name@example.com" required autofocus>
                              </div>
                           </div>

                           <!-- Password Input -->
                           <div class="auth-field">
                              <label class="auth-label">Mật khẩu <span class="required">*</span></label>
                              <div class="auth-input-group">
                                 <i class="far fa-lock-alt auth-input-icon"></i>
                                 <input type="password" name="password" id="loginPassword" class="auth-input-control has-toggle" placeholder="Nhập mật khẩu của bạn" required>
                                 <button type="button" class="auth-password-toggle" onclick="togglePassword('loginPassword', 'loginEyeIcon')" title="Hiện/ẩn mật khẩu">
                                    <i class="far fa-eye" id="loginEyeIcon"></i>
                                 </button>
                              </div>
                           </div>

                           <!-- Remember Me & Forgot Password -->
                           <div class="auth-options">
                              <div class="auth-checkbox-wrap">
                                 <input type="checkbox" name="remember" value="1" id="rememberMe" {{ old('remember') ? 'checked' : '' }}>
                                 <label class="auth-checkbox-label" for="rememberMe">Ghi nhớ đăng nhập</label>
                              </div>
                              <a class="auth-link" href="#" data-bs-toggle="modal" data-bs-target="#forgotPasswordModal">Quên mật khẩu?</a>
                           </div>

                           <!-- Submit Button -->
                           <div class="mb-3">
                              <button type="submit" class="auth-btn-primary">
                                 <span>Đăng nhập</span>
                                 <i class="far fa-arrow-right"></i>
                              </button>
                           </div>

                           @if (\App\Services\GoogleAuthConfigService::get('is_enabled', true))
                           <!-- Divider -->
                           <div class="auth-divider">
                              <span>hoặc tiếp tục với</span>
                           </div>

                           <!-- Google Login -->
                           <div>
                              <a href="{{ route('auth.google') }}" class="auth-btn-google" id="btnGoogleLogin">
                                 <svg width="18" height="18" viewBox="0 0 24 24">
                                    <path fill="#4285F4" d="M23.745 12.27c0-.7-.06-1.4-.19-2.07H12v4.51h6.6c-.29 1.52-1.14 2.82-2.4 3.68v3.05h3.88c2.27-2.09 3.66-5.17 3.66-9.17z"/>
                                    <path fill="#34A853" d="M12 24c3.24 0 5.95-1.08 7.93-2.91l-3.88-3.05c-1.08.72-2.45 1.16-4.05 1.16-3.12 0-5.77-2.1-6.72-4.93H1.25v3.15C3.26 21.36 7.33 24 12 24z"/>
                                    <path fill="#FBBC05" d="M5.28 14.27c-.25-.72-.38-1.49-.38-2.27s.13-1.55.38-2.27V6.58H1.25C.45 8.18 0 9.98 0 12s.45 3.82 1.25 5.42l4.03-3.15z"/>
                                    <path fill="#EA4335" d="M12 4.75c1.77 0 3.35.61 4.6 1.8l3.42-3.42C17.95 1.19 15.24 0 12 0 7.33 0 3.26 2.64 1.25 6.58l4.03 3.15c.95-2.83 3.6-4.98 6.72-4.98z"/>
                                 </svg>
                                 <span>Đăng nhập với Google</span>
                              </a>
                           </div>
                           @endif

                           <!-- Switch to Register -->
                           <p class="auth-switch-text">
                              Bạn chưa có tài khoản? <a href="{{ route('frontend.register') }}">Đăng ký ngay</a>
                           </p>
                        </form>
                     </div>
                  </div>
               </div> 
            </div>
         </div>
      </section>
      <!-- auth-area-end -->

      <!-- Forgot Password Modal -->
      <div class="modal fade" id="forgotPasswordModal" tabindex="-1" aria-labelledby="forgotPasswordModalLabel" aria-hidden="true">
         <div class="modal-dialog modal-dialog-centered" style="max-width: 440px;">
            <div class="modal-content border-0 shadow-lg" style="border-radius: 16px; overflow: hidden;">
               <div class="modal-header text-white p-4" style="background: #03594E;">
                  <h5 class="modal-title fw-bold text-white d-flex align-items-center gap-2 mb-0" id="forgotPasswordModalLabel" style="font-size: 18px;">
                     <i class="far fa-key text-warning"></i> Khôi phục mật khẩu
                  </h5>
                  <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
               </div>
               <form action="{{ route('frontend.forgot-password') }}" method="POST">
                  @csrf
                  <div class="modal-body p-4">
                     <p class="text-muted mb-3" style="font-size: 13.5px; line-height: 1.55;">
                        Nhập địa chỉ email đăng ký tài khoản của bạn. Hệ thống sẽ gửi liên kết khôi phục mật khẩu đến hòm thư của bạn.
                     </p>
                     <div class="auth-field mb-0">
                        <label class="auth-label">Địa chỉ Email của bạn <span class="required">*</span></label>
                        <div class="auth-input-group">
                           <i class="far fa-envelope auth-input-icon"></i>
                           <input type="email" name="email" class="auth-input-control" placeholder="name@example.com" required>
                        </div>
                     </div>
                  </div>
                  <div class="modal-footer bg-light px-4 py-3 border-0 d-flex justify-content-end gap-2">
                     <button type="button" class="btn btn-outline-secondary px-3 py-2" data-bs-dismiss="modal" style="border-radius: 8px; font-size: 13.5px; font-weight: 500;">Hủy</button>
                     <button type="submit" class="auth-btn-primary px-4 py-2" style="width: auto; height: 38px; font-size: 13.5px;">
                        <span>Gửi liên kết</span>
                     </button>
                  </div>
               </form>
            </div>
         </div>
      </div>
   </main>

   @include('frontend.partials.footer')
   
   <!-- JS Libraries -->
   <script src="{{ asset('assets/js/jquery.js') }}"></script>                     
   <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>      
   <script src="{{ asset('assets/js/purecounter.js') }}"></script>          
   <script src="{{ asset('assets/js/range-slider.js') }}"></script>          
   <script src="{{ asset('assets/js/nice-select.js') }}"></script>             
   <script src="{{ asset('assets/js/swiper-bundle.min.js') }}"></script>         
   <script src="{{ asset('assets/js/slick.min.js') }}"></script>                 
   <script src="{{ asset('assets/js/magnific-popup.js') }}"></script>           
   <script src="{{ asset('assets/js/wow.js') }}"></script>                    
   <script src="{{ asset('assets/js/main.js') }}"></script>

   <script>
      function togglePassword(inputId, iconId) {
         var input = document.getElementById(inputId);
         var icon = document.getElementById(iconId);
         if (!input || !icon) return;
         if (input.type === 'password') {
            input.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
         } else {
            input.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
         }
      }

      // Visual feedback when clicking Google Login
      document.addEventListener('DOMContentLoaded', function() {
         var googleBtn = document.getElementById('btnGoogleLogin');
         if (googleBtn) {
            googleBtn.addEventListener('click', function(e) {
               if (this.dataset.submitting === 'true') {
                  e.preventDefault();
                  return;
               }
               this.dataset.submitting = 'true';
               this.classList.add('is-loading');
               var span = this.querySelector('span');
               if (span) {
                  span.textContent = 'Đang chuyển hướng sang Google...';
               }
            });
         }
      });
   </script>

   @if(isset($errors) && $errors->has('email') && (str_contains($errors->first('email'), 'lưu hành nội bộ') || str_contains($errors->first('email'), 'liên hệ admin')))
   <script>
      document.addEventListener('DOMContentLoaded', function () {
         if (typeof Swal !== 'undefined') {
            Swal.fire({
               icon: 'warning',
               title: 'Thông báo',
               html: '<div style="font-size: 15.5px; line-height: 1.6; color: #374151; font-weight: 500; padding: 4px 0;">{!! addslashes($errors->first('email')) !!}</div>',
               confirmButtonColor: '#03594E',
               confirmButtonText: 'Đã hiểu',
               allowOutsideClick: false,
               customClass: {
                  popup: 'swal2-center-notice-modal'
               }
            });
         }
      });
   </script>
   @endif
</body>
</html>