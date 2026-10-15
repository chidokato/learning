<!doctype html>
<html class="no-js" lang="vi">

<head>
   <meta charset="utf-8">
   <meta http-equiv="x-ua-compatible" content="ie=edge">
   <title>{{ $post->title }} - Học trực tuyến & Sách lật 3D</title>
   <meta name="description" content="Học trực tuyến khóa học {{ $post->title }} - Giao diện LMS chuẩn & Sách lật PDF 3D FULL">
   <meta name="csrf-token" content="{{ csrf_token() }}">
   <meta name="viewport" content="width=device-width, initial-scale=1">

   <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/img/logo/favicon.png') }}">

   <!-- Google Fonts - Montserrat -->
   <link rel="preconnect" href="https://fonts.googleapis.com">
   <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
   <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

   <!-- CSS Here -->
   <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
   <link rel="stylesheet" href="{{ asset('assets/css/font-awesome-pro.css') }}">
   <link rel="stylesheet" href="{{ asset('assets/css/spacing.css') }}">
   <link rel="stylesheet" href="{{ asset('assets/css/course-curriculum.css') }}?v={{ time() }}">
   <link rel="stylesheet" href="{{ asset('assets/css/course-custom.css') }}?v={{ time() }}">

   <style>
      * {
         box-sizing: border-box;
      }
      body, html {
         margin: 0;
         padding: 0;
         height: 100%;
         font-family: 'Montserrat', sans-serif;
         background-color: #f8f9fa;
         color: #333;
         overflow: hidden;
      }
      body, button, input, select, textarea,
      h1, h2, h3, h4, h5, h6,
      p, a, li, label, table, th, td, blockquote, small, strong, em, b,
      span:not([class*="fa-"]):not([class*="fal"]):not([class*="far"]):not([class*="fas"]):not([class*="fad"]):not([class*="fab"]):not([class*="flaticon-"]):not([class*="mdi"]):not([class*="ri-"]):not([class*="bx-"]),
      div:not([class*="fa-"]):not([class*="fal"]):not([class*="far"]):not([class*="fas"]):not([class*="fad"]):not([class*="fab"]):not([class*="flaticon-"]):not([class*="mdi"]):not([class*="ri-"]):not([class*="bx-"]),
      i:not([class*="fa-"]):not([class*="fal"]):not([class*="far"]):not([class*="fas"]):not([class*="fad"]):not([class*="fab"]):not([class*="flaticon-"]):not([class*="mdi"]):not([class*="ri-"]):not([class*="bx-"]) {
         font-family: 'Montserrat', sans-serif !important;
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
      
      /* Presence & Active Learning Tracker Widget */
      
      /* Test Tab Styles */
      .course-test-highlight-card {
         background: linear-gradient(135deg, #f0fdf4 0%, #ffffff 100%);
         border: 2px solid #03594e;
         border-radius: 12px;
         padding: 16px;
         box-shadow: 0 6px 20px rgba(3, 89, 78, 0.12);
         margin-bottom: 18px;
         position: relative;
         overflow: hidden;
      }
      .course-test-highlight-card::before {
         content: "";
         position: absolute;
         top: 0;
         left: 0;
         width: 5px;
         height: 100%;
         background: #03594e;
      }
      .general-test-card {
         background: #ffffff;
         border: 1px solid #e2e8f0;
         border-radius: 10px;
         padding: 14px 16px;
         margin-bottom: 12px;
         transition: all 0.2s ease;
      }
      .general-test-card:hover {
         border-color: #03594e;
         box-shadow: 0 4px 14px rgba(0, 0, 0, 0.06);
         transform: translateY(-2px);
      }
      .test-meta-badge {
         display: inline-flex;
         align-items: center;
         gap: 5px;
         font-size: 11.5px;
         font-weight: 600;
         padding: 3px 8px;
         border-radius: 6px;
         background: #f1f5f9;
         color: #475569;
      }

      .learning-tracker-box {
         display: flex;
         align-items: center;
         gap: 10px;
         background: #f1f5f9;
         border: 1px solid #e2e8f0;
         padding: 5px 12px;
         border-radius: 999px;
      }
      .tracker-status-indicator {
         display: inline-flex;
         align-items: center;
         gap: 6px;
         font-size: 11.5px;
         font-weight: 600;
         color: #10b981;
         padding: 2px 8px;
         border-radius: 20px;
         background: rgba(16, 185, 129, 0.1);
         transition: all 0.25s ease;
      }
      .tracker-status-indicator .status-dot {
         width: 7px;
         height: 7px;
         border-radius: 50%;
         background: #10b981;
         box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7);
         animation: pulse-green 1.8s infinite;
      }
      .tracker-status-indicator.paused {
         color: #b45309;
         background: rgba(245, 158, 11, 0.12);
      }
      .tracker-status-indicator.paused .status-dot {
         background: #f59e0b;
         animation: none;
         box-shadow: none;
      }
      @keyframes pulse-green {
         0% { box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7); }
         70% { box-shadow: 0 0 0 6px rgba(16, 185, 129, 0); }
         100% { box-shadow: 0 0 0 0 rgba(16, 185, 129, 0); }
      }
      .tracker-time-display {
         font-size: 13px;
         font-weight: 700;
         color: #0f172a;
         font-variant-numeric: tabular-nums;
         display: flex;
         align-items: center;
      }
      .progress-circle.completed {
         border-color: #059669;
         background: #d1fae5;
         color: #059669;
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
         height: calc(100dvh - 60px);
         margin-top: 60px;
         overflow: hidden;
         position: relative;
         width: 100%;
      }

      /* Lesson and independently scrolling course information */
      .gitiho-main-pane {
         flex: 1;
         width: 100%;
         display: flex;
         min-width: 0;
         overflow: hidden;
         background: #ffffff;
      }
      .gitiho-player-container {
         background-color: #121315;
         flex: 1;
         min-width: 0;
         height: 100%;
         min-height: 0;
         flex-shrink: 0;
         display: flex;
         flex-direction: column;
         position: relative;
      }
      .gitiho-course-panel {
         flex: 0 0 clamp(360px, 25%, 460px);
         min-width: 0;
         height: 100%;
         display: flex;
         flex-direction: column;
         border-left: 1px solid #e5e5e5;
         background: #fff;
      }

      /* Top Toolbar inside Player */
      .player-toolbar {
         min-height: 52px;
         background: #1c1d20;
         border-bottom: 1px solid #2d2e32;
         display: flex;
         align-items: center;
         justify-content: space-between;
         padding: 8px 25px;
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
         min-height: 0;
         position: relative;
         display: flex;
         align-items: center;
         justify-content: center;
         overflow: hidden;
         padding: 15px 40px;
         background-color: #121315;
         width: 100%;
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

      /* Slide E-Learning Viewer (FULL RESPONSIVE & HIGH DEFINITION) */
      #slideViewerWrapper {
         width: 100%;
         height: 100%;
         display: flex;
         justify-content: center;
         align-items: center;
         position: relative;
         padding: 10px 40px;
         overflow: auto;
         user-select: none;
      }
      .slide-stage {
         position: relative;
         display: flex;
         align-items: center;
         justify-content: center;
         box-shadow: 0 15px 50px rgba(0, 0, 0, 0.85);
         background: #1e1e24;
         border-radius: 6px;
         max-width: 100%;
         max-height: 100%;
         transition: opacity 0.15s ease-out;
         cursor: pointer;
      }
      .slide-stage canvas {
         display: block;
         max-width: 100%;
         max-height: 100%;
         border-radius: 6px;
      }
      .slide-progress-container {
         position: absolute;
         bottom: 0;
         left: 0;
         right: 0;
         height: 4px;
         background: rgba(255, 255, 255, 0.1);
         z-index: 12;
      }
      .slide-progress-bar {
         height: 100%;
         width: 0%;
         background: #d32f2f;
         transition: width 0.25s ease;
      }

      /* Floating Left & Right Navigation Arrows */
      .flip-nav-btn {
         position: absolute;
         top: 50%;
         transform: translateY(-50%);
         width: 48px;
         height: 48px;
         border-radius: 50%;
         background: rgba(0, 0, 0, 0.65);
         color: #fff;
         border: 1px solid rgba(255, 255, 255, 0.25);
         display: flex;
         align-items: center;
         justify-content: center;
         font-size: 20px;
         cursor: pointer;
         z-index: 10;
         transition: all 0.2s;
         backdrop-filter: blur(4px);
      }
      .flip-nav-btn:hover:not(:disabled) {
         background: #d32f2f;
         transform: translateY(-50%) scale(1.08);
         border-color: #d32f2f;
      }
      .flip-nav-btn:disabled {
         opacity: 0.2;
         cursor: not-allowed;
         pointer-events: none;
      }
      .flip-prev { left: 16px; }
      .flip-next { right: 16px; }

      /* Scroll Mode Container (iframe fallback) */
      #scrollModeContainer {
         width: 100%;
         height: 100%;
         display: none;
      }
      #scrollModeContainer iframe {
         width: 100%;
         height: 100%;
         min-height: 0;
         border: none;
         background: #fff;
      }

      /* Horizontal Tabs Nav */
      .gitiho-tabs-nav {
         background: #ffffff;
         border-bottom: 1px solid #eaeaea;
         padding: 8px 16px 0;
         flex-shrink: 0;
         z-index: 10;
      }
      .gitiho-tabs-nav .nav-tabs {
         border-bottom: none;
         gap: 0 16px;
         flex-wrap: nowrap;
         overflow-x: auto;
         overflow-y: hidden;
         scrollbar-width: thin;
         scrollbar-color: #c5d3d0 #f4f7f6;
         scroll-behavior: smooth;
         padding-bottom: 8px;
      }
      .gitiho-tabs-nav .nav-tabs::-webkit-scrollbar {
         height: 5px;
      }
      .gitiho-tabs-nav .nav-tabs::-webkit-scrollbar-track {
         background: #f4f7f6;
         border-radius: 999px;
      }
      .gitiho-tabs-nav .nav-tabs::-webkit-scrollbar-thumb {
         background: #c5d3d0;
         border-radius: 999px;
      }
      .gitiho-tabs-nav .nav-tabs::-webkit-scrollbar-thumb:hover {
         background: #8daaa3;
      }
      .gitiho-tabs-nav .nav-tabs::-webkit-scrollbar-button {
         display: none;
         width: 0;
         height: 0;
      }
      @supports selector(::-webkit-scrollbar) {
         .gitiho-tabs-nav .nav-tabs {
            scrollbar-width: auto;
            scrollbar-color: auto;
         }
      }
      @media (prefers-reduced-motion: reduce) {
         .gitiho-tabs-nav .nav-tabs { scroll-behavior: auto; }
      }
      .gitiho-tabs-nav .nav-item {
         flex: 0 0 auto;
      }
      .gitiho-tabs-nav .nav-link {
         white-space: nowrap;
         border: none;
         background: transparent;
         color: #555555;
         font-size: 14px;
         font-weight: 600;
         padding: 12px 0;
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
         padding: 24px 20px;
         flex: 1;
         min-height: 0;
         overflow-y: auto;
         overflow-wrap: anywhere;
         background: #ffffff;
         width: 100%;
      }
      .gitiho-course-panel .gap-4 { flex-wrap: wrap; gap: 12px !important; }
      .gitiho-course-panel .col-md-6 { width: 100%; }
      .gitiho-course-panel .p-5 { padding: 24px !important; }
      .gitiho-course-panel .avatar { flex-shrink: 0; }
      .gitiho-course-panel a[download] { flex-shrink: 0; white-space: nowrap; }
      .course-desc-content img, .course-desc-content iframe { max-width: 100%; }
      .course-desc-content img { height: auto; }

      /* Responsive adjustments */
      .gitiho-player-container:fullscreen {
         height: 100vh;
         height: 100dvh;
      }
      @media (max-width: 1399.98px) {
         .toolbar-left .text-white-50 { display: none !important; }
      }
      @media (max-width: 767.98px) {
         .player-toolbar { padding: 8px 12px; }
         .toolbar-left { width: 100%; }
         .player-viewer-area { padding: 12px 0; }
         #flipbookContainerWrapper { padding: 0 12px; }
         .flip-nav-btn { width: 36px; height: 36px; }
      }
      @media (max-width: 991.98px) {
         .gitiho-main-pane { flex-direction: column; overflow-y: auto; }
         .gitiho-player-container { flex: 0 0 auto; height: 70vh; height: 70dvh; min-height: 360px; }
         .gitiho-course-panel { flex: 0 0 auto; height: auto; border-left: 0; border-top: 1px solid #e5e5e5; }
         .gitiho-tab-content { overflow-y: visible; }
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
         <!-- Active Learning Presence & Time Tracker -->
         <div class="learning-tracker-box">
            <div class="tracker-status-indicator" id="trackerIndicator" title="Trạng thái theo dõi thời gian học thực tế">
               <span class="status-dot"></span>
               <span id="trackerStatusText">Đang học</span>
            </div>
            <div class="tracker-time-display" title="Tổng thời gian bạn đã thực sự học bài này">
               <i class="fa-regular fa-clock me-1 text-danger"></i>
               <span id="studyTimeCounter">00:00:00</span>
            </div>
         </div>

         <!-- Course Progress -->
         <div class="progress-ring-box" title="Tiến trình học tập">
            <div class="progress-circle" id="progressCircle">{{ $userHistory->progress_percent ?? 0 }}%</div>
            <div class="progress-text d-none d-sm-block">
               <div style="font-size: 12.5px; font-weight: 700; color: #1a1a1a; line-height: 1.2;">Tiến độ</div>
               <div style="font-size: 11px; color: #64748b;" id="progressSubtext">
                  Trang {{ $userHistory->current_page ?? 1 }}
               </div>
            </div>
         </div>
      </div>
   </header>

   <!-- Main Fullwidth Workspace (No Sidebar) -->
   <div class="gitiho-workspace">

      <!-- Left lesson viewer and right course tabs -->
      <div class="gitiho-main-pane" id="mainPaneArea">
         
         <!-- PDF / 3D Book Flipbook Viewer Area -->
         <div class="gitiho-player-container" id="lessonPlayer">
            
            <!-- Toolbar control -->
            <div class="player-toolbar">
               <div class="toolbar-left">
                  <span class="badge bg-danger px-3 py-2" style="font-size: 13px;">
                     <i class="fa-solid fa-display me-1"></i> Trình chiếu Slide
                  </span>
                  <span class="text-white-50 ms-2 d-none d-md-inline" style="font-size: 13.5px;">
                     Dùng phím mũi tên ← → hoặc click hai bên để đổi slide
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
                  <button class="btn-toolbar-icon" id="btnZoomOut" title="Thu nhỏ (-)">
                     <i class="fa-solid fa-minus"></i>
                  </button>
                  <button class="btn-toolbar-icon" id="btnZoomReset" title="Vừa màn hình (100%)" style="font-size: 12px; font-weight: 600; width: auto; padding: 0 10px;">
                     100%
                  </button>
                  <button class="btn-toolbar-icon" id="btnZoomIn" title="Phóng to (+)">
                     <i class="fa-solid fa-plus"></i>
                  </button>
                  <button class="btn-toolbar-icon" id="btnFullscreen" title="Mở toàn màn hình (F)">
                     <i class="fa-solid fa-expand"></i>
                  </button>
               </div>
            </div>

            <!-- Viewer Body Area -->
            <div class="player-viewer-area" id="viewerArea">
               
               <!-- 1. Loading Overlay -->
               <div class="flipbook-loading" id="flipbookLoading">
                  <div class="spinner-book"></div>
                  <h5 class="mb-2" style="font-weight: 700;">Đang mở bài giảng...</h5>
                  <p class="loading-text text-white-50 mb-0" style="font-size: 13.5px;">Vui lòng đợi trong giây lát</p>
               </div>

               <!-- 2. Slide E-Learning Mode Container -->
               <div id="slideViewerWrapper">
                  <button id="floatingPrevBtn" class="flip-nav-btn flip-prev" title="Slide trước (←)">
                     <i class="fa-solid fa-chevron-left"></i>
                  </button>

                  <!-- Main Slide Stage with Canvas -->
                  <div id="slideStage" class="slide-stage" title="Click nửa phải để xem tiếp, nửa trái để lùi lại">
                     <canvas id="slideCanvas"></canvas>
                  </div>

                  <button id="floatingNextBtn" class="flip-nav-btn flip-next" title="Slide tiếp theo (→)">
                     <i class="fa-solid fa-chevron-right"></i>
                  </button>

                  <!-- Bottom Reading Progress Bar -->
                  <div class="slide-progress-container">
                     <div class="slide-progress-bar" id="slideProgressBar"></div>
                  </div>
               </div>

               <!-- 3. Scroll Mode Container (iframe fallback) -->
               <div id="scrollModeContainer">
                  @if ($post->pdf_url)
                  <iframe id="pdfViewerFrame" src="{{ $post->pdf_url }}#toolbar=1&view=FitH" allowfullscreen>
                     <div class="p-5 text-center bg-white" style="height: 100%;">
                        <h5 class="text-danger mb-3">Trình duyệt không hỗ trợ xem trực tiếp PDF</h5>
                        <p class="mb-4">Vui lòng tải tài liệu để xem trên thiết bị của bạn.</p>
                        <a href="{{ $post->pdf_url }}" download class="btn btn-success">Tải tài liệu PDF ngay</a>
                     </div>
                  </iframe>
                  @endif
               </div>

            </div>
         </div>

         <aside class="gitiho-course-panel" aria-label="Thông tin khóa học">
         <!-- Course tabs at the top of the right panel -->
         <div class="gitiho-tabs-nav">
            <ul class="nav nav-tabs" id="learnTabs" role="tablist">
               <!-- 1. BÀI TEST (ĐẦU TIÊN & ACTIVE) -->
               <li class="nav-item" role="presentation">
                  <button class="nav-link active" id="tests-tab" data-bs-toggle="tab" data-bs-target="#tab-tests" type="button" role="tab" aria-selected="true">
                     <i class="fa-solid fa-clipboard-check me-1"></i> Làm bài test
                     @php 
                        $courseTestsList = $courseTests ?? collect(); 
                        $generalTestsList = $generalTests ?? collect(); 
                        $totalTestsCount = $courseTestsList->count() + $generalTestsList->count();
                     @endphp
                     @if($totalTestsCount > 0)
                        <span class="badge rounded-pill bg-danger ms-1" style="font-size: 10px; padding: 2px 6px;">{{ $totalTestsCount }}</span>
                     @endif
                  </button>
               </li>
               <!-- 2. NỘI DUNG KHÓA HỌC -->
               <li class="nav-item" role="presentation">
                  <button class="nav-link" id="overview-tab" data-bs-toggle="tab" data-bs-target="#tab-overview" type="button" role="tab" aria-selected="false">
                     Nội dung khóa học
                  </button>
               </li>
               <!-- 3. HỎI ĐÁP -->
               <li class="nav-item" role="presentation">
                  <button class="nav-link" id="qa-tab" data-bs-toggle="tab" data-bs-target="#tab-qa" type="button" role="tab" aria-selected="false">
                     Hỏi đáp
                  </button>
               </li>
            </ul>
         </div>

         <!-- Tab Contents -->
         <div class="gitiho-tab-content">
            <div class="tab-content">

               <!-- 1. TỔNG QUAN -->
               <!-- 4. LÀM BÀI TEST (BÀI KIỂM TRA CHUNG & RIÊNG) -->
               <div class="tab-pane fade show active" id="tab-tests" role="tabpanel">
                  @php
                     $courseTestsList = $courseTests ?? collect();
                     $generalTestsList = $generalTests ?? collect();
                     $resultsMap = $userTestResults ?? collect();
                  @endphp

                  <!-- Header giới thiệu -->
                  <div class="mb-3 pb-2 border-bottom">
                     <h6 class="fw-bold mb-1" style="font-size: 14.5px; color: #1e293b;">
                        <i class="fa-solid fa-graduation-cap text-danger me-1"></i> Kiểm tra & Đánh giá năng lực
                     </h6>
                     <p class="text-muted mb-0" style="font-size: 12px;">
                        Hoàn thành bài kiểm tra để củng cố kiến thức và xác nhận kết quả học tập.
                     </p>
                  </div>

                  <!-- PHẦN 1: BÀI TEST RIÊNG CỦA KHÓA HỌC (LÀM NỔI BẬT) -->
                  <div class="mb-4">
                     <div class="d-flex align-items-center justify-content-between mb-2">
                        <span class="fw-bold" style="font-size: 13px; color: #03594e;">
                           <i class="fa-solid fa-star text-warning me-1"></i> BÀI TEST RIÊNG CỦA KHÓA HỌC
                        </span>
                        @if($courseTestsList->isNotEmpty())
                           <span class="badge" style="background: rgba(3, 89, 78, 0.12); color: #03594e; font-size: 11px;">
                              {{ $courseTestsList->count() }} bài
                           </span>
                        @endif
                     </div>

                     @if($courseTestsList->isNotEmpty())
                        @foreach($courseTestsList as $cTest)
                           @php $res = $resultsMap->get($cTest->id); @endphp
                           <div class="course-test-highlight-card">
                              <div class="d-flex justify-content-between align-items-start mb-2 gap-2">
                                 <div>
                                    <span class="badge text-white mb-2" style="background: #03594e; font-size: 11px; padding: 4px 8px; border-radius: 4px;">
                                       <i class="fa-solid fa-certificate me-1"></i> Đề thi trọng tâm khóa học
                                    </span>
                                    <h6 class="fw-bold mb-1" style="font-size: 14px; color: #0f172a; line-height: 1.35;">
                                       <a href="{{ route('frontend.tests.show', $cTest->id) }}" class="text-decoration-none text-dark hover-primary">
                                          {{ $cTest->title }}
                                       </a>
                                    </h6>
                                 </div>
                              </div>

                              <div class="d-flex flex-wrap align-items-center gap-2 mb-3">
                                 <span class="test-meta-badge">
                                    <i class="fa-regular fa-clipboard-question text-primary"></i> {{ $cTest->questions_count }} câu hỏi
                                 </span>
                                 <span class="test-meta-badge">
                                    <i class="fa-regular fa-stopwatch text-danger"></i> {{ $cTest->duration ? $cTest->duration . ' phút' : 'Không giới hạn' }}
                                 </span>
                                 <span class="test-meta-badge">
                                    <i class="fa-regular fa-bullseye-arrow text-success"></i> Yêu cầu đạt: {{ $cTest->pass_score }}/{{ $cTest->questions_count }} câu
                                 </span>
                              </div>

                              @if($res)
                                 @if($res['is_passed'])
                                    <div class="alert alert-success py-2 px-3 mb-3 d-flex justify-content-between align-items-center" style="font-size: 12px; border-radius: 8px;">
                                       <span><i class="fa-solid fa-circle-check text-success me-1"></i> <strong>ĐÃ ĐẠT:</strong> {{ $res['max_score'] }}/{{ $cTest->questions_count }} câu</span>
                                       <span class="text-muted" style="font-size: 11px;">(Đã làm {{ $res['attempts'] }} lần)</span>
                                    </div>
                                 @else
                                    <div class="alert alert-warning py-2 px-3 mb-3 d-flex justify-content-between align-items-center" style="font-size: 12px; border-radius: 8px;">
                                       <span><i class="fa-solid fa-triangle-exclamation text-warning me-1"></i> <strong>CHƯA ĐẠT:</strong> {{ $res['max_score'] }}/{{ $cTest->questions_count }} câu</span>
                                       <span class="text-muted" style="font-size: 11px;">(Cần đạt {{ $cTest->pass_score }}/{{ $cTest->questions_count }} câu)</span>
                                    </div>
                                 @endif
                              @else
                                 <div class="mb-3 text-muted" style="font-size: 12px;">
                                    <i class="fa-regular fa-circle-info me-1"></i> Bạn chưa thực hiện bài kiểm tra này.
                                 </div>
                              @endif

                              <a href="{{ route('frontend.tests.show', $cTest->id) }}" class="btn text-white w-100 fw-bold py-2 shadow-sm" style="background: linear-gradient(135deg, #03594e 0%, #057d6e 100%); border-radius: 8px; font-size: 13.5px;">
                                 <i class="fa-solid fa-pen-to-square me-1"></i> {{ $res ? 'Làm lại bài kiểm tra' : 'Bắt đầu làm bài test ngay' }} <i class="fa-solid fa-arrow-right ms-1"></i>
                              </a>
                           </div>
                        @endforeach
                     @else
                        <div class="p-3 rounded text-center mb-3" style="background: #f8fafc; border: 1px dashed #cbd5e1;">
                           <div class="text-muted mb-1" style="font-size: 12.5px;">
                              <i class="fa-regular fa-clipboard-list me-1"></i> Khóa học này chưa có bài test riêng.
                           </div>
                           <small class="text-muted" style="font-size: 11.5px;">
                              Vui lòng tham khảo các bài kiểm tra năng lực chung ở bên dưới.
                           </small>
                        </div>
                     @endif
                  </div>

                  <!-- PHẦN 2: BÀI TEST CHUNG NỘI BỘ (GENERAL TESTS) -->
                  <div>
                     <div class="d-flex align-items-center justify-content-between mb-2">
                        <span class="fw-bold" style="font-size: 13px; color: #334155;">
                           <i class="fa-solid fa-layer-group me-1 text-primary"></i> BÀI TEST ĐÁNH GIÁ CHUNG
                        </span>
                        @if($generalTestsList->isNotEmpty())
                           <span class="badge bg-secondary" style="font-size: 11px;">
                              {{ $generalTestsList->count() }} bài
                           </span>
                        @endif
                     </div>

                     @if($generalTestsList->isNotEmpty())
                        @foreach($generalTestsList as $gTest)
                           @php $gRes = $resultsMap->get($gTest->id); @endphp
                           <div class="general-test-card">
                              <div class="d-flex justify-content-between align-items-start gap-2 mb-2">
                                 <h6 class="fw-bold mb-0" style="font-size: 13px; color: #1e293b; line-height: 1.35;">
                                    <a href="{{ route('frontend.tests.show', $gTest->id) }}" class="text-decoration-none text-dark hover-primary">
                                       {{ $gTest->title }}
                                    </a>
                                 </h6>
                                 @if($gRes)
                                    @if($gRes['is_passed'])
                                       <span class="badge bg-success" style="font-size: 10.5px; flex-shrink: 0;">
                                          <i class="fa-solid fa-check me-1"></i> Đạt ({{ $gRes['max_score'] }}/{{ $gTest->questions_count }} câu)
                                       </span>
                                    @else
                                       <span class="badge bg-warning text-dark" style="font-size: 10.5px; flex-shrink: 0;">
                                          Chưa đạt ({{ $gRes['max_score'] }}/{{ $gTest->questions_count }} câu)
                                       </span>
                                    @endif
                                 @endif
                              </div>

                              <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mt-2 pt-2 border-top">
                                 <div class="d-flex align-items-center gap-2" style="font-size: 11.5px; color: #64748b;">
                                    <span><i class="fa-regular fa-clipboard-question me-1"></i> {{ $gTest->questions_count }} câu</span>
                                    <span>•</span>
                                    <span><i class="fa-regular fa-clock me-1"></i> {{ $gTest->duration ? $gTest->duration . 'p' : 'Tự do' }}</span>
                                    <span>•</span>
                                    <span><i class="fa-regular fa-bullseye me-1"></i> Đạt: {{ $gTest->pass_score }}/{{ $gTest->questions_count }} câu</span>
                                 </div>
                                 <a href="{{ route('frontend.tests.show', $gTest->id) }}" class="btn btn-sm btn-outline-primary px-3 py-1" style="font-size: 12px; font-weight: 600; border-radius: 6px;">
                                    {{ $gRes ? 'Làm lại' : 'Vào thi' }} <i class="fa-solid fa-angle-right ms-1"></i>
                                 </a>
                              </div>
                           </div>
                        @endforeach
                     @else
                        <div class="p-3 rounded text-center text-muted" style="background: #f8fafc; font-size: 12px;">
                           Hiện chưa có bài kiểm tra chung nào.
                        </div>
                     @endif
                  </div>
               </div>

               <div class="tab-pane fade" id="tab-overview" role="tabpanel">
                  @include('frontend.partials.course-curriculum')
               </div>

               <div class="tab-pane fade" id="tab-qa" role="tabpanel"></div>
               <div class="tab-pane fade" id="tab-articles" role="tabpanel">
                  @if ($post->pdf_url)
                     <a href="{{ $post->pdf_url }}" download class="btn btn-outline-danger">
                        <i class="fa-solid fa-download me-1"></i> {{ basename($post->pdf_file) }}
                     </a>
                  @endif
               </div>
               <div class="tab-pane fade" id="tab-cert" role="tabpanel"></div>

            </div>
         </div>
         </aside>
      </div>

   </div>

   <!-- JS Libraries -->
   <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
   <!-- PDF.js CDN for E-Learning Slide Viewer -->
   <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"></script>

   <script>
      // ========================================================
      // TRÌNH CHIẾU SLIDE E-LEARNING SIÊU TỐC & THEO DÕI HỌC TẬP
      // ========================================================
      let pdfDoc = null;
      let currentPage = {{ (int) ($userHistory->current_page ?? 1) }};
      let totalPagesCount = {{ (int) ($userHistory->total_pages ?? 1) }};
      let currentZoom = 1.0;
      let isRendering = false;
      let pendingPageNum = null;
      let currentRenderTask = null;
      const pageCache = new Map();

      // Dữ liệu tiến trình học
      const initialStudySeconds = {{ (int) ($userHistory->study_time_seconds ?? 0) }};
      const initialCurrentPage = {{ (int) ($userHistory->current_page ?? 1) }};
      let currentProgressPercent = {{ (int) ($userHistory->progress_percent ?? 0) }};
      let maxPageVisited = Math.max(initialCurrentPage, 1);

      const pdfUrl = @json($post->pdf_url);
      const trackApiUrl = "{{ route('api.course.track-learning', $post->slug) }}";
      const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || "{{ csrf_token() }}";

      const loadingEl = document.getElementById('flipbookLoading');
      const slideWrapper = document.getElementById('slideViewerWrapper');
      const slideStage = document.getElementById('slideStage');
      const slideCanvas = document.getElementById('slideCanvas');
      const slideCtx = slideCanvas.getContext('2d');
      const scrollWrapper = document.getElementById('scrollModeContainer');

      const pageNumInput = document.getElementById('pageNumInput');
      const totalPagesText = document.getElementById('totalPagesText');
      const progressBar = document.getElementById('slideProgressBar');
      const btnPrev = document.getElementById('btnPrevPage');
      const btnNext = document.getElementById('btnNextPage');
      const floatPrev = document.getElementById('floatingPrevBtn');
      const floatNext = document.getElementById('floatingNextBtn');
      const btnZoomIn = document.getElementById('btnZoomIn');
      const btnZoomOut = document.getElementById('btnZoomOut');
      const btnZoomReset = document.getElementById('btnZoomReset');
      const btnFullscreen = document.getElementById('btnFullscreen');

      // Tracker Elements
      const trackerIndicator = document.getElementById('trackerIndicator');
      const trackerStatusText = document.getElementById('trackerStatusText');
      const studyTimeCounter = document.getElementById('studyTimeCounter');
      const progressCircle = document.getElementById('progressCircle');
      const progressSubtext = document.getElementById('progressSubtext');

      // ========================================================
      // 1. KIỂM TRA HIỆN DIỆN & TÍNH THỜI GIAN HỌC THỰC TẾ
      // ========================================================
      let totalStudySeconds = initialStudySeconds;
      let unsavedActiveSeconds = 0;
      let lastUserActivity = Date.now();
      let isUserActive = true;
      const IDLE_LIMIT_MS = 120000; // 2 phút không có tương tác chuột/phím -> Tạm dừng

      function formatStudyTime(totalSec) {
         const h = Math.floor(totalSec / 3600);
         const m = Math.floor((totalSec % 3600) / 60);
         const s = totalSec % 60;
         const pad = (n) => String(n).padStart(2, '0');
         return (h > 0 ? pad(h) + ':' : '') + pad(m) + ':' + pad(s);
      }

      studyTimeCounter.innerText = formatStudyTime(totalStudySeconds);

      // Lắng nghe tương tác của người dùng
      function onUserActivity() {
         lastUserActivity = Date.now();
      }
      ['mousemove', 'mousedown', 'keydown', 'touchstart', 'scroll', 'click'].forEach(evt => {
         window.addEventListener(evt, onUserActivity, { passive: true });
      });

      // Vòng lặp đếm giờ mỗi giây
      setInterval(() => {
         const isVisible = (document.visibilityState === 'visible');
         const isNotIdle = (Date.now() - lastUserActivity < IDLE_LIMIT_MS);

         if (isVisible && isNotIdle) {
            isUserActive = true;
            totalStudySeconds++;
            unsavedActiveSeconds++;

            if (trackerIndicator) trackerIndicator.classList.remove('paused');
            if (trackerStatusText) trackerStatusText.innerText = 'Đang học';
         } else {
            isUserActive = false;
            if (trackerIndicator) trackerIndicator.classList.add('paused');
            if (trackerStatusText) {
               if (!isVisible) {
                  trackerStatusText.innerText = 'Tạm dừng (Rời tab)';
               } else {
                  trackerStatusText.innerText = 'Tạm dừng (Treo máy)';
               }
            }
         }

         if (studyTimeCounter) {
            studyTimeCounter.innerText = formatStudyTime(totalStudySeconds);
         }
      }, 1000);

      // ========================================================
      // 2. ĐỒNG BỘ DỮ LIỆU TIẾN ĐỘ & THỜI GIAN VÀO DATABASE
      // ========================================================
      function syncLearningProgress(isBeacon = false) {
         if (unsavedActiveSeconds <= 0 && !isBeacon) return;

         const payload = {
            active_seconds: unsavedActiveSeconds,
            current_page: currentPage,
            total_pages: totalPagesCount,
            progress_percent: currentProgressPercent,
            _token: csrfToken
         };

         if (isBeacon && navigator.sendBeacon) {
            const formData = new FormData();
            for (const key in payload) {
               formData.append(key, payload[key]);
            }
            navigator.sendBeacon(trackApiUrl, formData);
            unsavedActiveSeconds = 0;
            return;
         }

         const secondsToSend = unsavedActiveSeconds;
         fetch(trackApiUrl, {
            method: 'POST',
            headers: {
               'Content-Type': 'application/json',
               'X-CSRF-TOKEN': csrfToken,
               'Accept': 'application/json'
            },
            body: JSON.stringify(payload)
         })
         .then(res => res.json())
         .then(data => {
            if (data && data.success) {
               unsavedActiveSeconds = Math.max(0, unsavedActiveSeconds - secondsToSend);
            }
         })
         .catch(err => {
            console.warn("Lỗi lưu tiến trình học:", err);
         });
      }

      // Tự động lưu định kỳ mỗi 15 giây
      setInterval(() => {
         syncLearningProgress();
      }, 15000);

      // Lưu khi rời khỏi tab hoặc đóng trình duyệt
      document.addEventListener('visibilitychange', () => {
         if (document.visibilityState === 'hidden') {
            syncLearningProgress(true);
         }
      });
      window.addEventListener('beforeunload', () => {
         syncLearningProgress(true);
      });

      // Cập nhật hiển thị tiến trình học
      function updateProgressUi(pageNum) {
         maxPageVisited = Math.max(maxPageVisited, pageNum);
         if (totalPagesCount > 0) {
            const calculated = Math.round((maxPageVisited / totalPagesCount) * 100);
            currentProgressPercent = Math.max(currentProgressPercent, calculated);
         }

         if (progressCircle) {
            progressCircle.innerText = currentProgressPercent + '%';
            if (currentProgressPercent >= 100) {
               progressCircle.classList.add('completed');
            }
         }
         if (progressSubtext) {
            progressSubtext.innerText = 'Trang ' + pageNum + ' / ' + totalPagesCount;
         }
      }

      // ========================================================
      // 3. KHỞI TẠO & RENDER SLIDE (PDF.JS + CACHE)
      // ========================================================
      async function initSlideViewer() {
         if (!pdfUrl) {
            if (loadingEl) loadingEl.style.display = 'none';
            if (slideWrapper) slideWrapper.style.display = 'none';
            const toolbar = document.querySelector('.player-toolbar');
            if (toolbar) toolbar.style.display = 'none';
            return;
         }

         try {
            if (typeof pdfjsLib === 'undefined') {
               throw new Error("Thư viện PDF.js chưa tải thành công");
            }

            pdfjsLib.GlobalWorkerOptions.workerSrc = "https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js";

            const loadingTask = pdfjsLib.getDocument(pdfUrl);
            pdfDoc = await loadingTask.promise;
            totalPagesCount = pdfDoc.numPages;
            if (totalPagesText) totalPagesText.innerText = totalPagesCount;
            if (pageNumInput) {
               pageNumInput.max = totalPagesCount;
            }

            // Tự động nhảy đến slide học dở lần trước (nếu có)
            let startPage = initialCurrentPage;
            if (startPage < 1 || startPage > totalPagesCount) startPage = 1;

            updateProgressUi(startPage);
            await renderSlide(startPage);

         } catch (err) {
            console.warn("Chuyển sang chế độ cuộn do lỗi tải Slide:", err);
            if (loadingEl) loadingEl.style.display = 'none';
            switchToScrollMode();
         }
      }

      async function renderSlide(num) {
         if (num < 1) num = 1;
         if (num > totalPagesCount) num = totalPagesCount;

         if (isRendering) {
            pendingPageNum = num;
            if (currentRenderTask && typeof currentRenderTask.cancel === 'function') {
               try { currentRenderTask.cancel(); } catch (e) {}
            }
            return;
         }

         isRendering = true;
         currentPage = num;

         // Cập nhật UI
         if (pageNumInput) pageNumInput.value = num;
         if (btnPrev) btnPrev.disabled = (num <= 1);
         if (floatPrev) floatPrev.disabled = (num <= 1);
         if (btnNext) btnNext.disabled = (num >= totalPagesCount);
         if (floatNext) floatNext.disabled = (num >= totalPagesCount);
         if (progressBar) progressBar.style.width = ((num / totalPagesCount) * 100) + '%';

         updateProgressUi(num);

         // 1. Kiểm tra nếu trang đã có trong Cache -> 0ms
         if (pageCache.has(num)) {
            const cached = pageCache.get(num);
            slideCanvas.width = cached.width;
            slideCanvas.height = cached.height;
            slideCanvas.style.width = cached.cssW;
            slideCanvas.style.height = cached.cssH;
            slideCtx.clearRect(0, 0, cached.width, cached.height);
            slideCtx.drawImage(cached.canvas, 0, 0);

            slideStage.style.opacity = '1';
            if (loadingEl && loadingEl.style.display !== 'none') {
               loadingEl.style.display = 'none';
            }
            isRendering = false;

            preloadAdjacentSlides(num);
            syncLearningProgress();
            return;
         }

         // 2. Nếu chưa có -> Render từ PDF.js
         try {
            const page = await pdfDoc.getPage(num);

            const style = getComputedStyle(slideWrapper);
            const padX = parseFloat(style.paddingLeft || 0) + parseFloat(style.paddingRight || 0) + 30;
            const padY = parseFloat(style.paddingTop || 0) + parseFloat(style.paddingBottom || 0) + 30;

            const availW = Math.max(250, slideWrapper.clientWidth - padX);
            const availH = Math.max(250, slideWrapper.clientHeight - padY);

            const unscaledViewport = page.getViewport({ scale: 1 });
            const pageRatio = unscaledViewport.height / unscaledViewport.width;

            let fitW = Math.min(availW, availH / pageRatio) * currentZoom;
            let fitH = fitW * pageRatio;

            const dpr = Math.min(window.devicePixelRatio || 1, 2);
            const canvasW = Math.round(fitW * dpr);
            const canvasH = Math.round(fitH * dpr);

            slideCanvas.width = canvasW;
            slideCanvas.height = canvasH;
            slideCanvas.style.width = Math.round(fitW) + 'px';
            slideCanvas.style.height = Math.round(fitH) + 'px';

            const renderViewport = page.getViewport({ scale: canvasW / unscaledViewport.width });
            currentRenderTask = page.render({
               canvasContext: slideCtx,
               viewport: renderViewport
            });

            await currentRenderTask.promise;
            currentRenderTask = null;

            // Lưu Cache
            const offscreen = document.createElement('canvas');
            offscreen.width = canvasW;
            offscreen.height = canvasH;
            const offCtx = offscreen.getContext('2d');
            offCtx.drawImage(slideCanvas, 0, 0);

            pageCache.set(num, {
               canvas: offscreen,
               width: canvasW,
               height: canvasH,
               cssW: Math.round(fitW) + 'px',
               cssH: Math.round(fitH) + 'px'
            });

            if (pageCache.size > 15) {
               const oldest = pageCache.keys().next().value;
               pageCache.delete(oldest);
            }

            slideStage.style.opacity = '1';
            if (loadingEl && loadingEl.style.display !== 'none') {
               loadingEl.style.display = 'none';
            }

            syncLearningProgress();

         } catch (err) {
            if (err?.name !== 'RenderingCancelledException') {
               console.warn("Lỗi vẽ slide " + num + ":", err);
            }
         } finally {
            isRendering = false;
            if (pendingPageNum !== null) {
               const next = pendingPageNum;
               pendingPageNum = null;
               renderSlide(next);
            } else {
               preloadAdjacentSlides(num);
            }
         }
      }

      async function preloadAdjacentSlides(current) {
         if (!pdfDoc) return;
         const targets = [current + 1, current - 1].filter(n => n >= 1 && n <= totalPagesCount && !pageCache.has(n));
         for (const n of targets) {
            try {
               const page = await pdfDoc.getPage(n);
               const style = getComputedStyle(slideWrapper);
               const padX = parseFloat(style.paddingLeft || 0) + parseFloat(style.paddingRight || 0) + 30;
               const padY = parseFloat(style.paddingTop || 0) + parseFloat(style.paddingBottom || 0) + 30;
               const availW = Math.max(250, slideWrapper.clientWidth - padX);
               const availH = Math.max(250, slideWrapper.clientHeight - padY);
               const unscaledViewport = page.getViewport({ scale: 1 });
               const pageRatio = unscaledViewport.height / unscaledViewport.width;

               let fitW = Math.min(availW, availH / pageRatio) * currentZoom;
               let fitH = fitW * pageRatio;
               const dpr = Math.min(window.devicePixelRatio || 1, 2);
               const canvasW = Math.round(fitW * dpr);
               const canvasH = Math.round(fitH * dpr);

               const offscreen = document.createElement('canvas');
               offscreen.width = canvasW;
               offscreen.height = canvasH;
               const offCtx = offscreen.getContext('2d');

               const renderViewport = page.getViewport({ scale: canvasW / unscaledViewport.width });
               await page.render({
                  canvasContext: offCtx,
                  viewport: renderViewport
               }).promise;

               pageCache.set(n, {
                  canvas: offscreen,
                  width: canvasW,
                  height: canvasH,
                  cssW: Math.round(fitW) + 'px',
                  cssH: Math.round(fitH) + 'px'
               });
            } catch (e) {}
         }
      }

      function prevSlide() {
         if (currentPage > 1) {
            slideStage.style.opacity = '0.7';
            renderSlide(currentPage - 1);
         }
      }

      function nextSlide() {
         if (currentPage < totalPagesCount) {
            slideStage.style.opacity = '0.7';
            renderSlide(currentPage + 1);
         }
      }

      btnPrev?.addEventListener('click', prevSlide);
      floatPrev?.addEventListener('click', prevSlide);
      btnNext?.addEventListener('click', nextSlide);
      floatNext?.addEventListener('click', nextSlide);

      slideStage?.addEventListener('click', (e) => {
         const rect = slideStage.getBoundingClientRect();
         const clickX = e.clientX - rect.left;
         if (clickX > rect.width * 0.5) {
            nextSlide();
         } else {
            prevSlide();
         }
      });

      pageNumInput?.addEventListener('change', (e) => {
         let target = parseInt(e.target.value) || 1;
         if (target < 1) target = 1;
         if (target > totalPagesCount) target = totalPagesCount;
         renderSlide(target);
      });

      document.addEventListener('keydown', (e) => {
         if (document.activeElement.tagName === 'INPUT' || document.activeElement.tagName === 'TEXTAREA') return;
         if (e.key === 'ArrowLeft' || e.key === 'PageUp') {
            e.preventDefault();
            prevSlide();
         } else if (e.key === 'ArrowRight' || e.key === 'PageDown' || e.key === ' ') {
            e.preventDefault();
            nextSlide();
         } else if (e.key === 'Home') {
            e.preventDefault();
            renderSlide(1);
         } else if (e.key === 'End') {
            e.preventDefault();
            renderSlide(totalPagesCount);
         } else if (e.key === 'f' || e.key === 'F') {
            btnFullscreen?.click();
         }
      });

      let touchStartX = 0;
      let touchStartY = 0;
      slideWrapper?.addEventListener('touchstart', (e) => {
         touchStartX = e.changedTouches[0].screenX;
         touchStartY = e.changedTouches[0].screenY;
      }, { passive: true });

      slideWrapper?.addEventListener('touchend', (e) => {
         const diffX = e.changedTouches[0].screenX - touchStartX;
         const diffY = e.changedTouches[0].screenY - touchStartY;
         if (Math.abs(diffX) > 40 && Math.abs(diffX) > Math.abs(diffY)) {
            if (diffX > 0) prevSlide();
            else nextSlide();
         }
      }, { passive: true });

      function updateZoomText() {
         if (btnZoomReset) btnZoomReset.innerText = Math.round(currentZoom * 100) + '%';
      }

      btnZoomIn?.addEventListener('click', () => {
         if (currentZoom < 2.2) {
            currentZoom = Math.min(2.2, +(currentZoom + 0.15).toFixed(2));
            updateZoomText();
            pageCache.clear();
            renderSlide(currentPage);
         }
      });

      btnZoomOut?.addEventListener('click', () => {
         if (currentZoom > 0.6) {
            currentZoom = Math.max(0.6, +(currentZoom - 0.15).toFixed(2));
            updateZoomText();
            pageCache.clear();
            renderSlide(currentPage);
         }
      });

      btnZoomReset?.addEventListener('click', () => {
         if (currentZoom !== 1.0) {
            currentZoom = 1.0;
            updateZoomText();
            pageCache.clear();
            renderSlide(currentPage);
         }
      });

      btnFullscreen?.addEventListener('click', () => {
         const elem = document.getElementById('lessonPlayer');
         if (!document.fullscreenElement) {
            if (elem.requestFullscreen) elem.requestFullscreen();
            else if (elem.webkitRequestFullscreen) elem.webkitRequestFullscreen();
            else if (elem.msRequestFullscreen) elem.msRequestFullscreen();
         } else {
            if (document.exitFullscreen) document.exitFullscreen();
         }
      });

      let resizeTimer = null;
      const resizeObserver = new ResizeObserver(() => {
         clearTimeout(resizeTimer);
         resizeTimer = setTimeout(() => {
            if (pdfDoc) {
               pageCache.clear();
               renderSlide(currentPage);
            }
         }, 120);
      });
      if (slideWrapper) resizeObserver.observe(slideWrapper);

      function switchToScrollMode() {
         if (scrollWrapper) scrollWrapper.style.display = 'block';
         if (slideWrapper) slideWrapper.style.display = 'none';
      }

      window.addEventListener('DOMContentLoaded', () => {
         initSlideViewer();
      });
   </script>
</body>
</html>
