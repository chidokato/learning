<!doctype html>
<html class="no-js" lang="vi">
<head>
   <meta charset="utf-8">
   <meta http-equiv="x-ua-compatible" content="ie=edge">
   <title>{{ $post->seo_title ?: $post->title }} -- Educeet</title>
   <meta name="description" content="{{ $post->seo_description ?: Str::limit(strip_tags($post->description ?? $post->summary ?? $post->content), 150) }}">
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

   <!-- Theme / Main CSS -->
   <link rel="stylesheet" href="{{ asset('assets/css/spacing.css') }}">          
   <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">   

   <style>
      /* Đồng bộ kích thước ảnh khóa học bằng nhau */
      .it-course-thumb {
         position: relative;
         overflow: hidden;
         border-radius: 20px;
      }
      .it-course-thumb a {
         display: block;
         width: 100%;
      }
      .it-course-thumb img {
         width: 100% !important;
         height: 230px !important;
         object-fit: cover !important;
         object-position: center !important;
         display: block !important;
         transition: transform 0.4s ease;
      }
      .it-course-item:hover .it-course-thumb img {
         transform: scale(1.05);
      }
   </style>
</head>

<body>

   <!-- back-to-top-start  -->
   <button class="scroll-top scroll-to-target" data-target="html">
      <i class="far fa-angle-double-up"></i>
   </button>
   <!-- back-to-top-end  -->

   <!-- search popup start -->
   <div class="search-popup">
        <button class="close-search"><span class="flaticon-multiply"><i class="fal fa-times"></i></span></button>
        <form method="post" action="#">
            <div class="form-group">
                <input type="search" name="search-field" value="" placeholder="Search Here" required="">
                <button type="submit"><i class="fal fa-search"></i></button>
            </div>
        </form>
   </div>
   <!-- search popup end -->

   <!-- it-offcanvus-area-start -->
   <div class="it-offcanvas-area">
      <div class="itoffcanvas">
         <div class="itoffcanvas__close-btn">
            <button class="close-btn"><i class="fal fa-times"></i></button>
         </div>
         <div class="itoffcanvas__logo">
            <a href="{{ route('frontend.home') }}">
               <img src="{{ $siteSetting->logo_url ?? asset('assets/img/logo/logo-1.png') }}" alt="">
            </a>
         </div>
         <div class="itoffcanvas__text">
            <p>Khóa học chất lượng cao, chia sẻ kiến thức và kinh nghiệm thực tiễn.</p>
         </div>
         <div class="it-menu-mobile d-xl-none"></div>
         <div class="itoffcanvas__info">
            <h3 class="offcanva-title">Get In Touch</h3>
            <div class="it-info-wrapper mb-20 d-flex align-items-center">
               <div class="itoffcanvas__info-icon">
                  <a href="#"><i class="fal fa-envelope"></i></a>
               </div>
               <div class="itoffcanvas__info-address">
                  <span>Email</span>
                  <a href="mailto:info@educeet.com">info@educeet.com</a>
               </div>
            </div>
            <div class="it-info-wrapper mb-20 d-flex align-items-center">
               <div class="itoffcanvas__info-icon">
                  <a href="#"><i class="fal fa-phone-alt"></i></a>
               </div>
               <div class="itoffcanvas__info-address">
                  <span>Phone</span>
                  <a href="tel:(705)569-0123">(705) 569-0123</a>
               </div>
            </div>
         </div>
      </div>
   </div>
   <div class="body-overlay"></div>
   <!-- it-offcanvus-area-end -->

   @include('frontend.partials.header')

   <main>

      <!-- breadcrumb-area-start -->
      <div class="it-breadcrumb-area it-breadcrumb-ptb it-breadcrumb-course-details-style fix z-index-1" data-background="{{ asset('assets/img/shape/breadcrumb-details-bg.png') }}">
         <img class="it-breadcrumb-shape-1" src="{{ asset('assets/img/shape/breadcrumb-1-1.png') }}" alt="">
         <img class="it-breadcrumb-shape-3" src="{{ asset('assets/img/shape/breadcrumb-1-2.png') }}" alt="">
         <div class="container">
            <div class="row align-items-center">
               <div class="col-xxl-8 col-xl-8 col-lg-8 col-md-12">
                  <div class="it-breadcrumb-content z-index-1">
                     <div class="it-breadcrumb-list-2 d-none d-md-block">
                        <span><a href="{{ route('frontend.home') }}">Home</a></span>
                        <span class="dvdr">
                           <svg width="15" height="15" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                              <path d="M14.6364 8.1364C14.9879 7.78492 14.9879 7.21508 14.6364 6.8636L8.90883 1.13604C8.55736 0.784567 7.98751 0.784567 7.63604 1.13604C7.28457 1.48751 7.28457 2.05736 7.63604 2.40883L12.7272 7.5L7.63604 12.5912C7.28457 12.9426 7.28457 13.5125 7.63604 13.864C7.98751 14.2154 8.55736 14.2154 8.90883 13.864L14.6364 8.1364ZM0 7.5V8.4H14V7.5V6.6H0V7.5Z" fill="white" />
                           </svg>
                        </span>
                        <span><a href="{{ $post->category ? route('frontend.category.show', $post->category->slug) : '#' }}">{{ $post->category?->name ?? 'Courses' }}</a></span>
                        <span class="dvdr">
                           <svg width="15" height="15" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                              <path d="M14.6364 8.1364C14.9879 7.78492 14.9879 7.21508 14.6364 6.8636L8.90883 1.13604C8.55736 0.784567 7.98751 0.784567 7.63604 1.13604C7.28457 1.48751 7.28457 2.05736 7.63604 2.40883L12.7272 7.5L7.63604 12.5912C7.28457 12.9426 7.28457 13.5125 7.63604 13.864C7.98751 14.2154 8.55736 14.2154 8.90883 13.864L14.6364 8.1364ZM0 7.5V8.4H14V7.5V6.6H0V7.5Z" fill="white" />
                           </svg>
                        </span>
                        <span>{{ $post->title }}</span>
                     </div>
                     <div class="it-breadcrumb-list-wrap">
                        <span class="it-breadcrumb-subtitle">{{ $post->category?->name ?? 'Khóa học' }}</span>
                     </div>
                     <div class="it-breadcrumb-title-box">
                        <h3 class="it-section-title text-white">
                           {{ $post->title }}
                        </h3>
                     </div>
                     <div class="it-breadcrumb-author-wrapper mt-20 d-none d-md-flex align-items-center">
                        <div class="border-style d-flex align-items-center mb-20">
                           <div class="it-breadcrumb-author">
                              <img src="{{ $post->seller?->avatar ? asset($post->seller->avatar) : asset('assets/img/avatar/avatar-1-8.png') }}" alt="">
                           </div>
                           <div class="it-breadcrumb-author-info">
                              <span>Giảng viên</span>
                              <span class="name">{{ $post->seller?->name ?? ($post->instructor ?? 'Educeet Instructor') }}</span>
                           </div>
                        </div>
                        <div class="it-breadcrumb-author-info border-style mb-20">
                           <span>Cập nhật gần nhất</span>
                           <span>{{ $post->updated_at ? $post->updated_at->format('d/m/Y') : now()->format('d/m/Y') }}</span>
                        </div>
                        <div class="it-breadcrumb-author-info mb-20">
                           <span>Đánh giá</span>
                           <span>
                              <svg width="21" height="20" viewBox="0 0 21 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                 <path d="M20.8895 7.48386C20.7195 6.96254 20.2687 6.58354 19.7255 6.50442L14.223 5.70487L11.7643 0.736734C11.2774 -0.245578 9.66836 -0.245578 9.18151 0.736734L6.72275 5.70487L1.23329 6.50442C0.691637 6.58354 0.240812 6.96386 0.0708685 7.48541C-0.0990748 8.0054 0.0421395 8.57733 0.435285 8.96031L4.41669 12.8409L3.47747 18.316C3.38532 18.8561 3.60719 19.4035 4.05072 19.7262C4.4958 20.0473 5.08497 20.0893 5.56894 19.8343L10.4723 17.2486L15.3901 19.8343C15.6005 19.9452 15.831 20 16.0599 20C16.358 20 16.6561 19.9063 16.9083 19.7264C17.352 19.4022 17.5737 18.8564 17.4816 18.3163L16.5439 12.8412L20.5253 8.96053C20.9184 8.57866 21.0594 8.0054 20.8895 7.48386Z" fill="#ffffff" />
                              </svg>
                              (5.0) Rating
                           </span>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- breadcrumb-area-end -->

      <!-- details-area-start -->
      <div class="it-course-details-area it-course-details-style-2 it-course-details-v1-style pt-120 pb-100">
         <div class="container">
            <div class="row gx-35">
               <div class="col-lg-8">
                  <div class="it-course-details-left">
                     {{-- Tạm ẩn thanh điều hướng trang chi tiết theo yêu cầu --}}
                     <div class="it-course-details-nav-box mb-75 d-none" style="display: none !important;">
                        <nav>
                           <ul id="course_details2_nav">
                              <li class="current"><a href="#overview">Tổng quan</a></li>
                              <li><a href="#curriculum">Chương trình học</a></li>
                              <li><a href="#instructor">Giảng viên</a></li>
                              <li><a href="#reviews">Đánh giá</a></li>
                           </ul>
                        </nav>
                     </div>
                     <div id="overview">
                        <h4 class="it-details-title">Giới thiệu khóa học</h4>
                        <div class="postbox-dsc mb-55">
                           @if ($post->summary)
                              <p class="mb-20"><strong>{{ $post->summary }}</strong></p>
                           @endif
                           <div class="content-body">
                              @if ($post->content)
                                 {!! $post->content !!}
                              @else
                                 <p class="mb-10">Khóa học mang đến cho bạn kiến thức thực tế, toàn diện từ cơ bản đến nâng cao. Được thiết kế một cách khoa học, chuyên sâu giúp học viên nhanh chóng làm chủ các kỹ năng và áp dụng ngay vào công việc thực tế.</p>
                                 <p>Tham gia khóa học, học viên sẽ được đồng hành cùng giảng viên có nhiều năm kinh nghiệm, giải đáp thắc mắc và làm các bài tập thực hành sát với yêu cầu của doanh nghiệp.</p>
                              @endif
                           </div>
                        </div>
                        <h4 class="it-details-title">Bạn sẽ học được gì</h4>
                        <div class="it-details-list-box mt-5 mb-60">
                           <div class="row">
                              <div class="col-lg-6">
                                 <div class="it-details-list style-1">
                                    <ul>
                                       <li>
                                          <span>
                                             <svg width="20" height="16" viewBox="0 0 20 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M5.71195 16C5.58634 16 5.48163 15.9144 5.43976 15.8073C5.41885 15.7644 3.618 11.0101 0.833023 9.21113C0.288584 8.86848 -0.130124 8.50439 0.0373593 7.69056C0.204843 6.89818 0.728376 6.44844 1.67062 6.23426C3.34575 5.87017 5.14655 8.52577 5.81666 9.61804C8.16184 6.12724 12.8523 0.644689 19.6786 0.00221658C20.0079 -0.037266 20.1297 0.461976 19.8252 0.601865C19.7205 0.644689 9.96258 5.20638 6.00505 15.8287C5.94227 15.9357 5.83756 16 5.71195 16Z" fill="currentcolor" />
                                             </svg>
                                             Hiểu sâu lý thuyết căn bản và tư duy áp dụng thực tế
                                          </span>
                                       </li>
                                       <li>
                                          <span>
                                             <svg width="20" height="16" viewBox="0 0 20 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M5.71195 16C5.58634 16 5.48163 15.9144 5.43976 15.8073C5.41885 15.7644 3.618 11.0101 0.833023 9.21113C0.288584 8.86848 -0.130124 8.50439 0.0373593 7.69056C0.204843 6.89818 0.728376 6.44844 1.67062 6.23426C3.34575 5.87017 5.14655 8.52577 5.81666 9.61804C8.16184 6.12724 12.8523 0.644689 19.6786 0.00221658C20.0079 -0.037266 20.1297 0.461976 19.8252 0.601865C19.7205 0.644689 9.96258 5.20638 6.00505 15.8287C5.94227 15.9357 5.83756 16 5.71195 16Z" fill="currentcolor" />
                                             </svg>
                                             Làm chủ các công cụ chuyên sâu và kỹ năng thực hành
                                          </span>
                                       </li>
                                       <li>
                                          <span>
                                             <svg width="20" height="16" viewBox="0 0 20 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M5.71195 16C5.58634 16 5.48163 15.9144 5.43976 15.8073C5.41885 15.7644 3.618 11.0101 0.833023 9.21113C0.288584 8.86848 -0.130124 8.50439 0.0373593 7.69056C0.204843 6.89818 0.728376 6.44844 1.67062 6.23426C3.34575 5.87017 5.14655 8.52577 5.81666 9.61804C8.16184 6.12724 12.8523 0.644689 19.6786 0.00221658C20.0079 -0.037266 20.1297 0.461976 19.8252 0.601865C19.7205 0.644689 9.96258 5.20638 6.00505 15.8287C5.94227 15.9357 5.83756 16 5.71195 16Z" fill="currentcolor" />
                                             </svg>
                                             Tự tin triển khai các dự án hoàn chỉnh từ A-Z
                                          </span>
                                       </li>
                                    </ul>
                                 </div>
                              </div>
                              <div class="col-lg-6">
                                 <div class="it-details-list style-2">
                                    <ul>
                                       <li>
                                          <span>
                                             <svg width="20" height="16" viewBox="0 0 20 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M5.71195 16C5.58634 16 5.48163 15.9144 5.43976 15.8073C5.41885 15.7644 3.618 11.0101 0.833023 9.21113C0.288584 8.86848 -0.130124 8.50439 0.0373593 7.69056C0.204843 6.89818 0.728376 6.44844 1.67062 6.23426C3.34575 5.87017 5.14655 8.52577 5.81666 9.61804C8.16184 6.12724 12.8523 0.644689 19.6786 0.00221658C20.0079 -0.037266 20.1297 0.461976 19.8252 0.601865C19.7205 0.644689 9.96258 5.20638 6.00505 15.8287C5.94227 15.9357 5.83756 16 5.71195 16Z" fill="currentcolor" />
                                             </svg>
                                             Quy trình làm việc chuẩn nghiệp vụ chuyên nghiệp
                                          </span>
                                       </li>
                                       <li>
                                          <span>
                                             <svg width="20" height="16" viewBox="0 0 20 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M5.71195 16C5.58634 16 5.48163 15.9144 5.43976 15.8073C5.41885 15.7644 3.618 11.0101 0.833023 9.21113C0.288584 8.86848 -0.130124 8.50439 0.0373593 7.69056C0.204843 6.89818 0.728376 6.44844 1.67062 6.23426C3.34575 5.87017 5.14655 8.52577 5.81666 9.61804C8.16184 6.12724 12.8523 0.644689 19.6786 0.00221658C20.0079 -0.037266 20.1297 0.461976 19.8252 0.601865C19.7205 0.644689 9.96258 5.20638 6.00505 15.8287C5.94227 15.9357 5.83756 16 5.71195 16Z" fill="currentcolor" />
                                             </svg>
                                             Đạt chứng chỉ hoàn thành khóa học và thăng tiến nghề nghiệp
                                          </span>
                                       </li>
                                    </ul>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <h4 class="it-details-title">Khóa học này bao gồm:</h4>
                        <div class="it-details-list-box mt-5 mb-60">
                           <div class="row">
                              <div class="col-lg-6 col-md-6">
                                 <div class="it-details-list course-list-style-1">
                                    <ul>
                                       <li>
                                          <span>
                                             <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M1.63636 0C0.736897 0 0 0.736897 0 1.63636V4.09091H0.818182H17.1818V12.2727C17.1818 12.7331 16.824 13.0909 16.3636 13.0909H10.2209C10.2247 13.0209 10.2273 12.9508 10.2273 12.8808C10.2273 11.3894 9.37261 10.0519 8.07156 9.4059C8.39565 9.01647 8.59091 8.51657 8.59091 7.97328C8.59091 6.73747 7.57968 5.72727 6.34331 5.72727C5.10693 5.72727 4.0949 6.73747 4.0949 7.97328C4.0949 8.51659 4.29078 9.01647 4.61506 9.4059C3.31407 10.0521 2.45854 11.3894 2.45854 12.8808C2.45854 12.9509 2.46104 13.021 2.46493 13.0909H1.63636C1.17602 13.0909 0.818182 12.7331 0.818182 12.2727V4.90909H0V12.2727C0 13.1722 0.736897 13.9091 1.63636 13.9091H16.3636C17.2631 13.9091 18 13.1722 18 12.2727V1.63636C18 0.736897 17.2631 0 16.3636 0H1.63636ZM1.63636 0.818182H16.3636C16.824 0.818182 17.1818 1.17602 17.1818 1.63636V3.27273H0.818182V1.63636C0.818182 1.17602 1.17602 0.818182 1.63636 0.818182ZM6.34331 6.54545C7.13794 6.54545 7.77273 7.18009 7.77273 7.97328C7.77273 8.76647 7.13794 9.4011 6.34331 9.4011C5.54867 9.4011 4.91309 8.76647 4.91309 7.97328C4.91309 7.18009 5.54867 6.54545 6.34331 6.54545ZM5.34695 9.98518C5.64774 10.1349 5.98605 10.2193 6.34331 10.2193C6.70057 10.2193 7.03897 10.1349 7.33967 9.98518C8.57344 10.4079 9.40909 11.5654 9.40909 12.8808C9.40909 12.9509 9.40599 13.0209 9.4011 13.0909H3.28471C3.27983 13.021 3.27672 12.951 3.27672 12.8808C3.27672 11.5651 4.11306 10.4078 5.34695 9.98518Z" fill="#03594E" />
                                             </svg>
                                             Truy cập trọn đời trên máy tính và thiết bị di động
                                          </span>
                                       </li>
                                       <li>
                                          <span>
                                             <svg width="17" height="18" viewBox="0 0 17 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M6.32812 8.33329H2.66146C2.57305 8.33329 2.48827 8.29817 2.42576 8.23566C2.36324 8.17315 2.32812 8.08836 2.32812 7.99996C2.32812 7.91155 2.36324 7.82677 2.42576 7.76426C2.48827 7.70174 2.57305 7.66663 2.66146 7.66663H6.32812C6.41653 7.66663 6.50132 7.70174 6.56383 7.76426C6.62634 7.82677 6.66146 7.91155 6.66146 7.99996C6.66146 8.08836 6.62634 8.17315 6.56383 8.23566C6.50132 8.29817 6.41653 8.33329 6.32812 8.33329Z" fill="#03594E" />
                                                <path d="M2.66146 6H11.3281C11.4165 6 11.5013 6.03512 11.5638 6.09763C11.6263 6.16014 11.6615 6.24493 11.6615 6.33333C11.6615 6.42174 11.6263 6.50652 11.5638 6.56904C11.5013 6.63155 11.4165 6.66667 11.3281 6.66667H2.66146C2.57305 6.66667 2.48827 6.63155 2.42576 6.56904C2.36324 6.50652 2.32812 6.42174 2.32812 6.33333C2.32812 6.24493 2.36324 6.16014 2.42576 6.09763C2.48827 6.03512 2.57305 6 2.66146 6Z" fill="#03594E" />
                                                <path d="M2.66146 4.33337H11.3281C11.4165 4.33337 11.5013 4.36849 11.5638 4.431C11.6263 4.49352 11.6615 4.5783 11.6615 4.66671C11.6615 4.75511 11.6263 4.8399 11.5638 4.90241C11.5013 4.96492 11.4165 5.00004 11.3281 5.00004H2.66146C2.57305 5.00004 2.48827 4.96492 2.42576 4.90241C2.36324 4.8399 2.32812 4.75511 2.32812 4.66671C2.32812 4.5783 2.36324 4.49352 2.42576 4.431C2.48827 4.36849 2.57305 4.33337 2.66146 4.33337Z" fill="#03594E" />
                                                <path d="M2.66146 2.66663H11.3281C11.4165 2.66663 11.5013 2.70174 11.5638 2.76426C11.6263 2.82677 11.6615 2.91155 11.6615 2.99996C11.6615 3.08836 11.6263 3.17315 11.5638 3.23566C11.5013 3.29817 11.4165 3.33329 11.3281 3.33329H2.66146C2.57305 3.33329 2.48827 3.29817 2.42576 3.23566C2.36324 3.17315 2.32812 3.08836 2.32812 2.99996C2.32812 2.91155 2.36324 2.82677 2.42576 2.76426C2.48827 2.70174 2.57305 2.66663 2.66146 2.66663Z" fill="#03594E" />
                                                <path d="M16.28 8.00333L16.0533 8.23333L15.8133 7.99333L16.0233 7.78333C16.3017 7.50589 16.4649 7.13345 16.4802 6.74072C16.4954 6.34798 16.3616 5.964 16.1056 5.6658C15.8496 5.3676 15.4903 5.17723 15.0997 5.13287C14.7092 5.08852 14.3164 5.19347 14 5.42667V1C13.9992 0.735027 13.8936 0.481133 13.7062 0.293767C13.5189 0.106402 13.265 0.000791364 13 0H1C0.735027 0.000791364 0.481133 0.106402 0.293767 0.293767C0.106402 0.481133 0.000791364 0.735027 0 1V17C0.000791364 17.265 0.106402 17.5189 0.293767 17.7062C0.481133 17.8936 0.735027 17.9992 1 18H13C13.265 17.9992 13.5189 17.8936 13.7062 17.7062C13.8936 17.5189 13.9992 17.265 14 17V11.23L16.7533 8.47667C16.8161 8.4139 16.8514 8.32877 16.8514 8.24C16.8514 8.15123 16.8161 8.0661 16.7533 8.00333C16.6906 7.94057 16.6054 7.9053 16.5167 7.9053C16.4279 7.9053 16.3428 7.94057 16.28 8.00333ZM13.3333 10.9533L12.9433 11.3433C12.8867 11.3993 12.8521 11.4739 12.8459 11.5533C12.8398 11.6328 12.8625 11.7118 12.9099 11.7758C12.9574 11.8398 13.0263 11.8846 13.1041 11.9019C13.1818 11.9192 13.2632 11.9079 13.3333 11.87V17C13.3333 17.0884 13.2982 17.1732 13.2357 17.2357C13.1732 17.2982 13.0884 17.3333 13 17.3333H1C0.911595 17.3333 0.82681 17.2982 0.764298 17.2357C0.701786 17.1732 0.666667 17.0884 0.666667 17V1C0.666667 0.911595 0.701786 0.82681 0.764298 0.764298C0.82681 0.701786 0.911595 0.666667 1 0.666667H13C13.0884 0.666667 13.1732 0.701786 13.2357 0.764298C13.2982 0.82681 13.3333 0.911595 13.3333 1V6.06667C11.9333 7.46667 7.09333 12.3067 7.09 12.3133C6.99567 12.4077 6.92733 12.456 6.90333 12.5833C6.89533 12.6167 6.45 14.6453 6.45 14.68L6.11333 15.0167C6.05057 15.0794 6.0153 15.1646 6.0153 15.2533C6.0153 15.3421 6.05057 15.4272 6.11333 15.49C6.1761 15.5528 6.26123 15.588 6.35 15.588C6.43877 15.588 6.5239 15.5528 6.58667 15.49L6.92667 15.15C6.97833 15.15 8.971 14.7117 9.02 14.7C9.17167 14.6643 9.18367 14.6263 9.29333 14.5167L13.3333 10.4733V10.9533ZM7.38333 13.1533L8.45 14.22C7.348 14.4643 7.97933 14.3257 7.08667 14.5167C7.271 13.6543 7.2 13.9803 7.38333 13.1533ZM9.07667 13.7933L7.81333 12.53C7.91667 12.4213 12.62 7.71967 12.7267 7.61333L13.99 8.87667C13.8047 9.061 9.23333 13.6283 9.07667 13.7933ZM14 10.2867V9.80667C15.12 8.68667 14.827 8.979 15.3433 8.46667L15.5833 8.70333L14 10.2867ZM15.55 7.31333C14.9913 7.872 15.2353 7.62733 14.4633 8.40333H14.46L13.2033 7.14333C13.397 6.945 13.2087 7.13433 14.29 6.05333C14.4577 5.88903 14.6834 5.79752 14.9181 5.79871C15.1529 5.79989 15.3777 5.89367 15.5437 6.05967C15.7097 6.22566 15.8034 6.45045 15.8046 6.6852C15.8058 6.91994 15.7143 7.14567 15.55 7.31333Z" fill="#03594E" />
                                             </svg>
                                             Tài liệu, bài tập và mã nguồn mẫu tải về
                                          </span>
                                       </li>
                                    </ul>
                                 </div>
                              </div>
                              <div class="col-lg-6 col-md-6">
                                 <div class="it-details-list course-list-style-2">
                                    <ul>
                                       <li>
                                          <span>
                                             <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M13.0762 7.79204V4.3856C13.0762 4.2881 13.0311 4.19801 12.9674 4.12673L9.1483 0.116318C9.07703 0.041336 8.97568 0 8.87447 0H2.81936C1.70151 0 0.808594 0.911589 0.808594 2.02958V13.4794C0.808594 14.5974 1.70151 15.494 2.81936 15.494H7.59896C8.50299 16.9946 10.1463 18 12.0182 18C14.8619 18 17.1841 15.689 17.1841 12.8416C17.1879 10.3543 15.4021 8.27599 13.0762 7.79204ZM9.24965 1.31685L11.8119 4.01412H10.15C9.65477 4.01412 9.24965 3.6053 9.24965 3.11009V1.31685ZM2.81936 14.7436C2.11789 14.7436 1.55896 14.1809 1.55896 13.4794V2.02958C1.55896 1.32426 2.11789 0.750365 2.81936 0.750365H8.49929V3.11009C8.49929 4.02168 9.23839 4.76449 10.15 4.76449H12.3258V7.6944C12.2133 7.69069 12.1233 7.67943 12.0258 7.67943C10.7165 7.67943 9.51222 8.18219 8.60434 8.97005H3.83985C3.63345 8.97005 3.46467 9.13883 3.46467 9.3451C3.46467 9.5515 3.63345 9.72028 3.83985 9.72028H7.90658C7.64016 10.0955 7.41878 10.4706 7.2463 10.8833H3.83985C3.63345 10.8833 3.46467 11.0521 3.46467 11.2585C3.46467 11.4648 3.63345 11.6337 3.83985 11.6337H7.0024C6.90861 12.0089 6.85985 12.4252 6.85985 12.8416C6.85985 13.5169 6.99114 14.1847 7.22748 14.7475H2.81936V14.7436ZM12.022 17.2535C9.59105 17.2535 7.61393 15.2763 7.61393 12.8453C7.61393 10.4143 9.58721 8.43721 12.022 8.43721C14.4568 8.43721 16.43 10.4143 16.43 12.8453C16.43 15.2763 14.453 17.2535 12.022 17.2535Z" fill="#03594E" />
                                             </svg>
                                             Tài liệu hướng dẫn trực quan
                                          </span>
                                       </li>
                                       <li>
                                          <span>
                                             <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M15.2085 7.51489C15.0629 7.51489 14.9449 7.63291 14.9449 7.77856V10.4524H3.05664V7.77856C3.05664 7.63291 2.93862 7.51489 2.79297 7.51489C2.64732 7.51489 2.5293 7.63291 2.5293 7.77856V10.5662C2.5293 10.7942 2.71475 10.9797 2.94277 10.9797H15.0588C15.2868 10.9797 15.4722 10.7943 15.4722 10.5662V7.77856C15.4722 7.63298 15.3542 7.51489 15.2085 7.51489Z" fill="#03594E" />
                                                <path d="M15.0587 3.17114H2.94277C2.71478 3.17114 2.5293 3.35659 2.5293 3.58462V6.37229C2.5293 6.51795 2.64732 6.63597 2.79297 6.63597C2.93862 6.63597 3.05664 6.51795 3.05664 6.37229V3.69849H14.9449V6.37229C14.9449 6.51795 15.0629 6.63597 15.2085 6.63597C15.3542 6.63597 15.4722 6.51795 15.4722 6.37229V3.58462C15.4722 3.35656 15.2868 3.17114 15.0587 3.17114Z" fill="#03594E" />
                                             </svg>
                                             Hỗ trợ học viên trên mọi thiết bị
                                          </span>
                                       </li>
                                       <li>
                                          <span>
                                             <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M14.1062 7.50879C12.8878 7.50879 11.8965 8.50006 11.8965 9.7185C11.8965 10.9369 12.8878 11.9282 14.1062 11.9282C15.3246 11.9282 16.3159 10.9369 16.3159 9.7185C16.3159 8.50006 15.3246 7.50879 14.1062 7.50879ZM14.1062 11.4009C13.1785 11.4009 12.4238 10.6462 12.4238 9.71853C12.4238 8.79087 13.1785 8.0361 14.1062 8.0361C15.0339 8.0361 15.7886 8.79083 15.7886 9.71853C15.7886 10.6462 15.0339 11.4009 14.1062 11.4009Z" fill="#03594E" />
                                             </svg>
                                             Cấp chứng chỉ tốt nghiệp khi hoàn thành
                                          </span>
                                       </li>
                                    </ul>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                     <div id="curriculum">                     
                        <h4 class="it-details-title">Nội dung khóa học (Chương trình học)</h4>
                        <div class="it-course-faq mb-60">
                           <div class="it-course-faq-top-text mb-10 mt-25 d-flex align-items-center justify-content-between">
                              <span>{{ $post->unit_count ?: 12 }} chương học • Đầy đủ video hướng dẫn & tài liệu thực hành</span>
                              <a href="#">Mở rộng tất cả</a>                        
                           </div>
                           <div class="it-custom-accordion-2">
                              <div class="accordion" id="accordionExample">
                                 <div class="accordion-items">
                                    <h4 class="accordion-header" id="headingOne2">
                                       <button class="accordion-buttons" type="button" data-bs-toggle="collapse"
                                          data-bs-target="#collapseOne2" aria-expanded="true"
                                          aria-controls="collapseOne2">
                                          <span>Chương 1: Giới thiệu & Nhập môn khóa học</span>    
                                          <span>3 bài học • 30 Phút</span>                 
                                       </button>
                                    </h4>
                                    <div id="collapseOne2" class="accordion-collapse collapse show"
                                       aria-labelledby="headingOne2" data-bs-parent="#accordionExample">
                                       <div class="accordion-body">
                                          <div class="accordion-content">
                                             <ul>
                                                <li>
                                                   <span>
                                                      <i class="far fa-play-circle me-2" style="color: #03594E;"></i>
                                                      Bài 1.1: Tổng quan về khóa học và mục tiêu đầu ra
                                                   </span>
                                                   <div class="preview-box">
                                                      <a href="{{ $post->learn_url }}" class="preview">Vào học</a>
                                                      <span>08:15</span>
                                                   </div>
                                                </li>
                                                <li>
                                                   <span>
                                                      <i class="far fa-play-circle me-2" style="color: #03594E;"></i>
                                                      Bài 1.2: Chuẩn bị môi trường học tập và các công cụ cần thiết
                                                   </span>
                                                   <div class="preview-box">
                                                      <a href="#" class="preview">Học thử</a>
                                                      <span>12:20</span>
                                                   </div>
                                                </li>
                                                <li>
                                                   <span>
                                                      <i class="far fa-play-circle me-2" style="color: #03594E;"></i>
                                                      Bài 1.3: Phương pháp học hiệu quả và cách đạt chứng chỉ
                                                   </span>
                                                   <div class="preview-box">
                                                      <span>09:45</span>
                                                   </div>
                                                </li>
                                             </ul>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="accordion-items">
                                    <h4 class="accordion-header" id="headingTwo2">
                                       <button class="accordion-buttons collapsed" type="button" data-bs-toggle="collapse"
                                          data-bs-target="#collapseTwo2" aria-expanded="false"
                                          aria-controls="collapseTwo2">
                                          <span>Chương 2: Kiến thức trọng tâm & Kỹ năng cốt lõi</span>    
                                          <span>5 bài học • 95 Phút</span>                 
                                       </button>
                                    </h4>
                                    <div id="collapseTwo2" class="accordion-collapse collapse"
                                       aria-labelledby="headingTwo2" data-bs-parent="#accordionExample">
                                       <div class="accordion-body">
                                          <div class="accordion-content">
                                             <ul>
                                                <li>
                                                   <span>
                                                      <i class="far fa-play-circle me-2" style="color: #03594E;"></i>
                                                      Bài 2.1: Các nguyên lý nền tảng quan trọng
                                                   </span>
                                                   <div class="preview-box">
                                                      <span>18:30</span>
                                                   </div>
                                                </li>
                                                <li>
                                                   <span>
                                                      <i class="far fa-play-circle me-2" style="color: #03594E;"></i>
                                                      Bài 2.2: Phân tích thực tế và giải quyết bài toán
                                                   </span>
                                                   <div class="preview-box">
                                                      <span>22:15</span>
                                                   </div>
                                                </li>
                                                <li>
                                                   <span>
                                                      <i class="far fa-play-circle me-2" style="color: #03594E;"></i>
                                                      Bài 2.3: Thực hành quy trình chuyên nghiệp bước 1
                                                   </span>
                                                   <div class="preview-box">
                                                      <span>25:40</span>
                                                   </div>
                                                </li>
                                             </ul>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="accordion-items">
                                    <h4 class="accordion-header" id="headingThree2">
                                       <button class="accordion-buttons collapsed" type="button" data-bs-toggle="collapse"
                                          data-bs-target="#collapseThree2" aria-expanded="false"
                                          aria-controls="collapseThree2">
                                          <span>Chương 3: Thực hành dự án thực tế & Tổng kết</span>    
                                          <span>4 bài học • 80 Phút</span>                 
                                       </button>
                                    </h4>
                                    <div id="collapseThree2" class="accordion-collapse collapse"
                                       aria-labelledby="headingThree2" data-bs-parent="#accordionExample">
                                       <div class="accordion-body">
                                          <div class="accordion-content">
                                             <ul>
                                                <li>
                                                   <span>
                                                      <i class="far fa-play-circle me-2" style="color: #03594E;"></i>
                                                      Bài 3.1: Phân tích đề bài dự án thực tế
                                                   </span>
                                                   <div class="preview-box">
                                                      <span>20:00</span>
                                                   </div>
                                                </li>
                                                <li>
                                                   <span>
                                                      <i class="far fa-play-circle me-2" style="color: #03594E;"></i>
                                                      Bài 3.2: Hoàn thiện sản phẩm và kiểm thử chất lượng
                                                   </span>
                                                   <div class="preview-box">
                                                      <span>30:00</span>
                                                   </div>
                                                </li>
                                             </ul>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                     <div id="instructor">
                        <h4 class="it-details-title">Yêu cầu khóa học</h4>
                        <div class="it-details-list mb-60">
                           <ul>
                              <li>
                                 <span>
                                    <svg width="20" height="16" viewBox="0 0 20 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                       <path fill-rule="evenodd" clip-rule="evenodd" d="M5.71195 16C5.58634 16 5.48163 15.9144 5.43976 15.8073C5.41885 15.7644 3.618 11.0101 0.833023 9.21113C0.288584 8.86848 -0.130124 8.50439 0.0373593 7.69056C0.204843 6.89818 0.728376 6.44844 1.67062 6.23426C3.34575 5.87017 5.14655 8.52577 5.81666 9.61804C8.16184 6.12724 12.8523 0.644689 19.6786 0.00221658C20.0079 -0.037266 20.1297 0.461976 19.8252 0.601865C19.7205 0.644689 9.96258 5.20638 6.00505 15.8287C5.94227 15.9357 5.83756 16 5.71195 16Z" fill="currentcolor" />
                                    </svg>
                                    Máy tính hoặc laptop có kết nối Internet để học tập
                                 </span>
                              </li>
                              <li>
                                 <span>
                                    <svg width="20" height="16" viewBox="0 0 20 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                       <path fill-rule="evenodd" clip-rule="evenodd" d="M5.71195 16C5.58634 16 5.48163 15.9144 5.43976 15.8073C5.41885 15.7644 3.618 11.0101 0.833023 9.21113C0.288584 8.86848 -0.130124 8.50439 0.0373593 7.69056C0.204843 6.89818 0.728376 6.44844 1.67062 6.23426C3.34575 5.87017 5.14655 8.52577 5.81666 9.61804C8.16184 6.12724 12.8523 0.644689 19.6786 0.00221658C20.0079 -0.037266 20.1297 0.461976 19.8252 0.601865C19.7205 0.644689 9.96258 5.20638 6.00505 15.8287C5.94227 15.9357 5.83756 16 5.71195 16Z" fill="currentcolor" />
                                    </svg>
                                    Không yêu cầu kinh nghiệm trước đó, phù hợp cả cho người mới bắt đầu
                                 </span>
                              </li>
                              <li>
                                 <span>
                                    <svg width="20" height="16" viewBox="0 0 20 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                       <path fill-rule="evenodd" clip-rule="evenodd" d="M5.71195 16C5.58634 16 5.48163 15.9144 5.43976 15.8073C5.41885 15.7644 3.618 11.0101 0.833023 9.21113C0.288584 8.86848 -0.130124 8.50439 0.0373593 7.69056C0.204843 6.89818 0.728376 6.44844 1.67062 6.23426C3.34575 5.87017 5.14655 8.52577 5.81666 9.61804C8.16184 6.12724 12.8523 0.644689 19.6786 0.00221658C20.0079 -0.037266 20.1297 0.461976 19.8252 0.601865C19.7205 0.644689 9.96258 5.20638 6.00505 15.8287C5.94227 15.9357 5.83756 16 5.71195 16Z" fill="currentcolor" />
                                    </svg>
                                    Tinh thần ham học hỏi và sẵn sàng thực hành qua từng bài tập
                                 </span>
                              </li>
                           </ul>
                        </div>
                     </div>
                     <div id="reviews">
                        <div class="postbox-comment-item course-style mb-30">
                           <h4 class="it-details-title">Giảng viên phụ trách</h4>
                           <div class="postbox-comment-content mt-25">
                              <ul>
                                 <li>
                                    <div class="postbox-comment-user d-flex">
                                       <div class="postbox-user-thumb">
                                          <img src="{{ $post->seller?->avatar ? asset($post->seller->avatar) : asset('assets/img/avatar/details-1-1.png') }}" alt="">
                                       </div>
                                       <div class="mt-20">
                                          <div class="postbox-user-info mb-20">
                                             <h4 class="user-title">{{ $post->seller?->name ?? ($post->instructor ?? 'Educeet Instructor') }}</h4>
                                             <span>Chuyên gia & Giảng viên thỉnh giảng</span>
                                          </div>
                                           <div class="postbox-user-meta mb-20">
                                             <span>
                                                <i class="fa-sharp fa-solid fa-star text-warning me-1"></i>
                                                (5.0) Đánh giá xuất sắc
                                             </span>
                                             <span>
                                                <i class="fa-solid fa-user-graduate me-1" style="color: #03594E;"></i>
                                                5,000+ Học viên
                                             </span>
                                             <span>
                                                <i class="fa-solid fa-book-open me-1" style="color: #03594E;"></i>
                                                {{ $post->category?->name ?? '10+ Khóa học' }}
                                             </span>
                                          </div>
                                          <div class="postbox-user-info mb-25">
                                             <p>Giảng viên có nhiều năm kinh nghiệm thực tiễn trong ngành, đã trực tiếp giảng dạy và dẫn dắt hàng ngàn học viên thành công. Phong cách giảng dạy trực quan, dễ hiểu, tận tâm giúp học viên áp dụng kiến thức vào thực tế một cách tự tin.</p>
                                          </div>
                                       </div>
                                    </div>
                                 </li>
                              </ul>
                           </div>
                        </div>
                        <h4 class="it-details-title">Phản hồi từ học viên</h4>
                        <div class="it-course-details-ratting-wrap mt-25 mb-65">
                           <div class="row gx-35">
                              <div class="col-xl-3 col-lg-4 col-md-5">
                                 <div class="ratting-left text-center">
                                    <h5 class="title">5.0</h5>
                                    <div class="ratting mb-15">
                                       <i class="fa-sharp fa-solid fa-star text-warning"></i>
                                       <i class="fa-sharp fa-solid fa-star text-warning"></i>
                                       <i class="fa-sharp fa-solid fa-star text-warning"></i>
                                       <i class="fa-sharp fa-solid fa-star text-warning"></i>
                                       <i class="fa-sharp fa-solid fa-star text-warning"></i>
                                    </div>
                                    <span>Tổng 50+ Đánh giá</span>
                                 </div>
                              </div>
                              <div class="col-xl-9 col-lg-8 col-md-7">
                                 <div class="ratting-right">
                                    <div class="it-progress-bar-item mb-15">
                                       <label>5 sao</label>
                                       <span>95%</span>
                                       <div class="it-progress-bar">
                                          <div class="progress">
                                             <div class="progress-bar wow slideInLeft" data-wow-delay=".1s"
                                                data-wow-duration="2s" role="progressbar" data-width="95%" aria-valuenow="95"
                                                aria-valuemin="0" aria-valuemax="100"
                                                style="width: 95%; visibility: visible; animation-duration: 2s; animation-delay: 0.1s; animation-name: slideInLeft;">
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="it-progress-bar-item mb-15">
                                       <label>4 sao</label>
                                       <span>5%</span>
                                       <div class="it-progress-bar">
                                          <div class="progress">
                                             <div class="progress-bar orange wow slideInLeft" data-wow-delay=".1s"
                                                data-wow-duration="2s" role="progressbar" data-width="5%" aria-valuenow="5"
                                                aria-valuemin="0" aria-valuemax="100"
                                                style="width: 5%; visibility: visible; animation-duration: 2s; animation-delay: 0.1s; animation-name: slideInLeft;">
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="postbox-comment mb-35">
                           <h4 class="it-details-title">Đánh giá tiêu biểu</h4>
                           <div class="postbox-comment-item mt-25">
                              <div class="postbox-comment-content">
                                 <ul>
                                    <li>
                                       <div class="postbox-comment-user d-flex">
                                          <div class="postbox-user-thumb">
                                             <img src="{{ asset('assets/img/avatar/details-1-2.png') }}" alt="">
                                          </div>
                                          <div>
                                             <div class="d-flex justify-content-between">
                                                <div class="postbox-user-info mt-20 mb-20">
                                                   <h4 class="user-title">Nguyễn Minh Tuấn</h4>
                                                   <span>
                                                      <i class="fa-sharp fa-solid fa-star text-warning"></i>
                                                      <i class="fa-sharp fa-solid fa-star text-warning"></i>
                                                      <i class="fa-sharp fa-solid fa-star text-warning"></i>
                                                      <i class="fa-sharp fa-solid fa-star text-warning"></i>
                                                      <i class="fa-sharp fa-solid fa-star text-warning"></i>
                                                      (5.0) • Đã đánh giá
                                                   </span>
                                                </div>
                                             </div>
                                             <div class="postbox-user-info">
                                                <p>Khóa học thực sự tuyệt vời! Giảng viên hướng dẫn chi tiết, từ các khái niệm cơ bản cho tới phần thực hành làm dự án. Nhờ khóa học mà mình tự tin áp dụng ngay vào công việc hàng ngày.</p>
                                             </div>
                                          </div>
                                       </div>
                                    </li>
                                    <li>
                                       <div class="postbox-comment-user d-flex">
                                          <div class="postbox-user-thumb">
                                             <img src="{{ asset('assets/img/avatar/details-1-3.png') }}" alt="">
                                          </div>
                                          <div>
                                             <div class="d-flex justify-content-between">
                                                <div class="postbox-user-info mt-20 mb-20">
                                                   <h4 class="user-title">Trần Thu Hà</h4>
                                                   <span>
                                                      <i class="fa-sharp fa-solid fa-star text-warning"></i>
                                                      <i class="fa-sharp fa-solid fa-star text-warning"></i>
                                                      <i class="fa-sharp fa-solid fa-star text-warning"></i>
                                                      <i class="fa-sharp fa-solid fa-star text-warning"></i>
                                                      <i class="fa-sharp fa-solid fa-star text-warning"></i>
                                                      (5.0) • Đã đánh giá
                                                   </span>
                                                </div>
                                             </div>
                                             <div class="postbox-user-info">
                                                <p>Nội dung cô đọng, chất lượng cao, bài tập rất sát với thực tiễn. Rất hài lòng về chất lượng hỗ trợ của trung tâm và giảng viên.</p>
                                             </div>
                                          </div>
                                       </div>
                                    </li>
                                 </ul>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col-lg-4">
                  <div class="it-course-sidebar-wrap">
                     <div class="it-course-sidebar">
                        <div class="it-course-sidebar-thumb thumb-overlay z-index-1" style="border-radius: 15px; overflow: hidden; margin-bottom: 25px;">
                           <img style="width: 100%; height: 240px; object-fit: cover;" src="{{ $post->image ? asset($post->image) : asset('assets/img/course/details-v2.jpg') }}" alt="{{ $post->title }}">
                           <a class="it-about-thumb-icon pulse-white popup-video" href="https://www.youtube.com/watch?v=pQ9GnDx4Ozk">
                              <svg width="12" height="13" viewBox="0 0 12 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                                 <path d="M10.0234 8.09735C11.0234 7.52 11.0234 6.07607 10.0234 5.49872L3.36035 1.65204C2.36048 1.0749 1.11061 1.79643 1.11035 2.95087V10.6452C1.11052 11.7997 2.36044 12.5212 3.36035 11.944L10.0234 8.09735Z" fill="#03594E" stroke="#03594E" />
                              </svg>
                           </a>
                        </div>
                        <div class="price-section-box">
                           <div class="it-course-btn mb-20">
                              <a href="{{ $post->learn_url }}" class="it-btn-yellow w-100 text-center">
                                 <span>
                                    <span class="text-1">Vào Học Ngay</span>
                                    <span class="text-2">Vào Học Ngay</span>
                                 </span>
                              </a>
                           </div>
                        </div>
                        <div class="contact-section-wrap gray-bg mt-20">
                           <div class="contact-section text-center">
                              <div class="call-box w-100">
                                 <i class="fa-solid fa-phone-volume me-2" style="color: #03594E;"></i>
                                 Hotline: <a href="tel:0900123456">0900 123 456</a>
                              </div>
                            </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>    
      <!-- details-area-end -->

      <!-- course-area-start -->
      <div class="it-course-area it-course-style-11 it-course-style-3">
         <div class="container">
            <div class="it-course-details-border pt-125 pb-130">
               <div class="row">
                  <div class="col-lg-7">
                     <div class="it-course-details-section-title-box mb-70">
                        <h4 class="it-details-title">Khóa học liên quan</h4>
                        <span>Khám phá thêm các khóa học hấp dẫn khác</span>
                     </div>
                  </div>
               </div>
               <div class="row">
                  @if (isset($relatedCourses) && $relatedCourses->isNotEmpty())
                     @foreach ($relatedCourses as $index => $course)
                        @include('frontend.partials.course-item', ['course' => $course, 'index' => $index])
                     @endforeach
                  @else
                     <div class="col-12 text-center text-muted">
                        <p>Đang cập nhật thêm khóa học liên quan.</p>
                     </div>
                  @endif
               </div>
            </div>
         </div>
      </div>      
      <!-- course-area-end -->

   </main>

   @include('frontend.partials.footer')
   
   <!-- JS  Libraries -->
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

</body>
</html>
