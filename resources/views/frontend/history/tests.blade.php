@extends('frontend.layouts.profile')

@section('title', 'Lịch Sử Làm Bài')
@section('page_title', 'Lịch sử làm bài')

@section('breadcrumb')
   <li class="breadcrumb-item active">Lịch sử làm bài</li>
@endsection

@section('page_actions')
   @php $testList = $testResults ?? collect(); @endphp
   <span class="badge" style="background-color: #03594e; font-size: 13px; padding: 7px 15px; border-radius: 20px;">
      <i class="far fa-history me-1"></i> Đã làm: {{ $testList->count() }} lượt
   </span>
@endsection

@section('content')
<div class="profile-content-card">
   @if($testList->count() > 0)
      <div class="table-responsive">
         <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
               <tr style="font-size: 13.5px;">
                  <th>Bài kiểm tra</th>
                  <th class="text-center">Số câu đúng</th>
                  <th class="text-center">Kết quả</th>
                  <th>Thời gian hoàn thành</th>
                  <th class="text-end">Hành động</th>
               </tr>
            </thead>
            <tbody>
               @foreach($testList as $result)
               @php
                  $totalQ = $result->test ? $result->test->questions->count() : null;
               @endphp
               <tr style="font-size: 13.5px;">
                  <td>
                     <strong class="text-dark">{{ $result->test ? $result->test->title : 'Bài kiểm tra #' . $result->test_id }}</strong>
                     @if($result->test)
                        <div class="small text-muted">Số câu qua: {{ $result->test->pass_score }}{{ $totalQ ? '/' . $totalQ : '' }}</div>
                     @endif
                  </td>
                  <td class="text-center fw-bold" style="font-size: 14.5px;">
                     <span class="text-primary">{{ $result->score }}</span>{{ $totalQ ? '/' . $totalQ : '' }}
                  </td>
                  <td class="text-center">
                     @if($result->is_passed)
                        <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-2 rounded-pill">
                           <i class="far fa-check-circle me-1"></i> ĐẠT
                        </span>
                     @else
                        <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-3 py-2 rounded-pill">
                           <i class="far fa-times-circle me-1"></i> CHƯA ĐẠT
                        </span>
                     @endif
                  </td>
                  <td class="text-muted">
                     <i class="far fa-calendar-alt me-1"></i>
                     {{ $result->completed_at ? $result->completed_at->timezone('Asia/Ho_Chi_Minh')->format('d/m/Y H:i') : $result->created_at->timezone('Asia/Ho_Chi_Minh')->format('d/m/Y H:i') }}
                  </td>
                  <td class="text-end">
                     <a href="{{ route('frontend.tests.show', $result->test_id) }}" class="btn btn-sm btn-outline-secondary rounded-pill px-3" style="font-size: 12.5px;">
                        <i class="far fa-redo me-1"></i> Làm lại
                     </a>
                  </td>
               </tr>
               @endforeach
            </tbody>
         </table>
      </div>
   @else
      <div class="text-center py-5">
         <div style="font-size: 48px; color: #adb5bd;" class="mb-3">
            <i class="far fa-clipboard-check"></i>
         </div>
         <h6 class="text-muted mb-3">Bạn chưa có lịch sử làm bài kiểm tra nào.</h6>
         <a href="{{ route('frontend.tests.index') }}" class="it-btn-profile" style="padding: 10px 24px; font-size: 14px;">
            <i class="far fa-clipboard-list me-2"></i> Xem danh sách bài kiểm tra
         </a>
      </div>
   @endif
</div>
@endsection
