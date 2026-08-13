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
            <div class="col-xl-8 col-lg-10">
               <div class="it-signup-wrap">
                  <h4 class="it-signup-title">Chào mừng bạn quay trở lại!</h4>

                  @if ($errors->any())
                     <div class="alert alert-danger mb-30" style="border-radius: 10px;">
                        <ul class="mb-0 ps-3">
                           @foreach ($errors->all() as $error)
                              <li>{{ $error }}</li>
                           @endforeach
                        </ul>
                     </div>
                  @endif

                  @if (session('success'))
                     <div class="alert alert-success mb-30" style="border-radius: 10px;">
                        {{ session('success') }}
                     </div>
                  @endif

                  @if (session('info'))
                     <div class="alert alert-info mb-30" style="border-radius: 10px;">
                        {{ session('info') }}
                     </div>
                  @endif

                  <form action="{{ route('frontend.login.post') }}" method="POST">
                     @csrf
                     <div class="it-signup-input-wrap">
                        <div class="it-signup-input mb-20">
                           <label>Email hoặc tên đăng nhập</label>
                           <input type="email" name="email" value="{{ old('email') }}" placeholder="Email hoặc tên đăng nhập" required autofocus>
                        </div>
                        <div class="it-signup-input mb-25">
                           <label>Mật khẩu</label>
                           <input type="password" name="password" placeholder="Nhập mật khẩu" required>
                        </div>
                     </div>
                     <div class="it-signup-forget d-flex justify-content-between flex-wrap">
                        <div class="it-contact-agree mb-30">
                           <div class="form-check">
                              <input class="form-check-input" type="checkbox" name="remember" value="1"
                                 id="flexCheckDefault" {{ old('remember') ? 'checked' : '' }}>
                              <label class="form-check-label" for="flexCheckDefault">
                                 Ghi nhớ đăng nhập
                              </label>
                           </div>
                        </div>
                        <a class="mb-30 border-line" href="#" data-bs-toggle="modal" data-bs-target="#forgotPasswordModal">Quên mật khẩu?</a>
                     </div>
                     <div class="it-signup-btn mb-25">
                        <button type="submit" class="it-btn-yellow theme-bg w-100">
                           <span>
                              <span class="text-1">Đăng nhập</span>
                              <span class="text-2">Đăng nhập</span>
                           </span>
                        </button>
                     </div>
                     <div class="it-signup-text text-center mb-30">
                        <span>Bạn chưa có tài khoản?<a href="{{ route('frontend.register') }}"> Đăng ký ngay</a></span>
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
                                       <span>Đăng nhập với Google</span>
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

   <!-- newsletter-area-start -->
   <div class="it-newsletter-area">
      <div class="container">
         <div class="it-newsletter-wrap theme-bg z-index-2 wow itfadeUp" data-wow-duration=".9s"
                  data-wow-delay=".3s">
            <img class="it-newsletter-shape-1" src="{{ asset('assets/img/shape/newsletter-2-1.png') }}" alt="">
            <div class="row align-items-center">
               <div class="col-lg-6">
                  <div class="it-newsletter-2-left">
                     <h4 class="it-newsletter-2-title text-white mb-0">Đăng ký ngay hôm nay để nhận <br> những kiến thức & thông tin mới nhất</h4>
                  </div>
               </div>
               <div class="col-lg-6">
                  <div class="it-newsletter-input-box">
                     <form class="input-wrap p-relative" action="#">
                        <input type="email" placeholder="Nhập địa chỉ Email của bạn">
                        <button type="submit">
                           <svg width="26" height="27" viewBox="0 0 26 27" fill="none" xmlns="http://www.w3.org/2000/svg">
                              <path d="M24.7282 1.82586C24.3517 1.44485 23.8834 1.16736 23.3684 1.02022C22.8534 0.873071 22.3091 0.861239 21.7882 0.985864L4.9882 4.52436C4.0207 4.65705 3.10947 5.05722 2.35711 5.6798C1.60475 6.30238 1.04115 7.12265 0.729789 8.04823C0.418424 8.97381 0.371658 9.96795 0.594756 10.9187C0.817855 11.8694 1.30196 12.739 1.99255 13.4294L3.79645 15.2323C3.89408 15.3299 3.97151 15.4458 4.0243 15.5733C4.07709 15.7009 4.1042 15.8376 4.1041 15.9757V19.3021C4.10641 19.7698 4.21408 20.2309 4.4191 20.6513L4.4107 20.6587L4.438 20.686C4.74566 21.3045 5.24816 21.8048 5.8681 22.1098L5.8954 22.1371L5.90275 22.1287C6.32312 22.3337 6.78429 22.4413 7.252 22.4437H10.5784C10.8567 22.4434 11.1237 22.5537 11.3207 22.7503L13.1236 24.5531C13.6071 25.042 14.1827 25.4304 14.817 25.6958C15.4514 25.9613 16.132 26.0986 16.8196 26.0998C17.3926 26.0991 17.9618 26.0054 18.5048 25.8226C19.422 25.5214 20.2367 24.97 20.8571 24.2305C21.4775 23.4909 21.8789 22.5928 22.016 21.6373L25.5598 4.80051C25.6909 4.27514 25.6832 3.72471 25.5374 3.20322C25.3916 2.68173 25.1127 2.20709 24.7282 1.82586ZM5.28325 13.7497L3.4783 11.9468C3.058 11.5366 2.76343 11.0151 2.62915 10.4434C2.49487 9.87166 2.52645 9.27351 2.7202 8.71911C2.90804 8.15035 3.25528 7.64751 3.72063 7.27039C4.18598 6.89327 4.74986 6.65774 5.3452 6.59181L21.9782 3.09006L6.202 18.8684V15.9757C6.20359 15.5623 6.12321 15.1528 5.96551 14.7707C5.80781 14.3886 5.57591 14.0416 5.28325 13.7497ZM19.9528 21.2782C19.8722 21.8581 19.6315 22.4041 19.2578 22.8549C18.8841 23.3056 18.3921 23.6433 17.8372 23.83C17.2822 24.0167 16.6862 24.045 16.116 23.9118C15.5459 23.7786 15.0241 23.4891 14.6093 23.0758L12.8033 21.2698C12.5118 20.9767 12.1651 20.7443 11.7832 20.586C11.4013 20.4278 10.9918 20.3468 10.5784 20.3479H7.68565L23.464 4.57476L19.9528 21.2782Z" fill="currentcolor" />
                           </svg>
                        </button>
                     </form>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
   <!-- newsletter-area-end -->

   <!-- Forgot Password Modal -->
   <div class="modal fade" id="forgotPasswordModal" tabindex="-1" aria-labelledby="forgotPasswordModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
         <div class="modal-content border-0 shadow" style="border-radius: 12px; overflow: hidden;">
            <div class="modal-header bg-dark text-white p-4">
               <h5 class="modal-title fw-bold" id="forgotPasswordModalLabel">
                  <i class="fas fa-key text-warning me-2"></i> Khôi Phục Mật Khẩu
               </h5>
               <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('frontend.forgot-password') }}" method="POST">
               @csrf
               <div class="modal-body p-4">
                  <p class="text-muted mb-4">
                     Vui lòng nhập địa chỉ email bạn đã dùng để đăng ký. Chúng tôi sẽ gửi liên kết để bạn đặt lại mật khẩu mới.
                  </p>
                  <div class="it-signup-input mb-0">
                     <label>Địa chỉ Email của bạn</label>
                     <input type="email" name="email" placeholder="email@example.com" required style="width: 100%;">
                  </div>
               </div>
               <div class="modal-footer bg-light p-3 border-0">
                  <button type="button" class="btn btn-secondary px-4 py-2" data-bs-dismiss="modal">Hủy bỏ</button>
                  <button type="submit" class="it-btn-yellow px-4 py-2" style="border: none;">
                     <span>
                        <span class="text-1">Gửi link khôi phục</span>
                        <span class="text-2">Gửi link khôi phục</span>
                     </span>
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
      function showDemoToast(provider) {
         alert('Tính năng đăng nhập nhanh với ' + provider + ' đang được kích hoạt. Vui lòng sử dụng đăng nhập bằng Email / Mật khẩu để trải nghiệm hệ thống!');
      }
   </script>
</body>
</html>
