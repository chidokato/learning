@if ($post->content)
<div class="course-curriculum">
   <div class="course-curriculum-header d-flex flex-wrap align-items-center justify-content-between gap-3 mb-20">
      <div class="curriculum-title-wrap">
         <h4 class="it-details-title mb-1 d-flex align-items-center gap-2">
            <i class="fa-solid fa-graduation-cap text-primary-color" style="color: #03594E;"></i>
            <span>Nội dung khóa học</span>
         </h4>
         <div class="curriculum-meta-info d-flex align-items-center gap-2">
            <span><i class="fa-regular fa-folder-open me-1" style="color: #03594E;"></i><strong id="total-chapters-count">0</strong> chương học</span>
            <span class="meta-dot">•</span>
            <span><i class="fa-regular fa-circle-play me-1" style="color: #03594E;"></i><strong id="total-lessons-count">0</strong> bài học</span>
         </div>
      </div>
      <div class="curriculum-actions">
         <button type="button" class="btn-curriculum-toggle" id="toggle-all-accordion" title="Mở rộng / Thu gọn toàn bộ">
            <i class="fa-solid fa-arrows-up-down me-1"></i>
            <span id="toggle-all-text">Mở rộng tất cả</span>
         </button>
      </div>
   </div>

   <div class="it-course-faq">
      <div id="raw-curriculum" style="display: none;">{!! $post->content !!}</div>
      <div class="it-custom-accordion-2" id="dynamic-curriculum-container"></div>
   </div>
   <script src="{{ asset('assets/js/course-custom.js') }}?v={{ time() }}"></script>
</div>
@endif
