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
   <link rel="stylesheet" href="{{ asset('assets/css/course-curriculum.css') }}">
   <link rel="stylesheet" href="{{ asset('assets/css/course-custom.css') }}">

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
                     <i class="fa-solid fa-book-open me-1"></i> Sách lật 3D (Từng trang)
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
               <li class="nav-item" role="presentation">
                  <button class="nav-link active" id="overview-tab" data-bs-toggle="tab" data-bs-target="#tab-overview" type="button" role="tab">
                     Nội dung
                  </button>
               </li>
               <li class="nav-item" role="presentation">
                  <button class="nav-link" id="qa-tab" data-bs-toggle="tab" data-bs-target="#tab-qa" type="button" role="tab">
                     Hỏi đáp
                  </button>
               </li>
               <!-- <li class="nav-item" role="presentation">
                  <button class="nav-link" id="articles-tab" data-bs-toggle="tab" data-bs-target="#tab-articles" type="button" role="tab">
                     Tài liệu
                  </button>
               </li> -->
               <li class="nav-item" role="presentation">
                  <button class="nav-link" id="reviews-tab" data-bs-toggle="tab" data-bs-target="#tab-reviews" type="button" role="tab">
                     Đánh giá
                  </button>
               </li>
               <!-- <li class="nav-item" role="presentation">
                  <button class="nav-link" id="cert-tab" data-bs-toggle="tab" data-bs-target="#tab-cert" type="button" role="tab">
                     Tải chứng nhận
                  </button>
               </li> -->
            </ul>
         </div>

         <!-- Tab Contents -->
         <div class="gitiho-tab-content">
            <div class="tab-content">

               <!-- 1. TỔNG QUAN -->
               <div class="tab-pane fade show active" id="tab-overview" role="tabpanel">
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
               <div class="tab-pane fade" id="tab-reviews" role="tabpanel"></div>
               <div class="tab-pane fade" id="tab-cert" role="tabpanel"></div>

            </div>
         </div>
         </aside>
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

      const pdfUrl = @json($post->pdf_url);
      const loadingEl = document.getElementById('flipbookLoading');
      const flipbookEl = document.getElementById('flipbook');
      const flipbookWrapper = document.getElementById('flipbookContainerWrapper');
      const scrollWrapper = document.getElementById('scrollModeContainer');

      const pageNumInput = document.getElementById('pageNumInput');
      const totalPagesText = document.getElementById('totalPagesText');

      async function initPdfFlipbook() {
         if (!pdfUrl) {
            loadingEl.style.display = 'none';
            flipbookWrapper.style.display = 'none';
            document.querySelector('.player-toolbar').style.display = 'none';
            return;
         }
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

            // Keep the host narrower than PageFlip's two-page breakpoint.
            // Size one page from the actual reading area, including in fullscreen.
            const maxPageWidth = 2400;
            function resizeBook() {
               const style = getComputedStyle(flipbookWrapper);
               const availableWidth = flipbookWrapper.clientWidth - parseFloat(style.paddingLeft) - parseFloat(style.paddingRight);
               const availableHeight = flipbookWrapper.clientHeight - parseFloat(style.paddingTop) - parseFloat(style.paddingBottom);
               const pageWidth = Math.max(1, Math.floor(Math.min(availableWidth, availableHeight / pageRatio, maxPageWidth)));
               flipbookEl.style.width = pageWidth + 'px';
               flipbookEl.style.height = Math.max(1, Math.floor(pageWidth * pageRatio)) + 'px';
               if (flipBook) flipBook.update();
            }

            resizeBook();

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
               width: maxPageWidth,
               height: Math.round(maxPageWidth * pageRatio),
               size: "stretch",
               minWidth: maxPageWidth,
               maxWidth: maxPageWidth,
               minHeight: 1,
               maxHeight: Math.round(maxPageWidth * pageRatio),
               usePortrait: true,
               autoSize: false,
               maxShadowOpacity: 0.6,
               showCover: false,
               mobileScrollSupport: false,
               flippingTime: 650
            });

            flipBook.loadFromHTML(document.querySelectorAll('.flip-page'));
            // PageFlip sets this inline minimum when it loads the HTML pages.
            // Allow the host to shrink while retaining the single-page breakpoint.
            flipbookEl.style.minWidth = '0';
            resizeBook();
            const bookResizeObserver = new ResizeObserver(resizeBook);
            bookResizeObserver.observe(flipbookWrapper);

            flipBook.on("flip", (e) => {
               pageNumInput.value = (e.data + 1);
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
         const elem = document.getElementById('lessonPlayer');
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
