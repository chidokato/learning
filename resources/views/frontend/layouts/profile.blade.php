<!doctype html>
<html class="no-js" lang="vi">
<head>
   <meta charset="utf-8">
   <meta http-equiv="x-ua-compatible" content="ie=edge">
   <title>@yield('title', 'Tài Khoản') - {{ $siteSetting->site_name ?? 'Hệ thống học tập' }}</title>
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <meta name="csrf-token" content="{{ csrf_token() }}">

   <link rel="shortcut icon" type="image/x-icon" href="{{ $siteSetting->favicon_url ?? asset('assets/img/favicon.png') }}">

   <!-- Google Fonts - Montserrat -->
   <link rel="preconnect" href="https://fonts.googleapis.com">
   <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
   <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

   <!-- CSS Assets -->
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

   <style>
      body, html {
         font-family: 'Montserrat', sans-serif !important;
         background-color: #f3f3f9;
      }

      /* Khung bao bọc giao diện Profile toàn màn hình dạng Admin Dashboard */
      .profile-dashboard-wrapper {
         display: flex;
         width: 100%;
         min-height: calc(100vh - var(--site-header-height, 76px));
         background-color: #f3f3f9;
         position: relative;
      }

      /* Cột Sidebar bên trái: Docked sát mép trái, full chiều cao như Admin, bám sát ngay dưới thanh menu đã ghim */
      .profile-dashboard-sidebar {
         width: 270px;
         min-width: 270px;
         max-width: 270px;
         background: #ffffff;
         border-right: 1px solid #e9ebec;
         display: flex;
         flex-direction: column;
         flex-shrink: 0;
         position: sticky;
         top: var(--site-header-height, 76px);
         height: calc(100vh - var(--site-header-height, 76px));
         overflow-y: auto;
         z-index: 10;
         transition: all 0.25s ease;
      }
      .profile-dashboard-sidebar::-webkit-scrollbar {
         width: 5px;
      }
      .profile-dashboard-sidebar::-webkit-scrollbar-track {
         background: transparent;
      }
      .profile-dashboard-sidebar::-webkit-scrollbar-thumb {
         background: #e2e8f0;
         border-radius: 4px;
      }
      .profile-dashboard-sidebar::-webkit-scrollbar-thumb:hover {
         background: #cbd5e1;
      }

      /* Vùng nội dung chính bên phải: Chiếm toàn bộ không gian còn lại */
      .profile-dashboard-main {
         flex: 1;
         min-width: 0;
         padding: 24px 32px 50px;
         background-color: #f3f3f9;
      }

      /* Thanh tiêu đề trang & Breadcrumbs phong cách Admin */
      .profile-page-title-box {
         display: flex;
         align-items: center;
         justify-content: space-between;
         flex-wrap: wrap;
         gap: 12px;
         margin-bottom: 22px;
      }
      .profile-page-title-box h3,
      .profile-page-title-box h4 {
         font-size: 20px;
         font-weight: 700;
         color: #1e293b;
         margin: 0;
         letter-spacing: -0.2px;
      }
      .profile-breadcrumb {
         display: flex;
         align-items: center;
         flex-wrap: wrap;
         font-size: 12.5px;
         margin: 4px 0 0;
         padding: 0;
         list-style: none;
      }
      .profile-breadcrumb .breadcrumb-item {
         color: #64748b;
      }
      .profile-breadcrumb .breadcrumb-item a {
         color: #64748b;
         text-decoration: none;
         transition: color 0.2s;
      }
      .profile-breadcrumb .breadcrumb-item a:hover {
         color: #03594e;
      }
      .profile-breadcrumb .breadcrumb-item.active {
         color: #03594e;
         font-weight: 600;
      }
      .profile-breadcrumb .breadcrumb-item + .breadcrumb-item::before {
         content: "/";
         padding: 0 8px;
         color: #94a3b8;
      }

      /* Card trắng chuẩn admin bọc nội dung */
      .profile-content-card {
         background: #ffffff;
         border: 1px solid #e9ebec;
         border-radius: 12px;
         box-shadow: 0 1px 3px rgba(15, 23, 42, 0.04);
         padding: 26px 28px;
         margin-bottom: 24px;
      }

      /* Nút thao tác profile */
      .it-btn-profile {
         background-color: #03594e;
         color: #ffffff !important;
         font-weight: 600;
         padding: 9px 20px;
         border-radius: 8px;
         border: none;
         display: inline-flex;
         align-items: center;
         justify-content: center;
         transition: all 0.25s ease;
         font-size: 13.5px;
         cursor: pointer;
         text-decoration: none !important;
      }
      .it-btn-profile:hover {
         background-color: #02463d;
         color: #ffffff !important;
         transform: translateY(-1px);
         box-shadow: 0 4px 12px rgba(3, 89, 78, 0.22);
      }

      /* Responsive cho thiết bị màn hình nhỏ */
      @media (max-width: 991.98px) {
         .profile-dashboard-wrapper {
            flex-direction: column;
         }
         .profile-dashboard-sidebar {
            width: 100%;
            min-width: 100%;
            max-width: 100%;
            height: auto;
            position: static;
            border-right: none;
            border-bottom: 1px solid #e9ebec;
         }
         .profile-dashboard-main {
            padding: 18px 14px 35px;
         }
         .profile-content-card {
            padding: 20px 16px;
         }
      }
   </style>
   @stack('styles')
</head>

<body>
   <div class="body-overlay"></div>

   <button class="it-back-to-top scroll-top" role="button" aria-label="scroll to top">
      <i class="far fa-arrow-up"></i>
   </button>

   <!-- Header trang chủ -->
   @include('frontend.partials.header')

   <!-- Bố cục Profile toàn màn hình chuẩn Admin: Cột menu trái + Cột nội dung phải -->
   <div class="profile-dashboard-wrapper">
      
      <!-- Cột menu Sidebar trái -->
      <aside class="profile-dashboard-sidebar">
         @include('frontend.partials.profile-sidebar')
      </aside>

      <!-- Vùng nội dung chính bên phải -->
      <main class="profile-dashboard-main">
         
         <!-- Tiêu đề & Breadcrumb phong cách Admin -->
         <div class="profile-page-title-box">
            <div>
               <h4>@yield('page_title', 'Tài Khoản')</h4>
               <nav aria-label="breadcrumb">
                  <ol class="profile-breadcrumb">
                     <li class="breadcrumb-item"><a href="{{ route('frontend.home') }}"><i class="far fa-home me-1"></i> Trang chủ</a></li>
                     <li class="breadcrumb-item"><a href="{{ route('frontend.profile') }}">Tài khoản</a></li>
                     @yield('breadcrumb')
                  </ol>
               </nav>
            </div>
            <div class="profile-page-actions d-flex align-items-center gap-2">
               @yield('page_actions')
            </div>
         </div>

         <!-- Nội dung trang -->
         @yield('content')

      </main>

   </div>

   <!-- Footer trang chủ -->
   @include('frontend.partials.footer')

   <!-- JS Assets -->
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
   <script src="{{ asset('assets/js/slider.js') }}"></script>                
   <script src="{{ asset('assets/js/main.js') }}"></script>  
   <script>
      function updateStickyHeaderHeight() {
         var headerWrap = document.querySelector('.custom-header-wrapper');
         if (headerWrap) {
            var h = headerWrap.offsetHeight;
            document.documentElement.style.setProperty('--site-header-height', h + 'px');
         }
      }
      $(document).ready(function() {
         updateStickyHeaderHeight();
         $(window).on('resize', updateStickyHeaderHeight);
      });
      $(window).on('load', updateStickyHeaderHeight);
   </script>
   @stack('scripts')
</body>
</html>