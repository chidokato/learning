@if ($post->content)
<div class="course-curriculum">
   <!-- <h4 class="it-details-title">Nội dung khóa học</h4> -->
   @if ($post->content)
      <div class="it-course-faq">
         <div class="it-course-faq-top-text mb-10 d-flex align-items-center justify-content-between">
            <span><strong id="total-chapters-count"></strong> chương học</span>
            <a href="#dynamic-curriculum-container" id="toggle-all-accordion">Mở rộng tất cả</a>
         </div>
         <div id="raw-curriculum" style="display: none;">{!! $post->content !!}</div>
         <div class="it-custom-accordion-2" id="dynamic-curriculum-container"></div>
      </div>
      <script src="{{ asset('assets/js/course-custom.js') }}"></script>
   @endif
</div>
@endif
