@extends('frontend.layouts.profile')

@section('title', 'Kết quả: ' . $test->title)
@section('page_title', 'Kết quả bài kiểm tra')

@section('breadcrumb')
   <li class="breadcrumb-item"><a href="{{ route('frontend.tests.index') }}">Bài kiểm tra</a></li>
   <li class="breadcrumb-item active">Kết quả chi tiết</li>
@endsection

@section('page_actions')
   @if($result->is_passed)
      <span class="badge" style="background: rgba(22, 163, 74, 0.1); color: #16a34a; font-weight: 700; font-size: 13.5px; padding: 7px 15px; border-radius: 999px; border: 1px solid rgba(22, 163, 74, 0.2);">
         <i class="fa-solid fa-trophy me-1"></i> ĐẠT ({{ $result->score }}/{{ $test->questions->count() }})
      </span>
   @else
      <span class="badge" style="background: rgba(220, 38, 38, 0.1); color: #dc2626; font-weight: 700; font-size: 13.5px; padding: 7px 15px; border-radius: 999px; border: 1px solid rgba(220, 38, 38, 0.2);">
         <i class="fa-solid fa-circle-xmark me-1"></i> CHƯA ĐẠT ({{ $result->score }}/{{ $test->questions->count() }})
      </span>
   @endif
@endsection

@push('styles')
<style>
   /* Result Summary Box */
   .result-summary-card {
      background: #ffffff;
      border: 1px solid #e9ebec;
      border-radius: 14px;
      padding: 24px;
      box-shadow: 0 2px 6px rgba(15, 23, 42, 0.04);
      margin-bottom: 24px;
   }
   .result-hero-box {
      border-radius: 12px;
      padding: 24px 20px;
      text-align: center;
      margin-bottom: 24px;
   }
   .result-hero-box.pass {
      background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
      border: 1.5px solid #bbf7d0;
      color: #15803d;
   }
   .result-hero-box.fail {
      background: linear-gradient(135deg, #fef2f2 0%, #fee2e2 100%);
      border: 1.5px solid #fecaca;
      color: #991b1b;
   }
   .result-icon-lg {
      width: 68px;
      height: 68px;
      line-height: 68px;
      border-radius: 50%;
      margin: 0 auto 14px;
      font-size: 30px;
      display: flex;
      align-items: center;
      justify-content: center;
   }
   .result-hero-box.pass .result-icon-lg {
      background: #ffffff;
      color: #16a34a;
      box-shadow: 0 4px 12px rgba(22, 163, 74, 0.15);
   }
   .result-hero-box.fail .result-icon-lg {
      background: #ffffff;
      color: #dc2626;
      box-shadow: 0 4px 12px rgba(220, 38, 38, 0.15);
   }

   /* Stat Tiles */
   .stat-tile {
      background: #f8fafc;
      border: 1px solid #e2e8f0;
      border-radius: 10px;
      padding: 14px 16px;
      text-align: center;
      transition: all 0.2s ease;
   }
   .stat-tile:hover {
      background: #ffffff;
      border-color: #cbd5e1;
      transform: translateY(-2px);
      box-shadow: 0 4px 12px rgba(0,0,0,0.05);
   }
   .stat-label {
      font-size: 12.5px;
      color: #64748b;
      font-weight: 500;
      margin-bottom: 4px;
   }
   .stat-value {
      font-size: 19px;
      font-weight: 700;
      color: #0f172a;
   }

   /* Legend */
   .legend-bar {
      background: #ffffff;
      border: 1px solid #e9ebec;
      border-radius: 10px;
      padding: 12px 18px;
      margin-bottom: 20px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      flex-wrap: wrap;
      gap: 12px;
   }
   .legend-items {
      display: flex;
      align-items: center;
      flex-wrap: wrap;
      gap: 16px;
      font-size: 13px;
      color: #475569;
   }
   .legend-item {
      display: inline-flex;
      align-items: center;
      gap: 6px;
   }
   .legend-dot {
      width: 12px;
      height: 12px;
      border-radius: 4px;
   }

   /* Question Box */
   .review-question-card {
      background: #ffffff;
      border: 1px solid #e9ebec;
      border-radius: 12px;
      padding: 20px;
      margin-bottom: 16px;
      box-shadow: 0 1px 3px rgba(15, 23, 42, 0.03);
      transition: all 0.2s ease;
   }
   .review-question-card:hover {
      border-color: #cbd5e1;
      box-shadow: 0 4px 14px rgba(15, 23, 42, 0.06);
   }
   .review-question-header {
      display: flex;
      align-items: flex-start;
      justify-content: space-between;
      gap: 14px;
      margin-bottom: 14px;
      padding-bottom: 12px;
      border-bottom: 1px solid #f1f5f9;
   }
   .review-question-title {
      font-size: 15px;
      font-weight: 600;
      color: #1e293b;
      line-height: 1.5;
      margin: 0;
   }
   .review-question-num {
      color: #03594e;
      font-weight: 700;
   }

   /* Answers List */
   .review-answers-list {
      display: flex;
      flex-direction: column;
      gap: 8px;
   }
   .review-answer-item {
      display: flex;
      align-items: center;
      padding: 10px 14px;
      border-radius: 8px;
      font-size: 14px;
      line-height: 1.45;
      position: relative;
      transition: all 0.15s ease;
   }
   
   /* 4 trạng thái phương án */
   /* 1. Người dùng chọn ĐÚNG */
   .review-answer-item.user-correct {
      background: #f0fdf4;
      border: 1.5px solid #16a34a;
      color: #15803d;
      font-weight: 500;
   }
   /* 2. Người dùng chọn SAI */
   .review-answer-item.user-wrong {
      background: #fef2f2;
      border: 1.5px solid #dc2626;
      color: #991b1b;
   }
   /* 3. Đáp án đúng của đề mà người dùng bỏ lỡ */
   .review-answer-item.missed-correct {
      background: #f8fafc;
      border: 1.5px dashed #16a34a;
      color: #15803d;
      font-weight: 500;
   }
   /* 4. Phương án sai người dùng không chọn (bình thường) */
   .review-answer-item.normal-option {
      background: #ffffff;
      border: 1px solid #e2e8f0;
      color: #475569;
   }

   .ans-indicator-icon {
      width: 22px;
      height: 22px;
      border-radius: 50%;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      font-size: 13px;
      margin-right: 10px;
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
      font-size: 11.5px;
      font-weight: 600;
      padding: 3px 8px;
      border-radius: 4px;
      white-space: nowrap;
      margin-left: 10px;
   }
</style>
@endpush

@section('content')
<!-- Card Tổng quan Kết quả -->
<div class="result-summary-card">
   <!-- Hero Banner -->
   <div class="result-hero-box {{ $result->is_passed ? 'pass' : 'fail' }}">
      <div class="result-icon-lg">
         @if($result->is_passed)
            <i class="fa-solid fa-trophy"></i>
         @else
            <i class="fa-solid fa-triangle-exclamation"></i>
         @endif
      </div>
      <h3 class="fw-bold mb-2">
         {{ $result->is_passed ? '🎉 Chúc mừng! Bạn đã ĐẠT bài kiểm tra.' : '⚠️ Rất tiếc! Bạn CHƯA ĐẠT bài kiểm tra.' }}
      </h3>
      <p class="mb-0 fs-14" style="opacity: 0.9;">
         Bài thi: <strong>{{ $test->title }}</strong>
      </p>
   </div>

   <!-- Chỉ số thống kê bài thi -->
   @php
      $totalQuestions = $test->questions->count();
      $pct = $totalQuestions > 0 ? round(($result->score / $totalQuestions) * 100) : 0;
   @endphp
   <div class="row g-3 mb-4">
      <div class="col-md-3 col-6">
         <div class="stat-tile">
            <div class="stat-label">Số câu đúng</div>
            <div class="stat-value text-primary">{{ $result->score }} / {{ $totalQuestions }}</div>
         </div>
      </div>
      <div class="col-md-3 col-6">
         <div class="stat-tile">
            <div class="stat-label">Tỉ lệ chính xác</div>
            <div class="stat-value {{ $result->is_passed ? 'text-success' : 'text-danger' }}">{{ $pct }}%</div>
         </div>
      </div>
      <div class="col-md-3 col-6">
         <div class="stat-tile">
            <div class="stat-label">Yêu cầu đạt</div>
            <div class="stat-value text-dark">{{ $test->pass_score }} / {{ $totalQuestions }} câu</div>
         </div>
      </div>
      <div class="col-md-3 col-6">
         <div class="stat-tile">
            <div class="stat-label">Thời gian nộp bài</div>
            <div class="stat-value text-muted" style="font-size: 14.5px; font-weight: 600; line-height: 28px;">
               {{ $result->completed_at ? $result->completed_at->timezone('Asia/Ho_Chi_Minh')->format('H:i d/m/Y') : $result->created_at->timezone('Asia/Ho_Chi_Minh')->format('H:i d/m/Y') }}
            </div>
         </div>
      </div>
   </div>

   <!-- Nút hành động -->
   <div class="d-flex justify-content-center align-items-center gap-2 flex-wrap pt-2 border-top">
      <a href="{{ route('frontend.tests.show', $test->id) }}" class="btn btn-warning px-4 py-2" style="font-weight: 700; border-radius: 8px;">
         <i class="fa-solid fa-rotate-right me-1"></i> Làm lại bài thi
      </a>
      <a href="{{ route('frontend.history.tests') }}" class="btn btn-outline-primary px-4 py-2" style="font-weight: 600; border-radius: 8px;">
         <i class="fa-solid fa-clock-rotate-left me-1"></i> Lịch sử làm bài
      </a>
      <a href="{{ route('frontend.tests.index') }}" class="btn btn-outline-secondary px-4 py-2" style="font-weight: 600; border-radius: 8px;">
         <i class="fa-solid fa-list me-1"></i> Danh sách bài thi
      </a>
   </div>
</div>

<!-- Thanh chú thích (Legend) -->
<div class="legend-bar">
   <div class="fw-bold text-dark fs-14">
      <i class="fa-solid fa-clipboard-check text-primary me-1"></i> Chi tiết bài làm & Đáp án:
   </div>
   <div class="legend-items">
      <div class="legend-item">
         <span class="legend-dot" style="background: #16a34a;"></span>
         <span>Bạn chọn đúng</span>
      </div>
      <div class="legend-item">
         <span class="legend-dot" style="background: #dc2626;"></span>
         <span>Bạn chọn sai</span>
      </div>
      <div class="legend-item">
         <span class="legend-dot" style="background: #ffffff; border: 1.5px dashed #16a34a;"></span>
         <span>Đáp án đúng của đề</span>
      </div>
   </div>
</div>

@if(empty($userAnswers))
   <div class="alert alert-warning border-warning-subtle d-flex align-items-center gap-2 mb-4" style="border-radius: 10px;">
      <i class="fa-solid fa-circle-info fs-18"></i>
      <div>
         Lượt làm bài này được thực hiện trước khi hệ thống lưu chi tiết phương án chọn. Dưới đây là đáp án chuẩn của đề thi để bạn đối chiếu.
      </div>
   </div>
@endif

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
                  <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1 fs-12">
                     <i class="fa-solid fa-check me-1"></i> Đúng
                  </span>
               @elseif($isUnanswered)
                  <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle px-2 py-1 fs-12">
                     <i class="fa-regular fa-circle-question me-1"></i> Chưa làm
                  </span>
               @else
                  <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-2 py-1 fs-12">
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
@endsection
