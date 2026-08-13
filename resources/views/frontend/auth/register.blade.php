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
</head>

<body>
   <!-- back-to-top-start  -->
   <button class="scroll-top scroll-to-target" data-target="html">
      <i class="far fa-angle-double-up"></i>
   </button>
   <!-- back-to-top-end  -->

   @include('frontend.partials.header')

   <main>

   

   <!-- sign-in-area-start -->
   <div class="it-signup-area pt-50 pb-130">
      <div class="container">
         <div class="row justify-content-center">
            <div class="col-xxl-8 col-xl-10 col-lg-11">
               <div class="it-signup-wrap">
                  <h4 class="it-signup-title">Chào mừng bạn đến với Indochine!</h4>

                  @if ($errors->any())
                     <div class="alert alert-danger mb-30" style="border-radius: 10px;">
                        <ul class="mb-0 ps-3">
                           @foreach ($errors->all() as $error)
                              <li>{{ $error }}</li>
                           @endforeach
                        </ul>
                     </div>
                  @endif

                  <form action="{{ route('frontend.register.post') }}" method="POST">
                     @csrf
                     <div class="it-signup-input-wrap">
                        <div class="row">
                           <div class="col-md-6">
                              <div class="it-signup-input mb-20">
                                 <label>Họ và tên <span class="text-danger">*</span></label>
                                 <input type="text" name="name" value="{{ old('name') }}" placeholder="Nhập họ và tên" required autofocus>
                              </div>
                           </div>
                           <div class="col-md-6">
                              <div class="it-signup-input mb-20">
                                 <label>Số điện thoại</label>
                                 <input type="tel" name="phone" value="{{ old('phone') }}" placeholder="Nhập số điện thoại">
                              </div>
                           </div>
                           <div class="col-12">
                              <div class="it-signup-input mb-20">
                                 <label>Địa chỉ Email <span class="text-danger">*</span></label>
                                 <input type="email" name="email" value="{{ old('email') }}" placeholder="student@example.com" required>
                              </div>
                           </div>
                           <div class="col-md-6">
                              <div class="it-signup-input mb-20">
                                 <label>Mật khẩu <span class="text-danger">*</span></label>
                                 <input type="password" name="password" placeholder="Nhập mật khẩu (ít nhất 6 ký tự)" required>
                              </div>
                           </div>
                           <div class="col-md-6">
                              <div class="it-signup-input mb-25">
                                 <label>Xác nhận mật khẩu <span class="text-danger">*</span></label>
                                 <input type="password" name="password_confirmation" placeholder="Nhập lại mật khẩu" required>
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="it-signup-forget d-flex justify-content-between flex-wrap">
                        <div class="it-contact-agree mb-30">
                           <div class="form-check">
                              <input class="form-check-input" type="checkbox" name="terms" value="1"
                                 id="flexCheckDefault" required {{ old('terms') ? 'checked' : '' }}>
                              <label class="form-check-label" for="flexCheckDefault">
                                 Tôi đồng ý với các Điều khoản & Chính sách bảo mật của Indochine
                              </label>
                           </div>
                        </div>
                     </div>
                     <div class="it-signup-btn mb-25">
                        <button type="submit" class="it-btn-yellow theme-bg w-100">
                           <span>
                              <span class="text-1">Đăng ký ngay</span>
                              <span class="text-2">Đăng ký ngay</span>
                           </span>
                        </button>
                     </div>
                     <div class="it-signup-text text-center mb-30">
                        <span>Bạn đã có tài khoản?<a href="{{ route('frontend.login') }}"> Đăng nhập ngay</a></span>
                     </div>
                     <div class="it-signup-border text-center">
                        <span>hoặc</span>
                     </div>
                     <div class="it-signup-continue-wrap">
                        <div class="row gx-35 justify-content-center">
                           <div class="col-12">
                              <div>
                                 <a href="#" onclick="showDemoToast('Google'); return false;">
                                    <div class="it-signup-continue-item d-flex align-items-center justify-content-center">
                                       <img src="{{ asset('assets/img/contact/icon-1.png') }}" alt="">
                                       <span>Đăng ký với Google</span>
                                    </div>
                                 </a>
                              </div>
                           </div>
                        </div>
                     </div>                     
                  </form>
               </div>
            </div> 
         </div>
      </div>
   </div>
   <!-- sign-in-area-end -->

   

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
      function showDemoToast(provider) {
         alert('Tính năng đăng ký nhanh với ' + provider + ' đang được kích hoạt. Vui lòng sử dụng đăng ký bằng Email / Mật khẩu để trải nghiệm hệ thống!');
      }
   </script>
</body>
</html>
