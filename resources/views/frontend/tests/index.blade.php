@extends('frontend.layouts.profile')

@section('title', 'Bài Kiểm Tra')
@section('page_title', 'Danh sách bài kiểm tra')

@section('breadcrumb')
   <li class="breadcrumb-item active">Bài kiểm tra</li>
@endsection

@section('page_actions')
   <span class="badge" style="background: rgba(3, 89, 78, 0.1); color: #03594e; font-weight: 700; font-size: 13.5px; padding: 7px 15px; border-radius: 999px;">
      <i class="fa-solid fa-layer-group me-1"></i> <strong id="visibleTestCount">{{ $tests->count() }}</strong> / {{ $tests->count() }} bài thi
   </span>
@endsection

@push('styles')
<style>
   /* Header & Filter Box */
   .tests-header-box {
      background: #ffffff;
      border: 1px solid #e9ebec;
      border-radius: 12px;
      padding: 20px 22px;
      box-shadow: 0 1px 3px rgba(15, 23, 42, 0.04);
      margin-bottom: 20px;
   }
   
   /* Search Bar */
   .tests-search-wrapper {
      position: relative;
      display: flex;
      align-items: center;
      width: 100%;
   }
   .tests-search-wrapper .search-icon {
      position: absolute;
      left: 14px;
      top: 50%;
      transform: translateY(-50%);
      font-size: 14px;
      color: #94a3b8;
      pointer-events: none;
      transition: color 0.2s;
      z-index: 2;
   }
   .tests-search-input {
      width: 100%;
      height: 42px;
      padding: 0 38px 0 38px;
      font-size: 13.5px;
      font-weight: 500;
      border-radius: 8px;
      border: 1.5px solid #e2e8f0;
      background-color: #f8fafc;
      color: #1e293b;
      transition: all 0.2s ease;
   }
   .tests-search-input:hover {
      background-color: #ffffff;
      border-color: #cbd5e1;
   }
   .tests-search-input:focus {
      background-color: #ffffff;
      border-color: #03594e;
      outline: none;
      box-shadow: 0 0 0 3px rgba(3, 89, 78, 0.12);
   }
   .search-clear-btn {
      position: absolute;
      right: 12px;
      top: 50%;
      transform: translateY(-50%);
      width: 22px;
      height: 22px;
      border: none;
      background: #e2e8f0;
      color: #64748b;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 11px;
      cursor: pointer;
      transition: all 0.2s;
      z-index: 2;
   }
   .search-clear-btn:hover {
      background: #cbd5e1;
      color: #0f172a;
   }

   /* Filter Selects */
   .tests-select-wrapper {
      position: relative;
      display: flex;
      align-items: center;
      width: 100%;
   }
   .tests-select-wrapper .select-icon {
      position: absolute;
      left: 14px;
      top: 50%;
      transform: translateY(-50%);
      font-size: 13px;
      color: #64748b;
      pointer-events: none;
      z-index: 3;
   }
   .tests-select-wrapper .nice-select {
      display: none !important;
   }
   .tests-filter-select {
      display: block !important;
      width: 100% !important;
      height: 42px !important;
      line-height: 42px !important;
      padding: 0 34px 0 38px !important;
      font-size: 13.5px !important;
      font-weight: 600 !important;
      border-radius: 8px !important;
      border: 1.5px solid #e2e8f0 !important;
      background-color: #f8fafc !important;
      color: #1e293b !important;
      cursor: pointer !important;
      transition: all 0.2s ease !important;
      background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%2364748b' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m2 5 6 6 6-6'/%3e%3c/svg%3e") !important;
      background-repeat: no-repeat !important;
      background-position: right 14px center !important;
      background-size: 11px 9px !important;
      -webkit-appearance: none !important;
      -moz-appearance: none !important;
      appearance: none !important;
      text-overflow: ellipsis;
      white-space: nowrap;
      overflow: hidden;
   }
   .tests-filter-select:hover {
      background-color: #ffffff !important;
      border-color: #cbd5e1 !important;
   }
   .tests-filter-select:focus {
      background-color: #ffffff !important;
      border-color: #03594e !important;
      outline: none !important;
      box-shadow: 0 0 0 3px rgba(3, 89, 78, 0.12) !important;
   }

   /* Test List Items */
   .tests-list-wrap {
      display: flex;
      flex-direction: column;
      gap: 12px;
   }
   .test-list-item {
      background: #ffffff;
      border: 1px solid #e9ebec;
      border-radius: 12px;
      padding: 14px 20px;
      box-shadow: 0 1px 3px rgba(15, 23, 42, 0.04);
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 16px;
      transition: all 0.2s ease;
      position: relative;
   }
   .test-list-item:hover {
      transform: translateY(-1px);
      box-shadow: 0 6px 18px -2px rgba(3, 89, 78, 0.1);
      border-color: rgba(3, 89, 78, 0.35);
   }
   .test-list-left {
      display: flex;
      align-items: center;
      gap: 14px;
      flex: 1;
      min-width: 0;
   }
   .test-list-icon {
      width: 44px;
      height: 44px;
      border-radius: 10px;
      background: #f0fdf4;
      color: #03594e;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 19px;
      flex-shrink: 0;
      border: 1px solid rgba(3, 89, 78, 0.15);
      transition: all 0.2s ease;
   }
   .test-list-item:hover .test-list-icon {
      background: #03594e;
      color: #ffffff;
   }
   .test-list-body {
      flex: 1;
      min-width: 0;
   }
   .test-line-1 {
      display: flex;
      align-items: center;
      gap: 8px;
      flex-wrap: wrap;
      margin-bottom: 4px;
      line-height: 1.35;
   }
   .test-list-title {
      font-size: 15px;
      font-weight: 700;
      color: #0f172a;
      margin: 0;
   }
   .test-list-title a {
      color: #0f172a;
      text-decoration: none;
      transition: color 0.2s;
   }
   .test-list-title a:hover {
      color: #03594e;
   }
   .badge-tag-general {
      display: inline-flex;
      align-items: center;
      gap: 4px;
      font-size: 11px;
      font-weight: 600;
      color: #03594e;
      background: rgba(3, 89, 78, 0.08);
      padding: 2px 8px;
      border-radius: 4px;
   }
   .badge-tag-topic {
      display: inline-flex;
      align-items: center;
      gap: 4px;
      font-size: 11px;
      font-weight: 600;
      color: #03594e;
      background: rgba(3, 89, 78, 0.08);
      border: 1px solid rgba(3, 89, 78, 0.18);
      padding: 2px 8px;
      border-radius: 4px;
      max-width: 220px;
      overflow: hidden;
      text-overflow: ellipsis;
      white-space: nowrap;
   }
   .badge-tag-course {
      display: inline-flex;
      align-items: center;
      gap: 4px;
      font-size: 11px;
      font-weight: 600;
      color: #2563eb;
      background: #eff6ff;
      padding: 2px 8px;
      border-radius: 4px;
      max-width: 280px;
      overflow: hidden;
      text-overflow: ellipsis;
      white-space: nowrap;
   }
   .badge-status {
      display: inline-flex;
      align-items: center;
      gap: 4px;
      font-size: 11px;
      font-weight: 700;
      padding: 2px 8px;
      border-radius: 4px;
   }
   .badge-status.status-not_taken {
      background: #f1f5f9;
      color: #64748b;
   }
   .badge-status.status-passed {
      background: #dcfce7;
      color: #15803d;
   }
   .badge-status.status-failed {
      background: #fee2e2;
      color: #b91c1c;
   }
   .badge-score-pill {
      display: inline-flex;
      align-items: center;
      gap: 4px;
      font-size: 11px;
      font-weight: 600;
      background: #fefce8;
      color: #854d0e;
      border: 1px solid #fef08a;
      padding: 1px 7px;
      border-radius: 4px;
   }
   .badge-attempts-pill {
      display: inline-flex;
      align-items: center;
      gap: 4px;
      font-size: 11px;
      font-weight: 500;
      background: #f8fafc;
      color: #64748b;
      border: 1px solid #e2e8f0;
      padding: 1px 7px;
      border-radius: 4px;
   }
   .test-line-2 {
      display: flex;
      align-items: center;
      gap: 8px;
      flex-wrap: wrap;
      font-size: 12.5px;
      color: #64748b;
      line-height: 1.35;
   }
   .test-line-2 .meta-item {
      display: inline-flex;
      align-items: center;
      gap: 5px;
   }
   .test-line-2 .meta-item strong {
      color: #334155;
   }
   .test-line-2 .meta-divider {
      color: #cbd5e1;
      font-size: 9px;
   }
   .test-list-action {
      display: flex;
      align-items: center;
      flex-shrink: 0;
   }
   .btn-test-action {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
      font-size: 13px;
      font-weight: 600;
      padding: 7px 18px;
      border-radius: 8px;
      text-decoration: none !important;
      transition: all 0.2s ease;
      white-space: nowrap;
   }
   .btn-test-action.btn-start {
      background: #03594e;
      color: #ffffff !important;
      border: 1.5px solid #03594e;
      box-shadow: 0 2px 6px rgba(3, 89, 78, 0.15);
   }
   .btn-test-action.btn-start:hover {
      background: #02433b;
      border-color: #02433b;
      transform: translateY(-1px);
      box-shadow: 0 4px 10px rgba(3, 89, 78, 0.25);
   }
   .btn-test-action.btn-retake {
      background: #f0fdf4;
      color: #03594e !important;
      border: 1.5px solid #03594e;
   }
   .btn-test-action.btn-retake:hover {
      background: #03594e;
      color: #ffffff !important;
      transform: translateY(-1px);
   }
   
   /* Empty State */
   .empty-test-card {
      background: #ffffff;
      border: 2px dashed #e2e8f0;
      border-radius: 12px;
      padding: 40px 20px;
      text-align: center;
   }
   .empty-icon-circle {
      width: 60px;
      height: 60px;
      border-radius: 50%;
      background: #f8fafc;
      border: 1px solid #e2e8f0;
      color: #94a3b8;
      font-size: 24px;
      display: inline-flex;
      align-items: center;
      justify-content: center;
   }

   @media (max-width: 991.98px) {
      .test-list-item {
         flex-direction: column;
         align-items: flex-start;
         gap: 14px;
         padding: 16px;
      }
      .test-list-left {
         width: 100%;
      }
      .test-list-action {
         width: 100%;
      }
      .btn-test-action {
         width: 100%;
      }
   }
</style>
@endpush

@section('content')
<!-- Header & Filter Card -->
<div class="tests-header-box">
   <div class="row g-2 align-items-center">
      <!-- 1. Ô Tìm Kiếm theo tên -->
      <div class="col-lg-5 col-md-12">
         <div class="tests-search-wrapper">
            <i class="fa-regular fa-magnifying-glass search-icon"></i>
            <input 
               type="text" 
               id="testSearchInput" 
               class="tests-search-input" 
               placeholder="Tìm kiếm bài kiểm tra theo tên..." 
               value="{{ $search ?? '' }}"
               autocomplete="off"
            >
            <button type="button" id="clearSearchBtn" class="search-clear-btn {{ empty($search) ? 'd-none' : '' }}" title="Xóa tìm kiếm">
               <i class="fa-solid fa-xmark"></i>
            </button>
         </div>
      </div>

      <!-- 2. Select Topic / Mục bài kiểm tra -->
      <div class="col-lg-4 col-md-6">
         <div class="tests-select-wrapper">
            <i class="fa-solid fa-layer-group select-icon"></i>
            <select id="topicFilterSelect" class="tests-filter-select">
               <option value="all">Tất cả Topic / Mục</option>
               @foreach($topics as $tp)
                  <option value="{{ $tp->id }}">
                     {{ $tp->name }}@if(isset($tp->tests_count) && $tp->tests_count > 0) ({{ $tp->tests_count }})@endif
                  </option>
               @endforeach
            </select>
         </div>
      </div>

      <!-- 3. Select Trạng thái làm bài -->
      <div class="col-lg-3 col-md-6">
         <div class="tests-select-wrapper">
            <i class="fa-solid fa-filter select-icon"></i>
            <select id="statusFilterSelect" class="tests-filter-select">
               <option value="all" id="optStatusAll">Tất cả trạng thái ({{ $tests->count() }})</option>
               <option value="not_taken" id="optStatusNotTaken">Chưa làm (0)</option>
               <option value="passed" id="optStatusPassed">Đã đạt (0)</option>
               <option value="failed" id="optStatusFailed">Chưa đạt (0)</option>
            </select>
         </div>
      </div>
   </div>
</div>

<!-- Tests List Container -->
@if($tests->count() > 0)
   <div class="tests-list-wrap" id="testsListContainer">
      @foreach($tests as $test)
         @php
            $itemResult = $userResults[$test->id] ?? null;
            $qCount = $test->questions_count ?? $test->questions()->count();
            $statusKey = 'not_taken';
            $statusText = 'Chưa làm';
            $statusIcon = 'fa-clock';

            if ($itemResult) {
               if (!empty($itemResult['is_passed'])) {
                  $statusKey = 'passed';
                  $statusText = 'Đã đạt';
                  $statusIcon = 'fa-circle-check';
               } else {
                  $statusKey = 'failed';
                  $statusText = 'Chưa đạt';
                  $statusIcon = 'fa-circle-xmark';
               }
            }
         @endphp

         <div class="test-list-item" 
              data-title="{{ Str::lower($test->title) }}" 
              data-status="{{ $statusKey }}"
              data-topics="{{ $test->topics ? $test->topics->pluck('id')->implode(',') : '' }}"
              data-questions="{{ $qCount }}"
         >
            <div class="test-list-left">
               <div class="test-list-icon">
                  <i class="fa-solid fa-file-signature"></i>
               </div>

               <div class="test-list-body">
                  <!-- DÒNG 1: Tiêu đề + Trạng thái & Kết quả -->
                  <div class="test-line-1">
                     <h4 class="test-list-title">
                        <a href="{{ route('frontend.tests.show', $test->id) }}">{{ $test->title }}</a>
                     </h4>

                     <!-- Status Badge -->
                     <span class="badge-status status-{{ $statusKey }}">
                        <i class="fa-solid {{ $statusIcon }}"></i> {{ $statusText }}
                     </span>

                     @if($itemResult)
                        <span class="badge-score-pill" title="Điểm cao nhất">
                           <i class="fa-solid fa-trophy text-warning me-1"></i> 
                           <strong>{{ $itemResult['max_score'] }}</strong>/{{ $qCount }} câu
                        </span>
                        <span class="badge-attempts-pill" title="Số lần đã thi">
                           <i class="fa-solid fa-rotate-right text-muted me-1"></i> {{ $itemResult['attempts'] }} lần
                        </span>
                     @endif
                  </div>

                  <!-- DÒNG 2: Khóa học + Thông số đề thi -->
                  <div class="test-line-2">
                     @if($test->topics && $test->topics->isNotEmpty())
                        @foreach($test->topics as $tp)
                           <span class="badge-tag-topic" title="{{ $tp->name }}">
                              <i class="fa-solid fa-layer-group me-1"></i> {{ $tp->name }}
                           </span>
                        @endforeach
                        <span class="meta-divider">•</span>
                     @endif
                     @if($test->post)
                        <span class="badge-tag-course" title="{{ $test->post->title }}">
                           <i class="fa-solid fa-book-bookmark me-1"></i> {{ $test->post->title }}
                        </span>
                        <span class="meta-divider">•</span>
                     @else
                        <span class="badge-tag-general">
                           <i class="fa-solid fa-shield-check me-1"></i> Đề thi chung
                        </span>
                        <span class="meta-divider">•</span>
                     @endif

                     <span class="meta-item">
                        <i class="fa-regular fa-clipboard-question text-primary"></i> 
                        <strong>{{ $qCount }}</strong> câu hỏi
                     </span>
                     <span class="meta-divider">•</span>
                     <span class="meta-item">
                        <i class="fa-regular fa-bullseye-arrow text-success"></i> 
                        Yêu cầu đạt: <strong>{{ $test->pass_score }}</strong>/{{ $qCount }} câu
                     </span>
                     <span class="meta-divider">•</span>
                     <span class="meta-item">
                        <i class="fa-regular fa-clock text-warning"></i> 
                        Thời gian: <strong>{{ $test->duration && $test->duration > 0 ? $test->duration . ' phút' : 'Tự do' }}</strong>
                     </span>
                  </div>
               </div>
            </div>

            <div class="test-list-action">
               <a href="{{ route('frontend.tests.show', $test->id) }}" class="btn-test-action {{ $itemResult ? 'btn-retake' : 'btn-start' }}">
                  <span>{{ $itemResult ? 'Làm lại' : 'Vào thi' }}</span>
                  <i class="fa-solid {{ $itemResult ? 'fa-rotate-right' : 'fa-arrow-right-long' }}"></i>
               </a>
            </div>
         </div>
      @endforeach
   </div>

   <!-- Empty state khi tìm kiếm không có kết quả -->
   <div id="noSearchMatches" class="empty-test-card d-none mt-3">
      <div class="empty-icon-circle mb-3">
         <i class="fa-solid fa-magnifying-glass"></i>
      </div>
      <h5 class="fw-bold mb-2 text-dark">Không tìm thấy bài kiểm tra nào</h5>
      <p class="text-muted mb-3 fs-14" id="noSearchDesc">
         Không có bài kiểm tra nào phù hợp với từ khóa tìm kiếm của bạn.
      </p>
      <button type="button" class="btn btn-outline-primary btn-sm px-3 py-2 fw-semibold" id="btnResetSearch">
         <i class="fa-solid fa-rotate-left me-1"></i> Xóa tìm kiếm & Xem tất cả
      </button>
   </div>
@else
   <div class="empty-test-card">
      <div class="empty-icon-circle mb-3">
         <i class="fa-regular fa-clipboard-check"></i>
      </div>
      <h5 class="fw-bold mb-2 text-dark">Chưa có bài kiểm tra nào</h5>
      <p class="mb-0 text-muted fs-14">Hiện tại hệ thống chưa có bài kiểm tra nào được mở.</p>
   </div>
@endif
@endsection

@push('scripts')
<script>
   $(document).ready(function() {
      // Hủy bỏ hoàn toàn niceSelect trên các ô lọc để dùng native select hiện đại
      if ($.fn.niceSelect) {
         $('#topicFilterSelect, #statusFilterSelect').niceSelect('destroy');
      }
      $('.tests-select-wrapper .nice-select').remove();

      const $searchInput = $('#testSearchInput');
      const $clearBtn = $('#clearSearchBtn');
      const $topicSelect = $('#topicFilterSelect');
      const $statusSelect = $('#statusFilterSelect');
      const $items = $('.test-list-item');
      const $noMatches = $('#noSearchMatches');
      const $visibleCount = $('#visibleTestCount');
      const $btnReset = $('#btnResetSearch');
      
      let currentStatus = 'all';
      let currentTopic = 'all';

      // Chuẩn hóa tiếng Việt không dấu
      function removeVietnameseTones(str) {
         str = str.replace(/à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ/g, "a");
         str = str.replace(/è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ/g, "e");
         str = str.replace(/ì|í|ị|ỉ|ĩ/g, "i");
         str = str.replace(/ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ/g, "o");
         str = str.replace(/ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ/g, "u");
         str = str.replace(/ỳ|ý|ỵ|ỷ|ỹ/g, "y");
         str = str.replace(/đ/g, "d");
         str = str.replace(/À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ/g, "A");
         str = str.replace(/È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ/g, "E");
         str = str.replace(/Ì|Í|Ị|Ỉ|Ĩ/g, "I");
         str = str.replace(/Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ/g, "O");
         str = str.replace(/Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ/g, "U");
         str = str.replace(/Ỳ|Ý|Ỵ|Ỷ|Ỹ/g, "Y");
         str = str.replace(/Đ/g, "D");
         return str.toLowerCase().trim();
      }

      // Cập nhật số lượng đếm trên dropdown trạng thái
      function updateStatusCounts() {
         let totalAll = $items.length;
         let totalNotTaken = 0;
         let totalPassed = 0;
         let totalFailed = 0;

         $items.each(function() {
            const status = $(this).data('status');
            if (status === 'passed') totalPassed++;
            else if (status === 'failed') totalFailed++;
            else totalNotTaken++;
         });

         $('#optStatusAll').text(`Tất cả trạng thái (${totalAll})`);
         $('#optStatusNotTaken').text(`Chưa làm (${totalNotTaken})`);
         $('#optStatusPassed').text(`Đã đạt (${totalPassed})`);
         $('#optStatusFailed').text(`Chưa đạt (${totalFailed})`);
      }

      // Lọc danh sách thời gian thực
      function filterTests() {
         const rawKeyword = $searchInput.val().trim();
         const keyword = removeVietnameseTones(rawKeyword);

         if (rawKeyword.length > 0) {
            $clearBtn.removeClass('d-none');
         } else {
            $clearBtn.addClass('d-none');
         }

         let visibleItemsCount = 0;

         $items.each(function() {
            const $item = $(this);
            const itemTitleRaw = $item.find('.test-list-title').text();
            const itemTitle = removeVietnameseTones(itemTitleRaw);
            const itemStatus = String($item.data('status') || '');
            const itemTopicsStr = String($item.data('topics') || '');
            const itemTopics = itemTopicsStr ? itemTopicsStr.split(',').map(s => s.trim()) : [];

            const matchesSearch = (keyword === '') || 
                                  itemTitle.includes(keyword) || 
                                  itemTitleRaw.toLowerCase().includes(rawKeyword.toLowerCase());

            const matchesStatus = (currentStatus === 'all') || (itemStatus === currentStatus);

            const matchesTopic = (currentTopic === 'all') || itemTopics.includes(String(currentTopic));

            if (matchesSearch && matchesStatus && matchesTopic) {
               $item.stop(true, true).fadeIn(150);
               visibleItemsCount++;
            } else {
               $item.stop(true, true).hide();
            }
         });

         $visibleCount.text(visibleItemsCount);

         if (visibleItemsCount === 0 && $items.length > 0) {
            $noMatches.removeClass('d-none');
            if (rawKeyword) {
               $('#noSearchDesc').text(`Không có bài kiểm tra nào khớp với từ khóa "${rawKeyword}".`);
            } else if (currentTopic !== 'all' || currentStatus !== 'all') {
               $('#noSearchDesc').text(`Không có bài kiểm tra nào khớp với bộ lọc đã chọn.`);
            } else {
               $('#noSearchDesc').text(`Không có bài kiểm tra nào.`);
            }
         } else {
            $noMatches.addClass('d-none');
         }
      }

      updateStatusCounts();

      $searchInput.on('input keyup', function() {
         filterTests();
      });

      $clearBtn.on('click', function() {
         $searchInput.val('').focus();
         filterTests();
      });

      $statusSelect.on('change', function() {
         currentStatus = $(this).val();
         filterTests();
      });

      $topicSelect.on('change', function() {
         currentTopic = $(this).val();
         filterTests();
      });

      $btnReset.on('click', function() {
         $searchInput.val('');
         currentStatus = 'all';
         currentTopic = 'all';
         $statusSelect.val('all');
         $topicSelect.val('all');
         filterTests();
      });

      if ($searchInput.val().trim() !== '') {
         filterTests();
      }
   });

   $(window).on('load', function() {
      if ($.fn.niceSelect) {
         $('#topicFilterSelect, #statusFilterSelect').niceSelect('destroy');
      }
      $('.tests-select-wrapper .nice-select').remove();
   });
</script>
@endpush
