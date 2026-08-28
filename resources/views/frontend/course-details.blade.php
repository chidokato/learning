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

   <link rel="stylesheet" href="{{ asset('assets/css/course-custom.css') }}">
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
                              <span class="name">{{ $post->seller?->name ?? ($post->instructor ?? 'Indochine Instructor') }}</span>
                           </div>
                        </div>
                        <div class="it-breadcrumb-author-info border-style mb-20">
                           <span>Cập nhật gần nhất</span>
                           <span>{{ $post->updated_at ? $post->updated_at->format('d/m/Y') : now()->format('d/m/Y') }}</span>
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
                     <div id="summary-section">
                        @if ($post->summary)
                        <div class="postbox-dsc mb-55">
                           <p class="mb-20"><strong>{{ $post->summary }}</strong></p>
                        </div>
                        @endif
                     </div>

                     @if ($post->content)
                     <div id="curriculum">                     
                        <h4 class="it-details-title">Nội dung khóa học (Chương trình học)</h4>
                        <div class="it-course-faq mb-60">
                           <div class="it-course-faq-top-text mb-10 mt-25 d-flex align-items-center justify-content-between">
                              <span><strong id="total-chapters-count"></strong> chương học • Đầy đủ video hướng dẫn & tài liệu thực hành</span>
                              <a href="javascript:void(0)" id="toggle-all-accordion">Mở rộng tất cả</a>                        
                           </div>
                           
                           <!-- Dữ liệu gốc ẩn đi -->
                           <div id="raw-curriculum" style="display: none;">
                              {!! $post->content !!}
                           </div>
                           
                           <!-- Nơi chứa giao diện Accordion gốc được render tự động -->
                           <div class="it-custom-accordion-2" id="dynamic-curriculum-container"></div>
                        </div>

                        <script src="{{ asset('assets/js/course-custom.js') }}"></script>
                     </div>
                     @endif

                     <div id="overview">
                        <h4 class="it-details-title">Bạn sẽ học được gì</h4>
                        <div class="it-details-list-box mt-5 mb-60 ck-content-list style-2-col">
                           @if ($post->what_to_learn)
                              {!! $post->what_to_learn !!}
                           @else
                              <ul>
                                 <li>Hiểu sâu lý thuyết căn bản và tư duy áp dụng thực tế</li>
                                 <li>Quy trình làm việc chuẩn nghiệp vụ chuyên nghiệp</li>
                                 <li>Làm chủ các công cụ chuyên sâu và kỹ năng thực hành</li>
                                 <li>Đạt chứng chỉ hoàn thành khóa học và thăng tiến nghề nghiệp</li>
                                 <li>Tự tin triển khai các dự án hoàn chỉnh từ A-Z</li>
                              </ul>
                           @endif
                        </div>
                        <h4 class="it-details-title">Khóa học này bao gồm:</h4>
                        <div class="it-details-list-box mt-5 mb-60 ck-content-list style-2-col">
                           @if ($post->course_includes)
                              {!! $post->course_includes !!}
                           @else
                              <ul>
                                 <li>Truy cập trọn đời trên máy tính và thiết bị di động</li>
                                 <li>Tài liệu hướng dẫn trực quan</li>
                                 <li>Tài liệu, bài tập và mã nguồn mẫu tải về</li>
                                 <li>Hỗ trợ học viên trên mọi thiết bị</li>
                                 <li>Cấp chứng chỉ tốt nghiệp khi hoàn thành</li>
                              </ul>
                           @endif
                        </div>
                     </div>
                     <div id="instructor">
                        <h4 class="it-details-title">Yêu cầu khóa học</h4>
                        <div class="it-details-list mb-60 ck-content-list style-1">
                           @if ($post->course_requirements)
                              {!! $post->course_requirements !!}
                           @else
                              <ul>
                                 <li>Máy tính hoặc laptop có kết nối Internet để học tập</li>
                                 <li>Không yêu cầu kinh nghiệm trước đó, phù hợp cả cho người mới bắt đầu</li>
                                 <li>Tinh thần ham học hỏi và sẵn sàng thực hành qua từng bài tập</li>
                              </ul>
                           @endif
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
                                             <h4 class="user-title">{{ $post->seller?->name ?? ($post->instructor ?? 'Indochine Instructor') }}</h4>
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
                        <!-- Tạm ẩn phần đánh giá theo yêu cầu -->
                        <div class="d-none">
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
