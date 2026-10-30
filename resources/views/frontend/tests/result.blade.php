@extends('frontend.layouts.profile')

@section('title', 'Kết quả: ' . $test->title)
@section('page_title', 'Kết quả bài kiểm tra')

@section('breadcrumb')
   <li class="breadcrumb-item"><a href="{{ route('frontend.tests.index') }}">Bài kiểm tra</a></li>
   <li class="breadcrumb-item active">Kết quả chi tiết</li>
@endsection

@section('page_actions')
   @if($result->is_passed)
      <span class="badge" style="background: rgba(22, 163, 74, 0.1); color: #16a34a !important; font-weight: 700; font-size: 13px; padding: 6px 14px; border-radius: 999px; border: 1px solid rgba(22, 163, 74, 0.2);">
         <i class="fa-solid fa-trophy me-1"></i> ĐẠT ({{ $result->score }}/{{ $test->questions->count() }})
      </span>
   @else
      <span class="badge" style="background: rgba(220, 38, 38, 0.1); color: #dc2626 !important; font-weight: 700; font-size: 13px; padding: 6px 14px; border-radius: 999px; border: 1px solid rgba(220, 38, 38, 0.2);">
         <i class="fa-solid fa-circle-xmark me-1"></i> CHƯA ĐẠT ({{ $result->score }}/{{ $test->questions->count() }})
      </span>
   @endif
@endsection

@push('styles')
<style>
   /* Sticky Sidebar */
   .result-sidebar-sticky {
      position: sticky;
      top: 85px;
      z-index: 10;
   }
   @media (max-width: 991.98px) {
      .result-sidebar-sticky {
         position: static;
         top: auto;
      }
   }

   /* Result Summary Box (Gọn gàng, tinh tế) */
   .result-summary-card {
      background: #ffffff;
      border: 1px solid #e9ebec;
      border-radius: 12px;
      padding: 16px;
      box-shadow: 0 1px 4px rgba(15, 23, 42, 0.05);
      margin-bottom: 20px;
   }
   
   /* Hero Box compact */
   .result-hero-box {
      border-radius: 10px;
      padding: 12px 14px;
      text-align: center;
      margin-bottom: 12px;
   }
   .result-hero-box.pass {
      background: #f0fdf4;
      border: 1px solid #bbf7d0;
   }
   .result-hero-box.fail {
      background: #fef2f2;
      border: 1px solid #fecaca;
   }
   .result-hero-title {
      font-size: 15px;
      font-weight: 700;
      letter-spacing: 0.3px;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 6px;
   }
   .result-hero-box.pass .result-hero-title {
      color: #15803d;
   }
   .result-hero-box.fail .result-hero-title {
      color: #dc2626;
   }
   .result-hero-sub {
      font-size: 12px;
      color: #64748b;
      margin-top: 3px;
      line-height: 1.35;
   }

   /* Stat Tiles compact */
   .stat-tile {
      background: #f8fafc;
      border: 1px solid #e2e8f0;
      border-radius: 8px;
      padding: 8px 10px;
      text-align: center;
      height: 100%;
      display: flex;
      flex-direction: column;
      justify-content: center;
      transition: all 0.15s ease;
   }
   .stat-tile:hover {
      background: #ffffff;
      border-color: #cbd5e1;
   }
   .stat-label {
      font-size: 11px;
      color: #64748b;
      font-weight: 500;
      margin-bottom: 2px;
      white-space: nowrap;
   }
   .stat-value {
      font-size: 15px;
      font-weight: 700;
      color: #0f172a;
      line-height: 1.25;
   }

   /* Action Buttons in Sidebar */
   .btn-result-action {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 6px;
      width: 100%;
      padding: 7px 12px;
      font-size: 13px;
      font-weight: 600;
      border-radius: 7px;
      text-decoration: none !important;
      transition: all 0.15s ease;
      white-space: nowrap;
   }
   .btn-result-action.btn-main {
      background: #ffb013;
      color: #00225a !important;
      border: 1px solid #e59d0a;
      font-weight: 700;
   }
   .btn-result-action.btn-main:hover {
      background: #e59d0a;
   }

   /* Legend Bar */
   .legend-bar {
      background: #ffffff;
      border: 1px solid #e9ebec;
      border-radius: 8px;
      padding: 8px 14px;
      margin-bottom: 12px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      flex-wrap: wrap;
      gap: 10px;
   }
   .legend-items {
      display: flex;
      align-items: center;
      flex-wrap: wrap;
      gap: 12px;
      font-size: 12px;
      color: #475569;
   }
   .legend-item {
      display: inline-flex;
      align-items: center;
      gap: 5px;
   }
   .legend-dot {
      width: 10px;
      height: 10px;
      border-radius: 3px;
      flex-shrink: 0;
   }
   .badge-legacy-notice {
      background: #fef3c7 !important;
      color: #92400e !important;
      border: 1px solid #fde68a !important;
      font-size: 11.5px !important;
      font-weight: 500 !important;
      padding: 3px 10px !important;
      border-radius: 6px !important;
      display: inline-flex !important;
      align-items: center !important;
      gap: 5px !important;
      line-height: 1.4 !important;
   }
   .badge-legacy-notice i {
      color: #d97706 !important;
      font-size: 12px !important;
   }

   /* Question Box compact */
   .review-question-card {
      background: #ffffff;
      border: 1px solid #e9ebec;
      border-radius: 10px;
      padding: 14px 16px;
      margin-bottom: 10px;
      box-shadow: 0 1px 2px rgba(15, 23, 42, 0.02);
      transition: all 0.15s ease;
   }
   .review-question-card:hover {
      border-color: #cbd5e1;
      box-shadow: 0 2px 8px rgba(15, 23, 42, 0.04);
   }
   .review-question-header {
      display: flex;
      align-items: flex-start;
      justify-content: space-between;
      gap: 10px;
      margin-bottom: 10px;
      padding-bottom: 8px;
      border-bottom: 1px solid #f1f5f9;
   }
   .review-question-title {
      font-size: 14px;
      font-weight: 600;
      color: #1e293b;
      line-height: 1.45;
      margin: 0;
   }
   .review-question-num {
      color: #03594e;
      font-weight: 700;
   }

   /* Answers List compact */
   .review-answers-list {
      display: flex;
      flex-direction: column;
      gap: 6px;
   }
   .review-answer-item {
      display: flex;
      align-items: center;
      padding: 7px 12px;
      border-radius: 6px;
      font-size: 13px;
      line-height: 1.4;
      position: relative;
      transition: all 0.15s ease;
   }
   
   /* 4 trạng thái phương án */
   .review-answer-item.user-correct {
      background: #f0fdf4;
      border: 1.5px solid #16a34a;
      color: #15803d;
      font-weight: 500;
   }
   .review-answer-item.user-wrong {
      background: #fef2f2;
      border: 1.5px solid #dc2626;
      color: #991b1b;
   }
   .review-answer-item.missed-correct {
      background: #f8fafc;
      border: 1.5px dashed #16a34a;
      color: #15803d;
      font-weight: 500;
   }
   .review-answer-item.normal-option {
      background: #ffffff;
      border: 1px solid #e2e8f0;
      color: #475569;
   }

   .ans-indicator-icon {
      width: 18px;
      height: 18px;
      border-radius: 50%;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      font-size: 11px;
      margin-right: 8px;
      flex-shrink: 0;
   }
   .review-answer-item.user-correct .ans-indicator-icon {
      background: #16a34a;
      color: #ffffff;
   }
   .review-answer-item.user-wrong .ans-indicator-icon {
      background: #dc2626;
      color: #ffffff;
   }
   .review-answer-item.missed-correct .ans-indicator-icon {
      background: rgba(22, 163, 74, 0.15);
      color: #16a34a;
   }
   .review-answer-item.normal-option .ans-indicator-icon {
      background: #f1f5f9;
      color: #94a3b8;
   }

   .ans-text-wrap {
      flex: 1;
      min-width: 0;
   }
   .ans-label {
      font-weight: 700;
      margin-right: 4px;
   }
   .ans-status-tag {
      font-size: 11px;
      font-weight: 600;
      padding: 2px 7px;
      border-radius: 4px;
      white-space: nowrap;
      margin-left: 8px;
   }
</style>
@endpush

@section('content')
@php
   $totalQuestions = $test->questions->count();
   $pct = $totalQuestions > 0 ? round(($result->score / $totalQuestions) * 100) : 0;
@endphp

<div class="row g-3">
   <!-- ================= CỘT TRÁI (Nội dung câu hỏi và đáp án) ================= -->
   <div class="col-lg-8 col-xl-8 order-lg-1 order-2">
      <!-- Thanh chú thích (Legend) kết hợp thông báo gọn gàng trên 1 dòng -->
      <div class="legend-bar">
         <div class="d-flex align-items-center flex-wrap gap-2">
            <div class="fw-bold text-dark fs-12">
               <i class="fa-solid fa-clipboard-check text-primary me-1"></i> Chi tiết bài làm:
            </div>
            @if(empty($userAnswers))
               <span class="badge-legacy-notice">
                  <i class="fa-solid fa-circle-info"></i> Lượt thi này chưa lưu phương án đã chọn (hiển thị đáp án chuẩn)
               </span>
            @endif
         </div>

         <div class="legend-items">
            @if(!empty($userAnswers))
               <div class="legend-item">
                  <span class="legend-dot" style="background: #16a34a;"></span>
                  <span>Bạn chọn đúng</span>
               </div>
               <div class="legend-item">
                  <span class="legend-dot" style="background: #dc2626;"></span>
                  <span>Bạn chọn sai</span>
               </div>
            @endif
            <div class="legend-item">
               <span class="legend-dot" style="background: #ffffff; border: 1.5px dashed #16a34a;"></span>
               <span>Đáp án đúng của đề</span>
            </div>
         </div>
      </div>

      <!-- Danh sách câu hỏi và đáp án -->
      <div class="review-questions-wrap">
         @foreach($test->questions as $index => $q)
            @php
               $selectedAnsIds = array_map('intval', (array)($userAnswers[$q->id] ?? []));
               $correctAnsIds = $q->answers->where('is_correct', true)->pluck('id')->map(fn($id) => (int)$id)->toArray();
               
               sort($selectedAnsIds);
               sort($correctAnsIds);

               $isQuestionCorrect = !empty($correctAnsIds) && ($selectedAnsIds === $correctAnsIds);
               $isUnanswered = empty($selectedAnsIds);
            @endphp

            <div class="review-question-card">
               <div class="review-question-header">
                  <h5 class="review-question-title">
                     <span class="review-question-num">Câu {{ $index + 1 }}:</span> {{ $q->content }}
                  </h5>

                  <div class="d-flex align-items-center gap-2 flex-shrink-0">
                     @if($isQuestionCorrect)
                        <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1 fs-11">
                           <i class="fa-solid fa-check me-1"></i> Đúng
                        </span>
                     @elseif($isUnanswered)
                        <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle px-2 py-1 fs-11">
                           <i class="fa-regular fa-circle-question me-1"></i> Chưa làm
                        </span>
                     @else
                        <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-2 py-1 fs-11">
                           <i class="fa-solid fa-xmark me-1"></i> Sai
                        </span>
                     @endif
                  </div>
               </div>

               <div class="review-answers-list">
                  @foreach($q->answers as $a)
                     @php
                        $isASelected = in_array((int)$a->id, $selectedAnsIds);
                        $isACorrect = (bool)$a->is_correct;

                        $itemClass = 'normal-option';
                        $indicatorIcon = '<i class="fa-regular fa-circle"></i>';
                        $statusBadge = null;

                        if ($isASelected && $isACorrect) {
                           $itemClass = 'user-correct';
                           $indicatorIcon = '<i class="fa-solid fa-check"></i>';
                           $statusBadge = '<span class="ans-status-tag bg-success text-white"><i class="fa-solid fa-check me-1"></i> Bạn đã chọn (Đúng)</span>';
                        } elseif ($isASelected && !$isACorrect) {
                           $itemClass = 'user-wrong';
                           $indicatorIcon = '<i class="fa-solid fa-xmark"></i>';
                           $statusBadge = '<span class="ans-status-tag bg-danger text-white"><i class="fa-solid fa-xmark me-1"></i> Bạn đã chọn (Sai)</span>';
                        } elseif (!$isASelected && $isACorrect) {
                           $itemClass = 'missed-correct';
                           $indicatorIcon = '<i class="fa-solid fa-check"></i>';
                           $statusBadge = '<span class="ans-status-tag bg-success-subtle text-success border border-success-subtle"><i class="fa-solid fa-check me-1"></i> Đáp án đúng</span>';
                        }
                     @endphp

                     <div class="review-answer-item {{ $itemClass }}">
                        <span class="ans-indicator-icon">
                           {!! $indicatorIcon !!}
                        </span>
                        <div class="ans-text-wrap">
                           @if($a->label)
                              <span class="ans-label">{{ $a->label }}.</span>
                           @endif
                           <span>{{ $a->content }}</span>
                        </div>
                        @if($statusBadge)
                           {!! $statusBadge !!}
                        @endif
                     </div>
                  @endforeach
               </div>
            </div>
         @endforeach
      </div>
   </div>

   <!-- ================= CỘT PHẢI (Box tổng quan gọn gàng & Nút thao tác) ================= -->
   <div class="col-lg-4 col-xl-4 order-lg-2 order-1">
      <div class="result-sidebar-sticky">
         <div class="result-summary-card">
            <!-- Hero Banner Compact -->
            <div class="result-hero-box {{ $result->is_passed ? 'pass' : 'fail' }}">
               <div class="result-hero-title">
                  <i class="fa-solid {{ $result->is_passed ? 'fa-circle-check fs-17 text-success' : 'fa-circle-xmark fs-17 text-danger' }}"></i>
                  <span>{{ $result->is_passed ? 'KẾT QUẢ: ĐẠT' : 'KẾT QUẢ: CHƯA ĐẠT' }}</span>
               </div>
               <div class="result-hero-sub text-truncate" title="{{ $test->title }}">
                  {{ $test->title }}
               </div>
            </div>

            <!-- Lưới 2x2 thông số nhỏ gọn -->
            <div class="row g-2 mb-2">
               <div class="col-6">
                  <div class="stat-tile">
                     <div class="stat-label">Số câu đúng</div>
                     <div class="stat-value text-primary">{{ $result->score }}/{{ $totalQuestions }}</div>
                  </div>
               </div>
               <div class="col-6">
                  <div class="stat-tile">
                     <div class="stat-label">Tỉ lệ chính xác</div>
                     <div class="stat-value {{ $result->is_passed ? 'text-success' : 'text-danger' }}">{{ $pct }}%</div>
                  </div>
               </div>
               <div class="col-6">
                  <div class="stat-tile">
                     <div class="stat-label">Yêu cầu đạt</div>
                     <div class="stat-value text-dark fs-14">{{ $test->pass_score }}/{{ $totalQuestions }}</div>
                  </div>
               </div>
               <div class="col-6">
                  <div class="stat-tile">
                     <div class="stat-label">Thời gian nộp</div>
                     <div class="stat-value text-muted fs-12">
                        {{ $result->completed_at ? $result->completed_at->timezone('Asia/Ho_Chi_Minh')->format('H:i d/m/Y') : $result->created_at->timezone('Asia/Ho_Chi_Minh')->format('H:i d/m/Y') }}
                     </div>
                  </div>
               </div>
            </div>

            <!-- Các nút thao tác nhỏ gọn (2 dòng) -->
            <div class="d-flex flex-column gap-2 pt-2 border-top">
               <a href="{{ route('frontend.tests.show', $test->id) }}" class="btn-result-action btn-main">
                  <i class="fa-solid fa-rotate-right"></i> Làm lại bài thi
               </a>
               <div class="row g-2">
                  <div class="col-6">
                     <a href="{{ route('frontend.history.tests') }}" class="btn-result-action btn btn-outline-primary">
                        <i class="fa-solid fa-clock-rotate-left"></i> Lịch sử
                     </a>
                  </div>
                  <div class="col-6">
                     <a href="{{ route('frontend.tests.index') }}" class="btn-result-action btn btn-outline-secondary">
                        <i class="fa-solid fa-list"></i> Danh sách
                     </a>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection
