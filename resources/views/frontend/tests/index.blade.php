<!doctype html>
<html class="no-js" lang="zxx">
<head>
   <meta charset="utf-8">
   <meta http-equiv="x-ua-compatible" content="ie=edge">
   <title>Bài Kiểm Tra - {{ $siteSetting->site_name ?? 'Hệ thống học tập' }}</title>
   <meta name="description" content="Danh sách bài kiểm tra">
   <meta name="viewport" content="width=device-width, initial-scale=1">

   <link rel="shortcut icon" type="image/x-icon" href="{{ $siteSetting->favicon_url ?? '' }}">

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
      .sidebar-widget-list {
         cursor: pointer;
         text-decoration: none !important;
      }
      .sidebar-widget-list i {
         transition: 0.3s;
      }
      .sidebar-widget-list.active i,
      .sidebar-widget-list:hover i {
         color: var(--it-common-white) !important;
      }
      .sidebar-widget-list.active .text-danger,
      .sidebar-widget-list:hover .text-danger {
         color: var(--it-common-white) !important;
      }
   </style>
</head>

<body>

   <div class="body-overlay"></div>

   @include('frontend.partials.header')

   <main>
      <div class="it-blog-details-area blog-details-left-sidebar pt-40 pb-40">
         <div class="container">
            <div class="row gx-35">
               
               <!-- Sidebar -->
               <div class="col-xl-4 col-lg-4">
                  @include('frontend.partials.profile-sidebar')
               </div>

               <!-- Main Content -->
               <div class="col-xl-8 col-lg-8">
                  <div class="row gx-35">
                     @if($tests->count() > 0)
                        @foreach($tests as $test)
                           <div class="col-xl-6 col-lg-6 col-md-12 wow itfadeUp" data-wow-duration=".9s" data-wow-delay=".3s">
                              <div class="it-career-item mb-35">
                                 <span>Bài kiểm tra</span>
                                 <h4 class="title">{{ $test->title }}</h4>
                                 <div class="it-career-meta">
                                    <span>{{ $test->questions()->count() }} Câu hỏi</span>
                                    <span>Điểm qua: {{ $test->pass_score }}</span>
                                 </div>
                                 <div class="d-sm-flex align-items-center justify-content-between mt-4">
                                    @php
                                       $status = 'Chưa làm';
                                       $statusColor = '#6c757d'; // gray
                                       if(isset($results[$test->id])) {
                                          if($results[$test->id]->is_passed) {
                                             $status = 'Đã qua';
                                             $statusColor = '#28a745'; // green
                                          } else {
                                             $status = 'Chưa qua';
                                             $statusColor = '#dc3545'; // red
                                          }
                                       }
                                    @endphp
                                    <span class="it-career-price badge" style="background-color: {{ $statusColor }}; color: #fff; padding: 8px 15px; border-radius: 5px; font-weight: 500; font-size: 14px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">{{ $status }}</span>
                                    <a href="{{ route('frontend.tests.show', $test->id) }}" class="it-btn-yellow">
                                       <span>
                                          <span class="text-1">Làm bài</span>
                                          <span class="text-2">Làm bài</span>
                                       </span>
                                       <i>
                                          <svg width="15" height="14" viewBox="0 0 15 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                             <path d="M14.6364 7.26396C14.9879 6.91249 14.9879 6.34264 14.6364 5.99117L8.90883 0.263603C8.55736 -0.0878692 7.98751 -0.0878692 7.63604 0.263603C7.28457 0.615075 7.28457 1.18492 7.63604 1.53639L12.7272 6.62756L7.63604 11.7187C7.28457 12.0702 7.28457 12.6401 7.63604 12.9915C7.98751 13.343 8.55736 13.343 8.90883 12.9915L14.6364 7.26396ZM0 6.62756V7.52756H14V6.62756V5.72756H0V6.62756Z" fill="#1F2432"></path>
                                          </svg>
                                       </i>
                                    </a>
                                 </div>
                              </div>
                           </div>
                        @endforeach
                     @else
                        <div class="col-12 text-center">
                           <div class="postbox-details-wrapper p-5" style="border: 1px dashed #ddd; border-radius: 10px;">
                              <p class="mb-0 fs-18">Hiện chưa có bài kiểm tra chung nào được mở.</p>
                           </div>
                        </div>
                     @endif
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
   <script src="{{ asset('assets/js/slick.min.js') }}"></script>                 
   <script src="{{ asset('assets/js/magnific-popup.js') }}"></script>           
   <script src="{{ asset('assets/js/wow.js') }}"></script>                    
   <script src="{{ asset('assets/js/main.js') }}"></script>

</body>
</html>
