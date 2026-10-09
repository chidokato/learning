<!doctype html>
<html class="no-js" lang="vi">
<head>
   <meta charset="utf-8">
   <meta http-equiv="x-ua-compatible" content="ie=edge">
   <title>Trang cá nhân -- Indochine</title>
   <meta name="description" content="">
   <meta name="viewport" content="width=device-width, initial-scale=1">

   <link rel="shortcut icon" type="image/x-icon" href="{{ $siteSetting->favicon_url ?? asset('assets/img/favicon.png') }}">

   <!-- CSS Here -->
   <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">        
   <link rel="stylesheet" href="{{ asset('assets/css/font-awesome-pro.css') }}">     
   <link rel="stylesheet" href="{{ asset('assets/css/swiper-bundle.min.css') }}">   
   <link rel="stylesheet" href="{{ asset('assets/css/slick.css') }}">              
   <link rel="stylesheet" href="{{ asset('assets/css/magnific-popup.css') }}">      
   <link rel="stylesheet" href="{{ asset('assets/css/nice-select.css') }}">          
   <link rel="stylesheet" href="{{ asset('assets/css/custom-animation.css') }}">

   <!-- Theme / Main CSS -->
   <link rel="stylesheet" href="{{ asset('assets/css/spacing.css') }}">          
   <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}?v={{ time() }}">   

   <style>
      .profile-header {
         background: #f8f9fa;
         padding: 50px 0;
         border-bottom: 1px solid #eaeaea;
      }
      .profile-info {
         background: #fff;
         padding: 30px;
         border-radius: 10px;
         box-shadow: 0 5px 15px rgba(0,0,0,0.05);
      }
   </style>
</head>

<body>

   <!-- back-to-top-start  -->
   <button class="scroll-top scroll-to-target" data-target="html">
      <i class="far fa-angle-double-up"></i>
   </button>

   @include('frontend.partials.header')

   <main>
      <div class="profile-header text-center">
         <div class="container">
            <h2 class="mb-10">Trang cá nhân</h2>
            <p>Quản lý thông tin tài khoản của bạn</p>
         </div>
      </div>

      <div class="profile-area pt-80 pb-80">
         <div class="container">
            <div class="row justify-content-center">
               <div class="col-lg-8">
                  <div class="profile-info">
                     <h4 class="mb-30">Thông tin cá nhân</h4>
                     
                     <form action="{{ route('frontend.profile.update') }}" method="POST">
                        @csrf
                        
                        <div class="row mb-20">
                           <div class="col-md-6">
                              <label class="form-label">Họ và tên <span class="text-danger">*</span></label>
                              <input type="text" name="name" class="form-control" value="{{ old('name', Auth::user()->name) }}" required>
                              @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                           </div>
                           <div class="col-md-6 mt-20 mt-md-0">
                              <label class="form-label">Email</label>
                              <input type="email" class="form-control" value="{{ Auth::user()->email }}" disabled>
                              <small class="text-muted">Email không thể thay đổi</small>
                           </div>
                        </div>

                        <div class="row mb-20">
                           <div class="col-md-6">
                              <label class="form-label">Số điện thoại</label>
                              <input type="text" name="phone" class="form-control" value="{{ old('phone', Auth::user()->phone) }}">
                              @error('phone') <small class="text-danger">{{ $message }}</small> @enderror
                           </div>
                           <div class="col-md-6 mt-20 mt-md-0">
                              <label class="form-label">Địa chỉ</label>
                              <input type="text" name="address" class="form-control" value="{{ old('address', Auth::user()->address) }}">
                              @error('address') <small class="text-danger">{{ $message }}</small> @enderror
                           </div>
                        </div>

                        <hr class="my-4">
                        <h5 class="mb-20">Đổi mật khẩu (Để trống nếu không muốn đổi)</h5>

                        <div class="row mb-20">
                           <div class="col-md-6">
                              <label class="form-label">Mật khẩu mới</label>
                              <input type="password" name="password" class="form-control" minlength="6">
                              @error('password') <small class="text-danger">{{ $message }}</small> @enderror
                           </div>
                           <div class="col-md-6 mt-20 mt-md-0">
                              <label class="form-label">Nhập lại mật khẩu mới</label>
                              <input type="password" name="password_confirmation" class="form-control" minlength="6">
                           </div>
                        </div>

                        <div class="mt-4 text-end">
                           <button type="submit" class="it-btn-yellow">
                              <span>
                                 <span class="text-1">Cập nhật thông tin</span>
                                 <span class="text-2">Cập nhật thông tin</span>
                              </span>
                           </button>
                        </div>
                     </form>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </main>

   @include('frontend.partials.footer')
   
   <!-- JS  Libraries -->
   <script src="{{ asset('assets/js/jquery.js') }}"></script>                     
   <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>      
   <script src="{{ asset('assets/js/purecounter.js') }}"></script>          
   <script src="{{ asset('assets/js/range-slider.js') }}"></script>          
   <script src="{{ asset('assets/js/nice-select.js') }}"></script>             
   <script src="{{ asset('assets/js/swiper-bundle.min.js') }}"></script>         
   <script src="{{ asset('assets/js/isotope-pkgd.js') }}"></script>     
   <script src="{{ asset('assets/js/slick.min.js') }}"></script>            
   <script src="{{ asset('assets/js/wow.js') }}"></script>                
   <script src="{{ asset('assets/js/countdown.js') }}"></script>                
   <script src="{{ asset('assets/js/magnific-popup.js') }}"></script>                
   <script src="{{ asset('assets/js/imagesloaded-pkgd.js') }}"></script>                
   <script src="{{ asset('assets/js/parallax.js') }}"></script>                

   <!-- Custom JS -->
   <script src="{{ asset('assets/js/slider.js') }}"></script>                
   <script src="{{ asset('assets/js/main.js') }}"></script>  
</body>
</html>
