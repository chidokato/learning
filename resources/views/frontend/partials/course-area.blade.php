   <!-- course-area-start -->
   <div class="it-course-area it-course-inner-v1-style pt-50 pb-130">
      <div class="container">
         <div class="row">
            <div class="col-12">
               <div class="it-shop-top-wrap d-none justify-content-between align-items-center mb-60">
                  <div class="it-shop-text">
                     <span>Showing all {{ isset($courses) ? $courses->total() : 0 }} results</span>
                  </div>
                  <div class="it-shop-filter-box d-flex align-items-center">
                     <span>Show 9 / 12 / 15</span>
                     <div class="it-shop-filter p-relative text-md-end ml-30">
                        <select>
                           <option>Default Sorting</option>
                           <option>Low to Hight</option>
                           <option>High to Low</option>
                           <option>New Added</option>
                           <option>On Sale</option>
                        </select>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <div class="row gx-35">
            @if (isset($courses) && $courses->isNotEmpty())
               @foreach ($courses as $course)
                  @include('frontend.partials.course-item', ['course' => $course, 'index' => $loop->index])
               @endforeach
            @else
               <div class="col-12 text-center py-5">
                  <p>Chưa có bài học nào được đăng.</p>
               </div>
            @endif
         </div>
         @if (isset($courses) && $courses->hasPages())
            <div class="row">
               <div class="col-12">
                  <div class="it-pagination text-center mt-45">
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
