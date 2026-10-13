path = r"resources/views/frontend/tests/show.blade.php"
with open(path, "r", encoding="utf-8") as f:
    content = f.read()

import re

# 1. Change submit button to type="button"
content = content.replace(
    '<button type="submit" class="btn-test-submit-bar" id="bottom-submit-btn">',
    '<button type="button" class="btn-test-submit-bar" id="bottom-submit-btn">'
)

# 2. Add Modal HTML before </main>
modals_html = """
   <!-- Modal Xác nhận Nộp bài (Ở giữa màn hình) -->
   <div class="modal fade" id="submitConfirmModal" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" style="max-width: 420px;">
         <div class="modal-content text-center p-4" style="border-radius: 16px; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.15);">
            <div class="mb-3">
               <div style="width: 60px; height: 60px; line-height: 60px; border-radius: 50%; background: #fef3c7; color: #d97706; margin: 0 auto; font-size: 26px;">
                  <i class="far fa-paper-plane"></i>
               </div>
            </div>
            <h4 class="mb-2" style="font-weight: 700; color: #00225a;">Xác nhận nộp bài?</h4>
            <p class="text-muted mb-4" style="font-size: 14.5px;">
               Bạn đã làm <strong class="text-primary" id="modal-answered-count">0</strong>/{{ $test->questions->count() }} câu.<br>Bạn có chắc chắn muốn nộp bài để chấm điểm?
            </p>
            <div class="d-flex justify-content-center gap-2">
               <button type="button" class="btn btn-light px-4 py-2" data-bs-dismiss="modal" style="font-weight: 600; border-radius: 8px; border: 1px solid #cbd5e1;">
                  Xem lại
               </button>
               <button type="button" class="btn px-4 py-2" id="btn-confirm-submit-action" style="font-weight: 700; border-radius: 8px; background: #ffb013; color: #00225a; border: none;">
                  Đồng ý nộp
               </button>
            </div>
         </div>
      </div>
   </div>

   <!-- Modal Xác nhận Hủy bài (Ở giữa màn hình) -->
   <div class="modal fade" id="cancelConfirmModal" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" style="max-width: 420px;">
         <div class="modal-content text-center p-4" style="border-radius: 16px; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.15);">
            <div class="mb-3">
               <div style="width: 60px; height: 60px; line-height: 60px; border-radius: 50%; background: #fee2e2; color: #dc2626; margin: 0 auto; font-size: 26px;">
                  <i class="far fa-exclamation-triangle"></i>
               </div>
            </div>
            <h4 class="mb-2" style="font-weight: 700; color: #991b1b;">Hủy bài làm?</h4>
            <p class="text-muted mb-4" style="font-size: 14.5px;">
               Thời gian và các câu trả lời hiện tại sẽ bị xóa.<br>Bạn có chắc chắn muốn thoát không?
            </p>
            <div class="d-flex justify-content-center gap-2">
               <button type="button" class="btn btn-light px-4 py-2" data-bs-dismiss="modal" style="font-weight: 600; border-radius: 8px; border: 1px solid #cbd5e1;">
                  Tiếp tục làm
               </button>
               <button type="button" class="btn btn-danger px-4 py-2" id="btn-confirm-cancel-action" style="font-weight: 700; border-radius: 8px;">
                  Xác nhận hủy
               </button>
            </div>
         </div>
      </div>
   </div>
   </main>"""

content = re.sub(r'\s*</main>', modals_html, content)

# 3. Replace old JS handlers with modal JS handlers
old_js_block = """         // 2.5. Xử lý Hủy bài làm
         $('#btn-cancel-test').on('click', function() {
            if (confirm('Bạn có chắc chắn muốn hủy bài làm này? Thời gian và câu trả lời hiện tại sẽ bị xóa.')) {
               localStorage.removeItem(testStorageKey);
               window.location.href = "{{ route('frontend.tests.index') }}";
            }
         });

         // 3. Kích hoạt nộp bài từ thanh cố định ở đáy
         $('#bottom-submit-btn').on('click', function() {
            $('#test-form').submit();
         });

         // 4. Xử lý nộp bài
         $('#test-form').on('submit', function(e) {
            e.preventDefault();
            
            if(!confirm('Bạn có chắc chắn muốn nộp bài?')) return;"""

new_js_block = """         // 2.5. Xử lý Hủy bài làm (Hiện Modal ở giữa màn hình)
         $('#btn-cancel-test').on('click', function() {
            var cancelModal = new bootstrap.Modal(document.getElementById('cancelConfirmModal'));
            cancelModal.show();
         });

         $('#btn-confirm-cancel-action').on('click', function() {
            localStorage.removeItem(testStorageKey);
            window.location.href = "{{ route('frontend.tests.index') }}";
         });

         // 3. Kích hoạt nộp bài từ thanh cố định ở đáy (Hiện Modal ở giữa màn hình)
         $('#bottom-submit-btn').on('click', function() {
            let count = 0;
            $('.question-box').each(function() {
               if ($(this).find('input:checked').length > 0) {
                  count++;
               }
            });
            $('#modal-answered-count').text(count);

            var submitModal = new bootstrap.Modal(document.getElementById('submitConfirmModal'));
            submitModal.show();
         });

         $('#btn-confirm-submit-action').on('click', function() {
            var modalEl = document.getElementById('submitConfirmModal');
            var modalInstance = bootstrap.Modal.getInstance(modalEl);
            if (modalInstance) {
               modalInstance.hide();
            }
            executeSubmitTest();
         });

         // 4. Xử lý nộp bài
         function executeSubmitTest() {"""

content = content.replace(old_js_block, new_js_block)

# Replace the closing of submit handler
content = content.replace(
    "            });\n         });\n      });\n   </script>",
    "            });\n         }\n      });\n   </script>"
)

with open(path, "w", encoding="utf-8") as f:
    f.write(content)

print("Updated modals and replaced confirm with centered modals!")
