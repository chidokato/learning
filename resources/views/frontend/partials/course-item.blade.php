@php
    $defaultImages = [
        'assets/img/course/course-1-5.jpg',
        'assets/img/course/course-2-1.jpg',
        'assets/img/course/course-2-2.jpg',
        'assets/img/course/course-4-1.jpg',
        'assets/img/course/course-4-2.jpg',
        'assets/img/course/course-5-1.jpg',
    ];
    $fallbackImage = asset($defaultImages[($course->id ?? 0) % count($defaultImages)]);
    $hasImage = !empty($course->image) && file_exists(public_path(ltrim($course->image, '/')));
    $courseImage = $hasImage ? asset(ltrim($course->image, '/')) : $fallbackImage;
    
    $hasAvatar = !empty($course->seller?->avatar) && file_exists(public_path(ltrim($course->seller->avatar, '/')));
    $avatarImage = $hasAvatar ? asset(ltrim($course->seller->avatar, '/')) : asset('assets/img/avatar/avatar-1-5.png');

    $displayCategoryName = $course->category?->name ?? ($category->name ?? null);
@endphp

<div class="{{ $colClass ?? 'col-xl-4 col-lg-4 col-md-6 mb-30' }}">
   <div class="modern-course-card">
      <!-- Thumbnail -->
      <div class="course-card-thumb">
         <a href="{{ $course->frontend_url }}">
            <img class="course-card-img" 
                 src="{{ $courseImage }}" 
                 alt="{{ $course->title }}"
                 onerror="this.onerror=null; this.src='{{ $fallbackImage }}';"
                 loading="lazy">
         </a>

         @if($displayCategoryName)
            <span class="course-badge-category">
               {{ $displayCategoryName }}
            </span>
         @endif

         <button type="button" class="course-card-wishlist" title="Lưu khóa học">
            <i class="far fa-bookmark"></i>
         </button>
      </div>

      <!-- Content -->
      <div class="course-card-body">
         <!-- Author & Price -->
         <div class="course-author-row d-flex justify-content-between align-items-center mb-10">
            <div class="course-author-info d-flex align-items-center">
               <img class="course-author-avatar" 
                    src="{{ $avatarImage }}" 
                    alt="{{ $course->seller ? $course->seller->name : 'Indochine' }}"
                    onerror="this.onerror=null; this.src='{{ asset('assets/img/avatar/avatar-1-5.png') }}';">
               <span class="course-author-name">{{ $course->seller ? $course->seller->name : 'Indochine' }}</span>
            </div>

            @if(isset($course->price) && $course->price > 0)
               <div class="course-price-badge">
                  {{ number_format($course->price, 0, ',', '.') }}đ
               </div>
            @endif
         </div>

         <!-- Title -->
         <h5 class="course-card-title">
            <a href="{{ $course->frontend_url }}" title="{{ $course->title }}">
               {{ $course->title }}
            </a>
         </h5>

         <!-- Meta Info -->
         <div class="course-card-meta d-flex justify-content-between align-items-center">
            <span class="meta-item">
               <i class="far fa-book-open me-1"></i>
               {{ $course->lesson_count > 0 ? $course->lesson_count : ($course->unit_count ?? 0) }} Bài học
            </span>
            <span class="meta-item">
               <i class="far fa-user-graduate me-1"></i>
               {{ $course->student_count ?? 0 }} Học viên
            </span>
         </div>

         <!-- Button -->
         <div class="course-card-action mt-auto">
            <a href="{{ $course->frontend_url }}" class="course-btn-primary">
               <span>Xem Khóa Học</span>
               <i class="far fa-arrow-right btn-icon-arrow"></i>
            </a>
         </div>
      </div>
   </div>
</div>