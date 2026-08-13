<!doctype html>
<html class="no-js" lang="zxx">
<!-- Mirrored from ordainit.com/html/indochine/indochine/courses-v1.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 28 Jul 2026 03:47:47 GMT -->
<head>
   <meta charset="utf-8">
   <meta http-equiv="x-ua-compatible" content="ie=edge">
   <title>Indochine -- Online Education & Courses Template</title>
   <meta name="description" content="">
   <meta name="viewport" content="width=device-width, initial-scale=1">

   <!-- Place favicon.ico in the root directory -->
   <link rel="shortcut icon" type="image/x-icon" href="{{ $siteSetting->favicon_url }}">

   <!-- CSS Here -->
   <link rel="stylesheet" href="assets/css/bootstrap.min.css">        
   <link rel="stylesheet" href="assets/css/font-awesome-pro.css">     
   <link rel="stylesheet" href="assets/css/swiper-bundle.min.css">   
   <link rel="stylesheet" href="assets/css/slick.css">              
   <link rel="stylesheet" href="assets/css/magnific-popup.css">      
   <link rel="stylesheet" href="assets/css/nice-select.css">          
   <link rel="stylesheet" href="assets/css/custom-animation.css">

   <!-- Theme / Main CSS -->
   <link rel="stylesheet" href="assets/css/spacing.css">          
   <link rel="stylesheet" href="assets/css/main.css">   

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

   @include('frontend.partials.course-area')

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


<!-- Mirrored from ordainit.com/html/indochine/indochine/courses-v1.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 28 Jul 2026 03:47:48 GMT -->
</html>

