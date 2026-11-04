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
      padding: 16px 20px;
      box-shadow: 0 1px 3px rgba(15, 23, 42, 0.04);
      margin-bottom: 16px;
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
      height: 40px;
      padding: 0 38px 0 38px;
      font-size: 13px;
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
      height: 40px !important;
      line-height: 40px !important;
      padding: 0 34px 0 38px !important;
      font-size: 13px !important;
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


   /* Topic Group Section */
   .topic-group-section {
      background: transparent;
      margin-bottom: 34px;
      transition: all 0.3s ease;
   }
   .topic-group-header {
      background: transparent;
      border: none;
      border-bottom: 2px solid #edf2f7;
      border-radius: 0;
      padding: 0 0 10px 0;
      display: flex;
      align-items: center;
      justify-content: space-between;
      flex-wrap: wrap;
      gap: 12px;
      margin-bottom: 18px;
      box-shadow: none;
      transition: border-color 0.2s ease;
   }
   .topic-group-header:hover {
      border-bottom-color: #cbd5e1;
   }
   .topic-header-left {
      display: flex;
      align-items: center;
      gap: 10px;
      flex: 1;
      min-width: 0;
   }
   .topic-header-icon {
      width: 28px;
      height: 28px;
      border-radius: 6px;
      background: rgba(3, 89, 78, 0.08);
      color: #03594e;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      font-size: 13px;
      flex-shrink: 0;
   }
   .topic-header-text {
      display: flex;
      align-items: center;
      flex-wrap: wrap;
      gap: 8px 12px;
      flex: 1;
      min-width: 0;
   }
   .topic-group-title {
      font-size: 16px;
      font-weight: 700;
      color: #0f172a;
      margin: 0;
      line-height: 1.3;
      letter-spacing: -0.2px;
   }
   .topic-count-badge {
      display: inline-flex;
      align-items: center;
      font-size: 11.5px;
      font-weight: 600;
      color: #475569;
      background: #f1f5f9;
      border: 1px solid #e2e8f0;
      padding: 1px 8px;
      border-radius: 999px;
      white-space: nowrap;
   }
   .topic-progress-info {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      margin: 0;
      padding-left: 12px;
      border-left: 1.5px solid #e2e8f0;
      font-size: 12px;
      color: #64748b;
      white-space: nowrap;
   }
   @media (max-width: 767px) {
      .topic-progress-info {
         padding-left: 0;
         border-left: none;
         width: 100%;
         margin-top: 4px;
      }
   }
   .topic-progress-bar-wrap {
      width: 90px;
      height: 5px;
      background: #e2e8f0;
      border-radius: 999px;
      overflow: hidden;
      flex-shrink: 0;
   }
   .topic-progress-bar {
      height: 100%;
      background: #03594e;
      border-radius: 999px;
      transition: width 0.4s ease;
   }
   .topic-progress-percent {
      font-size: 11.5px;
      font-weight: 700;
      color: #03594e;
   }
   .btn-toggle-topic {
      border: none;
      background: transparent;
      color: #64748b;
      font-size: 12px;
      font-weight: 600;
      padding: 4px 8px;
      border-radius: 6px;
      display: inline-flex;
      align-items: center;
      gap: 5px;
      cursor: pointer;
      transition: all 0.2s ease;
   }
   .btn-toggle-topic:hover {
      background: #f1f5f9;
      color: #03594e;
   }
   .btn-toggle-topic .toggle-icon {
      transition: transform 0.25s ease;
      font-size: 10px;
   }
   .topic-group-section.collapsed .btn-toggle-topic .toggle-icon {
      transform: rotate(-90deg);
   }
   .topic-group-section.collapsed .topic-group-body {
      display: none;
   }

   /* 4-Column Card Grid */
   .test-list-item {
      display: flex;
      visibility: visible !important;
      transition: opacity 0.35s ease, transform 0.35s cubic-bezier(0.165, 0.84, 0.44, 1);
   }

   /* Load More Button in Topic Section */
   .topic-load-more-wrap {
      margin-top: 18px;
      margin-bottom: 6px;
      text-align: center;
   }
   .btn-load-more-tests {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
      padding: 8px 26px;
      background: #ffffff;
      color: #03594e;
      border: 1.5px solid rgba(3, 89, 78, 0.28);
      border-radius: 999px;
      font-size: 13px;
      font-weight: 600;
      cursor: pointer;
      box-shadow: 0 1px 4px rgba(15, 23, 42, 0.05);
      transition: all 0.25s cubic-bezier(0.165, 0.84, 0.44, 1);
   }
   .btn-load-more-tests:hover {
      background: #03594e;
      color: #ffffff;
      border-color: #03594e;
      transform: translateY(-2px);
      box-shadow: 0 6px 16px rgba(3, 89, 78, 0.2);
   }
   .btn-load-more-tests i {
      font-size: 11px;
      transition: transform 0.25s ease;
   }
   .btn-load-more-tests:hover i {
      transform: translateY(2px);
   }
   .btn-load-more-tests .load-more-remaining-count {
      font-weight: 700;
   }

   /* Special Group Section Load More Button */
   .special-group-section .btn-load-more-tests {
      color: #92400e;
      border-color: rgba(245, 158, 11, 0.4);
      background: #ffffff;
   }
   .special-group-section .btn-load-more-tests:hover {
      background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
      color: #ffffff;
      border-color: #d97706;
      box-shadow: 0 6px 16px rgba(245, 158, 11, 0.28);
   }

   /* Career Item Box - Nhỏ gọn, tinh tế */
   .it-career-item {
      width: 100%;
      background-color: #ffffff;
      border: 1px solid #e9ebec;
      border-radius: 12px;
      padding: 15px 15px 13px;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      transition: all 0.25s cubic-bezier(0.165, 0.84, 0.44, 1);
      box-shadow: 0 1px 3px rgba(15, 23, 42, 0.04);
      position: relative;
   }
   .it-career-item:hover {
      transform: translateY(-3px);
      box-shadow: 0 8px 20px -3px rgba(3, 89, 78, 0.12);
      border-color: rgba(3, 89, 78, 0.35);
   }

   /* Special / Featured Group Section & Card Highlight */
   .special-group-section {
      margin-bottom: 34px;
   }
   .special-group-header {
      background: transparent !important;
      border: none !important;
      border-bottom: 2px solid #fde68a !important;
      border-radius: 0 !important;
      padding: 0 0 10px 0 !important;
      display: flex;
      align-items: center;
      justify-content: space-between;
      flex-wrap: wrap;
      gap: 12px;
      margin-bottom: 18px !important;
      box-shadow: none !important;
      transition: border-color 0.25s ease;
   }
   .special-group-header:hover {
      border-bottom-color: #f59e0b !important;
      box-shadow: none !important;
   }
   .special-header-icon {
      width: 28px !important;
      height: 28px !important;
      border-radius: 6px !important;
      background: #fef3c7 !important;
      color: #d97706 !important;
      display: inline-flex !important;
      align-items: center;
      justify-content: center;
      font-size: 13px !important;
      flex-shrink: 0;
      box-shadow: none !important;
   }
   .special-group-title {
      font-size: 16px !important;
      font-weight: 800 !important;
      color: #92400e !important;
      margin: 0;
      line-height: 1.3;
      letter-spacing: -0.2px;
   }
   .special-count-badge {
      display: inline-flex;
      align-items: center;
      font-size: 11.5px !important;
      font-weight: 700 !important;
      color: #92400e !important;
      background: #fef3c7 !important;
      border: 1px solid #fde68a !important;
      padding: 1px 8px !important;
      border-radius: 999px !important;
      white-space: nowrap;
   }
   .special-group-header .btn-toggle-topic {
      color: #92400e !important;
   }
   .special-group-header .btn-toggle-topic:hover {
      background: #fef3c7 !important;
      color: #78350f !important;
   }

   /* Special Card Highlight */
   .it-career-item.is-special-card {
      border: 2px solid #f59e0b !important;
      background: linear-gradient(180deg, #fffdf5 0%, #ffffff 45%) !important;
      box-shadow: 0 4px 16px rgba(245, 158, 11, 0.18) !important;
      position: relative;
      overflow: hidden;
   }
   .it-career-item.is-special-card::before {
      content: "";
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      height: 3px;
      background: linear-gradient(90deg, #f59e0b, #d97706, #fbbf24);
      z-index: 1;
   }
   .it-career-item.is-special-card:hover {
      transform: translateY(-4px) !important;
      box-shadow: 0 10px 24px rgba(245, 158, 11, 0.28) !important;
      border-color: #d97706 !important;
   }
   .badge-special-highlight {
      display: inline-flex;
      align-items: center;
      gap: 3px;
      font-size: 10px;
      font-weight: 800;
      letter-spacing: 0.4px;
      text-transform: uppercase;
      background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
      color: #ffffff;
      padding: 2px 7px;
      border-radius: 5px;
      box-shadow: 0 2px 5px rgba(217, 119, 6, 0.35);
      line-height: 1.25;
   }
   .it-career-item.is-special-card .title a {
      color: #0f172a;
      font-weight: 800;
   }
   .it-career-item.is-special-card .title a:hover {
      color: #d97706;
   }

   /* Category & Status Top */
   .it-career-top {
      margin-bottom: 8px;
   }
   .it-career-category {
      display: inline-flex;
      align-items: center;
      font-size: 11px;
      font-weight: 600;
      color: #03594e;
      background: rgba(3, 89, 78, 0.08);
      border: 1px solid rgba(3, 89, 78, 0.15);
      padding: 2px 7px;
      border-radius: 5px;
      max-width: 135px;
      overflow: hidden;
      text-overflow: ellipsis;
      white-space: nowrap;
      line-height: 1.25;
   }
   .badge-status {
      display: inline-flex;
      align-items: center;
      gap: 3px;
      font-size: 10.5px;
      font-weight: 700;
      padding: 2px 7px;
      border-radius: 5px;
      line-height: 1.25;
   }
   .badge-status.status-passed {
      background: #dcfce7;
      color: #15803d;
   }
   .badge-status.status-failed {
      background: #fee2e2;
      color: #b91c1c;
   }
   .badge-status.status-not_taken {
      background: #f1f5f9;
      color: #64748b;
   }

   /* Title */
   .it-career-item .title {
      font-size: 14px;
      font-weight: 700;
      margin-bottom: 8px;
      color: #0f172a;
      line-height: 1.35;
      display: -webkit-box;
      -webkit-line-clamp: 2;
      -webkit-box-orient: vertical;
      overflow: hidden;
      min-height: 38px;
      font-family: 'Montserrat', sans-serif !important;
   }
   .it-career-item .title a {
      color: #0f172a;
      text-decoration: none;
      transition: color 0.2s;
   }
   .it-career-item .title a:hover {
      color: #03594e;
   }

   /* Meta info */
   .it-career-item .it-career-meta {
      margin-bottom: 8px;
      display: flex;
      align-items: center;
      flex-wrap: wrap;
      gap: 4px 0;
      font-size: 11.5px;
      color: #64748b;
   }
   .it-career-item .it-career-meta span {
      line-height: 1.2;
      display: inline-flex;
      align-items: center;
   }
   .it-career-item .it-career-meta span:not(:last-child) {
      padding-right: 8px;
      margin-right: 7px;
      border-right: 1px solid rgba(108, 117, 125, 0.3);
   }
   .it-career-item .it-career-meta strong {
      color: #1e293b;
      margin-left: 2px;
   }

   /* Score / Attempt highlight */
   .it-career-score-wrap {
      margin-bottom: 12px;
      min-height: 22px;
      display: flex;
      align-items: center;
      flex-wrap: wrap;
      gap: 5px;
   }
   .badge-score-pill {
      display: inline-flex;
      align-items: center;
      font-size: 10.5px;
      font-weight: 600;
      background: #fefce8;
      color: #854d0e;
      border: 1px solid #fef08a;
      padding: 2px 6px;
      border-radius: 4px;
   }
   .badge-attempts-pill {
      display: inline-flex;
      align-items: center;
      font-size: 10.5px;
      font-weight: 500;
      background: #f8fafc;
      color: #64748b;
      border: 1px solid #e2e8f0;
      padding: 2px 6px;
      border-radius: 4px;
   }
   .badge-not-taken-pill {
      display: inline-flex;
      align-items: center;
      font-size: 10.5px;
      font-weight: 500;
      background: #f8fafc;
      color: #94a3b8;
      border: 1px dashed #e2e8f0;
      padding: 2px 6px;
      border-radius: 4px;
   }

   /* Bottom Row */
   .it-career-bottom {
      border-top: 1px solid #f1f5f9;
      padding-top: 10px;
      margin-top: auto;
   }
   .it-career-price {
      font-size: 11.5px;
      font-weight: 600;
      border-radius: 6px;
      padding: 4px 9px;
      display: inline-flex;
      align-items: center;
      line-height: 1;
      color: #475569;
      background-color: #f8fafc;
      border: 1px solid #e2e8f0;
      white-space: nowrap;
   }
   .it-career-price.it-career-result-btn {
      background-color: #ffffff;
      color: #03594e;
      border: 1.5px solid rgba(3, 89, 78, 0.35);
      text-decoration: none;
      cursor: pointer;
      transition: all 0.2s ease;
   }
   .it-career-price.it-career-result-btn:hover {
      background-color: #f0fdf4;
      border-color: #03594e;
      color: #03594e;
      transform: translateY(-1px);
   }

   /* it-btn-yellow - Nhỏ gọn */
   .it-career-item .it-btn-yellow {
      font-size: 11.5px;
      font-weight: 700;
      padding: 5px 12px !important;
      height: auto !important;
      border-radius: 6px;
      display: inline-flex !important;
      align-items: center !important;
      justify-content: center !important;
      background-color: #03594e !important;
      color: #ffffff !important;
      text-decoration: none !important;
      border: 1.5px solid #03594e !important;
      box-shadow: 0 1px 4px rgba(3, 89, 78, 0.15) !important;
      transition: all 0.25s ease !important;
      cursor: pointer !important;
      white-space: nowrap;
   }
   .it-career-item .it-btn-yellow span span {
      color: #ffffff !important;
   }
   .it-career-item .it-btn-yellow svg {
      width: 12px;
      height: 11px;
      margin-left: 6px;
   }
   .it-career-item .it-btn-yellow svg path {
      fill: #ffffff !important;
   }
   .it-career-item .it-btn-yellow:hover {
      background-color: #02433b !important;
      border-color: #02433b !important;
      transform: translateY(-1px);
      box-shadow: 0 3px 8px rgba(3, 89, 78, 0.22) !important;
   }
   .it-career-item .it-btn-yellow.it-btn-retake {
      background-color: #f0fdf4 !important;
      border: 1.5px solid #03594e !important;
      color: #03594e !important;
      box-shadow: none !important;
   }
   .it-career-item .it-btn-yellow.it-btn-retake span span {
      color: #03594e !important;
   }
   .it-career-item .it-btn-yellow.it-btn-retake svg path {
      fill: #03594e !important;
   }
   .it-career-item .it-btn-yellow.it-btn-retake:hover {
      background-color: #03594e !important;
      color: #ffffff !important;
      box-shadow: 0 3px 8px rgba(3, 89, 78, 0.22) !important;
   }
   .it-career-item .it-btn-yellow.it-btn-retake:hover span span {
      color: #ffffff !important;
   }
   .it-career-item .it-btn-yellow.it-btn-retake:hover svg path {
      fill: #ffffff !important;
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
               <option value="all">Tất cả Topic / Mục ({{ $tests->count() }})</option>
               @foreach($topics as $tp)
                  @if(isset($tp->tests_count) && $tp->tests_count > 0)
                     <option value="{{ $tp->id }}">
                        {{ $tp->name }} ({{ $tp->tests_count }})
                     </option>
                  @endif
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

@guest
   <div class="alert alert-warning d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3 shadow-sm" style="border-radius: 10px; border-left: 4px solid #f59e0b; background: #fffbeb; padding: 12px 18px;">
      <div class="d-flex align-items-center gap-2">
         <i class="fa-solid fa-lock text-warning fs-5"></i>
         <span style="font-size: 13.5px; color: #92400e;">
            <strong>Yêu cầu đăng nhập:</strong> Bạn cần đăng nhập tài khoản để vào làm bài kiểm tra và lưu lịch sử kết quả thi.
         </span>
      </div>
      <a href="{{ route('frontend.login') }}" class="btn btn-sm text-white fw-bold px-3 py-1" style="background: #03594e; border-radius: 6px; font-size: 13px;">
         <i class="fa-solid fa-right-to-bracket me-1"></i> Đăng nhập ngay
      </a>
   </div>
@endguest

@php
   // Danh sách các bài test đặc biệt (hiển thị lên trên cùng)
   $specialTests = $tests->filter(fn($t) => (bool)$t->is_special);

   // Gom nhóm các bài test theo từng Topic có bài thi (ưu tiên bài đặc biệt lên đầu nhóm)
   $groupedByTopic = collect();

   foreach ($topics as $tp) {
       $topicTests = $tests->filter(function($t) use ($tp) {
           return $t->topics->contains('id', $tp->id);
       })->sortByDesc('is_special');

       if ($topicTests->isNotEmpty()) {
           $groupedByTopic->put($tp->id, [
               'topic' => $tp,
               'tests' => $topicTests
           ]);
       }
   }

   // Các bài test không thuộc topic nào (nếu có)
   $untaggedTests = $tests->filter(function($t) {
       return $t->topics->isEmpty();
   })->sortByDesc('is_special');
@endphp


<!-- Vùng hiển thị các bài thi nhóm theo từng Topic -->
@if($tests->count() > 0)
   <div class="it-career-area" id="testsGroupedContainer">

      <!-- KHU VỰC BÀI THI ĐẶC BIỆT LÊN TRÊN CÙNG -->
      @if($specialTests->isNotEmpty())
         <div class="topic-group-section special-group-section" id="specialGroupSection" data-topic-id="special">
            <!-- Header Nhóm Bài Thi Đặc Biệt -->
            <div class="topic-group-header special-group-header">
               <div class="topic-header-left">
                  <div class="topic-header-icon special-header-icon">
                     <i class="fa-solid fa-star"></i>
                  </div>
                  <div class="topic-header-text">
                     <h3 class="topic-group-title special-group-title">
                        Bài kiểm tra đặc biệt
                     </h3>
                     <span class="topic-count-badge special-count-badge">
                        <span class="topic-visible-count">{{ $specialTests->count() }}</span> bài thi
                     </span>
                     <span class="d-none d-sm-inline-flex align-items-center gap-1" style="font-size: 12px; color: #b45309; padding-left: 10px; border-left: 1.5px solid #fde68a;">
                        <i class="fa-solid fa-sparkles text-warning"></i> Trọng tâm
                     </span>
                  </div>
               </div>

               <!-- Nút Thu gọn / Mở rộng nhóm -->
               <div class="topic-header-right">
                  <button type="button" class="btn-toggle-topic">
                     <span class="toggle-text">Thu gọn</span>
                     <i class="fa-solid fa-chevron-down toggle-icon"></i>
                  </button>
               </div>
            </div>

            <!-- Danh sách bài thi đặc biệt dạng 4 cột -->
            <div class="topic-group-body">
               <div class="row g-3">
                  @foreach($specialTests as $test)
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

                        $topicName = $test->topics->first()?->name ?? 'Bài test chung';
                        $delay = 0.1 + (($loop->index % 4) * 0.1);
                     @endphp

                     <div class="col-xxl-3 col-xl-3 col-lg-4 col-md-6 col-sm-12 test-list-item special-test-item wow itfadeUp" 
                          data-wow-duration=".8s" 
                          data-wow-delay="{{ $delay }}s"
                          data-test-id="{{ $test->id }}"
                          data-title="{{ Str::lower($test->title) }}" 
                          data-status="{{ $statusKey }}"
                          data-topics="{{ $test->topics->pluck('id')->implode(',') }}"
                          data-questions="{{ $qCount }}"
                          @if($loop->index >= 8) style="display: none;" @endif
                     >
                        <div class="it-career-item is-special-card">
                           <!-- Header: Category & Status -->
                           <div class="it-career-top d-flex align-items-center justify-content-between flex-wrap gap-1">
                              <div class="d-flex align-items-center gap-1 flex-wrap">
                                 <span class="badge-special-highlight" title="Bài kiểm tra đặc biệt">
                                    <i class="fa-solid fa-star"></i> Đặc biệt
                                 </span>
                                 <span class="it-career-category" title="{{ $topicName }}">
                                    <i class="fa-solid fa-layer-group me-1"></i> {{ $topicName }}
                                 </span>
                              </div>

                              <span class="badge-status status-{{ $statusKey }}">
                                 <i class="fa-solid {{ $statusIcon }}"></i> {{ $statusText }}
                              </span>
                           </div>

                           <!-- Title -->
                           <h4 class="title test-list-title">
                              <a href="{{ route('frontend.tests.show', $test->id) }}" title="{{ $test->title }}">
                                 {{ $test->title }}
                              </a>
                           </h4>

                           <!-- Meta Information: Câu hỏi | Yêu cầu đạt | Thời gian -->
                           <div class="it-career-meta">
                              <span>
                                 <i class="fa-regular fa-clipboard-question text-primary me-1"></i>
                                 <strong>{{ $qCount }}</strong> câu
                              </span>
                              <span>
                                 <i class="fa-regular fa-bullseye-arrow text-success me-1"></i>
                                 Đạt: <strong>{{ $test->pass_score }}</strong>/{{ $qCount }}
                              </span>
                              <span>
                                 <i class="fa-regular fa-clock text-warning me-1"></i>
                                 <strong>{{ $test->duration && $test->duration > 0 ? $test->duration . 'p' : 'Tự do' }}</strong>
                              </span>
                           </div>

                           <!-- Score / Attempts status -->
                           <div class="it-career-score-wrap">
                              @if($itemResult)
                                 <span class="badge-score-pill" title="Điểm cao nhất">
                                    <i class="fa-solid fa-trophy text-warning me-1"></i> <strong>{{ $itemResult['max_score'] }}</strong>/{{ $qCount }} câu
                                 </span>
                                 <span class="badge-attempts-pill" title="Số lần đã thi">
                                    <i class="fa-solid fa-rotate-right text-muted me-1"></i> {{ $itemResult['attempts'] }} lần
                                 </span>
                              @else
                                 <span class="badge-not-taken-pill">
                                    <i class="fa-regular fa-circle-dot me-1 text-muted"></i> Chưa làm bài
                                 </span>
                              @endif
                           </div>

                           <!-- Bottom: Duration & Action Link -->
                           <div class="it-career-bottom d-flex align-items-center justify-content-between flex-wrap gap-2">
                              <span class="it-career-price" title="Thời gian làm bài">
                                 <i class="fa-regular fa-clock me-1"></i> {{ $test->duration && $test->duration > 0 ? $test->duration . ' phút' : 'Tự do' }}
                              </span>

                              <a href="{{ route('frontend.tests.show', $test->id) }}" class="it-btn-yellow {{ $itemResult ? 'it-btn-retake' : '' }}">
                                 <span>
                                    <span class="text-1">{{ $itemResult ? 'Làm lại' : 'Vào thi' }}</span>
                                    <span class="text-2">{{ $itemResult ? 'Làm lại' : 'Vào thi' }}</span>
                                 </span>
                                 <i>
                                    <svg width="12" height="11" viewBox="0 0 15 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                       <path d="M14.6364 7.26396C14.9879 6.91249 14.9879 6.34264 14.6364 5.99117L8.90883 0.263603C8.55736 -0.0878692 7.98751 -0.0878692 7.63604 0.263603C7.28457 0.615075 7.28457 1.18492 7.63604 1.53639L12.7272 6.62756L7.63604 11.7187C7.28457 12.0702 7.28457 12.6401 7.63604 12.9915C7.98751 13.343 8.55736 13.343 8.90883 12.9915L14.6364 7.26396ZM0 6.62756V7.52756H14V6.62756V5.72756H0V6.62756Z" fill="currentColor"></path>
                                    </svg>
                                 </i>
                              </a>
                           </div>
                        </div>
                     </div>
                  @endforeach
               </div>
               @php $specialRemaining = $specialTests->count() - 8; @endphp
               <div class="topic-load-more-wrap text-center mt-3 {{ $specialRemaining <= 0 ? 'd-none' : '' }}">
                  <button type="button" class="btn-load-more-tests">
                     <span>Xem thêm bài thi (còn <strong class="load-more-remaining-count">{{ max(0, $specialRemaining) }}</strong> bài)</span>
                     <i class="fa-solid fa-chevron-down ms-1"></i>
                  </button>
               </div>
            </div>
         </div>
      @endif
      @foreach($groupedByTopic as $tpId => $group)
         @php
            $topicTotal = $group['tests']->count();
            $topicPassedCount = 0;
            foreach ($group['tests'] as $t) {
                if (!empty($userResults[$t->id]['is_passed'])) {
                    $topicPassedCount++;
                }
            }
            $percentPassed = $topicTotal > 0 ? round(($topicPassedCount / $topicTotal) * 100) : 0;
         @endphp

         <div class="topic-group-section" data-topic-id="{{ $tpId }}">
            <!-- Header Nhóm Topic -->
            <div class="topic-group-header">
               <div class="topic-header-left">
                  <div class="topic-header-icon">
                     <i class="fa-solid fa-layer-group"></i>
                  </div>
                  <div class="topic-header-text">
                     <h3 class="topic-group-title">{{ $group['topic']->name }}</h3>
                     <span class="topic-count-badge">
                        <span class="topic-visible-count">{{ $topicTotal }}</span> bài thi
                     </span>
                     @if(Auth::check())
                     <div class="topic-progress-info">
                        <span class="topic-passed-stat">
                           <i class="fa-solid fa-circle-check text-success me-1"></i>
                           Đã đạt: <strong>{{ $topicPassedCount }}</strong>/{{ $topicTotal }}
                        </span>
                        <div class="topic-progress-bar-wrap" title="Tiến độ hoàn thành: {{ $percentPassed }}%">
                           <div class="topic-progress-bar" style="width: {{ $percentPassed }}%"></div>
                        </div>
                        <span class="topic-progress-percent">{{ $percentPassed }}%</span>
                     </div>
                     @endif
                  </div>
               </div>

               <!-- Nút Thu gọn / Mở rộng nhóm -->
               <div class="topic-header-right">
                  <button type="button" class="btn-toggle-topic">
                     <span class="toggle-text">Thu gọn</span>
                     <i class="fa-solid fa-chevron-down toggle-icon"></i>
                  </button>
               </div>
            </div>

            <!-- Danh sách bài thi dạng 4 cột -->
            <div class="topic-group-body">
               <div class="row g-3">
                  @foreach($group['tests'] as $test)
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

                        $delay = 0.1 + (($loop->index % 4) * 0.1);
                     @endphp

                     <div class="col-xxl-3 col-xl-3 col-lg-4 col-md-6 col-sm-12 test-list-item wow itfadeUp" 
                          data-wow-duration=".8s" 
                          data-wow-delay="{{ $delay }}s"
                          data-test-id="{{ $test->id }}"
                          data-title="{{ Str::lower($test->title) }}" 
                          data-status="{{ $statusKey }}"
                          data-topics="{{ $tpId }}"
                          data-questions="{{ $qCount }}"
                          @if($loop->index >= 8) style="display: none;" @endif
                     >
                        <div class="it-career-item {{ $test->is_special ? 'is-special-card' : '' }}">
                           <!-- Header: Category & Status -->
                           <div class="it-career-top d-flex align-items-center justify-content-between flex-wrap gap-1">
                              <div class="d-flex align-items-center gap-1 flex-wrap">
                                 @if($test->is_special)
                                    <span class="badge-special-highlight" title="Bài kiểm tra đặc biệt">
                                       <i class="fa-solid fa-star"></i> Đặc biệt
                                    </span>
                                 @endif
                                 <span class="it-career-category" title="{{ $group['topic']->name }}">
                                    <i class="fa-solid fa-layer-group me-1"></i> {{ $group['topic']->name }}
                                 </span>
                              </div>

                              <span class="badge-status status-{{ $statusKey }}">
                                 <i class="fa-solid {{ $statusIcon }}"></i> {{ $statusText }}
                              </span>
                           </div>

                           <!-- Title -->
                           <h4 class="title test-list-title">
                              <a href="{{ route('frontend.tests.show', $test->id) }}" title="{{ $test->title }}">
                                 {{ $test->title }}
                              </a>
                           </h4>

                           <!-- Meta Information: Câu hỏi | Yêu cầu đạt | Thời gian -->
                           <div class="it-career-meta">
                              <span>
                                 <i class="fa-regular fa-clipboard-question text-primary me-1"></i>
                                 <strong>{{ $qCount }}</strong> câu
                              </span>
                              <span>
                                 <i class="fa-regular fa-bullseye-arrow text-success me-1"></i>
                                 Đạt: <strong>{{ $test->pass_score }}</strong>/{{ $qCount }}
                              </span>
                              <span>
                                 <i class="fa-regular fa-clock text-warning me-1"></i>
                                 <strong>{{ $test->duration && $test->duration > 0 ? $test->duration . 'p' : 'Tự do' }}</strong>
                              </span>
                           </div>

                           <!-- Score / Attempts status -->
                           <div class="it-career-score-wrap">
                              @if($itemResult)
                                 <span class="badge-score-pill" title="Điểm cao nhất">
                                    <i class="fa-solid fa-trophy text-warning me-1"></i> <strong>{{ $itemResult['max_score'] }}</strong>/{{ $qCount }} câu
                                 </span>
                                 <span class="badge-attempts-pill" title="Số lần đã thi">
                                    <i class="fa-solid fa-rotate-right text-muted me-1"></i> {{ $itemResult['attempts'] }} lần
                                 </span>
                              @else
                                 <span class="badge-not-taken-pill">
                                    <i class="fa-regular fa-circle-dot me-1 text-muted"></i> Chưa làm bài
                                 </span>
                              @endif
                           </div>

                           <!-- Bottom: Duration & Action Link -->
                           <div class="it-career-bottom d-flex align-items-center justify-content-between flex-wrap gap-2">
                              <span class="it-career-price" title="Thời gian làm bài">
                                 <i class="fa-regular fa-clock me-1"></i> {{ $test->duration && $test->duration > 0 ? $test->duration . ' phút' : 'Tự do' }}
                              </span>

                              <a href="{{ route('frontend.tests.show', $test->id) }}" class="it-btn-yellow {{ $itemResult ? 'it-btn-retake' : '' }}">
                                 <span>
                                    <span class="text-1">{{ $itemResult ? 'Làm lại' : 'Vào thi' }}</span>
                                    <span class="text-2">{{ $itemResult ? 'Làm lại' : 'Vào thi' }}</span>
                                 </span>
                                 <i>
                                    <svg width="12" height="11" viewBox="0 0 15 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                       <path d="M14.6364 7.26396C14.9879 6.91249 14.9879 6.34264 14.6364 5.99117L8.90883 0.263603C8.55736 -0.0878692 7.98751 -0.0878692 7.63604 0.263603C7.28457 0.615075 7.28457 1.18492 7.63604 1.53639L12.7272 6.62756L7.63604 11.7187C7.28457 12.0702 7.28457 12.6401 7.63604 12.9915C7.98751 13.343 8.55736 13.343 8.90883 12.9915L14.6364 7.26396ZM0 6.62756V7.52756H14V6.62756V5.72756H0V6.62756Z" fill="currentColor"></path>
                                    </svg>
                                 </i>
                              </a>
                           </div>
                        </div>
                     </div>
                  @endforeach
               </div>
               @php $topicRemaining = $topicTotal - 8; @endphp
               <div class="topic-load-more-wrap text-center mt-3 {{ $topicRemaining <= 0 ? 'd-none' : '' }}">
                  <button type="button" class="btn-load-more-tests">
                     <span>Xem thêm bài thi (còn <strong class="load-more-remaining-count">{{ max(0, $topicRemaining) }}</strong> bài)</span>
                     <i class="fa-solid fa-chevron-down ms-1"></i>
                  </button>
               </div>
            </div>
         </div>
      @endforeach

      <!-- Nhóm bài thi Chưa gán topic (nếu có) -->
      @if($untaggedTests->isNotEmpty())
         <div class="topic-group-section" data-topic-id="untagged">
            <div class="topic-group-header">
               <div class="topic-header-left">
                  <div class="topic-header-icon">
                     <i class="fa-solid fa-shield-check"></i>
                  </div>
                  <div class="topic-header-text">
                     <h3 class="topic-group-title">Đề thi chung & Chuyên đề khác</h3>
                     <span class="topic-count-badge">
                        <span class="topic-visible-count">{{ $untaggedTests->count() }}</span> bài thi
                     </span>
                  </div>
               </div>
               <div class="topic-header-right">
                  <button type="button" class="btn-toggle-topic">
                     <span class="toggle-text">Thu gọn</span>
                     <i class="fa-solid fa-chevron-down toggle-icon"></i>
                  </button>
               </div>
            </div>

            <div class="topic-group-body">
               <div class="row g-3">
                  @foreach($untaggedTests as $test)
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

                     <div class="col-xxl-3 col-xl-3 col-lg-4 col-md-6 col-sm-12 test-list-item wow itfadeUp" 
                          data-wow-duration=".8s" 
                          data-test-id="{{ $test->id }}"
                          data-title="{{ Str::lower($test->title) }}" 
                          data-status="{{ $statusKey }}"
                          data-topics="untagged"
                          data-questions="{{ $qCount }}"
                          @if($loop->index >= 8) style="display: none;" @endif
                     >
                        <div class="it-career-item {{ $test->is_special ? 'is-special-card' : '' }}">
                           <div class="it-career-top d-flex align-items-center justify-content-between flex-wrap gap-1">
                              <div class="d-flex align-items-center gap-1 flex-wrap">
                                 @if($test->is_special)
                                    <span class="badge-special-highlight" title="Bài kiểm tra đặc biệt">
                                       <i class="fa-solid fa-star"></i> Đặc biệt
                                    </span>
                                 @endif
                                 <span class="it-career-category">
                                    <i class="fa-solid fa-shield-check me-1"></i> Đề thi chung
                                 </span>
                              </div>
                              <span class="badge-status status-{{ $statusKey }}">
                                 <i class="fa-solid {{ $statusIcon }}"></i> {{ $statusText }}
                              </span>
                           </div>

                           <h4 class="title test-list-title">
                              <a href="{{ route('frontend.tests.show', $test->id) }}" title="{{ $test->title }}">
                                 {{ $test->title }}
                              </a>
                           </h4>

                           <div class="it-career-meta">
                              <span><i class="fa-regular fa-clipboard-question text-primary me-1"></i><strong>{{ $qCount }}</strong> câu</span>
                              <span><i class="fa-regular fa-bullseye-arrow text-success me-1"></i>Đạt: <strong>{{ $test->pass_score }}</strong>/{{ $qCount }}</span>
                              <span><i class="fa-regular fa-clock text-warning me-1"></i><strong>{{ $test->duration && $test->duration > 0 ? $test->duration . 'p' : 'Tự do' }}</strong></span>
                           </div>

                           <div class="it-career-score-wrap">
                              @if($itemResult)
                                 <span class="badge-score-pill">
                                    <i class="fa-solid fa-trophy text-warning me-1"></i> <strong>{{ $itemResult['max_score'] }}</strong>/{{ $qCount }} câu
                                 </span>
                                 <span class="badge-attempts-pill ms-2">
                                    <i class="fa-solid fa-rotate-right text-muted me-1"></i> {{ $itemResult['attempts'] }} lần
                                 </span>
                              @else
                                 <span class="badge-not-taken-pill">Chưa làm bài</span>
                              @endif
                           </div>

                           <div class="it-career-bottom d-flex align-items-center justify-content-between flex-wrap gap-2">
                              <span class="it-career-price">
                                 <i class="fa-regular fa-clock me-1"></i> {{ $test->duration && $test->duration > 0 ? $test->duration . ' phút' : 'Tự do' }}
                              </span>

                              <a href="{{ route('frontend.tests.show', $test->id) }}" class="it-btn-yellow {{ $itemResult ? 'it-btn-retake' : '' }}">
                                 <span>
                                    <span class="text-1">{{ $itemResult ? 'Làm lại' : 'Vào thi' }}</span>
                                    <span class="text-2">{{ $itemResult ? 'Làm lại' : 'Vào thi' }}</span>
                                 </span>
                                 <i>
                                    <svg width="12" height="11" viewBox="0 0 15 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                       <path d="M14.6364 7.26396C14.9879 6.91249 14.9879 6.34264 14.6364 5.99117L8.90883 0.263603C8.55736 -0.0878692 7.98751 -0.0878692 7.63604 0.263603C7.28457 0.615075 7.28457 1.18492 7.63604 1.53639L12.7272 6.62756L7.63604 11.7187C7.28457 12.0702 7.28457 12.6401 7.63604 12.9915C7.98751 13.343 8.55736 13.343 8.90883 12.9915L14.6364 7.26396ZM0 6.62756V7.52756H14V6.62756V5.72756H0V6.62756Z" fill="currentColor"></path>
                                    </svg>
                                 </i>
                              </a>
                           </div>
                        </div>
                     </div>
                  @endforeach
               </div>
               @php $untaggedRemaining = $untaggedTests->count() - 8; @endphp
               <div class="topic-load-more-wrap text-center mt-3 {{ $untaggedRemaining <= 0 ? 'd-none' : '' }}">
                  <button type="button" class="btn-load-more-tests">
                     <span>Xem thêm bài thi (còn <strong class="load-more-remaining-count">{{ max(0, $untaggedRemaining) }}</strong> bài)</span>
                     <i class="fa-solid fa-chevron-down ms-1"></i>
                  </button>
               </div>
            </div>
         </div>
      @endif
   </div>

   <!-- Empty state khi tìm kiếm hoặc lọc không có kết quả -->
   <div id="noSearchMatches" class="empty-test-card d-none mt-3">
      <div class="empty-icon-circle mb-3">
         <i class="fa-solid fa-magnifying-glass"></i>
      </div>
      <h5 class="fw-bold mb-2 text-dark">Không tìm thấy bài kiểm tra nào</h5>
      <p class="text-muted mb-3 fs-14" id="noSearchDesc">
         Không có bài kiểm tra nào phù hợp với bộ lọc hiện tại của bạn.
      </p>
      <button type="button" class="btn btn-outline-primary btn-sm px-3 py-2 fw-semibold" id="btnResetSearch">
         <i class="fa-solid fa-rotate-left me-1"></i> Xem tất cả bài thi
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
      const $sections = $('.topic-group-section');
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
         let totalNotTaken = 0;
         let totalPassed = 0;
         let totalFailed = 0;

         $('.topic-group-section:not(#specialGroupSection) .test-list-item').each(function() {
            const status = $(this).data('status');
            if (status === 'passed') totalPassed++;
            else if (status === 'failed') totalFailed++;
            else totalNotTaken++;
         });

         let totalAll = totalNotTaken + totalPassed + totalFailed;

         $('#optStatusAll').text(`Tất cả trạng thái (${totalAll})`);
         $('#optStatusNotTaken').text(`Chưa làm (${totalNotTaken})`);
         $('#optStatusPassed').text(`Đã đạt (${totalPassed})`);
         $('#optStatusFailed').text(`Chưa đạt (${totalFailed})`);
      }

      // Lọc danh sách bài thi theo Topic, Trạng thái & Từ khóa tìm kiếm
      function filterTests(resetLimits = false) {
         if (resetLimits) {
            $sections.each(function() {
               $(this).data('visible-limit', 8);
            });
         }

         const rawKeyword = $searchInput.val().trim();
         const keyword = removeVietnameseTones(rawKeyword);

         if (rawKeyword.length > 0) {
            $clearBtn.removeClass('d-none');
         } else {
            $clearBtn.addClass('d-none');
         }

         let totalVisible = 0;

         $sections.each(function() {
            const $sec = $(this);
            const isSpecialSec = $sec.attr('id') === 'specialGroupSection';
            const secTopicId = String($sec.data('topic-id') || '');

            // Nếu người dùng chọn lọc 1 topic cụ thể mà không phải nhóm đặc biệt thì kiểm tra topicId
            const matchesTopicFilter = (currentTopic === 'all') || (!isSpecialSec && secTopicId === currentTopic);

            if (!matchesTopicFilter) {
               $sec.hide();
               return;
            }

            const $secItems = $sec.find('.test-list-item');
            const matchingItems = [];

            $secItems.each(function() {
               const $item = $(this);
               const itemTitleRaw = $item.find('.test-list-title').text();
               const itemTitle = removeVietnameseTones(itemTitleRaw);
               const itemStatus = String($item.data('status') || '');

               const matchesSearch = (keyword === '') || 
                                     itemTitle.includes(keyword) || 
                                     itemTitleRaw.toLowerCase().includes(rawKeyword.toLowerCase());

               const matchesStatus = (currentStatus === 'all') || (itemStatus === currentStatus);

               if (matchesSearch && matchesStatus) {
                  matchingItems.push($item);
                  if (!isSpecialSec) {
                     totalVisible++;
                  }
               } else {
                  $item.hide();
               }
            });

            const totalMatched = matchingItems.length;
            // Cập nhật số lượng bài thi khớp trong header nhóm topic
            $sec.find('.topic-visible-count').text(totalMatched);

            if (totalMatched === 0) {
               $sec.hide();
               return;
            }

            $sec.show();

            // Áp dụng giới hạn hiển thị tối đa (mặc định 8 bài)
            const currentLimit = parseInt($sec.data('visible-limit') || 8, 10);
            const $loadMoreWrap = $sec.find('.topic-load-more-wrap');

            matchingItems.forEach(function($item, idx) {
               if (idx < currentLimit) {
                  $item.css({
                     'display': 'flex',
                     'opacity': '1',
                     'transform': 'translateY(0)'
                  }).show();
               } else {
                  $item.hide();
               }
            });

            // Hiển thị hoặc ẩn nút Xem thêm tùy theo số bài còn lại
            if (totalMatched > currentLimit) {
               const remaining = totalMatched - currentLimit;
               $loadMoreWrap.find('.load-more-remaining-count').text(remaining);
               $loadMoreWrap.removeClass('d-none').show();
            } else {
               $loadMoreWrap.addClass('d-none').hide();
            }
         });

         $visibleCount.text(totalVisible);

         if (totalVisible === 0) {
            $noMatches.removeClass('d-none');
            if (rawKeyword) {
               $('#noSearchDesc').text(`Không có bài kiểm tra nào khớp với từ khóa "${rawKeyword}".`);
            } else {
               $('#noSearchDesc').text(`Không có bài kiểm tra nào khớp với bộ lọc đã chọn.`);
            }
         } else {
            $noMatches.addClass('d-none');
         }
      }

      // Xử lý sự kiện bấm "Xem thêm" (tải thêm 4 bài thi mượt mà)
      $(document).on('click', '.btn-load-more-tests', function(e) {
         e.preventDefault();
         const $btn = $(this);
         const $sec = $btn.closest('.topic-group-section');
         const currentLimit = parseInt($sec.data('visible-limit') || 8, 10);
         const newLimit = currentLimit + 4;
         $sec.data('visible-limit', newLimit);

         const rawKeyword = $searchInput.val().trim();
         const keyword = removeVietnameseTones(rawKeyword);
         const $secItems = $sec.find('.test-list-item');

         const matchingItems = [];
         $secItems.each(function() {
            const $item = $(this);
            const itemTitleRaw = $item.find('.test-list-title').text();
            const itemTitle = removeVietnameseTones(itemTitleRaw);
            const itemStatus = String($item.data('status') || '');

            const matchesSearch = (keyword === '') || 
                                  itemTitle.includes(keyword) || 
                                  itemTitleRaw.toLowerCase().includes(rawKeyword.toLowerCase());

            const matchesStatus = (currentStatus === 'all') || (itemStatus === currentStatus);

            if (matchesSearch && matchesStatus) {
               matchingItems.push($item);
            }
         });

         const newlyShown = [];
         matchingItems.forEach(function($item, idx) {
            if (idx >= currentLimit && idx < newLimit) {
               newlyShown.push($item);
            }
         });

         // Hiệu ứng xuất hiện mượt mà (stagger animation)
         newlyShown.forEach(function($item, i) {
            $item.css({
               'display': 'flex',
               'opacity': '0',
               'transform': 'translateY(16px)'
            }).show();

            setTimeout(function() {
               $item.css({
                  'opacity': '1',
                  'transform': 'translateY(0)'
               });
            }, i * 65);
         });

         // Cập nhật số bài thi còn lại hoặc ẩn nút nếu đã hết
         const totalMatched = matchingItems.length;
         const $loadMoreWrap = $sec.find('.topic-load-more-wrap');
         if (totalMatched > newLimit) {
            const remaining = totalMatched - newLimit;
            $loadMoreWrap.find('.load-more-remaining-count').text(remaining);
         } else {
            $loadMoreWrap.fadeOut(250, function() {
               $(this).addClass('d-none');
            });
         }
      });

      // Xử lý sự kiện đổi Topic từ Dropdown
      $topicSelect.on('change', function() {
         currentTopic = $(this).val();
         filterTests(true);
      });

      // Xử lý sự kiện đổi Trạng thái từ Dropdown
      $statusSelect.on('change', function() {
         currentStatus = $(this).val();
         filterTests(true);
      });

      // Tìm kiếm theo từ khóa
      $searchInput.on('input keyup', function() {
         filterTests(true);
      });

      // Xóa ô tìm kiếm
      $clearBtn.on('click', function() {
         $searchInput.val('').focus();
         filterTests(true);
      });

      // Thu gọn / Mở rộng nhóm bài thi
      $(document).on('click', '.btn-toggle-topic', function(e) {
         e.preventDefault();
         const $sec = $(this).closest('.topic-group-section');
         $sec.toggleClass('collapsed');
         const isCollapsed = $sec.hasClass('collapsed');
         $(this).find('.toggle-text').text(isCollapsed ? 'Mở rộng' : 'Thu gọn');
      });

      // Nút xem tất cả / reset bộ lọc
      $btnReset.on('click', function() {
         $searchInput.val('');
         currentStatus = 'all';
         currentTopic = 'all';
         $statusSelect.val('all');
         $topicSelect.val('all');
         filterTests(true);
      });

      updateStatusCounts();
      filterTests(true);
   });

   $(window).on('load', function() {
      if ($.fn.niceSelect) {
         $('#topicFilterSelect, #statusFilterSelect').niceSelect('destroy');
      }
      $('.tests-select-wrapper .nice-select').remove();
   });
</script>
@endpush
