@extends('frontend.layouts.profile')

@section('title', 'Lịch Sử Học Tập')
@section('page_title', 'Lịch sử học tập')

@section('breadcrumb')
   <li class="breadcrumb-item active">Lịch sử học tập</li>
@endsection

@section('page_actions')
   @php $learnedList = $learnedCourses ?? collect(); @endphp
   <span class="badge" style="background-color: #03594e; font-size: 13px; padding: 7px 15px; border-radius: 20px;">
      <i class="far fa-graduation-cap me-1"></i> Đã học: {{ $learnedList->count() }} khóa học
   </span>
@endsection

@section('content')
<div class="profile-content-card">
   @if($learnedList->count() > 0)
      <div class="row g-3">
         @foreach($learnedList as $item)
            @if($item->post)
            <div class="col-12">
               <div class="p-3 rounded-3 border d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3" style="background: #fafbfc; border-color: #eef2f6 !important; transition: all 0.2s ease;">
                  <div class="d-flex align-items-center gap-3 min-w-0 flex-grow-1">
                     <img src="{{ $item->post->image ? asset($item->post->image) : asset('assets/img/course/course-1-5.jpg') }}" alt="{{ $item->post->title }}" style="width: 88px; height: 64px; object-fit: cover; border-radius: 8px;" class="flex-shrink-0">
                     <div class="overflow-hidden flex-grow-1">
                        <h6 class="mb-1 fw-bold text-truncate">
                           <a href="{{ $item->post->frontend_url }}" class="text-dark text-decoration-none">
                              {{ $item->post->title }}
                           </a>
                        </h6>
                        <div class="text-muted small d-flex flex-wrap align-items-center gap-2 mb-2">
                           @if($item->post->category)
                              <span class="badge bg-light text-secondary border">{{ $item->post->category->name }}</span>
                           @endif
                           <span class="badge bg-white text-dark border">
                              <i class="far fa-clock text-primary me-1"></i> {{ $item->last_learned_at ? $item->last_learned_at->timezone('Asia/Ho_Chi_Minh')->format('d/m/Y H:i') : $item->updated_at->timezone('Asia/Ho_Chi_Minh')->format('d/m/Y H:i') }}
                           </span>
                           <span class="badge bg-white text-danger border">
                              <i class="far fa-stopwatch me-1"></i> Thời gian học: <strong>{{ $item->formatted_study_time }}</strong>
                           </span>
                           @if($item->completed_at || ($item->progress_percent ?? 0) >= 100)
                              <span class="badge bg-success text-white">
                                 <i class="far fa-check-circle me-1"></i> Đã hoàn thành
                              </span>
                           @endif
                        </div>
                        <!-- Tiến trình học -->
                        <div style="max-width: 360px;">
                           <div class="d-flex justify-content-between align-items-center mb-1" style="font-size: 11.5px;">
                              <span class="fw-semibold text-secondary">
                                 Tiến độ: <strong class="text-success">{{ $item->progress_percent ?? 0 }}%</strong>
                              </span>
                              <span class="text-muted">
                                 Đang học slide: {{ $item->current_page ?? 1 }}/{{ $item->total_pages ?: '--' }}
                              </span>
                           </div>
                           <div class="progress" style="height: 6px; border-radius: 999px; background-color: #e2e8f0;">
                              <div class="progress-bar" 
                                   style="width: {{ $item->progress_percent ?? 0 }}%; background-color: {{ ($item->progress_percent ?? 0) >= 100 ? '#10b981' : '#03594e' }}; border-radius: 999px;" 
                                   role="progressbar" 
                                   aria-valuenow="{{ $item->progress_percent ?? 0 }}" 
                                   aria-valuemin="0" 
                                   aria-valuemax="100"></div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="flex-shrink-0 text-md-end">
                     <a href="{{ $item->post->learn_url }}" class="it-btn-profile">
                        <i class="far fa-play-circle me-1"></i> Tiếp tục học
                     </a>
                  </div>
               </div>
            </div>
            @endif
         @endforeach
      </div>
   @else
      <div class="text-center py-5">
         <div style="font-size: 48px; color: #adb5bd;" class="mb-3">
            <i class="far fa-graduation-cap"></i>
         </div>
         <h6 class="text-muted mb-3">Bạn chưa có lịch sử học khóa học nào.</h6>
         <a href="{{ route('frontend.home') }}" class="it-btn-profile" style="padding: 10px 24px; font-size: 14px;">
            <i class="far fa-compass me-2"></i> Khám phá các khóa học
         </a>
      </div>
   @endif
</div>
@endsection
