<!doctype html>
<html class="no-js" lang="zxx">
<head>
   <meta charset="utf-8">
   <meta http-equiv="x-ua-compatible" content="ie=edge">
   <title>Bài Kiểm Tra - {{ $siteSetting->site_name ?? 'Hệ thống học tập' }}</title>
   <meta name="description" content="Danh sách bài kiểm tra">
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
   <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}?v={{ time() }}">   

   <style>
      .test-card-item {
         background: #ffffff;
         border: 1px solid #eef2f6;
         border-radius: 16px;
         padding: 24px;
         box-shadow: 0 4px 20px -2px rgba(15, 23, 42, 0.05);
         transition: all 0.25s ease;
         height: 100%;
         display: flex;
         flex-direction: column;
         justify-content: space-between;
      }
      .test-card-item:hover {
         transform: translateY(-3px);
         box-shadow: 0 10px 25px -4px rgba(3, 89, 78, 0.12);
         border-color: rgba(3, 89, 78, 0.25);
      }
      .test-card-tag {
         display: inline-block;
         font-size: 11.5px;
         font-weight: 600;
         color: #03594e;
         background: rgba(3, 89, 78, 0.08);
         padding: 3px 10px;
         border-radius: 6px;
         margin-bottom: 12px;
      }
      .test-card-title {
         font-size: 17px;
         font-weight: 700;
         color: #1a2c5e;
         margin-bottom: 12px;
         line-height: 1.4;
      }
      .test-card-meta {
         display: flex;
         align-items: center;
         gap: 15px;
         font-size: 13px;
         color: #64748b;
         margin-bottom: 20px;
      }
      .test-card-meta span {
         display: inline-flex;
         align-items: center;
         gap: 5px;
      }
      .test-status-badge {
         display: inline-flex;
         align-items: center;
         gap: 5px;
         font-size: 12.5px;
         font-weight: 600;
         padding: 5px 12px;
         border-radius: 6px;
      }
      .test-stat-pill {
         display: inline-flex;
         align-items: center;
         gap: 4px;
         font-size: 12px;
         font-weight: 500;
         padding: 4px 8px;
         border-radius: 6px;
         background: #f8fafc;
         border: 1px solid #e2e8f0;
         color: #475569;
         white-space: nowrap;
      }
      .test-btn-action {
         display: inline-flex;
         align-items: center;
         gap: 7px;
         background: #03594e;
         color: #ffffff !important;
         font-size: 13.5px;
         font-weight: 600;
         padding: 7px 16px;
         border-radius: 8px;
         text-decoration: none !important;
         transition: all 0.2s ease;
      }
      .test-btn-action:hover {
         background: #02433b;
         box-shadow: 0 4px 12px rgba(3, 89, 78, 0.25);
         transform: translateX(2px);
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
               <div class="col-xl-3 col-lg-4">
                  @include('frontend.partials.profile-sidebar')
               </div>

               <!-- Main Content -->
               <div class="col-xl-9 col-lg-8">
                  <div class="row g-4">
                     @if($tests->count() > 0)
                        @foreach($tests as $test)
                           <div class="col-xl-6 col-lg-6 col-md-12 wow itfadeUp" data-wow-duration=".9s" data-wow-delay=".3s">
                              <div class="test-card-item">
                                 <div>
                                    <span class="test-card-tag"><i class="far fa-clipboard-list me-1"></i> Bài kiểm tra</span>
                                    <h4 class="test-card-title">{{ $test->title }}</h4>
                                    <div class="test-card-meta">
                                       <span><i class="far fa-question-circle text-primary"></i> {{ $test->questions()->count() }} Câu</span>
                                       <span><i class="far fa-check-circle text-success"></i> Đạt: {{ $test->pass_score }}/{{ $test->questions()->count() }}</span>
                                       <span>
                                          <i class="far fa-clock text-warning"></i> 
                                          @if($test->duration && $test->duration > 0)
                                             {{ $test->duration }} phút
                                          @else
                                             Tự do
                                          @endif
                                       </span>
                                    </div>
                                 </div>
                                 <div class="d-flex align-items-center justify-content-between pt-15 border-top gap-2 flex-wrap">
                                    @php
                                       $itemResult = $userResults[$test->id] ?? null;
                                       $status = 'Chưa làm';
                                       $statusBg = '#f1f5f9';
                                       $statusColor = '#475467';
                                       $statusIcon = 'fa-clock';
                                       if($itemResult) {
                                          if($itemResult['is_passed']) {
                                             $status = 'Đã qua';
                                             $statusBg = '#dcfce7';
                                             $statusColor = '#15803d';
                                             $statusIcon = 'fa-check-circle';
                                          } else {
                                             $status = 'Chưa qua';
                                             $statusBg = '#fee2e2';
                                             $statusColor = '#b91c1c';
                                             $statusIcon = 'fa-times-circle';
                                          }
                                       }
                                    @endphp
                                    <div class="d-flex align-items-center gap-2 flex-wrap">
                                       <span class="test-status-badge" style="background-color: {{ $statusBg }}; color: {{ $statusColor }};">
                                          <i class="far {{ $statusIcon }}"></i> {{ $status }}
                                       </span>
                                       @if($itemResult)
                                          <span class="test-stat-pill" title="Số lần đã làm bài">
                                             <i class="far fa-redo text-muted"></i> {{ $itemResult['attempts'] }} Lần
                                          </span>
                                          <span class="test-stat-pill" title="Điểm số cao nhất">
                                             <i class="far fa-trophy text-warning"></i> <strong class="text-success">{{ $itemResult['max_score'] }}</strong>/{{ $test->questions()->count() }} Câu
                                          </span>
                                       @endif
                                    </div>
                                    <a href="{{ route('frontend.tests.show', $test->id) }}" class="test-btn-action">
                                       <span>{{ $itemResult ? 'Làm lại' : 'Làm bài' }}</span>
                                       <i class="far fa-arrow-right"></i>
                                    </a>
                                 </div>
                              </div>
                           </div>
                        @endforeach
                     @else
                        <div class="col-12 text-center">
                           <div class="p-5 bg-white rounded-3 shadow-sm" style="border: 1px dashed #cbd5e1;">
                              <i class="far fa-clipboard-check text-muted mb-3" style="font-size: 40px;"></i>
                              <p class="mb-0 text-muted fs-16">Hiện chưa có bài kiểm tra nào được mở.</p>
                           </div>
                        </div>
                     @endif
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
