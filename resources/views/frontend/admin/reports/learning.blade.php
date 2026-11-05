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
      
      /* Màu chữ trạng thái gọn gàng, không dùng khung viền hay background */
      .text-completed {
         color: #16a34a !important;
         font-weight: 700 !important;
         display: inline-flex;
         align-items: center;
         white-space: nowrap !important;
      }
      .text-in-progress {
         color: #d97706 !important;
         font-weight: 700 !important;
         display: inline-flex;
         align-items: center;
         white-space: nowrap !important;
      }
      .text-attempt {
         color: #0284c7 !important;
         font-weight: 700 !important;
         white-space: nowrap !important;
      }
      .text-passed {
         color: #16a34a !important;
         font-weight: 700 !important;
         display: inline-flex;
         align-items: center;
         white-space: nowrap !important;
      }
      .text-failed {
         color: #dc2626 !important;
         font-weight: 700 !important;
         display: inline-flex;
         align-items: center;
         white-space: nowrap !important;
      }
   </style>
@endpush

@section('content')
<!-- ================= 1. THỐNG KÊ KPI ================= -->
<div class="row g-3 mb-4">
   <!-- KPI 1: Tổng lượt bản ghi -->
   <div class="col-xl-3 col-md-6 col-12">
      <div class="kpi-stat-card">
         <div class="kpi-icon-box total">
            <i class="fa-solid fa-list-check"></i>
         </div>
         <div class="flex-grow-1">
            <div class="kpi-info-label">Tổng lượt theo dõi</div>
            <div class="kpi-info-value">{{ number_format($kpi['totalRecords']) }}</div>
            <div class="kpi-info-sub">Theo bộ lọc hiện tại</div>
         </div>
      </div>
   </div>

   <!-- KPI 2: Nhân viên tham gia -->
   <div class="col-xl-3 col-md-6 col-12">
      <div class="kpi-stat-card">
         <div class="kpi-icon-box users">
            <i class="fa-solid fa-user-graduate"></i>
         </div>
         <div class="flex-grow-1">
            <div class="kpi-info-label">Nhân sự tham gia</div>
            <div class="kpi-info-value text-primary">{{ number_format($kpi['uniqueUsers']) }}</div>
            <div class="kpi-info-sub">Nhân viên có lịch sử học/thi</div>
         </div>
      </div>
   </div>

   <!-- KPI 3: Hoàn thành khóa học -->
   <div class="col-xl-3 col-md-6 col-12">
      <div class="kpi-stat-card">
         <div class="kpi-icon-box pass">
            <i class="fa-solid fa-graduation-cap"></i>
         </div>
         <div class="flex-grow-1">
            <div class="kpi-info-label">Đã hoàn thành khóa</div>
            <div class="kpi-info-value text-success">{{ number_format($kpi['completedCount']) }}</div>
            <div class="kpi-info-sub">Tỉ lệ hoàn thành: <strong>{{ $kpi['completionRate'] }}%</strong></div>
         </div>
      </div>
   </div>

   <!-- KPI 4: Kết quả thi Đạt -->
   <div class="col-xl-3 col-md-6 col-12">
      <div class="kpi-stat-card">
         <div class="kpi-icon-box pass">
            <i class="fa-solid fa-circle-check"></i>
         </div>
         <div class="flex-grow-1">
            <div class="kpi-info-label">Lượt thi Đạt</div>
            <div class="kpi-info-value" style="color: #107c41;">{{ number_format($kpi['passedCount']) }}</div>
            <div class="kpi-info-sub">Tỉ lệ thi đạt: <strong>{{ $kpi['passRate'] }}%</strong></div>
         </div>
      </div>
   </div>
</div>

<!-- ================= 2. BỘ LỌC TÌM KIẾM & XUẤT EXCEL ================= -->
<div class="report-filter-card">
   <form action="{{ route('frontend.admin.reports.learning') }}" method="GET" id="learningReportFilterForm">
      <div class="row g-2 align-items-center">
         <!-- 1. Ô tìm kiếm từ khóa -->
         <div class="col-lg-3 col-md-6 col-12">
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
         <div class="col-lg-3 col-md-6 col-12">
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
         <div class="col-lg-2 col-md-4 col-6">
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

         <!-- 4. Tình trạng học -->
         <div class="col-lg-2 col-md-4 col-6">
            <div class="filter-input-wrap">
               <i class="fa-solid fa-book-reader filter-icon"></i>
               <select name="learning_status" class="filter-control select2-filter">
                  <option value="all" {{ $filters['learning_status'] == 'all' ? 'selected' : '' }}>Tất cả tình trạng học</option>
                  <option value="completed" {{ $filters['learning_status'] == 'completed' ? 'selected' : '' }}>Hoàn thành</option>
                  <option value="in_progress" {{ $filters['learning_status'] == 'in_progress' ? 'selected' : '' }}>Chưa hoàn thành</option>
               </select>
            </div>
         </div>

         <!-- 5. Kết quả thi -->
         <div class="col-lg-2 col-md-4 col-6">
            <div class="filter-input-wrap">
               <i class="fa-solid fa-square-poll-vertical filter-icon"></i>
               <select name="test_result" class="filter-control select2-filter">
                  <option value="all" {{ $filters['test_result'] == 'all' ? 'selected' : '' }}>Tất cả kết quả thi</option>
                  <option value="passed" {{ $filters['test_result'] == 'passed' ? 'selected' : '' }}>Đạt</option>
                  <option value="failed" {{ $filters['test_result'] == 'failed' ? 'selected' : '' }}>Không đạt</option>
                  <option value="not_taken" {{ $filters['test_result'] == 'not_taken' ? 'selected' : '' }}>Chưa thi</option>
               </select>
            </div>
         </div>

         <!-- 6. Chế độ hiển thị -->
         <div class="col-lg-3 col-md-6 col-12 mt-2">
            <div class="filter-input-wrap">
               <i class="fa-solid fa-layer-group filter-icon"></i>
               <select name="view_mode" class="filter-control select2-filter">
                  <option value="all_attempts" {{ $filters['view_mode'] == 'all_attempts' ? 'selected' : '' }}>Hiển thị tất cả lần thi (Chi tiết)</option>
                  <option value="best_attempt" {{ $filters['view_mode'] == 'best_attempt' ? 'selected' : '' }}>Chỉ lấy lần điểm cao nhất</option>
                  <option value="latest_attempt" {{ $filters['view_mode'] == 'latest_attempt' ? 'selected' : '' }}>Chỉ lấy lần thi mới nhất</option>
               </select>
            </div>
         </div>

         <!-- 7. Nút thao tác Lọc / Reset / Xuất Excel -->
         <div class="col-lg-9 col-md-6 col-12 mt-2 d-flex flex-wrap gap-2 justify-content-lg-end">
            <button type="submit" class="btn text-white fw-semibold d-inline-flex align-items-center justify-content-center px-4" style="height: 42px; background: #03594e; border-radius: 8px; font-size: 13.5px;">
               <i class="fa-solid fa-filter me-1"></i> Lọc
            </button>

            @if(!empty($filters['search']) || $filters['department_id'] !== 'all' || $filters['course_id'] !== 'all' || $filters['learning_status'] !== 'all' || $filters['test_result'] !== 'all' || $filters['view_mode'] !== 'all_attempts')
               <a href="{{ route('frontend.admin.reports.learning') }}" class="btn btn-outline-secondary d-inline-flex align-items-center justify-content-center px-3" style="height: 42px; border-radius: 8px; font-size: 13.5px;" title="Xóa bộ lọc về mặc định">
                  <i class="fa-solid fa-rotate-left me-1"></i> Làm mới
               </a>
            @endif

            <a href="{{ route('frontend.admin.reports.learning.export', request()->all()) }}" 
               class="btn text-white fw-semibold d-inline-flex align-items-center justify-content-center px-3" 
               style="height: 42px; background: #107c41; border-color: #107c41; border-radius: 8px; font-size: 13.5px;">
               <i class="fa-solid fa-file-excel me-1"></i> Xuất Excel
            </a>
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
                     <td class="text-center text-muted fw-semibold">
                        {{ ($paginatedResults->currentPage() - 1) * $paginatedResults->perPage() + $loop->iteration }}
                     </td>

                     <!-- 2. Mã NV -->
                     <td class="text-center">
                        @if(!empty($item['employee_code']))
                           <span class="font-monospace fw-semibold text-secondary">{{ $item['employee_code'] }}</span>
                        @else
                           <span class="text-muted">-</span>
                        @endif
                     </td>

                     <!-- 3. Họ tên -->
                     <td>
                        <span class="fw-bold text-dark">{{ $item['name'] }}</span>
                     </td>

                     <!-- 4. Chức danh -->
                     <td>
                        <span>{{ $item['job_title'] ?: '-' }}</span>
                     </td>

                     <!-- 5. Phòng ban -->
                     <td>
                        @if(!empty($item['department']))
                           <span class="text-primary fw-medium"><i class="fa-solid fa-building me-1"></i>{{ $item['department'] }}</span>
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
                        <span class="fw-bold text-primary font-monospace">{{ $item['course_code'] }}</span>
                     </td>

                     <!-- 8. Tên khóa học -->
                     <td>
                        <span class="fw-semibold text-dark" title="{{ $item['course_title'] }}">{{ $item['course_title'] }}</span>
                     </td>

                     <!-- 9. TG học -->
                     <td class="text-center">
                        <span class="fw-semibold text-secondary">
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
                        <span class="fw-bold text-dark">{{ $item['attempts_count'] ?: 0 }}</span>
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
                        @if($item['score'] !== '-' && is_numeric($item['score']))
                           <span class="fw-bold fs-14 {{ $item['result'] === 'Đạt' ? 'text-success' : 'text-danger' }}">
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

      // 3. Khi người dùng chọn một mục trong Select2, tự động submit form để lọc
      $('.select2-filter').on('change', function() {
         $('#learningReportFilterForm').submit();
      });
   });
</script>
@endpush
