<!-- course-area-start -->
<div class="category-courses-wrap">
   <div class="container">
      <div class="row gx-4 gy-4">
         @if (isset($courses) && $courses->isNotEmpty())
            @foreach ($courses as $course)
               @include('frontend.partials.course-item', ['course' => $course, 'index' => $loop->index])
            @endforeach
         @else
            <div class="col-12 text-center py-5">
               <div class="py-5" style="background: #ffffff; border-radius: 16px; border: 1px dashed #cbd5e1; padding: 40px 20px;">
                  <i class="far fa-books mb-3" style="font-size: 42px; color: #94a3b8;"></i>
                  <p class="text-muted fw-semibold mb-3">Chưa có khóa học nào được đăng trong danh mục này.</p>
                  <a href="{{ route('frontend.home') }}" class="btn-beautiful px-4 py-2" style="font-size: 13.5px;">Quay về trang chủ</a>
               </div>
            </div>
         @endif
      </div>

      @if (isset($courses) && $courses->hasPages())
         <div class="row mt-4">
            <div class="col-12">
               <div class="it-pagination modern-pagination text-center mt-30">
                  <nav>
                     <ul>
                        @if ($courses->onFirstPage())
                           <li class="disabled">
                              <span><i class="fa-regular fa-arrow-left"></i></span>
                           </li>
                        @else
                           <li>
                              <a href="{{ $courses->previousPageUrl() }}"><i class="fa-regular fa-arrow-left"></i></a>
                           </li>
                        @endif

                        @foreach ($courses->getUrlRange(1, $courses->lastPage()) as $page => $url)
                           <li class="{{ $page == $courses->currentPage() ? 'current' : '' }}">
                              <a href="{{ $url }}">{{ $page }}</a>
                           </li>
                        @endforeach

                        @if ($courses->hasMorePages())
                           <li>
                              <a href="{{ $courses->nextPageUrl() }}"><i class="fa-regular fa-arrow-right"></i></a>
                           </li>
                        @else
                           <li class="disabled">
                              <span><i class="fa-regular fa-arrow-right"></i></span>
                           </li>
                        @endif
                     </ul>
                  </nav>
               </div>
            </div>
         </div>
      @endif
   </div>
</div> 
<!-- course-area-end -->
