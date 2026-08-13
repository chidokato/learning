<!doctype html>
<html class="no-js" lang="vi">

<head>
   <meta charset="utf-8">
   <meta http-equiv="x-ua-compatible" content="ie=edge">
   <title>{{ $post->title }} - Học trực tuyến & Sách lật 3D</title>
   <meta name="description" content="Học trực tuyến khóa học {{ $post->title }} - Giao diện LMS chuẩn & Sách lật PDF 3D FULL">
   <meta name="viewport" content="width=device-width, initial-scale=1">

   <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/img/logo/favicon.png') }}">

   <!-- CSS Here -->
   <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
   <link rel="stylesheet" href="{{ asset('assets/css/font-awesome-pro.css') }}">
   <link rel="stylesheet" href="{{ asset('assets/css/spacing.css') }}">

   <style>
      * {
         box-sizing: border-box;
      }
      body, html {
         margin: 0;
         padding: 0;
         height: 100%;
         font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
         background-color: #f8f9fa;
         color: #333;
         overflow: hidden;
      }
      /* Top Navbar (60px) */
      .gitiho-header {
         height: 60px;
         background: #ffffff;
         border-bottom: 1px solid #e5e5e5;
         display: flex;
         align-items: center;
         justify-content: space-between;
         padding: 0 30px;
         position: fixed;
         top: 0;
         left: 0;
         right: 0;
         z-index: 1050;
      }
      .gitiho-header-left {
         display: flex;
         align-items: center;
         overflow: hidden;
      }
      .gitiho-logo img {
         max-height: 38px;
         width: auto;
      }
      .gitiho-divider {
         width: 1px;
         height: 24px;
         background: #dcdcdc;
         margin: 0 20px;
      }
      .gitiho-course-title {
         font-size: 17px;
         font-weight: 700;
         color: #1a1a1a;
         white-space: nowrap;
         overflow: hidden;
         text-overflow: ellipsis;
         max-width: 700px;
      }
      .gitiho-back-btn {
         display: inline-flex;
         align-items: center;
         justify-content: center;
         width: 34px;
         height: 34px;
         border-radius: 6px;
         color: #555;
         text-decoration: none;
         margin-right: 14px;
         transition: all 0.2s;
         font-size: 16px;
      }
      .gitiho-back-btn:hover {
         background: #f0f0f0;
         color: #000;
      }
      .gitiho-header-right {
         display: flex;
         align-items: center;
         gap: 20px;
      }
      .progress-ring-box {
         display: flex;
         align-items: center;
         gap: 10px;
      }
      .progress-circle {
         width: 36px;
         height: 36px;
         border-radius: 50%;
         border: 2.5px solid #28a745;
         display: flex;
         align-items: center;
         justify-content: center;
         font-size: 11px;
         font-weight: 700;
         color: #28a745;
         background: #ebfbee;
      }
      .progress-text {
         font-size: 14px;
         font-weight: 600;
         color: #444;
      }

      /* Main Fullwidth Workspace */
      .gitiho-workspace {
         display: flex;
         height: calc(100vh - 60px);
         margin-top: 60px;
         overflow: hidden;
         position: relative;
         width: 100%;
      }

      /* Fullscreen Main Pane (Player + Tabs) */
      .gitiho-main-pane {
         flex: 1;
         width: 100%;
         display: flex;
         flex-direction: column;
         overflow-y: auto;
         background: #ffffff;
      }
      .gitiho-player-container {
         background-color: #121315;
         width: 100%;
         height: calc(100vh - 60px);
         min-height: 650px;
         display: flex;
         flex-direction: column;
         position: relative;
      }

      /* Top Toolbar inside Player */
      .player-toolbar {
         height: 52px;
         background: #1c1d20;
         border-bottom: 1px solid #2d2e32;
         display: flex;
         align-items: center;
         justify-content: space-between;
         padding: 0 25px;
         color: #fff;
         z-index: 20;
         flex-wrap: wrap;
         gap: 10px;
         flex-shrink: 0;
      }
      .toolbar-left, .toolbar-center, .toolbar-right {
         display: flex;
         align-items: center;
         gap: 12px;
      }
      .page-input-box {
         display: inline-flex;
         align-items: center;
         background: #121315;
         border: 1px solid #444;
         border-radius: 4px;
         padding: 4px 12px;
         font-size: 14px;
      }
      .page-input-box input {
         background: transparent;
         border: none;
         color: #fff;
         width: 45px;
         text-align: center;
         font-weight: 700;
         font-size: 14.5px;
         outline: none;
      }
      .page-input-box span {
         color: #aaa;
         margin-left: 4px;
      }
      .btn-toolbar-icon {
         background: transparent;
         border: 1px solid #444;
         color: #eee;
         width: 36px;
         height: 36px;
         border-radius: 4px;
         display: flex;
         align-items: center;
         justify-content: center;
         cursor: pointer;
         transition: all 0.2s;
         font-size: 14px;
      }
      .btn-toolbar-icon:hover {
         background: #3a3d40;
         color: #fff;
      }
      .btn-mode-toggle {
         border: 1px solid #444;
         background: #121315;
         color: #ccc;
         font-size: 13.5px;
         font-weight: 600;
         padding: 6px 16px;
         border-radius: 4px;
         transition: all 0.2s;
         display: flex;
         align-items: center;
         gap: 8px;
      }
      .btn-mode-toggle.active {
         background: #d32f2f;
         border-color: #d32f2f;
         color: #fff;
      }

      /* Viewer Body Area (FULLSCREEN HEIGHT & WIDTH) */
      .player-viewer-area {
         flex: 1;
         position: relative;
         display: flex;
         align-items: center;
         justify-content: center;
         overflow: hidden;
         padding: 15px 40px;
         background-color: #121315;
         width: 100%;
         height: 100%;
      }

      /* Loading State */
      .flipbook-loading {
         position: absolute;
         inset: 0;
         background: #121315;
         display: flex;
         flex-direction: column;
         align-items: center;
         justify-content: center;
         z-index: 15;
         color: #fff;
      }
      .spinner-book {
         width: 50px;
         height: 50px;
         border: 4px solid rgba(255, 255, 255, 0.1);
         border-top-color: #d32f2f;
         border-radius: 50%;
         animation: spin 1s linear infinite;
         margin-bottom: 15px;
      }
      @keyframes spin {
         to { transform: rotate(360deg); }
      }

      /* 3D Book Flipbook styling (FULL SIZE, MAXIMIZED TO SCREEN) */
      #flipbookContainerWrapper {
         width: 100%;
         height: 100%;
         display: flex;
         justify-content: center;
         align-items: center;
         position: relative;
         padding: 5px 35px;
         overflow: hidden;
      }
      .flip-book {
         box-shadow: 0 25px 70px rgba(0, 0, 0, 0.9);
         position: relative;
      }
      .flip-page {
         background-color: #ffffff;
         overflow: hidden;
         border: 1px solid #dcdcdc;
         display: flex;
         align-items: center;
         justify-content: center;
      }
      /* object-fit contain ensures pages never stretch or get cropped */
      .flip-page canvas {
         width: 100%;
         height: 100%;
         object-fit: contain;
         display: block;
      }

      /* Floating Left & Right Navigation Arrows */
      .flip-nav-btn {
         position: absolute;
         top: 50%;
         transform: translateY(-50%);
         width: 48px;
         height: 48px;
         border-radius: 50%;
         background: rgba(0, 0, 0, 0.7);
         color: #fff;
         border: 1px solid rgba(255, 255, 255, 0.3);
         display: flex;
         align-items: center;
         justify-content: center;
         font-size: 20px;
         cursor: pointer;
         z-index: 10;
         transition: all 0.2s;
      }
      .flip-nav-btn:hover {
         background: #d32f2f;
         transform: translateY(-50%) scale(1.1);
      }
      .flip-prev { left: 10px; }
      .flip-next { right: 10px; }

      /* Scroll Mode Container (iframe fallback) */
      #scrollModeContainer {
         width: 100%;
         height: 100%;
         display: none;
      }
      #scrollModeContainer iframe {
         width: 100%;
         height: 100%;
         min-height: 680px;
         border: none;
         background: #fff;
      }

      /* Horizontal Tabs Nav */
      .gitiho-tabs-nav {
         background: #ffffff;
         border-bottom: 1px solid #eaeaea;
         padding: 0 40px;
         position: sticky;
         top: 0;
         z-index: 10;
      }
      .gitiho-tabs-nav .nav-tabs {
         border-bottom: none;
         gap: 32px;
      }
      .gitiho-tabs-nav .nav-link {
         border: none;
         background: transparent;
         color: #555555;
         font-size: 15.5px;
         font-weight: 600;
         padding: 18px 4px;
         border-bottom: 3px solid transparent;
         margin-bottom: -1px;
         transition: all 0.25s ease;
      }
      .gitiho-tabs-nav .nav-link:hover {
         color: #d32f2f;
      }
      .gitiho-tabs-nav .nav-link.active {
         color: #d32f2f;
         border-bottom-color: #d32f2f;
      }

      /* Tab Content Area */
      .gitiho-tab-content {
         padding: 35px 40px;
         flex: 1;
         background: #ffffff;
         max-width: 1300px;
         margin: 0 auto;
         width: 100%;
      }

      /* Responsive adjustments */
      @media (max-width: 991.98px) {
         .gitiho-course-title {
            max-width: 250px;
         }
      }
   </style>
</head>

<body>

   <!-- Top Gitiho Header Bar (60px) -->
   <header class="gitiho-header">
      <div class="gitiho-header-left">
         <a href="{{ route('frontend.home') }}" class="gitiho-logo" title="Trang chủ">
            <img src="{{ $siteSetting->logo_url ?? asset('assets/img/logo/logo-1.png') }}" alt="Logo">
         </a>
         <div class="gitiho-divider"></div>
         <a href="{{ $post->frontend_url }}" class="gitiho-back-btn" title="Quay lại trang chi tiết">
            <i class="fa-regular fa-arrow-left"></i>
         </a>
         <span class="gitiho-course-title" title="{{ $post->title }}">{{ $post->title }}</span>
      </div>

      <div class="gitiho-header-right">
         <div class="progress-ring-box">
            <div class="progress-circle" id="headerProgressPercent">5%</div>
            <span class="progress-text">Hoàn thành</span>
         </div>
      </div>
   </header>

   <!-- Main Fullwidth Workspace (No Sidebar) -->
   <div class="gitiho-workspace">

      <!-- Fullwidth Pane: Player & Horizontal Tabs -->
      <div class="gitiho-main-pane" id="mainPaneArea">
         
         <!-- PDF / 3D Book Flipbook Viewer Area -->
         <div class="gitiho-player-container">
            
            <!-- Toolbar control -->
            <div class="player-toolbar">
               <div class="toolbar-left">
                  <span class="badge bg-danger px-3 py-2" style="font-size: 13px;">
                     <i class="fa-solid fa-book-open me-1"></i> Sách lật 3D (Hiển thị FULL)
                  </span>
                  <span class="text-white-50 ms-2 d-none d-md-inline" style="font-size: 13.5px;">
                     Kéo góc sách hoặc bấm phím mũi tên để lật trang
                  </span>
               </div>

               <div class="toolbar-center">
                  <button class="btn-toolbar-icon" id="btnPrevPage" title="Trang trước (Mũi tên trái)">
                     <i class="fa-solid fa-chevron-left"></i>
                  </button>
                  <div class="page-input-box">
                     Trang <input type="number" id="pageNumInput" value="1" min="1"> 
                     <span>/ <strong id="totalPagesText">--</strong></span>
                  </div>
                  <button class="btn-toolbar-icon" id="btnNextPage" title="Trang tiếp theo (Mũi tên phải)">
                     <i class="fa-solid fa-chevron-right"></i>
                  </button>
               </div>

               <div class="toolbar-right">
                  <button class="btn-toolbar-icon" id="btnFullscreen" title="Mở toàn màn hình">
                     <i class="fa-solid fa-expand"></i>
                  </button>
               </div>
            </div>

            <!-- Viewer Body Area -->
            <div class="player-viewer-area" id="viewerArea">
               
               <!-- 1. Loading Overlay -->
               <div class="flipbook-loading" id="flipbookLoading">
                  <div class="spinner-book"></div>
                  <h5 class="mb-2" style="font-weight: 700;">Đang tạo quyển sách 3D FULL...</h5>
                  <p class="loading-text text-white-50 mb-0" style="font-size: 13.5px;">Vui lòng đợi trong giây lát</p>
               </div>

               <!-- 2. 3D Book Flipbook Mode Container (PageFlip) -->
               <div id="flipbookContainerWrapper">
                  <button id="floatingPrevBtn" class="flip-nav-btn flip-prev" title="Trang trước">
                     <i class="fa-solid fa-chevron-left"></i>
                  </button>

                  <!-- Target book element -->
                  <div id="flipbook" class="flip-book"></div>

                  <button id="floatingNextBtn" class="flip-nav-btn flip-next" title="Trang tiếp">
                     <i class="fa-solid fa-chevron-right"></i>
                  </button>
               </div>

               <!-- 3. Scroll Mode Container (iframe fallback) -->
               <div id="scrollModeContainer">
                  <iframe id="pdfViewerFrame" src="{{ $post->pdf_url }}#toolbar=1&view=FitH" allowfullscreen>
                     <div class="p-5 text-center bg-white" style="height: 100%;">
                        <h5 class="text-danger mb-3">Trình duyệt không hỗ trợ xem trực tiếp PDF</h5>
                        <p class="mb-4">Vui lòng tải tài liệu để xem trên thiết bị của bạn.</p>
                        <a href="{{ $post->pdf_url }}" download class="btn btn-success">Tải tài liệu PDF ngay</a>
                     </div>
                  </iframe>
               </div>

            </div>
         </div>

         <!-- Horizontal Navigation Tabs -->
         <div class="gitiho-tabs-nav">
            <ul class="nav nav-tabs" id="learnTabs" role="tablist">
               <li class="nav-item" role="presentation">
                  <button class="nav-link active" id="overview-tab" data-bs-toggle="tab" data-bs-target="#tab-overview" type="button" role="tab">
                     Tổng quan
                  </button>
               </li>
               <li class="nav-item" role="presentation">
                  <button class="nav-link" id="qa-tab" data-bs-toggle="tab" data-bs-target="#tab-qa" type="button" role="tab">
                     Hỏi đáp
                  </button>
               </li>
               <li class="nav-item" role="presentation">
                  <button class="nav-link" id="articles-tab" data-bs-toggle="tab" data-bs-target="#tab-articles" type="button" role="tab">
                     Bài viết chuyên môn
                  </button>
               </li>
               <li class="nav-item" role="presentation">
                  <button class="nav-link" id="reviews-tab" data-bs-toggle="tab" data-bs-target="#tab-reviews" type="button" role="tab">
                     Đánh giá
                  </button>
               </li>
               <li class="nav-item" role="presentation">
                  <button class="nav-link" id="cert-tab" data-bs-toggle="tab" data-bs-target="#tab-cert" type="button" role="tab">
                     Tải chứng nhận
                  </button>
               </li>
            </ul>
         </div>

         <!-- Tab Contents -->
         <div class="gitiho-tab-content">
            <div class="tab-content">

               <!-- 1. TỔNG QUAN -->
               <div class="tab-pane fade show active" id="tab-overview" role="tabpanel">
                  <h3 style="font-size: 24px; font-weight: 700; margin-bottom: 15px; color: #111;">
                     {{ $post->title }}
                  </h3>
                  <div class="d-flex align-items-center gap-4 text-muted mb-25" style="font-size: 14.5px;">
                     <span><i class="fa-solid fa-chalkboard-user text-danger me-2"></i> Giảng viên: <strong>Indochine Instructor</strong></span>
                     <span><i class="fa-solid fa-file-pdf text-danger me-2"></i> Tài liệu chính thức</span>
                     <span><i class="fa-solid fa-clock text-info me-2"></i> Cập nhật liên tục 24/7</span>
                  </div>
                  <div class="course-desc-content" style="font-size: 15.5px; line-height: 1.75; color: #444;">
                     {!! $post->content ?: '<p>Khóa học này được thiết kế theo phương pháp thực tiễn, giúp bạn nắm vững kiến thức nền tảng và vận dụng thành thạo vào công việc thực tế. Tài liệu PDF kèm theo bao gồm đầy đủ slide bài giảng, hướng dẫn thực hành và bài tập củng cố.</p>' !!}
                  </div>
               </div>

               <!-- 2. HỎI ĐÁP -->
               <div class="tab-pane fade" id="tab-qa" role="tabpanel">
                  <h4 style="font-size: 20px; font-weight: 700; margin-bottom: 20px;">
                     <i class="fa-regular fa-comments text-danger me-2"></i> Thảo luận & Hỏi đáp cùng Giảng viên
                  </h4>
                  <div class="mb-4 p-4 bg-light rounded-3 border">
                     <textarea class="form-control mb-3" rows="3" placeholder="Nhập câu hỏi hoặc thắc mắc của bạn về bài học này..." style="font-size: 14.5px;"></textarea>
                     <div class="d-flex justify-content-end">
                        <button class="btn btn-danger px-4 py-2" style="font-size: 14px; font-weight: 600;">
                           Gửi câu hỏi
                        </button>
                     </div>
                  </div>
                  <div class="qa-thread-list">
                     <div class="qa-item d-flex gap-3 mb-3 pb-3 border-bottom">
                        <div class="avatar" style="width: 44px; height: 44px; border-radius: 50%; background: #03594E; color: #fff; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 16px;">
                           H
                        </div>
                        <div>
                           <div class="d-flex align-items-center gap-2 mb-1">
                              <strong style="font-size: 15px;">Hoàng Minh</strong>
                              <span class="text-muted" style="font-size: 12.5px;">• 2 ngày trước</span>
                           </div>
                           <p class="mb-2" style="font-size: 14.5px; color: #333;">Giảng viên cho em hỏi ở chương 2 trang 15, phần cú pháp xử lý dữ liệu có áp dụng được cho phiên bản mới nhất không ạ?</p>
                           <div class="p-3 bg-light rounded-2 mt-2">
                              <div class="d-flex align-items-center gap-2 mb-1">
                                 <strong class="text-danger" style="font-size: 14px;">Indochine Instructor (Giảng viên)</strong>
                                 <span class="badge bg-danger" style="font-size: 11px;">Quản trị viên</span>
                              </div>
                              <p class="mb-0" style="font-size: 14px;">Chào bạn, hoàn toàn áp dụng được nhé! Bạn có thể xem ví dụ bổ sung ở phần thực hành chương 3.</p>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>

               <!-- 3. BÀI VIẾT CHUYÊN MÔN / TÀI LIỆU -->
               <div class="tab-pane fade" id="tab-articles" role="tabpanel">
                  <h4 style="font-size: 20px; font-weight: 700; margin-bottom: 20px;">
                     <i class="fa-regular fa-file-lines text-danger me-2"></i> Tài liệu đính kèm & Bài viết tham khảo
                  </h4>
                  <div class="row g-4">
                     <div class="col-md-6">
                        <div class="p-4 border rounded-3 d-flex align-items-center justify-content-between">
                           <div class="d-flex align-items-center gap-3">
                              <i class="fa-solid fa-file-pdf text-danger" style="font-size: 32px;"></i>
                              <div>
                                 <h6 class="mb-1" style="font-size: 16px; font-weight: 700;">Tài liệu toàn tập khóa học.pdf</h6>
                                 <span class="text-muted" style="font-size: 13px;">Dung lượng: 4.8 MB • PDF định dạng chuẩn</span>
                              </div>
                           </div>
                           <a href="{{ $post->pdf_url }}" download target="_blank" class="btn btn-outline-danger px-3 py-2">
                              <i class="fa-solid fa-download me-1"></i> Tải về
                           </a>
                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="p-4 border rounded-3 d-flex align-items-center justify-content-between">
                           <div class="d-flex align-items-center gap-3">
                              <i class="fa-solid fa-file-code text-success" style="font-size: 32px;"></i>
                              <div>
                                 <h6 class="mb-1" style="font-size: 16px; font-weight: 700;">Bộ file thực hành thực tế.zip</h6>
                                 <span class="text-muted" style="font-size: 13px;">Dung lượng: 12.4 MB • Kèm hướng dẫn</span>
                              </div>
                           </div>
                           <a href="{{ $post->pdf_url }}" download target="_blank" class="btn btn-outline-success px-3 py-2">
                              <i class="fa-solid fa-download me-1"></i> Tải về
                           </a>
                        </div>
                     </div>
                  </div>
               </div>

               <!-- 4. ĐÁNH GIÁ -->
               <div class="tab-pane fade" id="tab-reviews" role="tabpanel">
                  <div class="d-flex align-items-center gap-4 mb-30 p-4 bg-light rounded-3 border">
                     <div class="text-center">
                        <div style="font-size: 42px; font-weight: 800; color: #ffc107;">5.0</div>
                        <div class="text-warning mb-1" style="font-size: 18px;">
                           <i class="fa-solid fa-star"></i>
                           <i class="fa-solid fa-star"></i>
                           <i class="fa-solid fa-star"></i>
                           <i class="fa-solid fa-star"></i>
                           <i class="fa-solid fa-star"></i>
                        </div>
                        <span class="text-muted" style="font-size: 14px;">(128 lượt đánh giá)</span>
                     </div>
                     <div>
                        <h5 style="font-size: 18px; font-weight: 700;">Khóa học chất lượng cao</h5>
                        <p class="mb-0 text-muted" style="font-size: 15px;">100% học viên đánh giá hài lòng với nội dung thực tiễn và tài liệu chi tiết của khóa học này.</p>
                     </div>
                  </div>
               </div>

               <!-- 5. TẢI CHỨNG NHẬN -->
               <div class="tab-pane fade" id="tab-cert" role="tabpanel">
                  <div class="text-center p-5 border rounded-3 bg-light">
                     <i class="fa-solid fa-award text-warning mb-3" style="font-size: 60px;"></i>
                     <h4 style="font-size: 22px; font-weight: 700;">Chứng nhận hoàn thành khóa học</h4>
                     <p class="text-muted mb-4" style="font-size: 15px; max-width: 550px; margin: 0 auto;">
                        Hoàn thành 100% các bài học và bài kiểm tra để mở khóa và tải xuống chứng nhận chính thức từ Indochine.
                     </p>
                     <button class="btn btn-danger px-4 py-2" disabled style="font-weight: 600; font-size: 15px;">
                        <i class="fa-solid fa-lock me-2"></i> Chưa đủ điều kiện tải chứng nhận
                     </button>
                  </div>
               </div>

            </div>
         </div>
      </div>

   </div>

   <!-- JS Libraries -->
   <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
   <!-- PDF.js & PageFlip CDN for 3D Book Flipbook -->
   <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"></script>
   <script src="https://cdn.jsdelivr.net/npm/page-flip@2.0.7/dist/js/page-flip.browser.js"></script>

   <script>
      // 1. Quản lý sách lật 3D (PageFlip hiển thị FULL tối đa theo kích thước màn hình)
      let pdfDoc = null;
      let flipBook = null;
      let totalPagesCount = 1;

      const pdfUrl = "{{ $post->pdf_url }}";
      const loadingEl = document.getElementById('flipbookLoading');
      const flipbookEl = document.getElementById('flipbook');
      const flipbookWrapper = document.getElementById('flipbookContainerWrapper');
      const scrollWrapper = document.getElementById('scrollModeContainer');

      const pageNumInput = document.getElementById('pageNumInput');
      const totalPagesText = document.getElementById('totalPagesText');

      async function initPdfFlipbook() {
         try {
            if (typeof pdfjsLib === 'undefined' || typeof St === 'undefined') {
               throw new Error("Thư viện PDF.js hoặc PageFlip chưa load");
            }

            pdfjsLib.GlobalWorkerOptions.workerSrc = "https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js";
            
            const loadingTask = pdfjsLib.getDocument(pdfUrl);
            pdfDoc = await loadingTask.promise;
            totalPagesCount = pdfDoc.numPages;
            totalPagesText.innerText = totalPagesCount;
            pageNumInput.max = totalPagesCount;

            // Tính toán tỷ lệ chuẩn từ trang đầu tiên
            const firstPage = await pdfDoc.getPage(1);
            const firstViewport = firstPage.getViewport({ scale: 1 });
            const pageRatio = firstViewport.height / firstViewport.width;

            // Tính toán kích thước TRANG SÁCH LẬT TỐI ĐA (FULL) phù hợp 100% với màn hình hiện tại
            const availWidth = (window.innerWidth - 110) / 2; // vì 2 trang nằm cạnh nhau
            const availHeight = window.innerHeight - 130;     // trừ chiều cao header 60px + toolbar 52px

            let pageW = Math.floor(availWidth);
            let pageH = Math.round(pageW * pageRatio);

            if (pageH > availHeight) {
               pageH = Math.floor(availHeight);
               pageW = Math.round(pageH / pageRatio);
            }

            // Đảm bảo kích thước tối thiểu cho màn hình rất nhỏ
            if (pageW < 320) pageW = 320;
            if (pageH < Math.round(320 * pageRatio)) pageH = Math.round(320 * pageRatio);

            flipbookEl.innerHTML = "";

            for (let i = 1; i <= totalPagesCount; i++) {
               const page = await pdfDoc.getPage(i);
               const viewport = page.getViewport({ scale: 2.0 }); // Render Retina HD DPI 2.0 siêu sắc nét

               const pageDiv = document.createElement("div");
               pageDiv.className = "flip-page";
               pageDiv.setAttribute("data-density", (i === 1 || i === totalPagesCount) ? "hard" : "soft");

               const canvas = document.createElement("canvas");
               const context = canvas.getContext("2d");
               canvas.width = viewport.width;
               canvas.height = viewport.height;

               pageDiv.appendChild(canvas);
               flipbookEl.appendChild(pageDiv);

               await page.render({
                  canvasContext: context,
                  viewport: viewport
               }).promise;

               const loadText = loadingEl.querySelector('.loading-text');
               if (loadText) {
                  loadText.innerText = `Đang tạo trang sách FULL... (${i}/${totalPagesCount} trang)`;
               }
            }

            loadingEl.style.display = 'none';

            // Khởi tạo St.PageFlip với kích thước FULL màn hình
            flipBook = new St.PageFlip(flipbookEl, {
               width: pageW,
               height: pageH,
               size: "stretch",
               minWidth: Math.round(pageW * 0.5),
               maxWidth: pageW,
               minHeight: Math.round(pageH * 0.5),
               maxHeight: pageH,
               maxShadowOpacity: 0.6,
               showCover: false,
               mobileScrollSupport: false,
               flippingTime: 650
            });

            flipBook.loadFromHTML(document.querySelectorAll('.flip-page'));

            flipBook.on("flip", (e) => {
               pageNumInput.value = (e.data + 1);
               const percentage = Math.round(((e.data + 1) / totalPagesCount) * 100);
               const percentEl = document.getElementById('headerProgressPercent');
               if (percentEl) percentEl.innerText = percentage + "%";
            });

         } catch (err) {
            console.warn("Chuyển sang chế độ xem cuộn do lỗi tải Flipbook:", err);
            loadingEl.style.display = 'none';
            switchToScrollMode();
         }
      }

      // Điều hướng Trang trước / tiếp
      document.getElementById('btnPrevPage')?.addEventListener('click', () => {
         if (flipBook) flipBook.flipPrev();
      });
      document.getElementById('floatingPrevBtn')?.addEventListener('click', () => {
         if (flipBook) flipBook.flipPrev();
      });
      document.getElementById('btnNextPage')?.addEventListener('click', () => {
         if (flipBook) flipBook.flipNext();
      });
      document.getElementById('floatingNextBtn')?.addEventListener('click', () => {
         if (flipBook) flipBook.flipNext();
      });

      // Bấm số trang -> nhảy trực tiếp đến trang đó
      pageNumInput?.addEventListener('change', (e) => {
         let targetPage = parseInt(e.target.value) || 1;
         if (targetPage < 1) targetPage = 1;
         if (targetPage > totalPagesCount) targetPage = totalPagesCount;
         pageNumInput.value = targetPage;
         if (flipBook) {
            flipBook.flip(targetPage - 1);
         }
      });

      // Điều hướng bằng Phím mũi tên (ArrowLeft / ArrowRight)
      document.addEventListener('keydown', (e) => {
         if (document.activeElement.tagName === 'INPUT' || document.activeElement.tagName === 'TEXTAREA') return;
         if (e.key === 'ArrowLeft') {
            if (flipBook && flipbookWrapper.style.display !== 'none') flipBook.flipPrev();
         } else if (e.key === 'ArrowRight') {
            if (flipBook && flipbookWrapper.style.display !== 'none') flipBook.flipNext();
         }
      });

      // Chuyển chế độ xem cuộn (dự phòng khi lỗi tải Sách lật 3D)
      function switchToScrollMode() {
         scrollWrapper.style.display = 'block';
         flipbookWrapper.style.display = 'none';
      }

      // Nút xem Toàn màn hình
      document.getElementById('btnFullscreen')?.addEventListener('click', () => {
         const elem = document.getElementById('mainPaneArea');
         if (!document.fullscreenElement) {
            if (elem.requestFullscreen) elem.requestFullscreen();
            else if (elem.webkitRequestFullscreen) elem.webkitRequestFullscreen();
            else if (elem.msRequestFullscreen) elem.msRequestFullscreen();
         } else {
            if (document.exitFullscreen) document.exitFullscreen();
         }
      });

      // Tự động khởi tạo khi trang tải xong
      window.addEventListener('DOMContentLoaded', () => {
         initPdfFlipbook();
      });
   </script>

</body>

</html>
