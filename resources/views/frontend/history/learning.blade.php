<!doctype html>
<html class="no-js" lang="zxx">
<head>
   <meta charset="utf-8">
   <meta http-equiv="x-ua-compatible" content="ie=edge">
   <title>Lịch Sử Học Tập - {{ $siteSetting->site_name ?? 'Hệ thống học tập' }}</title>
   <meta name="description" content="Lịch sử học các khóa học">
   <meta name="viewport" content="width=device-width, initial-scale=1">

   <link rel="shortcut icon" type="image/x-icon" href="{{ $siteSetting->favicon_url ?? '' }}">

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
   <link rel="stylesheet" href="{{ asset('assets/css/course-custom.css') }}?v=1.0.1">   
   <link rel="stylesheet" href="{{ asset('assets/css/header-custom.css') }}?v=1.0.1">   

   <style>
      .sidebar-widget {
         border-radius: 16px;
         border: 1px solid #eef2f6;
         box-shadow: 0 4px 20px -2px rgba(15, 23, 42, 0.05);
         padding: 30px;
         background-color: #ffffff !important;
      }
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
         transition: all 0.3s ease;
         font-size: 13.5px;
         cursor: pointer;
         text-decoration: none !important;
      }
      .it-btn-profile:hover {
         background-color: #02463d;
         color: #ffffff !important;
         transform: translateY(-2px);
         box-shadow: 0 6px 15px rgba(3, 89, 78, 0.25);
      }
   </style>
</head>

<body>

   <div class="body-overlay"></div>

   <button class="it-back-to-top scroll-top" role="button" aria-label="scroll to top">
      <i class="far fa-arrow-up"></i>
   </button>

   @include('frontend.partials.header')

   <main>
      <div class="it-blog-details-area blog-details-left-sidebar pt-40 pb-40">
         <div class="container">
            <div class="row gx-35">
               
               <!-- Sidebar -->
               <div class="col-xl-3 col-lg-4">
                  @include('frontend.partials.profile-sidebar')
               </div>

               <!-- Main Content -->
               <div class="col-xl-9 col-lg-8">
                  <div class="sidebar-widget mb-40">
                     <div class="d-flex justify-content-between align-items-center mb-25 pb-15 border-bottom flex-wrap gap-2">
                        <h4 class="sidebar-widget-title mb-0">Lịch sử học tập</h4>
                        @php $learnedList = $learnedCourses ?? collect(); @endphp
                        <span class="badge" style="background-color: #03594e; font-size: 13px; padding: 7px 14px; border-radius: 20px;">
                           Đã học: {{ $learnedList->count() }} khóa học
                        </span>
                     </div>

                     @if($learnedList->count() > 0)
                        <div class="row g-3">
                           @foreach($learnedList as $item)
                              @if($item->post)
                              <div class="col-12">
                                 <div class="p-3 rounded border d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3" style="background: #fafbfc;">
                                    <div class="d-flex align-items-center gap-3">
                                       <img src="{{ $item->post->image ? asset($item->post->image) : asset('assets/img/course/course-1-5.jpg') }}" alt="{{ $item->post->title }}" style="width: 80px; height: 60px; object-fit: cover; border-radius: 8px;" class="flex-shrink-0">
                                       <div>
                                          <h6 class="mb-1 fw-bold">
                                             <a href="{{ $item->post->frontend_url }}" class="text-dark text-decoration-none">
                                                {{ $item->post->title }}
                                             </a>
                                          </h6>
                                          <div class="text-muted small d-flex flex-wrap align-items-center gap-2 mb-2">
                                             @if($item->post->category)
                                                <span class="badge bg-light text-secondary border">{{ $item->post->category->name }}</span>
                                             @endif
                                             <span class="badge bg-white text-dark border">
                                                <i class="far fa-clock text-primary me-1"></i> {{ $item->last_learned_at ? $item->last_learned_at->timezone('Asia/Ho_Chi_Minh')->format('d/m/Y H:i') : $item->updated_at->timezone('Asia/Ho_Chi_Minh')->format('d/m/Y H:i') }}
                                             </span>
                                             <span class="badge bg-white text-danger border">
                                                <i class="far fa-stopwatch me-1"></i> Thời gian học: <strong>{{ $item->formatted_study_time }}</strong>
                                             </span>
                                             @if($item->completed_at || ($item->progress_percent ?? 0) >= 100)
                                                <span class="badge bg-success text-white">
                                                   <i class="far fa-check-circle me-1"></i> Đã hoàn thành
                                                </span>
                                             @endif
                                          </div>
                                          <!-- Tiến trình học -->
                                          <div style="max-width: 320px;">
                                             <div class="d-flex justify-content-between align-items-center mb-1" style="font-size: 11.5px;">
                                                <span class="fw-semibold text-secondary">
                                                   Tiến độ: <strong class="text-success">{{ $item->progress_percent ?? 0 }}%</strong>
                                                </span>
                                                <span class="text-muted">
                                                   Đang học slide: {{ $item->current_page ?? 1 }}/{{ $item->total_pages ?: '--' }}
                                                </span>
                                             </div>
                                             <div class="progress" style="height: 6px; border-radius: 999px; background-color: #e2e8f0;">
                                                <div class="progress-bar" 
                                                     style="width: {{ $item->progress_percent ?? 0 }}%; background-color: {{ ($item->progress_percent ?? 0) >= 100 ? '#10b981' : '#03594e' }}; border-radius: 999px;" 
                                                     role="progressbar" 
                                                     aria-valuenow="{{ $item->progress_percent ?? 0 }}" 
                                                     aria-valuemin="0" 
                                                     aria-valuemax="100"></div>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="flex-shrink-0 text-md-end">
                                       <a href="{{ $item->post->learn_url }}" class="it-btn-profile">
                                          <i class="far fa-play-circle me-1"></i> Tiếp tục học
                                       </a>
                                    </div>
                                 </div>
                              </div>
                              @endif
                           @endforeach
                        </div>
                     @else
                        <div class="text-center py-5">
                           <div style="font-size: 48px; color: #adb5bd;" class="mb-3">
                              <i class="far fa-graduation-cap"></i>
                           </div>
                           <h6 class="text-muted mb-3">Bạn chưa có lịch sử học khóa học nào.</h6>
                           <a href="{{ route('frontend.home') }}" class="it-btn-profile" style="padding: 10px 24px; font-size: 14px;">
                              <i class="far fa-compass me-2"></i> Khám phá các khóa học
                           </a>
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
