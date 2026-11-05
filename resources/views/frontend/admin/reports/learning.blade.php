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
                  <option value="all">Tất cả phòng ban</option>
                  @foreach($departments as $dept)
                     <option value="{{ $dept->id }}" {{ $filters['department_id'] == $dept->id ? 'selected' : '' }}>
                        {{ $dept->name }}
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
                  <th class="th-user-info">Phòng ban</th>
                  <th class="th-user-info">Email</th>

                  <!-- Cột H -> O: Nhóm thông tin khóa học & bài thi (Màu xanh lá nhạt) -->
                  <th class="th-course-info text-center">Mã KH</th>
                  <th class="th-course-info">Tên khóa học</th>
                  <th class="th-course-info text-center">TG học</th>
                  <th class="th-course-info text-center">TT học</th>
                  <th class="th-course-info text-center">Lần thi</th>
                  <th class="th-course-info text-center">TT thi</th>
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

                     <!-- 5. Phòng ban -->
                     <td>
                        @if(!empty($item['department']))
                           <span class="text-primary"><i class="fa-solid fa-building me-1"></i>{{ $item['department'] }}</span>
                        @else
                           <span class="text-muted">-</span>
                        @endif
                     </td>

                     <!-- 6. Email -->
                     <td>
                        <span class="text-muted"><i class="fa-regular fa-envelope me-1 text-secondary"></i>{{ $item['email'] }}</span>
                     </td>

                     <!-- 7. Mã KH -->
                     <td class="text-center">
                        <span class="text-primary font-monospace">{{ $item['course_code'] }}</span>
                     </td>

                     <!-- 8. Tên khóa học -->
                     <td>
                        <span class="text-dark" title="{{ $item['course_title'] }}">{{ $item['course_title'] }}</span>
                     </td>

                     <!-- 9. TG học -->
                     <td class="text-center">
                        <span class="text-secondary">
                           <i class="fa-regular fa-clock me-1 text-muted"></i>{{ $item['study_time'] }}
                        </span>
                     </td>

                     <!-- 10. TT học -->
                     <td class="text-center">
                        @if($item['learning_status'] === 'Hoàn thành')
                           <span class="text-completed" title="Hoàn thành khóa học">
                              <i class="fa-solid fa-check me-1"></i>Hoàn thành
                           </span>
                        @else
                           <span class="text-in-progress" title="Chưa hoàn thành khóa học">
                              <i class="fa-solid fa-clock me-1"></i>Chưa xong
                           </span>
                        @endif
                     </td>

                     <!-- 11. Lần thi -->
                     <td class="text-center">
                        <span class="text-dark">{{ $item['attempts_count'] ?: 0 }}</span>
                     </td>

                     <!-- 12. TT thi -->
                     <td class="text-center">
                        @if(str_starts_with($item['attempt_status'], 'Lần'))
                           <span class="text-attempt">{{ $item['attempt_status'] }}</span>
                        @elseif($item['attempt_status'] === 'Chưa thi')
                           <span class="text-muted">Chưa thi</span>
                        @else
                           <span class="text-muted">-</span>
                        @endif
                     </td>

                     <!-- 13. Điểm -->
                     <td class="text-center">
                        @if($item['score'] !== '-' && $item['score'] !== null && $item['score'] !== '')
                           <span class="fs-13 {{ $item['result'] === 'Đạt' ? 'text-success' : ($item['result'] === 'Không đạt' ? 'text-danger' : 'text-dark') }}">
                              {{ $item['score'] }}
                           </span>
                        @else
                           <span class="text-muted">-</span>
                        @endif
                     </td>

                     <!-- 14. Kết quả -->
                     <td class="text-center">
                        @if($item['result'] === 'Đạt')
                           <span class="text-passed">
                              <i class="fa-solid fa-check me-1"></i>Đạt
                           </span>
                        @elseif($item['result'] === 'Không đạt')
                           <span class="text-failed" title="Không đạt">
                              <i class="fa-solid fa-xmark me-1"></i>K.Đạt
                           </span>
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
   });
</script>
@endpush
