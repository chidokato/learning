<!-- Header Custom Stylesheet -->
<link rel="stylesheet" href="{{ asset('assets/css/header-custom.css') }}?v={{ time() }}">

<!-- header-top-area-start -->
<div class="it-header-top-area custom-header-top">
   <div class="container">
      <div class="row align-items-center">
         <!-- Contact Info (Hotline & Email) -->
         <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
            <div class="header-top-contact d-flex align-items-center justify-content-center justify-content-md-start">
               @if(!empty($siteSetting->hotline))
                  <a href="tel:{{ preg_replace('/[^0-9]/', '', $siteSetting->hotline) }}" class="top-contact-item">
                     <span class="top-contact-icon"><i class="fas fa-phone-alt"></i></span>
                     <span class="top-contact-text">{{ $siteSetting->hotline }}</span>
                  </a>
               @endif

               @if(!empty($siteSetting->hotline) && !empty($siteSetting->email))
                  <span class="top-contact-divider"></span>
               @endif

               @if(!empty($siteSetting->email))
                  <a href="mailto:{{ $siteSetting->email }}" class="top-contact-item">
                     <span class="top-contact-icon"><i class="fas fa-envelope"></i></span>
                     <span class="top-contact-text">{{ $siteSetting->email }}</span>
                  </a>
               @endif
            </div>
         </div>      

         <!-- Auth Actions -->
         <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 d-none d-md-block">
            <div class="header-top-auth d-flex align-items-center justify-content-end">
               @auth
                  <div class="auth-logged-in-pill">
                     <a href="{{ route('frontend.profile') }}" class="user-profile-link" title="Xem hồ sơ cá nhân">
                        <span class="user-avatar-mini"><i class="fas fa-user"></i></span>
                        <span class="user-name-text">{{ Auth::user()->name }}</span>
                     </a>
                     @if(Auth::user()->isAdmin())
                        <a href="{{ route('backend.admin.dashboard') }}" class="user-badge-admin" title="Vào trang quản trị">
                           <i class="far fa-shield-alt me-1"></i> Quản trị
                        </a>
                     @endif
                     <a href="{{ route('frontend.logout.get') }}" class="user-logout-link" 
                        onclick="event.preventDefault(); document.getElementById('header-logout-form').submit();"
                        title="Đăng xuất">
                        <i class="far fa-sign-out-alt"></i>
                     </a>
                     <form id="header-logout-form" action="{{ route('frontend.logout') }}" method="POST" class="d-none">
                        @csrf
                     </form>
                  </div>
               @else
                  <div class="auth-guest-group">
                     <a href="{{ route('frontend.login') }}" class="guest-login-link">
                        <i class="far fa-user me-1"></i> Đăng nhập
                     </a>
                     <a href="{{ route('frontend.register') }}" class="guest-register-btn">
                        <i class="far fa-user-plus me-1"></i> Đăng ký
                     </a>
                  </div>
               @endauth
            </div>
         </div>                    
      </div>
   </div>
</div>
<!-- header-top-area-end -->

<!-- Main Navigation Header -->
<header class="it-header-height custom-header-wrapper">
   <div id="header-sticky" class="it-header-area custom-main-header">
      <div class="container">
         <div class="row align-items-center">
            <!-- Brand Logo -->
            <div class="col-xxl-3 col-xl-3 col-lg-4 col-md-6 col-8">
               <div class="it-header-logo custom-logo-box">
                  <a href="{{ route('frontend.home') }}">
                     <img src="{{ $siteSetting->logo_url }}" alt="Indochine" class="site-main-logo">
                  </a>
               </div>
            </div>

            <!-- Desktop Menu -->
            <div class="col-xxl-9 col-xl-9 d-none d-xl-block">
               <div class="custom-nav-wrapper d-flex align-items-center justify-content-end">
                  <nav class="custom-nav-menu">
                     <ul>
                        @if (isset($headerMenus) && $headerMenus->isNotEmpty())
                           @foreach ($headerMenus as $menu)
                              @include('frontend.partials.menu-item', ['menu' => $menu])
                           @endforeach
                        @else
                           <li class="active"><a href="{{ route('frontend.home') }}"><span>Trang chủ</span></a></li>
                           <li><a href="about-us-v1.html"><span>Giới thiệu</span></a></li>
                           <li><a href="courses-v1.html"><span>Khóa học</span></a></li>
                        @endif
                     </ul>
                  </nav>
               </div>
            </div>

            <!-- Mobile Toggle Bar -->
            <div class="col-md-6 col-4 d-xl-none text-end">
               <div class="it-header-bar">
                  <button class="it-menu-bar custom-mobile-toggle" type="button" aria-label="Menu">
                     <i class="fal fa-bars"></i>
                  </button>
               </div>
            </div>
         </div>
      </div>
   </div>
</header>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@if(session('info') || session('success') || session('warning') || session('error') || session('login_notice'))
<script>
   document.addEventListener('DOMContentLoaded', function () {
      const Toast = Swal.mixin({
         toast: true,
         position: 'bottom-start',
         showConfirmButton: false,
         timer: 4000,
         timerProgressBar: true,
         customClass: {
            popup: 'colored-toast'
         },
         didOpen: (toast) => {
            toast.onmouseenter = Swal.stopTimer;
            toast.onmouseleave = Swal.resumeTimer;
         }
      });

      @if(session('login_notice'))
      Swal.fire({
         icon: 'info',
         title: 'Thông báo',
         text: "{{ session('login_notice') }}",
         confirmButtonColor: '#03594E',
         confirmButtonText: 'Đã hiểu'
      });
      @endif

      @if(session('info'))
      Toast.fire({
         icon: 'info',
         title: "{{ session('info') }}"
      });
      @endif

      @if(session('success'))
      Toast.fire({
         icon: 'success',
         title: "{{ session('success') }}"
      });
      @endif

      @if(session('warning'))
      Toast.fire({
         icon: 'warning',
         title: "{{ session('warning') }}"
      });
      @endif

      @if(session('error'))
      Toast.fire({
         icon: 'error',
         title: "{{ session('error') }}"
      });
      @endif
   });
</script>
<style>
   /* Toast notifications */
   .colored-toast {
      box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.12), 0 8px 10px -6px rgba(0, 0, 0, 0.08) !important;
      border-radius: 12px !important;
      font-size: 14px !important;
      z-index: 99999 !important;
   }
   .colored-toast.swal2-icon-info {
      background-color: #e0f2fe !important;
      color: #0284c7 !important;
   }
   .colored-toast.swal2-icon-success {
      background-color: #dcfce7 !important;
      color: #16a34a !important;
   }
   .colored-toast.swal2-icon-warning {
      background-color: #fef3c7 !important;
      color: #92400e !important;
   }
   .colored-toast.swal2-icon-error {
      background-color: #fee2e2 !important;
      color: #dc2626 !important;
   }
   .colored-toast .swal2-title {
      color: inherit !important;
      font-weight: 600 !important;
   }
</style>
@endif
