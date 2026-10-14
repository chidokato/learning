<!doctype html>
<html class="no-js" lang="vi">
<head>
   <meta charset="utf-8">
   <meta http-equiv="x-ua-compatible" content="ie=edge">
   <title>{{ $category->seo_title ?: $category->name }} -- Indochine</title>
   <meta name="description" content="{{ $category->seo_description ?: $category->description }}">
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
   <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}?v={{ time() }}">   
   <link rel="stylesheet" href="{{ asset('assets/css/course-custom.css') }}?v={{ time() }}">
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
                <input type="search" name="search-field" value="" placeholder="Tìm kiếm khóa học..." required="">
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
               <img src="{{ $siteSetting->logo_url }}" alt="Indochine">
            </a>
         </div>
         <div class="itoffcanvas__text">
            <p>Khóa học chất lượng cao, chia sẻ kiến thức và kinh nghiệm thực tiễn.</p>
         </div>
         <div class="it-menu-mobile d-xl-none"></div>
         <div class="itoffcanvas__info">
            <h3 class="offcanva-title">Liên hệ</h3>
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
                  <span>Hotline</span>
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
      <!-- category-hero-start -->
      <section class="category-hero-section">
         <div class="container">
            <div class="row align-items-center">
               <div class="col-lg-8">
                  <nav class="category-breadcrumb mb-2" aria-label="breadcrumb">
                     <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('frontend.home') }}"><i class="fas fa-home me-1"></i> Trang chủ</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $category->name }}</li>
                     </ol>
                  </nav>
                  <h1 class="category-hero-title">{{ $category->name }}</h1>
                  @if(!empty($category->description))
                     <p class="category-hero-desc">{{ $category->description }}</p>
                  @else
                     <p class="category-hero-desc">Tổng hợp các chương trình đào tạo chuyên sâu và tài liệu thực chiến Indochine</p>
                  @endif
               </div>
               <div class="col-lg-4 text-lg-end d-none d-lg-block">
                  <div class="category-hero-badge">
                     <i class="fas fa-graduation-cap me-2"></i>
                     <span>{{ isset($courses) ? $courses->total() : 0 }} Khóa học</span>
                  </div>
               </div>
            </div>
         </div>
      </section>
      <!-- category-hero-end -->

      @include('frontend.partials.course-area')

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
