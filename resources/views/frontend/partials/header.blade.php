<!-- Header Custom Stylesheet -->
<link rel="stylesheet" href="{{ asset('assets/css/header-custom.css') }}?v={{ time() }}">

<!-- header-top-area-start: Thanh bên trên (không ghim, cuộn tự nhiên) -->
<div class="it-header-top-area custom-header-top">
   <div class="container-fluid px-3 px-xl-5">
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
                        <span class="user-avatar-mini">
                           @if(!empty(Auth::user()->avatar))
                              <img src="{{ Auth::user()->avatar }}" alt="{{ Auth::user()->name }}" style="width: 100%; height: 100%; border-radius: 50%; object-fit: cover;">
                           @else
                              <i class="fas fa-user"></i>
                           @endif
                        </span>
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
      <div class="container-fluid px-3 px-xl-5">
         <div class="row align-items-center">
            <!-- Brand Logo -->
            <div class="col-auto">
               <div class="it-header-logo custom-logo-box">
                  <a href="{{ route('frontend.home') }}">
                     <img src="{{ $siteSetting->logo_url }}" alt="Indochine" class="site-main-logo">
                  </a>
               </div>
            </div>

            <!-- Desktop Menu -->
            <div class="col flex-grow-1 d-none d-xl-block">
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
            <div class="col-auto ms-auto d-xl-none text-end">
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
@php
   $modalNotice = session('account_notice');
   $modalNoticeType = session('account_notice_type', 'warning');
   if (!$modalNotice) {
      if (session('warning') && (str_contains(session('warning'), 'lưu hành nội bộ') || str_contains(session('warning'), 'liên hệ admin'))) {
         $modalNotice = session('warning');
         $modalNoticeType = 'warning';
      } elseif (session('error') && (str_contains(session('error'), 'lưu hành nội bộ') || str_contains(session('error'), 'liên hệ admin'))) {
         $modalNotice = session('error');
         $modalNoticeType = 'error';
      }
   }
@endphp
@if(session('info') || session('success') || session('warning') || session('error') || session('login_notice') || $modalNotice)
<script>
   document.addEventListener('DOMContentLoaded', function () {
      @if($modalNotice)
      Swal.fire({
         icon: '{{ $modalNoticeType }}',
         title: 'Thông báo',
         html: '<div style="font-size: 15.5px; line-height: 1.6; color: #374151; font-weight: 500; padding: 4px 0;">{!! addslashes($modalNotice) !!}</div>',
         confirmButtonColor: '#03594E',
         confirmButtonText: 'Đã hiểu',
         allowOutsideClick: false,
         customClass: {
            popup: 'swal2-center-notice-modal'
         }
      });
      @elseif(session('login_notice'))
      Swal.fire({
         icon: 'info',
         title: 'Thông báo',
         text: "{{ session('login_notice') }}",
         confirmButtonColor: '#03594E',
         confirmButtonText: 'Đã hiểu'
      });
      @endif

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

      @if(!$modalNotice && session('warning'))
      Toast.fire({
         icon: 'warning',
         title: "{{ session('warning') }}"
      });
      @endif

      @if(!$modalNotice && session('error'))
      Toast.fire({
         icon: 'error',
         title: "{{ session('error') }}"
      });
      @endif
   });
</script>
<style>
   /* Centered Notice Modal */
   .swal2-center-notice-modal {
      border-radius: 16px !important;
      padding: 24px !important;
      box-shadow: 0 20px 30px -10px rgba(0, 0, 0, 0.25) !important;
   }
   .swal2-center-notice-modal .swal2-title {
      font-size: 20px !important;
      font-weight: 700 !important;
      color: #1e293b !important;
      margin-bottom: 8px !important;
   }
   .swal2-center-notice-modal .swal2-confirm {
      background-color: #03594E !important;
      border-radius: 8px !important;
      padding: 10px 28px !important;
      font-weight: 600 !important;
      font-size: 14.5px !important;
      box-shadow: 0 4px 6px -1px rgba(3, 89, 78, 0.3) !important;
   }

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
