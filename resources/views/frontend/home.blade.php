<!doctype html>
<html class="no-js" lang="zxx">
<head>
   <meta charset="utf-8">
   <meta http-equiv="x-ua-compatible" content="ie=edge">
   <title>{{ $siteSetting->site_name ?? 'Indochine' }} - Hệ thống đào tạo trực tuyến</title>
   <meta name="description" content="">
   <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Place favicon.ico in the root directory -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ $siteSetting->favicon_url }}">

    <!-- Google Fonts - Montserrat -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

    <!-- CSS Here -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">        
   <link rel="stylesheet" href="assets/css/font-awesome-pro.css">     
   <link rel="stylesheet" href="assets/css/swiper-bundle.min.css">   
   <link rel="stylesheet" href="assets/css/slick.css">              
   <link rel="stylesheet" href="assets/css/magnific-popup.css">      
   <link rel="stylesheet" href="assets/css/nice-select.css">          
   <link rel="stylesheet" href="assets/css/custom-animation.css">

   <!-- Theme / Main CSS -->
   <link rel="stylesheet" href="assets/css/spacing.css">          
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
               <img src="{{ $siteSetting->logo_url }}" alt="">
            </a>
         </div>
         <div class="itoffcanvas__text">
            <p>Suspendisse interdum consectetur libero id. Fermentum leo vel orci porta non. Euismod viverra nibh
               cras pulvinar suspen.</p>
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
                  <a href="maito:hello@yourmail.com">hello@yourmail.com</a>
               </div>
            </div>
            <div class="it-info-wrapper mb-20 d-flex align-items-center">
               <div class="itoffcanvas__info-icon">
                  <a href="#"><i class="fal fa-phone-alt"></i></a>
               </div>
               <div class="itoffcanvas__info-address">
                  <span>Phone</span>
                  <a href="tel:(00)45611227890">(00) 456 1122 7890</a>
               </div>
            </div>
            <div class="it-info-wrapper mb-20 d-flex align-items-center">
               <div class="itoffcanvas__info-icon">
                  <a href="#"><i class="fas fa-map-marker-alt"></i></a>
               </div>
               <div class="itoffcanvas__info-address">
                  <span>Location</span>
                  <a href="htits://www.google.com/maps/@37.4801311,22.8928877,3z" target="_blank">Riverside 255,
                     San Francisco, USA </a>
               </div>
            </div>
         </div>
      </div>
   </div>
   <div class="body-overlay"></div>
   <!-- it-offcanvus-area-end -->

   @include('frontend.partials.header')

   <main>

   @include('frontend.partials.hero-slider')
   @include('frontend.partials.categories-area')

   {{-- @include('frontend.partials.course-area') --}}

   @if(isset($categoriesWithCourses) && $categoriesWithCourses->isNotEmpty())
    @foreach($categoriesWithCourses as $category)
    <section class="home-category-section {{ $loop->odd ? 'bg-light-tint' : 'bg-white' }}">
       <div class="container">
          <!-- Section Header -->
          <div class="home-section-header d-flex flex-wrap align-items-end justify-content-between">
             <div class="home-section-header-left">
                <div class="home-section-badge">
                   <i class="fas fa-layer-group"></i>
                   <span>Chủ đề đào tạo</span>
                </div>
                <h3 class="home-section-title">
                   {{ $category->name }}
                </h3>
                <div class="home-section-title-line"></div>
                <span class="home-section-subtitle">Tuyển tập các khóa học và tài liệu chuyên sâu về {{ $category->name }}</span>
             </div>
             <div class="home-section-header-right mt-3 mt-md-0">
                <a href="{{ route('frontend.category.show', $category->slug) }}" class="home-btn-view-all">
                   <span>Xem tất cả</span>
                   @if($category->posts->count() > 0)
                      <span class="btn-count">({{ $category->posts->count() }})</span>
                   @endif
                   <i class="far fa-arrow-right"></i>
                </a>
             </div>
          </div>

          <!-- Courses Grid -->
          <div class="row gx-4 gy-4">
             @forelse($category->posts as $course)
                @include('frontend.partials.course-item', [
                    'course' => $course,
                    'category' => $category,
                    'colClass' => 'col-xl-3 col-lg-6 col-md-6 col-sm-12'
                ])
             @empty
                <div class="col-12">
                   <div class="home-empty-courses text-center">
                      <i class="far fa-folder-open mb-2" style="font-size: 2rem; color: #94a3b8;"></i>
                      <p class="mb-0 text-muted">Chưa có khóa học nào được cập nhật trong danh mục này.</p>
                   </div>
                </div>
             @endforelse
          </div>
       </div>
    </section>
    @endforeach
   @endif
   </main>

   @include('frontend.partials.footer')
   
   <!-- JS  Libraries -->
   <script src="assets/js/jquery.js"></script>                     
   <script src="assets/js/bootstrap.bundle.min.js"></script>      
   <script src="assets/js/purecounter.js"></script>          
   <script src="assets/js/range-slider.js"></script>          
   <script src="assets/js/nice-select.js"></script>             
   <script src="assets/js/swiper-bundle.min.js"></script>         
   <script src="assets/js/isotope-pkgd.js"></script>     
   <script src="assets/js/slick.min.js"></script>            
   <script src="assets/js/wow.js"></script>                
   <script src="assets/js/countdown.js"></script>                
   <script src="assets/js/magnific-popup.js"></script>                
   <script src="assets/js/imagesloaded-pkgd.js"></script>                
   <script src="assets/js/parallax.js"></script>                

   <!-- Custom JS -->
   <script src="assets/js/slider.js"></script>                
   <script src="assets/js/main.js"></script>  

</body>
</html>
