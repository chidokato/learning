<!doctype html>
<html class="no-js" lang="vi">
<head>
   <meta charset="utf-8">
   <meta http-equiv="x-ua-compatible" content="ie=edge">
   <title>Đăng ký tài khoản mới -- Indochine Online Education</title>
   <meta name="description" content="Đăng ký thành viên Indochine để mở khóa hàng ngàn khóa học chất lượng cao.">
   <meta name="viewport" content="width=device-width, initial-scale=1">

   <!-- Place favicon.ico in the root directory -->
   <link rel="shortcut icon" type="image/x-icon" href="{{ $siteSetting->favicon_url ?? asset('assets/img/logo/favicon.png') }}">

   <!-- CSS Here -->
   <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">        
   <link rel="stylesheet" href="{{ asset('assets/css/font-awesome-pro.css') }}">     
   <link rel="stylesheet" href="{{ asset('assets/css/swiper-bundle.min.css') }}">   
   <link rel="stylesheet" href="{{ asset('assets/css/slick.css') }}">              
   <link rel="stylesheet" href="{{ asset('assets/css/magnific-popup.css') }}">      
   <link rel="stylesheet" href="{{ asset('assets/css/nice-select.css') }}">          
   <link rel="stylesheet" href="{{ asset('assets/css/custom-animation.css') }}">
   <link rel="stylesheet" href="{{ asset('assets/css/spacing.css') }}">          
   <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">   
   <link rel="stylesheet" href="{{ asset('assets/css/auth.css') }}?v={{ time() }}">
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
                  <div class="auth-card-wrap auth-card-register">
                     <div class="auth-card">
                        <div class="auth-header">
                           <div class="auth-badge-icon">
                              <i class="fas fa-user-plus"></i>
                           </div>
                           <h4 class="auth-title">Tạo tài khoản mới</h4>
                           <p class="auth-subtitle">Đăng ký thành viên để khám phá các khóa học nội bộ Indochine</p>
                        </div>

                        @if (isset($errors) && $errors->any())
                           <div class="auth-alert auth-alert-danger">
                              <div class="d-flex align-items-start gap-2">
                                 <i class="fas fa-exclamation-circle mt-1 flex-shrink-0"></i>
                                 <div>
                                    <strong class="d-block mb-1">Đăng ký chưa hoàn tất</strong>
                                    <ul class="mb-0 ps-3">
                                       @foreach ($errors->all() as $error)
                                          <li>{{ $error }}</li>
                                       @endforeach
                                    </ul>
                                 </div>
                              </div>
                           </div>
                        @endif

                        <form action="{{ route('frontend.register.post') }}" method="POST">
                           @csrf

                           <div class="row">
                              <!-- Họ và tên -->
                              <div class="col-md-6">
                                 <div class="auth-field">
                                    <label class="auth-label">Họ và tên <span class="required">*</span></label>
                                    <div class="auth-input-group">
                                       <i class="far fa-user auth-input-icon"></i>
                                       <input type="text" name="name" value="{{ old('name') }}" class="auth-input-control" placeholder="Nguyễn Văn A" required autofocus>
                                    </div>
                                 </div>
                              </div>

                              <!-- Số điện thoại -->
                              <div class="col-md-6">
                                 <div class="auth-field">
                                    <label class="auth-label">Số điện thoại</label>
                                    <div class="auth-input-group">
                                       <i class="far fa-phone auth-input-icon"></i>
                                       <input type="tel" name="phone" value="{{ old('phone') }}" class="auth-input-control" placeholder="0987 654 321">
                                    </div>
                                 </div>
                              </div>

                              <!-- Email -->
                              <div class="col-12">
                                 <div class="auth-field">
                                    <label class="auth-label">Địa chỉ Email <span class="required">*</span></label>
                                    <div class="auth-input-group">
                                       <i class="far fa-envelope auth-input-icon"></i>
                                       <input type="email" name="email" value="{{ old('email') }}" class="auth-input-control" placeholder="student@indochine.vn" required>
                                    </div>
                                 </div>
                              </div>

                              <!-- Mật khẩu -->
                              <div class="col-md-6">
                                 <div class="auth-field">
                                    <label class="auth-label">Mật khẩu <span class="required">*</span></label>
                                    <div class="auth-input-group">
                                       <i class="far fa-lock-alt auth-input-icon"></i>
                                       <input type="password" name="password" id="registerPassword" class="auth-input-control has-toggle" placeholder="Tối thiểu 6 ký tự" required>
                                       <button type="button" class="auth-password-toggle" onclick="togglePassword('registerPassword', 'regPassEye')" title="Hiện/ẩn mật khẩu">
                                          <i class="far fa-eye" id="regPassEye"></i>
                                       </button>
                                    </div>
                                 </div>
                              </div>

                              <!-- Xác nhận mật khẩu -->
                              <div class="col-md-6">
                                 <div class="auth-field">
                                    <label class="auth-label">Xác nhận mật khẩu <span class="required">*</span></label>
                                    <div class="auth-input-group">
                                       <i class="far fa-shield-check auth-input-icon"></i>
                                       <input type="password" name="password_confirmation" id="registerPasswordConfirm" class="auth-input-control has-toggle" placeholder="Nhập lại mật khẩu" required>
                                       <button type="button" class="auth-password-toggle" onclick="togglePassword('registerPasswordConfirm', 'regPassConfirmEye')" title="Hiện/ẩn mật khẩu">
                                          <i class="far fa-eye" id="regPassConfirmEye"></i>
                                       </button>
                                    </div>
                                 </div>
                              </div>
                           </div>

                           <!-- Terms Agree -->
                           <div class="auth-checkbox-wrap my-3">
                              <input type="checkbox" name="terms" value="1" id="agreeTerms" required {{ old('terms') ? 'checked' : '' }}>
                              <label class="auth-checkbox-label" for="agreeTerms">
                                 Tôi đồng ý với <a href="#" class="auth-link">Điều khoản</a> & <a href="#" class="auth-link">Chính sách bảo mật</a> của Indochine
                              </label>
                           </div>

                           <!-- Submit Button -->
                           <div class="mb-3">
                              <button type="submit" class="auth-btn-primary">
                                 <span>Đăng ký ngay</span>
                                 <i class="far fa-arrow-right"></i>
                              </button>
                           </div>

                           <!-- Divider -->
                           <div class="auth-divider">
                              <span>hoặc tiếp tục với</span>
                           </div>

                           <!-- Google Register -->
                           <div>
                              <a href="#" onclick="showDemoToast('Google'); return false;" class="auth-btn-google">
                                 <svg width="18" height="18" viewBox="0 0 24 24">
                                    <path fill="#4285F4" d="M23.745 12.27c0-.7-.06-1.4-.19-2.07H12v4.51h6.6c-.29 1.52-1.14 2.82-2.4 3.68v3.05h3.88c2.27-2.09 3.66-5.17 3.66-9.17z"/>
                                    <path fill="#34A853" d="M12 24c3.24 0 5.95-1.08 7.93-2.91l-3.88-3.05c-1.08.72-2.45 1.16-4.05 1.16-3.12 0-5.77-2.1-6.72-4.93H1.25v3.15C3.26 21.36 7.33 24 12 24z"/>
                                    <path fill="#FBBC05" d="M5.28 14.27c-.25-.72-.38-1.49-.38-2.27s.13-1.55.38-2.27V6.58H1.25C.45 8.18 0 9.98 0 12s.45 3.82 1.25 5.42l4.03-3.15z"/>
                                    <path fill="#EA4335" d="M12 4.75c1.77 0 3.35.61 4.6 1.8l3.42-3.42C17.95 1.19 15.24 0 12 0 7.33 0 3.26 2.64 1.25 6.58l4.03 3.15c.95-2.83 3.6-4.98 6.72-4.98z"/>
                                 </svg>
                                 <span>Đăng ký với Google</span>
                              </a>
                           </div>

                           <!-- Switch to Login -->
                           <p class="auth-switch-text">
                              Bạn đã có tài khoản? <a href="{{ route('frontend.login') }}">Đăng nhập ngay</a>
                           </p>
                        </form>
                     </div>
                  </div>
               </div> 
            </div>
         </div>
      </section>
      <!-- auth-area-end -->
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

      function showDemoToast(provider) {
         alert('Tính năng đăng ký nhanh với ' + provider + ' đang được hoàn thiện. Vui lòng sử dụng đăng ký bằng Email / Mật khẩu để tiếp tục!');
      }
   </script>
</body>
</html>
