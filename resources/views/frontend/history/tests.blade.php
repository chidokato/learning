<!doctype html>
<html class="no-js" lang="zxx">
<head>
   <meta charset="utf-8">
   <meta http-equiv="x-ua-compatible" content="ie=edge">
   <title>Lịch Sử Làm Bài - {{ $siteSetting->site_name ?? 'Hệ thống học tập' }}</title>
   <meta name="description" content="Lịch sử kết quả làm bài kiểm tra">
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
                        <h4 class="sidebar-widget-title mb-0">Lịch sử làm bài kiểm tra</h4>
                        @php $testList = $testResults ?? collect(); @endphp
                        <span class="badge" style="background-color: #03594e; font-size: 13px; padding: 7px 14px; border-radius: 20px;">
                           Đã làm: {{ $testList->count() }} lượt
                        </span>
                     </div>

                     @if($testList->count() > 0)
                        <div class="table-responsive">
                           <table class="table table-hover align-middle mb-0">
                              <thead class="table-light">
                                 <tr style="font-size: 14px;">
                                    <th>Bài kiểm tra</th>
                                    <th class="text-center">Số câu đúng</th>
                                    <th class="text-center">Kết quả</th>
                                    <th>Thời gian hoàn thành</th>
                                    <th class="text-end">Hành động</th>
                                 </tr>
                              </thead>
                              <tbody>
                                 @foreach($testList as $result)
                                 @php
                                    $totalQ = $result->test ? $result->test->questions->count() : null;
                                 @endphp
                                 <tr style="font-size: 14px;">
                                    <td>
                                       <strong class="text-dark">{{ $result->test ? $result->test->title : 'Bài kiểm tra #' . $result->test_id }}</strong>
                                       @if($result->test)
                                          <div class="small text-muted">Số câu qua: {{ $result->test->pass_score }}{{ $totalQ ? '/' . $totalQ : '' }}</div>
                                       @endif
                                    </td>
                                    <td class="text-center fw-bold" style="font-size: 15px;">
                                       <span class="text-primary">{{ $result->score }}</span>{{ $totalQ ? '/' . $totalQ : '' }}
                                    </td>
                                    <td class="text-center">
                                       @if($result->is_passed)
                                          <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-2 rounded-pill">
                                             <i class="far fa-check-circle me-1"></i> ĐẠT
                                          </span>
                                       @else
                                          <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-3 py-2 rounded-pill">
                                             <i class="far fa-times-circle me-1"></i> CHƯA ĐẠT
                                          </span>
                                       @endif
                                    </td>
                                    <td class="text-muted">
                                       <i class="far fa-calendar-alt me-1"></i>
                                       {{ $result->completed_at ? $result->completed_at->timezone('Asia/Ho_Chi_Minh')->format('d/m/Y H:i') : $result->created_at->timezone('Asia/Ho_Chi_Minh')->format('d/m/Y H:i') }}
                                    </td>
                                    <td class="text-end">
                                       <a href="{{ route('frontend.tests.show', $result->test_id) }}" class="btn btn-sm btn-outline-secondary rounded-pill px-3" style="font-size: 12px;">
                                          <i class="far fa-redo me-1"></i> Làm lại
                                       </a>
                                    </td>
                                 </tr>
                                 @endforeach
                              </tbody>
                           </table>
                        </div>
                     @else
                        <div class="text-center py-5">
                           <div style="font-size: 48px; color: #adb5bd;" class="mb-3">
                              <i class="far fa-clipboard-check"></i>
                           </div>
                           <h6 class="text-muted mb-3">Bạn chưa có lịch sử làm bài kiểm tra nào.</h6>
                           <a href="{{ route('frontend.tests.index') }}" class="it-btn-profile" style="padding: 10px 24px; font-size: 14px;">
                              <i class="far fa-clipboard-list me-2"></i> Xem danh sách bài kiểm tra
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
