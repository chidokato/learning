<!doctype html>
<html class="no-js" lang="vi">
<head>
   <meta charset="utf-8">
   <meta http-equiv="x-ua-compatible" content="ie=edge">
   <title>{{ $post->seo_title ?: $post->title }} -- Indochine</title>
   <meta name="description" content="{{ $post->seo_description ?: Str::limit(strip_tags($post->description ?? $post->summary ?? $post->content), 150) }}">
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

   <!-- Theme / Main CSS -->
   <link rel="stylesheet" href="{{ asset('assets/css/spacing.css') }}">          
   <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}?v=1.0.1">   

   <link rel="stylesheet" href="{{ asset('assets/css/course-curriculum.css') }}">
   <link rel="stylesheet" href="{{ asset('assets/css/course-custom.css') }}?v=1.0.1">
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
         <div class="it-menu-mobile d-xl-none"></div>
         <div class="itoffcanvas__info">
            <h3 class="offcanva-title">Get In Touch</h3>
            <div class="it-info-wrapper mb-20 d-flex align-items-center">
               <div class="itoffcanvas__info-icon">
                  <a href="#"><i class="fal fa-envelope"></i></a>
               </div>
               <div class="itoffcanvas__info-address">
                  <span>Email</span>
                  <a href="mailto:{{ $siteSetting->email }}">{{ $siteSetting->email }}</a>
               </div>
            </div>
            <div class="it-info-wrapper mb-20 d-flex align-items-center">
               <div class="itoffcanvas__info-icon">
                  <a href="#"><i class="fal fa-phone-alt"></i></a>
               </div>
               <div class="itoffcanvas__info-address">
                  <span>Phone</span>
                  <a href="tel:{{ preg_replace('/[^0-9]/', '', $siteSetting->hotline) }}">{{ $siteSetting->hotline }}</a>
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
      <div class="it-breadcrumb-area it-breadcrumb-course-details-style modern-course-hero fix z-index-1">
         <div class="container">
            <div class="row align-items-center">
               <div class="col-xxl-8 col-xl-8 col-lg-8 col-md-12">
                  <div class="course-hero-content z-index-1">
                     
                     <!-- Modern Breadcrumb -->
                     <nav class="course-hero-breadcrumb" aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                           <li class="breadcrumb-item">
                              <a href="{{ route('frontend.home') }}"><i class="fa-solid fa-house me-1"></i> Trang chủ</a>
                           </li>
                           @if ($post->category)
                           <li class="breadcrumb-item">
                              <a href="{{ route('frontend.category.show', $post->category->slug) }}">{{ $post->category->name }}</a>
                           </li>
                           @endif
                           <li class="breadcrumb-item active" aria-current="page">
                              <span>{{ $post->title }}</span>
                           </li>
                        </ol>
                     </nav>

                     <!-- Badges -->
                     <div class="course-hero-badges d-flex flex-wrap align-items-center gap-2">
                        @if ($post->category)
                        <span class="hero-badge badge-category">
                           <i class="fa-solid fa-folder-open me-1"></i> {{ $post->category->name }}
                        </span>
                        @endif
                        <span class="hero-badge badge-internal">
                           <i class="fa-solid fa-shield-halved me-1"></i> Lưu hành nội bộ
                        </span>
                        @if (isset($post->lesson_count) && $post->lesson_count > 0)
                        <span class="hero-badge badge-lessons">
                           <i class="fa-regular fa-circle-play me-1"></i> {{ $post->lesson_count }} bài học
                        </span>
                        @endif
                        @if ($post->tests && $post->tests->isNotEmpty())
                        <span class="hero-badge badge-has-test">
                           <i class="fa-solid fa-clipboard-check me-1"></i> Có bài tập ({{ $post->tests->count() }})
                        </span>
                        @endif
                     </div>

                     <!-- Course Title -->
                     <h1 class="course-hero-title">
                        {{ $post->title }}
                     </h1>

                     <!-- Meta Bar -->
                     <div class="course-hero-meta-bar d-flex flex-wrap align-items-center">
                        <!-- Instructor / Seller -->
                        <div class="hero-meta-card d-flex align-items-center">
                           <div class="meta-avatar">
                              @if (!empty($post->seller?->avatar) && file_exists(public_path($post->seller->avatar)))
                                 <img src="{{ asset($post->seller->avatar) }}" alt="{{ $post->seller->name }}" onerror="this.onerror=null; this.src='{{ asset('assets/img/avatar/avatar-default.png') }}';">
                              @else
                                 <div class="avatar-placeholder">
                                    <i class="fa-solid fa-chalkboard-user"></i>
                                 </div>
                              @endif
                           </div>
                           <div class="meta-info">
                              <span class="meta-sub">Giảng viên / Phụ trách</span>
                              <span class="meta-main">{{ $post->seller?->name ?? ($post->instructor ?? 'Học viện Indochine') }}</span>
                           </div>
                        </div>


                        <!-- Student / Enrolled Count (if available) -->
                        @if (isset($post->student_count) && $post->student_count > 0)
                        <div class="hero-meta-card d-flex align-items-center">
                           <div class="meta-icon-box">
                              <i class="fa-solid fa-users"></i>
                           </div>
                           <div class="meta-info">
                              <span class="meta-sub">Học viên</span>
                              <span class="meta-main">{{ number_format($post->student_count) }} học viên</span>
                           </div>
                        </div>
                        @endif

                        <!-- Nút Làm Bài Tập (nếu có bài tập của khóa học này) -->
                        @if ($post->tests && $post->tests->isNotEmpty())
                           @if ($post->tests->count() === 1)
                              @php $singleTest = $post->tests->first(); @endphp
                              <a href="{{ route('frontend.tests.show', $singleTest->id) }}" class="hero-exercise-btn" title="{{ $singleTest->title }}">
                                 <i class="fa-solid fa-file-pen"></i>
                                 <span>Làm bài tập</span>
                                 @if ($singleTest->questions->count() > 0)
                                    <span class="exercise-count-tag">{{ $singleTest->questions->count() }} câu</span>
                                 @endif
                              </a>
                           @else
                              <div class="dropdown hero-exercise-dropdown">
                                 <button class="hero-exercise-btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fa-solid fa-file-pen"></i>
                                    <span>Làm bài tập</span>
                                    <span class="exercise-count-tag">{{ $post->tests->count() }} bài</span>
                                 </button>
                                 <ul class="dropdown-menu shadow-lg">
                                    <li class="dropdown-header">Chọn bài kiểm tra:</li>
                                    @foreach ($post->tests as $t)
                                    <li>
                                       <a class="dropdown-item" href="{{ route('frontend.tests.show', $t->id) }}">
                                          <i class="fa-regular fa-file-lines me-2 text-warning"></i>
                                          <span>{{ $t->title }}</span>
                                          @if ($t->questions->count() > 0)
                                             <span class="badge bg-light text-dark ms-auto" style="font-size: 11px;">{{ $t->questions->count() }} câu</span>
                                          @endif
                                       </a>
                                    </li>
                                    @endforeach
                                 </ul>
                              </div>
                           @endif
                        @endif
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
                     <div id="summary-section">
                        @if ($post->summary)
                        <div class="postbox-dsc mb-55">
                           <div class="course-summary-content">{!! $post->summary !!}</div>
                        </div>
                        @endif
                     </div>

                     @if ($post->content)
                     <div id="curriculum">                     
                        <div class="mb-60">
                           @include('frontend.partials.course-curriculum')
                        </div>
                     </div>
                     @endif

                     <div id="overview">
                        @if ($post->what_to_learn)
                        <h4 class="it-details-title">Bạn sẽ học được gì</h4>
                        <div class="it-details-list-box mt-5 mb-60 ck-content-list style-1">
                              {!! $post->what_to_learn !!}
                        </div>
                        @endif
                        @if ($post->course_includes)
                        <h4 class="it-details-title">Khóa học này bao gồm:</h4>
                        <div class="it-details-list-box mt-5 mb-60 ck-content-list style-1">
                              {!! $post->course_includes !!}
                        </div>
                        @endif
                     </div>
                     @if ($post->course_requirements)
                     <div id="instructor">
                        <h4 class="it-details-title">Yêu cầu khóa học</h4>
                        <div class="it-details-list mb-60 ck-content-list style-1">
                              {!! $post->course_requirements !!}
                        </div>
                     </div>
                     @endif
                     @if ($post->seller?->name || $post->instructor || $post->seller?->bio)
                     <div id="reviews">
                        <div class="postbox-comment-item course-style mb-30">
                           <h4 class="it-details-title">Giảng viên phụ trách</h4>
                           <div class="postbox-comment-content mt-25">
                              <ul>
                                 <li>
                                    <div class="postbox-comment-user d-flex">
                                       <div class="postbox-user-thumb">
                                          @if (!empty($post->seller?->avatar) && file_exists(public_path($post->seller->avatar)))
                                             <img src="{{ asset($post->seller->avatar) }}" alt="{{ $post->seller->name ?? 'Giảng viên' }}" onerror="this.onerror=null; this.src='{{ asset('assets/img/avatar/avatar-default.png') }}';">
                                          @else
                                             <img src="{{ asset('assets/img/avatar/avatar-default.png') }}" alt="{{ $post->seller?->name ?? 'Giảng viên' }}">
                                          @endif
                                       </div>
                                       <div class="mt-20">
                                          <div class="postbox-user-info mb-20">
                                             <h4 class="user-title">{{ $post->seller?->name ?? ($post->instructor ?? '') }}</h4>
                                          </div>
                                          @if (filled($post->seller?->bio))
                                             <div class="postbox-user-info mb-25">
                                                <p style="white-space: pre-line; overflow-wrap: anywhere;">{{ $post->seller->bio }}</p>
                                             </div>
                                          @endif
                                       </div>
                                    </div>
                                 </li>
                              </ul>
                           </div>
                        </div>
                     </div>
                     @endif
                  </div>
               </div>
               <div class="col-lg-4">
                  <div class="it-course-sidebar-wrap">
                     <div class="it-course-sidebar">
                        <div class="it-course-sidebar-thumb z-index-1">
                           <img src="{{ (!empty($post->image) && file_exists(public_path($post->image))) ? asset($post->image) : asset('assets/img/course/course-1-1.jpg') }}" 
                                alt="{{ $post->title }}"
                                onerror="this.onerror=null; this.src='{{ asset('assets/img/course/course-1-1.jpg') }}';">
                        </div>
                        <div class="price-section-box">
                           <div class="it-course-btn mb-20">
                              @auth
                              <a href="{{ $post->learn_url }}" class="btn-beautiful w-100 text-center">
                                 <span>Vào Học Ngay</span>
                              </a>
                              @else
                              <a href="javascript:void(0)" onclick="showInternalNotice()" class="btn-beautiful btn-beautiful-login w-100 text-center">
                                 <span>Đăng Nhập Để Vào Học</span>
                              </a>
                              <script>
                                 function showInternalNotice() {
                                    Swal.fire({
                                       icon: 'info',
                                       title: 'Thông báo',
                                       text: 'Các khóa học lưu hành nội bộ. Bạn cần truy cập web từ link nội bộ để được vào học',
                                       confirmButtonColor: '#03594E',
                                       confirmButtonText: 'Đã hiểu'
                                    });
                                 }
                              </script>
                              @endauth
                           </div>

                           @if ($post->tests && $post->tests->isNotEmpty())
                           <div class="it-course-test-action mb-20">
                              @if ($post->tests->count() === 1)
                                 @php $sideTest = $post->tests->first(); @endphp
                                 <a href="{{ route('frontend.tests.show', $sideTest->id) }}" class="sidebar-test-btn w-100 text-center" title="{{ $sideTest->title }}">
                                    <i class="fa-solid fa-file-pen me-2"></i>
                                    <span>Làm bài tập @if($sideTest->questions->count() > 0)({{ $sideTest->questions->count() }} câu)@endif</span>
                                 </a>
                              @else
                                 <div class="dropdown">
                                    <button class="sidebar-test-btn w-100 text-center dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                       <i class="fa-solid fa-file-pen me-2"></i>
                                       <span>Làm bài tập ({{ $post->tests->count() }} bài)</span>
                                    </button>
                                    <ul class="dropdown-menu w-100 shadow-lg">
                                       <li class="dropdown-header">Chọn bài kiểm tra:</li>
                                       @foreach ($post->tests as $t)
                                       <li>
                                          <a class="dropdown-item" href="{{ route('frontend.tests.show', $t->id) }}">
                                             <i class="fa-regular fa-file-lines me-2 text-warning"></i>
                                             <span>{{ $t->title }}</span>
                                             @if ($t->questions->count() > 0)
                                                <span class="badge bg-light text-dark ms-auto" style="font-size: 11px;">{{ $t->questions->count() }} câu</span>
                                             @endif
                                          </a>
                                       </li>
                                       @endforeach
                                    </ul>
                                 </div>
                              @endif
                           </div>
                           @endif
                        </div>
                        @if ($siteSetting->hotline)
                        <div class="sidebar-hotline-wrap">
                           <a href="tel:{{ preg_replace('/[^0-9+]/', '', $siteSetting->hotline) }}" class="sidebar-hotline-btn">
                              <i class="fa-solid fa-headset"></i>
                              <span>Hotline hỗ trợ: <strong>{{ $siteSetting->hotline }}</strong></span>
                           </a>
                        </div>
                        @endif
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>    
      <!-- details-area-end -->

      <!-- related-courses-area-start -->
      @if (isset($relatedCourses) && $relatedCourses->isNotEmpty())
      <section class="related-courses-section">
         <div class="container">
            <div class="row">
               <div class="col-12">
                  <div class="related-courses-header">
                     <span class="related-courses-badge">
                        <i class="fas fa-sparkles me-1"></i> Khóa học đề xuất
                     </span>
                     <h3 class="related-courses-title">Khóa học liên quan</h3>
                     <p class="related-courses-subtitle">Khám phá thêm các chương trình đào tạo hấp dẫn khác tại Indochine</p>
                  </div>
               </div>
            </div>
            <div class="row">
               @foreach ($relatedCourses as $index => $course)
                  @include('frontend.partials.course-item', ['course' => $course, 'index' => $index])
               @endforeach
            </div>
         </div>
      </section>      
      <!-- related-courses-area-end -->
      @endif

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
