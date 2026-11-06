@extends('frontend.layouts.profile')

@section('title', 'Báo Cáo Tiến Độ Đào Tạo & Kết Quả Thi')
@section('page_title', 'Báo Cáo Tiến Độ Đào Tạo & Kết Quả Thi')

@section('breadcrumb')
   <li class="breadcrumb-item"><a href="{{ route('frontend.profile') }}" class="text-secondary text-decoration-none">Tài khoản</a></li>
   <li class="breadcrumb-item active">Báo cáo đào tạo & thi</li>
@endsection

@section('page_actions')
   <div class="d-flex align-items-center gap-2">
      <!-- Nút Xuất Excel nổi bật -->
      <a href="{{ route('frontend.admin.reports.learning.export', request()->all()) }}" 
         class="btn btn-success fw-semibold d-inline-flex align-items-center gap-2 px-3 py-2 shadow-sm"
         style="background: #107c41; border-color: #107c41; border-radius: 8px; font-size: 13.5px;"
         title="Xuất danh sách theo bộ lọc hiện tại ra file Excel (.xlsx)">
         <i class="fa-solid fa-file-excel fs-15"></i>
         <span>Xuất Excel</span>
      </a>

      <span class="badge d-none d-md-inline-flex" style="background: rgba(3, 89, 78, 0.1); color: #03594e !important; font-weight: 700; font-size: 13px; padding: 8px 14px; border-radius: 999px;">
         <i class="fa-solid fa-users me-1"></i> {{ $kpi['uniqueUsers'] }} NV / {{ $kpi['totalRecords'] }} lượt ghi nhận
      </span>
   </div>
@endsection

@push('styles')
   <link rel="stylesheet" href="{{ asset('assets/css/test-report.css') }}?v={{ filemtime(public_path('assets/css/test-report.css')) }}">
   <link rel="stylesheet" href="{{ asset('admin-assets/libs/select2/select2.min.css') }}">
   <style>
      /* Select2 CSS Tùy biến đồng bộ với giao diện Admin */
      select.select2-hidden-accessible {
         display: none !important;
         position: absolute !important;
         visibility: hidden !important;
      }
      .filter-input-wrap .select2-container {
         width: 100% !important;
         display: block !important;
      }
      .filter-input-wrap .select2-container .select2-selection--single {
         height: 42px !important;
         background-color: #f8fafc !important;
         border: 1.5px solid #e2e8f0 !important;
         border-radius: 8px !important;
         padding-left: 38px !important;
         padding-right: 32px !important;
         display: flex !important;
         align-items: center !important;
         transition: all 0.2s ease !important;
      }
      .filter-input-wrap .select2-container .select2-selection--single:hover {
         background-color: #ffffff !important;
         border-color: #cbd5e1 !important;
      }
      .filter-input-wrap .select2-container--open .select2-selection--single,
      .filter-input-wrap .select2-container--focus .select2-selection--single {
         background-color: #ffffff !important;
         border-color: #03594e !important;
         outline: none !important;
         box-shadow: 0 0 0 3px rgba(3, 89, 78, 0.12) !important;
      }
      .filter-input-wrap .select2-container .select2-selection__rendered {
         padding-left: 0 !important;
         padding-right: 0 !important;
         font-size: 13.5px !important;
         font-weight: 500 !important;
         color: #1e293b !important;
         line-height: normal !important;
         overflow: hidden !important;
         text-overflow: ellipsis !important;
         white-space: nowrap !important;
         width: 100% !important;
         text-align: left !important;
      }
      .filter-input-wrap .select2-container .select2-selection__arrow {
         height: 40px !important;
         right: 12px !important;
         top: 50% !important;
         transform: translateY(-50%) !important;
      }
      .filter-input-wrap .select2-container .select2-selection__arrow b {
         border-color: #64748b transparent transparent transparent !important;
         border-width: 5px 4px 0 4px !important;
      }
      .filter-input-wrap .select2-container--open .select2-selection__arrow b {
         border-color: transparent transparent #03594e transparent !important;
         border-width: 0 4px 5px 4px !important;
      }
      .select2-dropdown {
         border: 1.5px solid #03594e !important;
         border-radius: 8px !important;
         box-shadow: 0 10px 25px rgba(15, 23, 42, 0.12) !important;
         z-index: 99999 !important;
         overflow: hidden !important;
         background: #ffffff !important;
      }
      .select2-search--dropdown {
         padding: 8px 10px !important;
         background: #f8fafc !important;
         border-bottom: 1px solid #e2e8f0 !important;
      }
      .select2-search--dropdown .select2-search__field {
         height: 38px !important;
         border: 1.5px solid #cbd5e1 !important;
         border-radius: 6px !important;
         padding: 0 12px !important;
         font-size: 13px !important;
         outline: none !important;
         background: #ffffff !important;
      }
      .select2-search--dropdown .select2-search__field:focus {
         border-color: #03594e !important;
         box-shadow: 0 0 0 2px rgba(3, 89, 78, 0.1) !important;
      }
      .select2-results__options {
         max-height: 280px !important;
         padding: 4px !important;
      }
      .select2-results__option {
         font-size: 13.5px !important;
         padding: 9px 12px !important;
         border-radius: 6px !important;
         margin-bottom: 2px !important;
         color: #1e293b !important;
         line-height: 1.35 !important;
      }
      .select2-results__option--highlighted[aria-selected] {
         background-color: #03594e !important;
         color: #ffffff !important;
      }
      .select2-results__option[aria-selected="true"] {
         background-color: rgba(3, 89, 78, 0.08) !important;
         color: #03594e !important;
         font-weight: 700 !important;
      }

      /* Nút dropdown bộ lọc khác */
      .btn-filter-dropdown {
         height: 42px !important;
         background: #f8fafc !important;
         border: 1.5px solid #e2e8f0 !important;
         border-radius: 8px !important;
         color: #334155 !important;
         font-size: 13.5px !important;
         font-weight: 500 !important;
         display: inline-flex !important;
         align-items: center !important;
         justify-content: space-between !important;
         padding: 0 14px !important;
         width: 100% !important;
         transition: all 0.2s ease !important;
      }
      .btn-filter-dropdown:hover,
      .btn-filter-dropdown:focus,
      .btn-filter-dropdown[aria-expanded="true"] {
         border-color: #03594e !important;
         background: #ffffff !important;
         color: #03594e !important;
         box-shadow: 0 0 0 2px rgba(3, 89, 78, 0.1) !important;
      }
      .btn-filter-dropdown.has-active {
         border-color: #107c41 !important;
         background: rgba(16, 124, 65, 0.06) !important;
         color: #107c41 !important;
         font-weight: 600 !important;
      }
      .more-filters-menu {
         min-width: 320px !important;
         border-radius: 12px !important;
         margin-top: 8px !important;
         box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1) !important;
      }
      .filter-dropdown-select {
         height: 38px !important;
         border-radius: 6px !important;
         border: 1.5px solid #e2e8f0 !important;
         background-color: #f8fafc !important;
      }
      .filter-dropdown-select:focus {
         border-color: #03594e !important;
         box-shadow: 0 0 0 2px rgba(3, 89, 78, 0.1) !important;
      }

      /* Bắt buộc toàn bộ các ô trong bảng không được xuống dòng */
      .report-table {
         white-space: nowrap !important;
      }
      .report-table thead tr th,
      .report-table tbody tr td {
         white-space: nowrap !important;
         vertical-align: middle !important;
         padding: 8px 12px !important;
         font-size: 13px !important;
      }
      .report-table tbody tr {
         height: 42px !important;
      }
      .report-table td > span,
      .report-table td > div {
         white-space: nowrap !important;
      }

      /* Giới hạn độ rộng tên khóa học hiển thị 1 dòng gọn gàng, có dấu ... nếu dài */
      .col-course-title {
         max-width: 250px !important;
         width: 250px !important;
         white-space: nowrap !important;
      }
      .course-title-truncate {
         max-width: 240px !important;
         white-space: nowrap !important;
         overflow: hidden !important;
         text-overflow: ellipsis !important;
         display: inline-block !important;
         vertical-align: middle !important;
         cursor: pointer;
      }

      /* Tùy chỉnh màu header bảng giống hệt ảnh mẫu Excel của khách */
      .report-table thead tr th.th-user-info {
         background: #fff8e1 !important;
         color: #6b4e00 !important;
         border-bottom: 2px solid #ecdca0 !important;
      }
      .report-table thead tr th.th-course-info {
         background: #e8f5e9 !important;
         color: #1b5e20 !important;
         border-bottom: 2px solid #b7dfb9 !important;
      }
      
      /* Bỏ bold chữ bên trong bảng, viết bình thường */
      .report-table tbody tr td {
         font-weight: 400 !important;
      }
      .report-table tbody tr td span,
      .report-table tbody tr td div,
      .report-table tbody tr td a {
         font-weight: 400 !important;
      }

      /* Màu chữ trạng thái gọn gàng, không dùng khung viền hay background, viết bình thường không bold */
      .text-completed {
         color: #16a34a !important;
         font-weight: 400 !important;
         display: inline-flex;
         align-items: center;
         white-space: nowrap !important;
      }
      .text-in-progress {
         color: #d97706 !important;
         font-weight: 400 !important;
         display: inline-flex;
         align-items: center;
         white-space: nowrap !important;
      }
      .text-attempt {
         color: #0284c7 !important;
         font-weight: 400 !important;
         white-space: nowrap !important;
      }
      .text-passed {
         color: #16a34a !important;
         font-weight: 400 !important;
         display: inline-flex;
         align-items: center;
         white-space: nowrap !important;
      }
      .text-failed {
         color: #dc2626 !important;
         font-weight: 400 !important;
         display: inline-flex;
         align-items: center;
         white-space: nowrap !important;
      }
      
      /* Nút số lần thi có thể click mở modal popup lịch sử */
      .btn-trigger-history {
         background: transparent;
         border: none;
         padding: 0;
         color: #0284c7 !important;
         cursor: pointer;
         text-decoration: underline;
         font-weight: 500 !important;
         transition: color 0.15s ease;
      }
      .btn-trigger-history:hover {
         color: #0369a1 !important;
         text-decoration: underline;
      }
   </style>
@endpush

@section('content')
<!-- ================= 2. BỘ LỌC TÌM KIẾM (1 DÒNG DUY NHẤT) ================= -->
@php
   $activeMoreCount = 0;
   if ($filters['learning_status'] !== 'all') $activeMoreCount++;
   if ($filters['test_result'] !== 'all') $activeMoreCount++;
   if ($filters['view_mode'] !== 'best_attempt') $activeMoreCount++;
@endphp
<div class="report-filter-card">
   <form action="{{ route('frontend.admin.reports.learning') }}" method="GET" id="learningReportFilterForm">
      <div class="row g-2 align-items-center">
         <!-- 1. Ô tìm kiếm từ khóa -->
         <div class="col-xl-3 col-lg-3 col-md-4 col-12">
            <div class="filter-input-wrap">
               <i class="fa-regular fa-magnifying-glass filter-icon"></i>
               <input 
                  type="text" 
                  name="search" 
                  class="filter-control" 
                  placeholder="Tìm họ tên, mã NV, email, khóa..." 
                  value="{{ $filters['search'] }}"
               >
            </div>
         </div>

         <!-- 2. Chọn Khóa học -->
         <div class="col-xl-4 col-lg-4 col-md-4 col-12">
            <div class="filter-input-wrap">
               <i class="fa-solid fa-book-open filter-icon"></i>
               <select name="course_id" class="filter-control select2-filter">
                  <option value="all">Tất cả khóa học</option>
                  @foreach($courses as $c)
                     <option value="{{ $c->id }}" {{ $filters['course_id'] == $c->id ? 'selected' : '' }}>
                        {{ $c->title }}
                     </option>
                  @endforeach
               </select>
            </div>
         </div>

         <!-- 3. Chọn Phòng ban -->
         <div class="col-xl-3 col-lg-3 col-md-4 col-12">
            <div class="filter-input-wrap">
               <i class="fa-solid fa-building filter-icon"></i>
               <select name="department_id" class="filter-control select2-filter">
                  <option value="all">Tất cả đơn vị / phòng ban</option>
                  @foreach($departments as $deptKey => $deptVal)
                     @php
                        $dId = is_object($deptVal) ? $deptVal->id : $deptKey;
                        $dName = is_object($deptVal) ? $deptVal->name : $deptVal;
                     @endphp
                     <option value="{{ $dId }}" {{ (string)$filters['department_id'] === (string)$dId ? 'selected' : '' }}>
                        {{ $dName }}
                     </option>
                  @endforeach
               </select>
            </div>
         </div>

         <!-- 4. Dropdown Bộ lọc khác (Tình trạng học, Kết quả thi, Chế độ hiển thị) -->
         <div class="col-xl-2 col-lg-2 col-md-12 col-12">
            <div class="dropdown w-100">
               <button 
                  class="btn-filter-dropdown dropdown-toggle {{ $activeMoreCount > 0 ? 'has-active' : '' }}" 
                  type="button" 
                  id="moreFiltersDropdown" 
                  data-bs-toggle="dropdown" 
                  data-bs-auto-close="outside" 
                  aria-expanded="false"
                  title="Các tùy chọn lọc mở rộng"
               >
                  <span class="d-inline-flex align-items-center gap-2 text-truncate">
                     <i class="fa-solid fa-sliders"></i>
                     <span>Bộ lọc khác</span>
                  </span>
                  @if($activeMoreCount > 0)
                     <span class="badge rounded-pill bg-success ms-1">{{ $activeMoreCount }}</span>
                  @endif
               </button>

               <div class="dropdown-menu dropdown-menu-end p-3 shadow-lg border-0 more-filters-menu" aria-labelledby="moreFiltersDropdown">
                  <div class="d-flex align-items-center justify-content-between pb-2 mb-3 border-bottom">
                     <span class="fw-bold fs-13 text-dark">
                        <i class="fa-solid fa-sliders me-1 text-primary"></i> Bộ lọc mở rộng
                     </span>
                     @if($activeMoreCount > 0)
                        <a href="javascript:void(0)" id="resetMoreFiltersBtn" class="text-danger fs-12 text-decoration-none fw-semibold">
                           <i class="fa-solid fa-rotate-left me-1"></i>Đặt lại
                        </a>
                     @endif
                  </div>

                  <!-- Tình trạng học -->
                  <div class="mb-3">
                     <label class="form-label fs-12 fw-semibold text-secondary mb-1">
                        <i class="fa-solid fa-book-reader me-1 text-muted"></i> Tình trạng học
                     </label>
                     <select name="learning_status" class="form-select fs-13 filter-dropdown-select">
                        <option value="all" {{ $filters['learning_status'] == 'all' ? 'selected' : '' }}>Tất cả tình trạng học</option>
                        <option value="completed" {{ $filters['learning_status'] == 'completed' ? 'selected' : '' }}>✓ Hoàn thành</option>
                        <option value="in_progress" {{ $filters['learning_status'] == 'in_progress' ? 'selected' : '' }}>⏰ Chưa hoàn thành</option>
                     </select>
                  </div>

                  <!-- Kết quả thi -->
                  <div class="mb-3">
                     <label class="form-label fs-12 fw-semibold text-secondary mb-1">
                        <i class="fa-solid fa-square-poll-vertical me-1 text-muted"></i> Kết quả thi
                     </label>
                     <select name="test_result" class="form-select fs-13 filter-dropdown-select">
                        <option value="all" {{ $filters['test_result'] == 'all' ? 'selected' : '' }}>Tất cả kết quả thi</option>
                        <option value="passed" {{ $filters['test_result'] == 'passed' ? 'selected' : '' }}>✓ Đạt</option>
                        <option value="failed" {{ $filters['test_result'] == 'failed' ? 'selected' : '' }}>✕ Không đạt</option>
                        <option value="not_taken" {{ $filters['test_result'] == 'not_taken' ? 'selected' : '' }}>Chưa thi</option>
                     </select>
                  </div>

                  <!-- Chế độ hiển thị -->
                  <div>
                     <label class="form-label fs-12 fw-semibold text-secondary mb-1">
                        <i class="fa-solid fa-layer-group me-1 text-muted"></i> Chế độ hiển thị
                     </label>
                     <select name="view_mode" class="form-select fs-13 filter-dropdown-select">
                        <option value="best_attempt" {{ $filters['view_mode'] == 'best_attempt' ? 'selected' : '' }}>Chỉ lấy lần điểm cao nhất</option>
                        <option value="latest_attempt" {{ $filters['view_mode'] == 'latest_attempt' ? 'selected' : '' }}>Chỉ lấy lần thi mới nhất</option>
                        <option value="all_attempts" {{ $filters['view_mode'] == 'all_attempts' ? 'selected' : '' }}>Hiển thị tất cả lần thi (Chi tiết)</option>
                     </select>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </form>
</div>

<!-- ================= 3. BẢNG DỮ LIỆU BÁO CÁO ================= -->
<div class="report-table-card">
   @if($paginatedResults->count() > 0)
      <div class="table-responsive">
         <table class="table report-table align-middle">
            <thead>
               <tr>
                  <th class="text-center" style="width: 40px;">#</th>
                  <!-- Cột C -> G: Nhóm thông tin nhân viên (Màu vàng nhạt) -->
                  <th class="th-user-info text-center">Mã NV</th>
                  <th class="th-user-info">Họ tên</th>
                  <th class="th-user-info">Chức danh</th>
                  <th class="th-user-info">Công ty</th>
                  <th class="th-user-info">Phòng ban</th>
                  <th class="th-user-info">Email</th>

                  <!-- Cột H -> O: Nhóm thông tin khóa học & bài thi (Màu xanh lá nhạt) -->
                  <th class="th-course-info text-center">Mã KH</th>
                  <th class="th-course-info col-course-title">Tên khóa học</th>
                  <th class="th-course-info text-center">TG học</th>
                  <th class="th-course-info text-center">TT học</th>
                  <th class="th-course-info text-center">Lần thi</th>
                  <th class="th-course-info text-center">Ngày thi</th>
                  <th class="th-course-info text-center" title="Thời gian hoàn thành bài thi">TG hoàn thành</th>
                  <th class="th-course-info text-center">Điểm</th>
                  <th class="th-course-info text-center">Kết quả</th>
               </tr>
            </thead>
            <tbody>
               @foreach($paginatedResults as $item)
                  <tr>
                     <!-- 1. STT -->
                     <td class="text-center text-muted">
                        {{ ($paginatedResults->currentPage() - 1) * $paginatedResults->perPage() + $loop->iteration }}
                     </td>

                     <!-- 2. Mã NV -->
                     <td class="text-center">
                        @if(!empty($item['employee_code']))
                           <span class="font-monospace text-secondary">{{ $item['employee_code'] }}</span>
                        @else
                           <span class="text-muted">-</span>
                        @endif
                     </td>

                     <!-- 3. Họ tên -->
                     <td>
                        <span class="text-dark">{{ $item['name'] }}</span>
                     </td>

                     <!-- 4. Chức danh -->
                     <td>
                        <span>{{ $item['job_title'] ?: '-' }}</span>
                     </td>

                     <!-- 5. Công ty -->
                     <td>
                        @if(!empty($item['company']) && $item['company'] !== '-')
                           <span class="text-dark" style="white-space: nowrap;">{{ $item['company'] }}</span>
                        @else
                           <span class="text-muted">-</span>
                        @endif
                     </td>

                     <!-- 6. Phòng ban -->
                     <td>
                        @if(!empty($item['department']) && $item['department'] !== '-')
                           <span class="text-primary" style="white-space: nowrap;">{{ $item['department'] }}</span>
                        @else
                           <span class="text-muted">-</span>
                        @endif
                     </td>

                     <!-- 7. Email -->
                     <td>
                        <span class="text-muted">{{ $item['email'] }}</span>
                     </td>

                     <!-- 7. Mã KH -->
                     <td class="text-center">
                        <span class="text-primary font-monospace">{{ $item['course_code'] }}</span>
                     </td>

                     <!-- 8. Tên khóa học -->
                     <td class="col-course-title">
                        <span class="text-dark course-title-truncate" title="{{ $item['course_title'] }}">{{ $item['course_title'] }}</span>
                     </td>

                     <!-- 9. TG học -->
                     <td class="text-center">
                        <span class="text-secondary">{{ $item['study_time'] }}</span>
                     </td>

                     <!-- 10. TT học -->
                     <td class="text-center">
                        @if($item['learning_status'] === 'Hoàn thành')
                           <span class="text-completed" title="Hoàn thành khóa học">Hoàn thành</span>
                        @else
                           <span class="text-in-progress" title="Chưa hoàn thành khóa học">Chưa xong</span>
                        @endif
                     </td>

                     <!-- 11. Lần thi -->
                     <td class="text-center">
                        @if($item['attempts_count'] > 0 && !empty($item['test_id']))
                           <button type="button" 
                              class="btn-trigger-history" 
                              data-bs-toggle="modal" 
                              data-bs-target="#userTestHistoryModal" 
                              data-user-id="{{ $item['user_id'] }}" 
                              data-test-id="{{ $item['test_id'] }}"
                              title="Bấm để xem chi tiết lịch sử {{ $item['attempts_count'] }} lần làm bài thi">
                              {{ $item['attempts_count'] }}
                           </button>
                        @else
                           <span class="text-muted">{{ $item['attempts_count'] ?: 0 }}</span>
                        @endif
                     </td>

                     <!-- 12. Ngày thi -->
                     <td class="text-center">
                        @if(!empty($item['test_date']) && $item['test_date'] !== '-')
                           <span class="text-secondary" style="white-space: nowrap;">{{ $item['test_date'] }}</span>
                        @else
                           <span class="text-muted">-</span>
                        @endif
                     </td>

                     <!-- 13. Thời gian hoàn thành bài thi -->
                     <td class="text-center">
                        @if(!empty($item['test_duration']) && $item['test_duration'] !== '-')
                           <span class="text-secondary" style="white-space: nowrap;">{{ $item['test_duration'] }}</span>
                        @else
                           <span class="text-muted">-</span>
                        @endif
                     </td>

                     <!-- 14. Điểm -->
                     <td class="text-center">
                        @if($item['score'] !== '-' && $item['score'] !== null && $item['score'] !== '')
                           <span class="fs-13 {{ $item['result'] === 'Đạt' ? 'text-success' : ($item['result'] === 'Không đạt' ? 'text-danger' : 'text-dark') }}">
                              {{ $item['score'] }}
                           </span>
                        @else
                           <span class="text-muted">-</span>
                        @endif
                     </td>

                     <!-- 15. Kết quả -->
                     <td class="text-center">
                        @if($item['result'] === 'Đạt')
                           <span class="text-passed">Đạt</span>
                        @elseif($item['result'] === 'Không đạt')
                           <span class="text-failed" title="Không đạt">K.Đạt</span>
                        @else
                           <span class="text-muted">{{ $item['result'] }}</span>
                        @endif
                     </td>
                  </tr>
               @endforeach
            </tbody>
         </table>
      </div>

      <!-- Phân trang -->
      <div class="d-flex flex-wrap align-items-center justify-content-between p-3 border-top gap-3">
         <div class="text-muted fs-13">
            Hiển thị <strong>{{ $paginatedResults->firstItem() }}</strong> - <strong>{{ $paginatedResults->lastItem() }}</strong> trên tổng số <strong>{{ $paginatedResults->total() }}</strong> bản ghi
         </div>
         <div>
            {{ $paginatedResults->links('pagination::bootstrap-5') }}
         </div>
      </div>
   @else
      <div class="text-center py-5">
         <div class="mb-3">
            <i class="fa-regular fa-folder-open text-muted" style="font-size: 48px;"></i>
         </div>
         <h5 class="fw-bold text-dark mb-1">Không tìm thấy dữ liệu báo cáo</h5>
         <p class="text-muted fs-13 mb-3">Thử thay đổi bộ lọc hoặc từ khóa tìm kiếm để xem các bản ghi khác.</p>
         <a href="{{ route('frontend.admin.reports.learning') }}" class="btn btn-outline-primary btn-sm px-3 py-2" style="border-radius: 8px;">
            <i class="fa-solid fa-rotate-left me-1"></i> Đặt lại bộ lọc
         </a>
      </div>
   @endif
</div>

<!-- ================= 4. MODAL POPUP: DANH SÁCH CÁC LẦN LÀM BÀI ================= -->
<div class="modal fade" id="userTestHistoryModal" tabindex="-1" aria-labelledby="userTestHistoryModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
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
               <!-- Thông tin Nhân viên & Đề thi / Bài giảng -->
               <div class="modal-profile-card">
                  <!-- 1. Hàng thông tin Nhân viên & Kết quả tổng quan -->
                  <div class="d-flex align-items-center justify-content-between gap-3" style="min-width: 0;">
                     <div class="d-flex align-items-center gap-3 min-width-0">
                        <div id="modalUserAvatar" class="user-avatar-modal flex-shrink-0"></div>
                        <div class="min-width-0">
                           <div class="d-flex align-items-center gap-2 flex-wrap">
                              <span class="fw-bold text-dark fs-15" id="modalUserName"></span>
                              <span class="badge bg-light text-secondary border px-2 py-0.5" id="modalUserCode" style="display: none; font-size: 11px;"></span>
                              <span class="badge bg-light text-primary border px-2 py-0.5" id="modalUserDept" style="display: none; font-size: 11px;"></span>
                           </div>
                           <div class="text-muted fs-12 mt-1 d-flex align-items-center" id="modalUserEmail"></div>
                        </div>
                     </div>
                     <div class="flex-shrink-0 text-end">
                        <div id="modalOverallBadge"></div>
                        <div id="modalBestScoreSub" class="text-muted fs-11 mt-1"></div>
                     </div>
                  </div>

                  <!-- 2. Hộp thông tin Bài thi & Bài giảng liên kết -->
                  <div class="modal-meta-box">
                     <!-- Dòng 1: Bài thi & Yêu cầu đạt -->
                     <div class="d-flex align-items-start gap-2.5 mb-2.5" style="min-width: 0;">
                        <div class="min-width-0 flex-grow-1">
                           <div class="d-flex align-items-start justify-content-between gap-2 flex-wrap">
                              <div class="fw-bold text-dark fs-13.5 pe-2" id="modalTestTitle" style="word-break: break-word; line-height: 1.45; flex: 1 1 240px; min-width: 0;"></div>
                              <div id="modalTestRequirement" class="flex-shrink-0 ms-auto"></div>
                           </div>
                        </div>
                     </div>

                     <!-- Dòng 2: Bài giảng liên quan -->
                     <div id="modalCourseRow" class="d-flex align-items-start gap-2.5" style="display: none; min-width: 0;">
                        <div class="min-width-0 flex-grow-1">
                           <div class="text-secondary fs-12.5 fw-medium" id="modalTestCourse" style="word-break: break-word; line-height: 1.45;"></div>
                        </div>
                     </div>
                  </div>
               </div>

               <!-- Bảng danh sách tất cả các lần thi (Mỗi lần đúng 1 dòng) -->
               <div class="card border-0 shadow-sm rounded-2 overflow-hidden" style="background: #ffffff; border: 1px solid #e2e8f0 !important;">
                  <div class="table-responsive" style="max-height: 400px;">
                     <table class="table history-table align-middle mb-0">
                        <thead class="sticky-top">
                           <tr>
                              <th class="text-center" style="width: 65px;">Lần</th>
                              <th style="width: 140px;">Thời lượng làm</th>
                              <th style="width: 140px;">Thời gian nộp</th>
                              <th>Điểm số</th>
                              <th class="text-center" style="width: 105px;">Kết quả</th>
                              <th class="text-end" style="width: 100px;">Hành động</th>
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
<script src="{{ asset('admin-assets/libs/select2/select2.min.js') }}"></script>
<script>
   $(document).ready(function() {
      // 1. Phá bỏ niceSelect trên các ô chọn của trang báo cáo
      if (typeof $.fn.niceSelect !== 'undefined') {
         $('.report-filter-card select').each(function() {
            try {
               $(this).niceSelect('destroy');
            } catch (err) {}
            $(this).next('.nice-select').remove();
         });
      }

      // 2. Khởi tạo Select2 cho toàn bộ các ô chọn trong bộ lọc
      $('.select2-filter').each(function() {
         var $sel = $(this);
         var name = $sel.attr('name');
         var isSmallList = (name === 'learning_status' || name === 'test_result' || name === 'view_mode');

         $sel.select2({
            width: '100%',
            dropdownAutoWidth: false,
            minimumResultsForSearch: isSmallList ? Infinity : 0,
            language: {
               noResults: function() {
                  return 'Không tìm thấy kết quả';
               }
            }
         });
      });

      // 3. Khi người dùng chọn một mục trong Select2 hoặc trong dropdown bộ lọc khác, tự động submit form để lọc
      $('.select2-filter, .filter-dropdown-select').on('change', function() {
         $('#learningReportFilterForm').submit();
      });

      // 4. Khi nhấn Enter trong ô tìm kiếm từ khóa, tự động lọc
      $('input[name="search"]').on('keypress', function(e) {
         if (e.which === 13) {
            $('#learningReportFilterForm').submit();
         }
      });

      // 5. Đặt lại các bộ lọc trong dropdown
      $('#resetMoreFiltersBtn').on('click', function(e) {
         e.preventDefault();
         $('select[name="learning_status"]').val('all');
         $('select[name="test_result"]').val('all');
         $('select[name="view_mode"]').val('best_attempt');
         $('#learningReportFilterForm').submit();
      });

      // 6. Xử lý hiển thị popup danh sách các lần làm bài thi
      $(document).on('click', '.btn-trigger-history', function(e) {
         e.preventDefault();
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

                  // Huy hiệu tổng kết trạng thái (Đạt / Chưa đạt) & Điểm cao nhất chuẩn SaaS
                  var bestPct = test.total_questions > 0 ? Math.round((stats.max_score / test.total_questions) * 100) : 0;
                  var anyPassed = stats.has_passed || (attempts && attempts.some(function(a) {
                     return (a.is_passed === true || a.is_passed === 1 || a.is_passed === '1') ||
                            (test.pass_score !== null && test.pass_score !== undefined && a.score !== null && Number(a.score) >= Number(test.pass_score));
                  }));

                  if (anyPassed) {
                     $('#modalOverallBadge')
                        .html('<span class="badge" style="background: #ecfdf5; color: #059669; border: 1px solid #a7f3d0; font-size: 11.5px; font-weight: 700; padding: 5px 12px; border-radius: 999px; letter-spacing: 0.3px;"><i class="fa-solid fa-circle-check me-1"></i> ĐÃ ĐẠT</span>');
                     $('#modalBestScoreSub')
                        .html('Điểm cao nhất: <strong class="text-success">' + stats.max_score + '/' + test.total_questions + '</strong> câu (' + bestPct + '%)');
                  } else {
                     $('#modalOverallBadge')
                        .html('<span class="badge" style="background: #fff1f2; color: #e11d48; border: 1px solid #fecdd3; font-size: 11.5px; font-weight: 700; padding: 5px 12px; border-radius: 999px; letter-spacing: 0.3px;"><i class="fa-solid fa-circle-xmark me-1"></i> CHƯA ĐẠT</span>');
                     $('#modalBestScoreSub')
                        .html('Điểm cao nhất: <strong class="text-danger">' + stats.max_score + '/' + test.total_questions + '</strong> câu (' + bestPct + '%)');
                  }

                  // Thông tin bài thi, bài giảng & yêu cầu
                  $('#modalTestTitle').text(test.title || ('Bài thi #' + test.id)).attr('title', test.title || '');
                  if (test.course_title) {
                     $('#modalTestCourse').text(test.course_title).attr('title', test.course_title);
                     $('#modalCourseRow').show();
                  } else {
                     $('#modalCourseRow').hide();
                  }

                  var reqHtml = '';
                  if (test.pass_score) {
                     reqHtml = '<span class="badge" style="background: #ffffff; color: #475569; border: 1px solid #cbd5e1; font-weight: 600; font-size: 11.5px; padding: 4px 10px; border-radius: 6px; white-space: nowrap;"><i class="fa-solid fa-bullseye text-primary me-1"></i> Yêu cầu đạt: <strong class="text-dark">' + test.pass_score + '/' + test.total_questions + '</strong> câu</span>';
                  }
                  $('#modalTestRequirement').html(reqHtml);

                  // Tạo các hàng trong bảng lần thi thu gọn (Mỗi lần đúng 1 dòng)
                  var rowsHtml = '';
                  if (attempts && attempts.length > 0) {
                     attempts.forEach(function(att) {
                        var bestBadge = att.is_best 
                           ? '<span class="badge ms-2" style="background: #fef3c7; color: #b45309; border: 1px solid #fde68a; font-size: 10px; padding: 2px 7px; font-weight: 700; vertical-align: middle;"><i class="fa-solid fa-crown me-1 text-warning"></i> Điểm cao nhất</span>' 
                           : '';

                        // Tự động đánh giá ĐẠT nếu điểm thi >= điểm yêu cầu đạt
                        var isPassed = (att.is_passed === true || att.is_passed === 1 || att.is_passed === '1') || 
                                       (test.pass_score !== null && test.pass_score !== undefined && att.score !== null && Number(att.score) >= Number(test.pass_score));

                        var resultBadge = isPassed 
                           ? '<span class="badge bg-success-subtle text-success border border-success-subtle px-2.5 py-1 rounded-pill fw-bold" style="font-size: 11px;"><i class="fa-solid fa-circle-check me-1"></i> ĐẠT</span>'
                           : '<span class="badge bg-danger-subtle text-danger border border-danger-subtle px-2.5 py-1 rounded-pill fw-bold" style="font-size: 11px;"><i class="fa-solid fa-circle-xmark me-1"></i> CHƯA ĐẠT</span>';
                        var scoreColor = isPassed ? 'text-success' : 'text-danger';

                        var durationHtml = att.duration_formatted 
                           ? `<span class="fw-semibold text-dark fs-12 d-flex align-items-center"><i class="fa-solid fa-stopwatch text-primary me-1"></i>${att.duration_formatted}</span>`
                           : `<span class="text-muted fs-12">--</span>`;

                        rowsHtml += `
                           <tr style="${att.is_best ? 'background-color: #fffdf5;' : ''}">
                              <td class="text-center fw-bold text-secondary fs-12">
                                 Lần ${att.attempt_number}
                              </td>
                              <td>
                                 ${durationHtml}
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
                     rowsHtml = '<tr><td colspan="6" class="text-center text-muted py-4">Chưa có lượt làm bài nào.</td></tr>';
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
</script>
@endpush
