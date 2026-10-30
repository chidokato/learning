@extends('frontend.layouts.profile')

@section('title', 'Báo Cáo Bài Thi Nhân Viên')
@section('page_title', 'Báo cáo kết quả bài thi nhân viên')

@section('breadcrumb')
   <li class="breadcrumb-item active">Báo cáo bài thi</li>
@endsection

@section('page_actions')
   <span class="badge" style="background: rgba(3, 89, 78, 0.1); color: #03594e !important; font-weight: 700; font-size: 13px; padding: 7px 15px; border-radius: 999px;">
      <i class="fa-solid fa-users me-1"></i> {{ $kpi['uniqueUsers'] }} nhân viên / {{ $kpi['totalAttempts'] }} lượt thi
   </span>
@endsection

@push('styles')
<style>
   /* KPI Cards */
   .kpi-stat-card {
      background: #ffffff;
      border: 1px solid #e9ebec;
      border-radius: 12px;
      padding: 18px 20px;
      box-shadow: 0 1px 3px rgba(15, 23, 42, 0.04);
      display: flex;
      align-items: center;
      gap: 16px;
      transition: all 0.2s ease;
      height: 100%;
   }
   .kpi-stat-card:hover {
      transform: translateY(-2px);
      box-shadow: 0 6px 16px rgba(15, 23, 42, 0.08);
      border-color: #cbd5e1;
   }
   .kpi-icon-box {
      width: 48px;
      height: 48px;
      border-radius: 12px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 20px;
      flex-shrink: 0;
   }
   .kpi-icon-box.total {
      background: #eff6ff;
      color: #2563eb;
   }
   .kpi-icon-box.users {
      background: #f0fdf4;
      color: #03594e;
   }
   .kpi-icon-box.pass {
      background: #dcfce7;
      color: #16a34a;
   }
   .kpi-icon-box.fail {
      background: #fee2e2;
      color: #dc2626;
   }
   .kpi-info-label {
      font-size: 12px;
      color: #64748b;
      font-weight: 500;
      margin-bottom: 2px;
   }
   .kpi-info-value {
      font-size: 22px;
      font-weight: 800;
      color: #0f172a;
      line-height: 1.2;
   }
   .kpi-info-sub {
      font-size: 11.5px;
      color: #94a3b8;
      margin-top: 3px;
   }

   /* Filter Box */
   .report-filter-card {
      background: #ffffff;
      border: 1px solid #e9ebec;
      border-radius: 12px;
      padding: 18px 20px;
      box-shadow: 0 1px 3px rgba(15, 23, 42, 0.04);
      margin-bottom: 20px;
   }
   .filter-input-wrap {
      position: relative;
      display: flex;
      align-items: center;
      width: 100%;
   }
   .filter-input-wrap .filter-icon {
      position: absolute;
      left: 14px;
      top: 50%;
      transform: translateY(-50%);
      color: #64748b;
      font-size: 13.5px;
      pointer-events: none;
      z-index: 3;
   }
   /* Hủy bỏ nice-select để dùng native select hiện đại */
   .filter-input-wrap .nice-select {
      display: none !important;
   }
   .filter-control {
      display: block !important;
      width: 100% !important;
      height: 42px !important;
      line-height: 42px !important;
      padding: 0 14px 0 38px !important;
      font-size: 13.5px !important;
      font-weight: 500 !important;
      border-radius: 8px !important;
      border: 1.5px solid #e2e8f0 !important;
      background-color: #f8fafc !important;
      color: #1e293b !important;
      transition: all 0.2s ease !important;
      vertical-align: middle !important;
   }
   .filter-control:hover {
      background-color: #ffffff !important;
      border-color: #cbd5e1 !important;
   }
   .filter-control:focus {
      background-color: #ffffff !important;
      border-color: #03594e !important;
      outline: none !important;
      box-shadow: 0 0 0 3px rgba(3, 89, 78, 0.12) !important;
   }
   .filter-select {
      cursor: pointer !important;
      background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%2364748b' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m2 5 6 6 6-6'/%3e%3c/svg%3e") !important;
      background-repeat: no-repeat !important;
      background-position: right 14px center !important;
      background-size: 11px 9px !important;
      -webkit-appearance: none !important;
      -moz-appearance: none !important;
      appearance: none !important;
      padding-right: 34px !important;
      text-overflow: ellipsis !important;
      white-space: nowrap !important;
      overflow: hidden !important;
   }

   /* Table Card */
   .report-table-card {
      background: #ffffff;
      border: 1px solid #e9ebec;
      border-radius: 12px;
      box-shadow: 0 1px 3px rgba(15, 23, 42, 0.04);
      overflow: hidden;
   }
   .report-table {
      margin-bottom: 0;
   }
   .report-table thead th {
      background: #f8fafc;
      color: #475569;
      font-weight: 700;
      font-size: 12.5px;
      text-transform: uppercase;
      letter-spacing: 0.4px;
      padding: 12px 16px;
      border-bottom: 1px solid #e2e8f0;
      white-space: nowrap;
   }
   .report-table tbody td {
      padding: 14px 16px;
      vertical-align: middle;
      border-bottom: 1px solid #f1f5f9;
      font-size: 13.5px;
   }
   .report-table tbody tr:hover td {
      background: #fbfcfe;
   }

   /* User Avatar & Info */
   .user-avatar-circle {
      width: 40px;
      height: 40px;
      border-radius: 10px;
      background: linear-gradient(135deg, #03594e 0%, #057d6e 100%);
      color: #ffffff;
      font-weight: 700;
      font-size: 15px;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      overflow: hidden;
      flex-shrink: 0;
   }
   .user-avatar-circle img {
      width: 100%;
      height: 100%;
      object-fit: cover;
   }
   .user-fullname {
      font-weight: 700;
      color: #0f172a;
      margin-bottom: 2px;
      line-height: 1.3;
   }
   .user-meta-sub {
      font-size: 12px;
      color: #64748b;
   }

   /* Progress Bar */
   .score-progress-wrap {
      width: 100px;
      height: 6px;
      background: #e2e8f0;
      border-radius: 999px;
      overflow: hidden;
      margin-top: 5px;
   }
   .score-progress-bar {
      height: 100%;
      border-radius: 999px;
   }

   /* Action Buttons */
   .btn-view-attempt {
      display: inline-flex;
      align-items: center;
      gap: 6px;
      font-size: 12px;
      font-weight: 600;
      padding: 6px 14px;
      border-radius: 6px;
      background: #03594e;
      color: #ffffff !important;
      text-decoration: none !important;
      transition: all 0.2s ease;
      box-shadow: 0 1px 3px rgba(3, 89, 78, 0.2);
      white-space: nowrap;
   }
   .btn-view-attempt:hover {
      background: #02433b;
      transform: translateY(-1px);
      box-shadow: 0 3px 8px rgba(3, 89, 78, 0.3);
   }

   /* Attempt Badge */
   .btn-attempts-badge {
      display: inline-flex;
      align-items: center;
      gap: 5px;
      padding: 2px 10px;
      border-radius: 999px;
      font-size: 11.5px;
      font-weight: 600;
      background: #eff6ff;
      color: #2563eb;
      border: 1px solid #bfdbfe;
      cursor: pointer;
      transition: all 0.2s ease;
      line-height: 1.4;
      text-decoration: none;
   }
   .btn-attempts-badge:hover {
      background: #2563eb;
      color: #ffffff;
      border-color: #2563eb;
      transform: translateY(-1px);
      box-shadow: 0 2px 6px rgba(37, 99, 235, 0.25);
   }
   .badge-attempt-single {
      display: inline-flex;
      align-items: center;
      padding: 2px 9px;
      border-radius: 999px;
      font-size: 11px;
      font-weight: 500;
      background: #f8fafc;
      color: #64748b;
      border: 1px solid #e2e8f0;
      line-height: 1.4;
   }

   /* Popup Lịch sử làm bài thu gọn (Compact Modal - Mỗi lần thi 1 dòng) */
   #userTestHistoryModal .modal-dialog {
      width: 95% !important;
      max-width: 820px !important;
      margin: 2rem auto !important;
   }
   #userTestHistoryModal .modal-content {
      border-radius: 12px !important;
      border: 1px solid #cbd5e1 !important;
      box-shadow: 0 20px 25px -5px rgba(15, 23, 42, 0.2), 0 8px 10px -6px rgba(15, 23, 42, 0.1) !important;
      overflow: hidden !important;
      background: #ffffff !important;
   }
   #userTestHistoryModal .modal-header {
      background: #03594e !important;
      color: #ffffff !important;
      padding: 12px 18px !important;
      border: none !important;
      display: flex !important;
      align-items: center !important;
      justify-content: space-between !important;
      position: relative !important;
   }
   #userTestHistoryModal .btn-close-modal {
      background: transparent !important;
      border: none !important;
      color: #ffffff !important;
      opacity: 0.85 !important;
      font-size: 18px !important;
      line-height: 1 !important;
      padding: 4px 8px !important;
      cursor: pointer !important;
      display: flex !important;
      align-items: center !important;
      justify-content: center !important;
      border-radius: 6px !important;
      transition: all 0.2s ease !important;
   }
   #userTestHistoryModal .btn-close-modal:hover {
      opacity: 1 !important;
      background: rgba(255, 255, 255, 0.15) !important;
   }
   #userTestHistoryModal .modal-body {
      padding: 14px 16px !important;
      background-color: #f8fafc !important;
   }
   #userTestHistoryModal .modal-footer {
      padding: 8px 16px !important;
      background-color: #ffffff !important;
      border-top: 1px solid #e2e8f0 !important;
   }
   #userTestHistoryModal .history-table thead th {
      padding: 9px 12px !important;
      font-size: 11.5px !important;
      background: #f1f5f9 !important;
      color: #475569 !important;
      font-weight: 700 !important;
      text-transform: uppercase !important;
      letter-spacing: 0.3px !important;
      border-bottom: 1px solid #e2e8f0 !important;
      white-space: nowrap !important;
   }
   #userTestHistoryModal .history-table tbody td {
      padding: 9px 12px !important;
      font-size: 12.5px !important;
      vertical-align: middle !important;
      border-bottom: 1px solid #f1f5f9 !important;
      white-space: nowrap !important;
      line-height: 1.4 !important;
   }
   #userTestHistoryModal .history-table tbody tr:hover td {
      background-color: #f8fafc !important;
   }
   #userTestHistoryModal .btn-history-view {
      display: inline-flex !important;
      align-items: center !important;
      gap: 5px !important;
      background: #03594e !important;
      color: #ffffff !important;
      font-size: 11.5px !important;
      font-weight: 600 !important;
      padding: 4px 12px !important;
      border-radius: 6px !important;
      text-decoration: none !important;
      white-space: nowrap !important;
      transition: all 0.2s ease !important;
      box-shadow: 0 1px 2px rgba(3, 89, 78, 0.2) !important;
   }
   #userTestHistoryModal .btn-history-view:hover {
      background: #02433b !important;
      color: #ffffff !important;
      transform: translateY(-1px) !important;
   }

   /* Empty State */
   .empty-report-card {
      padding: 60px 20px;
      text-align: center;
   }
   .empty-report-icon {
      width: 64px;
      height: 64px;
      border-radius: 50%;
      background: #f8fafc;
      border: 1px solid #e2e8f0;
      color: #94a3b8;
      font-size: 26px;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      margin-bottom: 16px;
   }
</style>
@endpush

@section('content')
<!-- ================= 1. HÀNG THỐNG KÊ KPI ================= -->
<div class="row g-3 mb-4">
   <!-- KPI 1: Tổng lượt làm bài -->
   <div class="col-xl-3 col-md-6 col-12">
      <div class="kpi-stat-card">
         <div class="kpi-icon-box total">
            <i class="fa-solid fa-file-signature"></i>
         </div>
         <div class="flex-grow-1">
            <div class="kpi-info-label">Tổng lượt làm bài</div>
            <div class="kpi-info-value">{{ number_format($kpi['totalAttempts']) }}</div>
            <div class="kpi-info-sub">Lượt thi toàn hệ thống</div>
         </div>
      </div>
   </div>

   <!-- KPI 2: Nhân viên đã tham gia -->
   <div class="col-xl-3 col-md-6 col-12">
      <div class="kpi-stat-card">
         <div class="kpi-icon-box users">
            <i class="fa-solid fa-users"></i>
         </div>
         <div class="flex-grow-1">
            <div class="kpi-info-label">Nhân viên tham gia</div>
            <div class="kpi-info-value text-primary">{{ number_format($kpi['uniqueUsers']) }}</div>
            <div class="kpi-info-sub">Nhân sự đã hoàn thành bài thi</div>
         </div>
      </div>
   </div>

   <!-- KPI 3: Lượt thi Đạt -->
   <div class="col-xl-3 col-md-6 col-12">
      <div class="kpi-stat-card">
         <div class="kpi-icon-box pass">
            <i class="fa-solid fa-circle-check"></i>
         </div>
         <div class="flex-grow-1">
            <div class="kpi-info-label">Lượt thi Đạt</div>
            <div class="kpi-info-value text-success">{{ number_format($kpi['passedAttempts']) }}</div>
            <div class="kpi-info-sub">Tỉ lệ đạt: <strong>{{ $kpi['passRate'] }}%</strong></div>
         </div>
      </div>
   </div>

   <!-- KPI 4: Lượt thi Chưa đạt -->
   <div class="col-xl-3 col-md-6 col-12">
      <div class="kpi-stat-card">
         <div class="kpi-icon-box fail">
            <i class="fa-solid fa-circle-xmark"></i>
         </div>
         <div class="flex-grow-1">
            <div class="kpi-info-label">Lượt thi Chưa đạt</div>
            <div class="kpi-info-value text-danger">{{ number_format($kpi['failedAttempts']) }}</div>
            <div class="kpi-info-sub">Tỉ lệ: <strong>{{ 100 - $kpi['passRate'] }}%</strong></div>
         </div>
      </div>
   </div>
</div>

<!-- ================= 2. BỘ LỌC TÌM KIẾM ================= -->
<div class="report-filter-card">
   <form action="{{ route('frontend.admin.reports.tests') }}" method="GET" id="reportFilterForm">
      <div class="row g-2 align-items-center">
         <!-- 1. Ô tìm kiếm từ khóa -->
         <div class="col-lg-3 col-md-6 col-12">
            <div class="filter-input-wrap">
               <i class="fa-regular fa-magnifying-glass filter-icon"></i>
               <input 
                  type="text" 
                  name="search" 
                  class="filter-control" 
                  placeholder="Tìm tên, email, mã NV..." 
                  value="{{ $search }}"
               >
            </div>
         </div>

         <!-- 2. Chọn Bài kiểm tra -->
         <div class="col-lg-3 col-md-6 col-12">
            <div class="filter-input-wrap">
               <i class="fa-solid fa-clipboard-list filter-icon"></i>
               <select name="test_id" class="filter-control filter-select" onchange="document.getElementById('reportFilterForm').submit();">
                  <option value="all">Tất cả bài kiểm tra</option>
                  @foreach($allTests as $tp)
                     <option value="{{ $tp->id }}" {{ $testId == $tp->id ? 'selected' : '' }}>
                        {{ $tp->title }}
                     </option>
                  @endforeach
               </select>
            </div>
         </div>

         <!-- 3. Chọn Phòng ban -->
         <div class="col-lg-2 col-md-4 col-6">
            <div class="filter-input-wrap">
               <i class="fa-solid fa-building-user filter-icon"></i>
               <select name="department_id" class="filter-control filter-select" onchange="document.getElementById('reportFilterForm').submit();">
                  <option value="all">Tất cả phòng ban</option>
                  @foreach($departments as $dept)
                     <option value="{{ $dept->id }}" {{ $departmentId == $dept->id ? 'selected' : '' }}>
                        {{ $dept->name }}
                     </option>
                  @endforeach
               </select>
            </div>
         </div>

         <!-- 4. Chọn Trạng thái Đạt / Chưa đạt -->
         <div class="col-lg-2 col-md-4 col-6">
            <div class="filter-input-wrap">
               <i class="fa-solid fa-filter filter-icon"></i>
               <select name="status" class="filter-control filter-select" onchange="document.getElementById('reportFilterForm').submit();">
                  <option value="all" {{ $status == 'all' ? 'selected' : '' }}>Tất cả kết quả</option>
                  <option value="passed" {{ $status == 'passed' ? 'selected' : '' }}>Đã đạt</option>
                  <option value="failed" {{ $status == 'failed' ? 'selected' : '' }}>Chưa đạt</option>
               </select>
            </div>
         </div>

         <!-- 5. Nút Thao tác -->
         <div class="col-lg-2 col-md-4 col-12 d-flex gap-2">
            <button type="submit" class="btn text-white w-100 fw-semibold d-inline-flex align-items-center justify-content-center" style="height: 42px; background: #03594e; border-radius: 8px; font-size: 13.5px;">
               <i class="fa-solid fa-filter me-1"></i> Lọc
            </button>
            @if(!empty($search) || $testId !== 'all' || $departmentId !== 'all' || $status !== 'all')
               <a href="{{ route('frontend.admin.reports.tests') }}" class="btn btn-outline-secondary d-inline-flex align-items-center justify-content-center" style="height: 42px; border-radius: 8px; font-size: 13.5px; min-width: 42px;" title="Xóa bộ lọc">
                  <i class="fa-solid fa-rotate-left"></i>
               </a>
            @endif
         </div>
      </div>
   </form>
</div>

<!-- ================= 3. BẢNG DANH SÁCH BÀI THI CỦA NHÂN VIÊN (ĐÃ GỘP ĐIỂM CAO NHẤT) ================= -->
<div class="report-table-card">
   @if($results->count() > 0)
      <div class="table-responsive">
         <table class="table report-table align-middle">
            <thead>
               <tr>
                  <th class="text-center" style="width: 50px;">#</th>
                  <th>Nhân viên</th>
                  <th>Bài kiểm tra</th>
                  <th>Điểm cao nhất</th>
                  <th class="text-center">Kết quả</th>
                  <th>Thời gian hoàn thành</th>
                  <th class="text-end" style="width: 130px;">Hành động</th>
               </tr>
            </thead>
            <tbody>
               @foreach($results as $res)
                  @php
                     $user = $res->user;
                     $test = $res->test;
                     $totalQ = $test ? ($test->questions_count ?? $test->questions()->count()) : 0;
                     $pct = $totalQ > 0 ? round(($res->score / $totalQ) * 100) : 0;
                     $attemptsCount = (int)($res->attempts_count ?? 1);
                  @endphp
                  <tr>
                     <!-- 1. STT -->
                     <td class="text-center text-muted fw-semibold">
                        {{ ($results->currentPage() - 1) * $results->perPage() + $loop->iteration }}
                     </td>

                     <!-- 2. Thông tin Nhân viên (2 dòng) -->
                     <td>
                        <div class="d-flex align-items-center gap-3">
                           <div class="user-avatar-circle">
                              @if($user && !empty($user->avatar))
                                 <img src="{{ Str::startsWith($user->avatar, ['http://', 'https://']) ? $user->avatar : asset($user->avatar) }}" alt="{{ $user->name }}">
                              @else
                                 {{ mb_strtoupper(mb_substr($user->name ?? 'N', 0, 1, 'UTF-8'), 'UTF-8') }}
                              @endif
                           </div>
                           <div>
                              <div class="user-fullname">{{ $user->name ?? 'Người dùng đã xóa' }}</div>
                              <div class="user-meta-sub d-flex align-items-center flex-wrap gap-2">
                                 <span><i class="fa-regular fa-envelope me-1"></i>{{ $user->email ?? 'N/A' }}</span>
                                 @if($user && !empty($user->employee_code))
                                    <span class="badge bg-light text-secondary border">Mã: {{ $user->employee_code }}</span>
                                 @endif
                                 @if($user && $user->department)
                                    <span class="badge bg-light text-primary border"><i class="fa-solid fa-building me-1"></i>{{ $user->department->name }}</span>
                                 @endif
                              </div>
                           </div>
                        </div>
                     </td>

                     <!-- 3. Bài kiểm tra (Tối ưu đúng 2 dòng) -->
                     <td style="max-width: 440px;">
                        <div class="fw-bold text-dark mb-1 text-truncate" title="{{ $test ? $test->title : '' }}">
                           {{ $test ? $test->title : 'Bài thi #' . $res->test_id }}
                        </div>
                        <div class="text-muted fs-12 d-flex align-items-center flex-nowrap" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                           @if($test && $test->pass_score)
                              <span class="flex-shrink-0">Yêu cầu đạt: <strong>{{ $test->pass_score }}</strong>/{{ $totalQ }} câu</span>
                           @endif
                           @if($test && $test->post)
                              <span class="ms-1 text-primary text-truncate flex-grow-1" title="{{ $test->post->title }}">• {{ $test->post->title }}</span>
                           @endif
                        </div>
                     </td>

                     <!-- 4. Điểm cao nhất (Tối ưu đúng 2 dòng) -->
                     <td>
                        <div class="fw-bold {{ $res->is_passed ? 'text-success' : 'text-danger' }}">
                           {{ $res->score }} / {{ $totalQ }} câu
                           <span class="ms-1 text-muted fs-12 fw-normal">({{ $pct }}%)</span>
                        </div>
                        <div class="mt-1">
                           @if($attemptsCount > 1)
                              <button type="button" 
                                 class="btn-attempts-badge btn-trigger-history" 
                                 data-bs-toggle="modal" 
                                 data-bs-target="#userTestHistoryModal" 
                                 data-user-id="{{ $res->user_id }}" 
                                 data-test-id="{{ $res->test_id }}"
                                 title="Bấm để xem danh sách {{ $attemptsCount }} lần làm bài của nhân viên này">
                                 <i class="fa-solid fa-clock-rotate-left"></i>
                                 <span>{{ $attemptsCount }} lần thi</span>
                              </button>
                           @else
                              <span class="badge-attempt-single">Thi 1 lần</span>
                           @endif
                        </div>
                     </td>

                     <!-- 5. Kết quả (Đạt / Chưa đạt) -->
                     <td class="text-center">
                        @if($res->is_passed)
                           <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-2 rounded-pill fw-bold">
                              <i class="fa-solid fa-circle-check me-1"></i> ĐẠT
                           </span>
                        @else
                           <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-3 py-2 rounded-pill fw-bold">
                              <i class="fa-solid fa-circle-xmark me-1"></i> CHƯA ĐẠT
                           </span>
                        @endif
                     </td>

                     <!-- 6. Thời gian hoàn thành -->
                     <td class="text-muted fs-13">
                        <div>
                           <i class="fa-regular fa-clock me-1"></i>
                           {{ $res->completed_at ? $res->completed_at->timezone('Asia/Ho_Chi_Minh')->format('H:i d/m/Y') : $res->created_at->timezone('Asia/Ho_Chi_Minh')->format('H:i d/m/Y') }}
                        </div>
                     </td>

                     <!-- 7. Hành động -->
                     <td class="text-end">
                        <a href="{{ route('frontend.tests.result', $res->id) }}" class="btn-view-attempt" title="Xem bài làm đạt điểm cao nhất">
                           <i class="fa-solid fa-eye"></i>
                           <span>Xem bài làm</span>
                        </a>
                     </td>
                  </tr>
               @endforeach
            </tbody>
         </table>
      </div>

      <!-- Phân trang -->
      @if($results->hasPages())
         <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 px-4 py-3 border-top bg-light-subtle">
            <div class="text-muted fs-13">
               Hiển thị <strong>{{ $results->firstItem() }}</strong> - <strong>{{ $results->lastItem() }}</strong> trong tổng số <strong>{{ $results->total() }}</strong> bài thi của nhân viên
            </div>
            <div>
               {{ $results->links('pagination::bootstrap-5') }}
            </div>
         </div>
      @endif
   @else
      <div class="empty-report-card">
         <div class="empty-report-icon">
            <i class="fa-solid fa-clipboard-question"></i>
         </div>
         <h5 class="fw-bold mb-2 text-dark">Chưa tìm thấy bài thi nào</h5>
         <p class="text-muted fs-14 mb-3">
            @if(!empty($search) || $testId !== 'all' || $departmentId !== 'all' || $status !== 'all')
               Không có kết quả nào phù hợp với bộ lọc hiện tại của bạn.
            @else
               Hiện tại chưa có nhân viên nào hoàn thành bài thi trong hệ thống.
            @endif
         </p>
         @if(!empty($search) || $testId !== 'all' || $departmentId !== 'all' || $status !== 'all')
            <a href="{{ route('frontend.admin.reports.tests') }}" class="btn btn-outline-primary btn-sm px-3 py-2 fw-semibold">
               <i class="fa-solid fa-rotate-left me-1"></i> Xóa bộ lọc & Xem tất cả
            </a>
         @endif
      </div>
   @endif
</div>

<!-- ================= 4. MODAL POPUP: DANH SÁCH CÁC LẦN LÀM BÀI (THU GỌN) ================= -->
<div class="modal fade" id="userTestHistoryModal" tabindex="-1" aria-labelledby="userTestHistoryModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
      <div class="modal-content">
         <div class="modal-header">
            <div class="d-flex align-items-center gap-2">
               <i class="fa-solid fa-clock-rotate-left text-white fs-15"></i>
               <h6 class="modal-title fw-bold text-white mb-0" id="userTestHistoryModalLabel" style="font-size: 15px;">Lịch sử các lần làm bài thi</h6>
            </div>
            <button type="button" class="btn-close-modal" data-bs-dismiss="modal" aria-label="Close" title="Đóng">
               <i class="fa-solid fa-xmark"></i>
            </button>
         </div>

         <div class="modal-body">
            <!-- Loading Spinner -->
            <div id="modalHistoryLoading" class="text-center py-4">
               <div class="spinner-border" style="width: 2.2rem; height: 2.2rem; color: #03594e !important;" role="status">
                  <span class="visually-hidden">Đang tải...</span>
               </div>
               <div class="text-muted mt-2 fs-13 fw-medium">Đang tải dữ liệu...</div>
            </div>

            <!-- Error message if request fails -->
            <div id="modalHistoryError" class="alert alert-danger py-3 text-center my-2" style="display: none; border-radius: 8px;">
               <i class="fa-solid fa-triangle-exclamation fs-4 mb-1 d-block text-danger"></i>
               <span id="modalHistoryErrorMsg" class="fs-13 fw-semibold">Không thể tải dữ liệu lịch sử thi.</span>
            </div>

            <!-- Content when loaded -->
            <div id="modalHistoryContent" style="display: none;">
               <!-- Thông tin Nhân viên & Bài thi (Thu gọn) -->
               <div class="card border-0 shadow-sm rounded-2 mb-2" style="background: #ffffff; border: 1px solid #e2e8f0 !important;">
                  <div class="card-body p-2 px-3">
                     <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                        <div class="d-flex align-items-center gap-2">
                           <div id="modalUserAvatar" class="user-avatar-circle" style="width: 36px; height: 36px; font-size: 14px; border-radius: 8px;"></div>
                           <div>
                              <div class="fw-bold text-dark fs-13" id="modalUserName"></div>
                              <div class="text-muted fs-11 d-flex align-items-center flex-wrap gap-2">
                                 <span id="modalUserEmail"></span>
                                 <span class="badge bg-light text-secondary border px-1 py-0" id="modalUserCode" style="display: none; font-size: 10px;"></span>
                                 <span class="badge bg-light text-primary border px-1 py-0" id="modalUserDept" style="display: none; font-size: 10px;"></span>
                              </div>
                           </div>
                        </div>
                        <div>
                           <div class="badge rounded-pill fw-bold" id="modalOverallBadge" style="font-size: 11.5px; padding: 4px 10px;"></div>
                        </div>
                     </div>
                     <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 text-muted fs-12 mt-1 pt-1 border-top">
                        <div class="text-truncate flex-grow-1 pe-2" style="max-width: 520px;">
                           <i class="fa-solid fa-clipboard-list me-1 text-primary"></i>
                           <strong class="text-dark" id="modalTestTitle"></strong>
                        </div>
                        <div id="modalTestRequirement" class="flex-shrink-0 text-nowrap"></div>
                     </div>
                  </div>
               </div>

               <!-- Bảng danh sách tất cả các lần thi (Mỗi lần đúng 1 dòng) -->
               <div class="card border-0 shadow-sm rounded-2 overflow-hidden" style="background: #ffffff; border: 1px solid #e2e8f0 !important;">
                  <div class="table-responsive" style="max-height: 400px;">
                     <table class="table history-table align-middle mb-0">
                        <thead class="sticky-top">
                           <tr>
                              <th class="text-center" style="width: 70px;">Lần</th>
                              <th style="width: 160px;">Thời gian nộp</th>
                              <th>Điểm số</th>
                              <th class="text-center" style="width: 110px;">Kết quả</th>
                              <th class="text-end" style="width: 110px;">Hành động</th>
                           </tr>
                        </thead>
                        <tbody id="modalAttemptsTableBody">
                           <!-- Dynamic rows loaded via JS -->
                        </tbody>
                     </table>
                  </div>
               </div>
            </div>
         </div>

         <div class="modal-footer">
            <button type="button" class="btn btn-secondary btn-sm px-3 fw-medium" data-bs-dismiss="modal" style="height: 32px; border-radius: 6px; font-size: 12.5px;">Đóng</button>
         </div>
      </div>
   </div>
</div>
@endsection

@push('scripts')
<script>
   $(document).ready(function() {
      // 1. Tắt bỏ niceSelect trên các ô chọn của trang báo cáo
      if ($.fn.niceSelect) {
         $('.filter-select, select').niceSelect('destroy');
      }
      $('.filter-input-wrap .nice-select').remove();

      // 2. Xử lý hiển thị popup danh sách các lần làm bài
      $(document).on('click', '.btn-trigger-history', function(e) {
         var userId = $(this).data('user-id');
         var testId = $(this).data('test-id');

         if (!userId || !testId) return;

         // Mở popup modal
         try {
            if (window.bootstrap && window.bootstrap.Modal) {
               var m = bootstrap.Modal.getOrCreateInstance(document.getElementById('userTestHistoryModal'));
               if (m) m.show();
            } else {
               $('#userTestHistoryModal').modal('show');
            }
         } catch(err) {
            $('#userTestHistoryModal').modal('show');
         }

         // Reset trạng thái đang tải
         $('#modalHistoryLoading').show();
         $('#modalHistoryContent').hide();
         $('#modalHistoryError').hide();

         // Gọi AJAX lấy lịch sử các lần thi
         $.ajax({
            url: "{{ route('frontend.admin.reports.user-test-history') }}",
            type: 'GET',
            data: {
               user_id: userId,
               test_id: testId
            },
            dataType: 'json',
            success: function(res) {
               if (res.success) {
                  var user = res.user;
                  var test = res.test;
                  var stats = res.stats;
                  var attempts = res.attempts;

                  // Điền thông tin nhân viên
                  $('#modalUserName').text(user.name || 'Người dùng');
                  $('#modalUserEmail').html('<i class="fa-regular fa-envelope me-1"></i>' + (user.email || 'N/A'));

                  if (user.avatar) {
                     $('#modalUserAvatar').html('<img src="' + user.avatar + '" alt="' + user.name + '" style="width:100%;height:100%;object-fit:cover;">');
                  } else {
                     var initial = (user.name ? user.name.charAt(0) : 'U').toUpperCase();
                     $('#modalUserAvatar').text(initial);
                  }

                  if (user.employee_code) {
                     $('#modalUserCode').text('Mã: ' + user.employee_code).show();
                  } else {
                     $('#modalUserCode').hide();
                  }

                  if (user.department_name) {
                     $('#modalUserDept').html('<i class="fa-solid fa-building me-1"></i>' + user.department_name).show();
                  } else {
                     $('#modalUserDept').hide();
                  }

                  // Huy hiệu tổng kết trạng thái (Đạt / Chưa đạt)
                  if (stats.has_passed) {
                     $('#modalOverallBadge')
                        .attr('class', 'badge bg-success-subtle text-success border border-success-subtle rounded-pill fw-bold')
                        .html('<i class="fa-solid fa-circle-check me-1"></i> ĐÃ ĐẠT (Điểm cao nhất: ' + stats.max_score + '/' + test.total_questions + ')');
                  } else {
                     $('#modalOverallBadge')
                        .attr('class', 'badge bg-danger-subtle text-danger border border-danger-subtle rounded-pill fw-bold')
                        .html('<i class="fa-solid fa-circle-xmark me-1"></i> CHƯA ĐẠT (Điểm cao nhất: ' + stats.max_score + '/' + test.total_questions + ')');
                  }

                  // Thông tin bài thi & yêu cầu
                  $('#modalTestTitle').text(test.title || ('Bài thi #' + test.id));
                  var reqHtml = '';
                  if (test.pass_score) {
                     reqHtml += 'Yêu cầu: <strong>' + test.pass_score + '/' + test.total_questions + ' câu</strong>';
                  }
                  if (test.course_title) {
                     reqHtml += (reqHtml ? ' • ' : '') + '<span class="text-primary">' + test.course_title + '</span>';
                  }
                  $('#modalTestRequirement').html(reqHtml);

                  // Tạo các hàng trong bảng lần thi thu gọn (Mỗi lần đúng 1 dòng)
                  var rowsHtml = '';
                  if (attempts && attempts.length > 0) {
                     attempts.forEach(function(att) {
                        var bestBadge = att.is_best 
                           ? '<span class="badge ms-2" style="background: #fef3c7; color: #b45309; border: 1px solid #fde68a; font-size: 10px; padding: 2px 7px; font-weight: 700; vertical-align: middle;"><i class="fa-solid fa-crown me-1 text-warning"></i> Điểm cao nhất</span>' 
                           : '';
                        var resultBadge = att.is_passed 
                           ? '<span class="badge bg-success-subtle text-success border border-success-subtle px-2.5 py-1 rounded-pill fw-bold" style="font-size: 11px;"><i class="fa-solid fa-circle-check me-1"></i> ĐẠT</span>'
                           : '<span class="badge bg-danger-subtle text-danger border border-danger-subtle px-2.5 py-1 rounded-pill fw-bold" style="font-size: 11px;"><i class="fa-solid fa-circle-xmark me-1"></i> CHƯA ĐẠT</span>';
                        var scoreColor = att.is_passed ? 'text-success' : 'text-danger';

                        rowsHtml += `
                           <tr style="${att.is_best ? 'background-color: #fffdf5;' : ''}">
                              <td class="text-center fw-bold text-secondary fs-12">
                                 Lần ${att.attempt_number}
                              </td>
                              <td class="text-muted fs-12">
                                 <i class="fa-regular fa-clock me-1 text-muted"></i>${att.completed_at}
                              </td>
                              <td>
                                 <span class="fw-bold ${scoreColor} fs-13">${att.score}/${att.total_questions}</span>
                                 <span class="text-muted fs-11 ms-1">(${att.percentage}%)</span>
                                 ${bestBadge}
                              </td>
                              <td class="text-center">
                                 ${resultBadge}
                              </td>
                              <td class="text-end">
                                 <a href="${att.view_url}" target="_blank" class="btn-history-view" title="Xem bài làm lần này">
                                    <i class="fa-solid fa-eye"></i> Xem bài
                                 </a>
                              </td>
                           </tr>
                        `;
                     });
                  } else {
                     rowsHtml = '<tr><td colspan="5" class="text-center text-muted py-4">Chưa có lượt làm bài nào.</td></tr>';
                  }

                  $('#modalAttemptsTableBody').html(rowsHtml);
                  $('#modalHistoryLoading').hide();
                  $('#modalHistoryContent').fadeIn(200);
               } else {
                  showModalError(res.message || 'Không thể tải dữ liệu các lần làm bài.');
               }
            },
            error: function(xhr) {
               showModalError('Đã có lỗi xảy ra khi kết nối máy chủ. Vui lòng tải lại trang.');
            }
         });
      });

      function showModalError(msg) {
         $('#modalHistoryLoading').hide();
         $('#modalHistoryContent').hide();
         $('#modalHistoryErrorMsg').text(msg);
         $('#modalHistoryError').fadeIn(200);
      }
   });

   $(window).on('load', function() {
      if ($.fn.niceSelect) {
         $('.filter-select, select').niceSelect('destroy');
      }
      $('.filter-input-wrap .nice-select').remove();
   });
</script>
@endpush
