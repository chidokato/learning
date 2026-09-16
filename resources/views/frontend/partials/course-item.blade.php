<div class="col-xl-4 col-lg-6 col-md-6">
   <div class="it-course-item mb-35">
      <div class="it-course-thumb z-index-1 border-radius-20" style="position: relative; overflow: hidden;">
         <a href="{{ $course->frontend_url }}" class="d-block w-100">
            @if ($course->image)
               <img class="w-100" style="height: 230px; object-fit: cover;" src="{{ asset($course->image) }}" alt="{{ $course->title }}">
            @endif
         </a>
         @if ($course->category)
            <span class="course-category">{{ $course->category->name }}</span>
         @endif
         <button class="wishlist-btn">
            <svg width="14" height="16" viewBox="0 0 14 16" fill="none" xmlns="http://www.w3.org/2000/svg">
               <path d="M13.6811 4.50134C13.3564 2.47755 11.9261 0.859544 10.0381 0.378868C9.06325 0.130895 8.04117 0.00363597 6.99804 0C5.95853 0.00290878 4.93718 0.130168 3.96232 0.378868C2.07436 0.859544 0.644035 2.47755 0.319325 4.50134C-0.155754 7.46102 -0.101273 10.5952 0.486402 14.0829C0.638224 14.9875 1.28038 15.7103 2.1717 15.9234C3.27005 16.1859 4.09235 15.695 4.53692 15.1395C4.99675 14.565 6.75178 12.3267 6.75178 12.3267C6.83459 12.2212 6.94355 12.2052 7.00021 12.2052C7.05688 12.2052 7.16584 12.2205 7.24865 12.3267C7.24865 12.3267 9.00441 14.5657 9.46351 15.1395C10.0359 15.8536 10.9418 16.1546 11.8287 15.9234C12.7157 15.6929 13.3615 14.9875 13.5133 14.0836C14.101 10.596 14.1562 7.46175 13.6804 4.50206L13.6811 4.50134ZM12.0808 13.8414C11.9973 14.3396 11.5868 14.4835 11.4626 14.5155C11.3399 14.5483 10.9113 14.6224 10.5967 14.229C10.1398 13.6589 9.65601 13.0415 9.16785 12.4176L8.38913 11.425C8.05134 10.9959 7.54503 10.7501 6.99949 10.7501C6.45395 10.7501 5.94836 10.9959 5.60985 11.425L4.83112 12.4176C4.34297 13.0408 3.85917 13.6589 3.40225 14.229C3.08844 14.6224 2.66058 14.5483 2.53636 14.5155C2.41287 14.4835 2.00244 14.3396 1.91818 13.8407C1.35738 10.5123 1.3029 7.53228 1.75255 4.73186C1.98573 3.2811 2.99328 2.12559 4.31972 1.78817C5.17908 1.56929 6.08129 1.4573 6.99731 1.45439C7.91768 1.4573 8.8199 1.56929 9.67925 1.78817C11.0057 2.12559 12.0132 3.2811 12.2464 4.73186C12.6961 7.53228 12.6416 10.5123 12.0808 13.8407V13.8414Z" fill="currentcolor" />
            </svg>
         </button>
      </div>
      <div class="it-course-content p-relative">
         <div class="d-flex justify-content-between align-items-center mb-20">
            <div class="it-course-author">
               @if ($course->seller?->avatar)
                  <img src="{{ asset($course->seller->avatar) }}" alt="{{ $course->seller?->name }}">
               @endif
               <span>{{ $course->seller?->name }}</span>
            </div>
         </div>
         <h5 class="it-course-title mb-20" style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; text-overflow: ellipsis; height: 3.2rem; line-height: 1.6rem;"><a class="border-line" href="{{ $course->frontend_url }}">{{ $course->title }}</a></h5>
         
         @if ($course->unit_count !== null)
            <div class="it-course-meta mb-30">{{ $course->unit_count }} Bài học</div>
         @endif
         <div class="it-course-btn">
            <a href="{{ $course->frontend_url }}" class="it-btn-yellow w-100">
               <span>
                  <span class="text-1">Xem Khóa Học</span>
                  <span class="text-2">Xem Khóa Học</span>
               </span>
               <i>
                  <svg width="16" height="15" viewBox="0 0 16 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                     <path d="M15.0544 8.1364C15.4058 7.78492 15.4058 7.21508 15.0544 6.8636L9.3268 1.13604C8.97533 0.784567 8.40548 0.784567 8.05401 1.13604C7.70254 1.48751 7.70254 2.05736 8.05401 2.40883L13.1452 7.5L8.05401 12.5912C7.70254 12.9426 7.70254 13.5125 8.05401 13.864C8.40548 14.2154 8.97533 14.2154 9.3268 13.864L15.0544 8.1364ZM0.417969 7.5V8.4H14.418V7.5V6.6H0.417969V7.5Z" fill="currentcolor" />
                  </svg>
               </i>
            </a>
         </div>
      </div>
   </div>
</div>
