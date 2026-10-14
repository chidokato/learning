<!doctype html>
<html class="no-js" lang="zxx">
<head>
   <meta charset="utf-8">
   <meta http-equiv="x-ua-compatible" content="ie=edge">
   <title>Làm bài: {{ $test->title }} - {{ $siteSetting->site_name ?? 'Hệ thống học tập' }}</title>
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">        
   <link rel="stylesheet" href="{{ asset('assets/css/font-awesome-pro.css') }}">     
   <link rel="stylesheet" href="{{ asset('assets/css/swiper-bundle.min.css') }}">   
   <link rel="stylesheet" href="{{ asset('assets/css/slick.css') }}">              
   <link rel="stylesheet" href="{{ asset('assets/css/magnific-popup.css') }}">      
   <link rel="stylesheet" href="{{ asset('assets/css/nice-select.css') }}">          
   <link rel="stylesheet" href="{{ asset('assets/css/custom-animation.css') }}">
   <link rel="stylesheet" href="{{ asset('assets/css/spacing.css') }}">          
   <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}?v={{ time() }}">   
   <meta name="csrf-token" content="{{ csrf_token() }}">
   
   <style>
      .test-header-box {
         background: #fff;
         padding: 16px 20px;
         border-radius: 10px;
         box-shadow: 0 2px 8px rgba(0,0,0,0.03);
         margin-bottom: 16px;
         border: 1px solid #edf2f7;
      }
      .test-header-title {
         font-size: 20px;
         font-weight: 700;
         color: #00225a;
         margin-bottom: 6px;
         line-height: 1.35;
      }
      .test-header-badge {
         background: #f1f5f9;
         color: #475569;
         font-weight: 500;
         font-size: 13px;
         padding: 4px 12px;
         border-radius: 20px;
         border: 1px solid #e2e8f0;
         display: inline-block;
      }
      .question-box {
         background: #fff;
         padding: 16px 20px;
         border-radius: 10px;
         margin-bottom: 14px;
         box-shadow: 0 2px 6px rgba(0,0,0,0.02);
         border: 1px solid #edf2f7;
      }
      .question-title {
         font-size: 15px;
         font-weight: 600;
         margin-bottom: 12px;
         color: #1e293b;
         line-height: 1.45;
      }
      .answers-list {
         display: flex;
         flex-direction: column;
         gap: 6px;
      }
      .answer-option {
         display: flex;
         align-items: center;
         margin-bottom: 0;
         padding: 8px 14px;
         background: #f8fafc;
         border: 1px solid #e2e8f0;
         border-radius: 6px;
         cursor: pointer;
         transition: all 0.2s ease;
      }
      .answer-option:hover {
         background: #f0fdf9;
         border-color: #03594e;
      }
      .answer-option:has(input:checked) {
         background: #e6f6f4;
         border-color: #03594e;
      }
      .answer-option:has(input:checked) .answer-text {
         color: #03594e;
         font-weight: 500;
      }
      .answer-option input {
         margin-right: 10px;
         width: 16px;
         height: 16px;
         cursor: pointer;
         accent-color: #03594e;
         flex-shrink: 0;
      }
      .answer-text {
         font-size: 14px;
         color: #334155;
         line-height: 1.4;
      }
      #result-box {
         display: none;
         margin-top: 20px;
         padding: 24px 20px;
         border-radius: 10px;
         text-align: center;
      }
      .pass { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
      .fail { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }

      /* Sticky Action Bar inside Content Column */
      .test-sticky-bar {
         position: sticky;
         bottom: 15px;
         background: rgba(255, 255, 255, 0.98);
         backdrop-filter: blur(8px);
         border: 1px solid #edf2f7;
         border-radius: 10px;
         box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
         z-index: 990;
         padding: 10px 16px;
         margin-top: 15px;
         transition: opacity 0.3s ease;
      }
      .test-sticky-bar.hidden {
         display: none !important;
      }

      .test-timer-wrapper {
         display: inline-flex;
         align-items: center;
         background: #f8fafc;
         border: 1px solid #e2e8f0;
         padding: 6px 14px;
         border-radius: 30px;
         font-size: 14px;
         color: #334155;
      }
      .test-timer-wrapper .timer-val {
         font-weight: 700;
         color: #e11d48;
         font-size: 15px;
         min-width: 44px;
         display: inline-block;
         text-align: center;
      }
      .test-progress-badge {
         background: #f1f5f9;
         color: #475569;
         font-size: 13px;
         padding: 5px 12px;
         border-radius: 20px;
         margin-left: 8px;
         font-weight: 500;
      }
      .btn-test-cancel {
         display: inline-flex;
         align-items: center;
         padding: 8px 18px;
         background: #f8fafc;
         color: #64748b !important;
         border: 1px solid #cbd5e1;
         border-radius: 8px;
         font-size: 14px;
         font-weight: 600;
         text-decoration: none !important;
         transition: all 0.2s ease;
         cursor: pointer;
      }
      .btn-test-cancel:hover {
         background: #fee2e2;
         color: #dc2626 !important;
         border-color: #fca5a5;
      }
      .btn-test-submit-bar {
         display: inline-flex;
         align-items: center;
         padding: 8px 24px;
         background: #ffb013;
         color: #00225a !important;
         border: none;
         border-radius: 8px;
         font-size: 14px;
         font-weight: 700;
         box-shadow: 0 2px 6px rgba(255, 176, 19, 0.3);
         transition: all 0.2s ease;
         cursor: pointer;
      }
      .btn-test-submit-bar:hover {
         background: #e59d0a;
         transform: translateY(-1px);
         box-shadow: 0 4px 10px rgba(255, 176, 19, 0.4);
      }
      
   </style>
</head>

<body>
   @include('frontend.partials.header')

   <main>
      <div class="it-blog-details-area blog-details-left-sidebar pt-40 pb-40">
         <div class="container">
            <div class="row gx-35">
               
               <!-- Sidebar -->
               <div class="col-xl-3 col-lg-4">
                  @include('frontend.partials.profile-sidebar')
               </div>

               <!-- Main Content -->
               <div class="col-xl-9 col-lg-8">
                  <div class="test-header-box text-center">
                     <h3 class="test-header-title">{{ $test->title }}</h3>
                     <div class="d-flex align-items-center justify-content-center gap-2 mt-2 flex-wrap">
                        <span class="test-header-badge">
                           Yêu cầu đạt: {{ $test->pass_score }}/{{ $test->questions->count() }} câu
                        </span>
                        <span class="test-header-badge">
                           <i class="far fa-clock text-warning me-1"></i> Thời gian: {{ $test->duration && $test->duration > 0 ? $test->duration . ' phút' : 'Không giới hạn' }}
                        </span>
                     </div>
                  </div>

                  <form id="test-form">
                     @foreach($test->questions as $index => $q)
                        <div class="question-box">
                           <div class="question-title">
                              Câu {{ $index + 1 }}: {{ $q->content }}
                           </div>
                           <div class="answers-list">
                              @foreach($q->answers as $a)
                                 <label class="answer-option">
                                    @if($q->type == 'single_choice')
                                       <input type="radio" name="q_{{ $q->id }}" value="{{ $a->id }}">
                                    @else
                                       <input type="checkbox" name="q_{{ $q->id }}[]" value="{{ $a->id }}">
                                    @endif
                                    <span class="answer-text"><strong>{{ $a->label }}.</strong> {{ $a->content }}</span>
                                 </label>
                              @endforeach
                           </div>
                        </div>
                     @endforeach

                     <!-- Sticky Action Bar inside Question Column -->
                     <div class="test-sticky-bar" id="test-bottom-bar">
                        <div class="d-flex align-items-center justify-content-between">
                           <!-- Nút Hủy bài làm -->
                            <div>
                               <button type="button" class="btn-test-cancel" id="btn-cancel-test">
                                  <i class="far fa-times me-2"></i> Hủy bài làm
                               </button>
                            </div>

                           <!-- Đồng hồ thời gian & Tiến độ làm bài -->
                           <div class="d-flex align-items-center">
                              <div class="test-timer-wrapper">
                                 <i class="far fa-clock text-danger me-2"></i>
                                 <span>{{ $test->duration && $test->duration > 0 ? "Còn lại:" : "Thời gian:" }}</span>
                                 <span class="timer-val ms-2" id="test-timer">00:00</span>
                              </div>
                              <span class="test-progress-badge d-none d-sm-inline-block">
                                 Đã làm: <strong id="answered-count" class="text-primary">0</strong>/{{ $test->questions->count() }} câu
                              </span>
                           </div>

                           <!-- Nút Nộp bài -->
                           <div>
                              <button type="button" class="btn-test-submit-bar" id="bottom-submit-btn">
                                 <i class="far fa-paper-plane me-2"></i> Nộp bài
                              </button>
                           </div>
                        </div>
                     </div>
                  </form>

                  <div id="result-box" style="display: none; background: #fff; padding: 36px 24px; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,0.06); text-align: center; border: 1px solid #edf2f7;">
                     <div id="result-icon-wrapper" class="mb-3" style="width: 72px; height: 72px; line-height: 72px; border-radius: 50%; margin: 0 auto; font-size: 32px;"></div>
                     <h3 id="result-title" class="fw-bold mb-2"></h3>
                     <div id="result-text" class="fs-18 mb-2"></div>
                     <p id="result-subtext" class="text-muted mb-4" style="font-size: 14.5px;"></p>
                     <div class="d-flex justify-content-center gap-3 flex-wrap">
                        <button type="button" class="btn btn-warning px-4 py-2" onclick="location.reload();" style="font-weight: 700; border-radius: 8px;">
                           <i class="far fa-redo me-2"></i> Làm lại bài
                        </button>
                        <a href="{{ route('frontend.history.tests') }}" class="btn btn-outline-primary px-4 py-2" style="font-weight: 600; border-radius: 8px;">
                           <i class="far fa-history me-2"></i> Lịch sử làm bài
                        </a>
                        <a href="{{ route('frontend.tests.index') }}" class="btn btn-secondary px-4 py-2" style="font-weight: 600; border-radius: 8px;">
                           <i class="far fa-list me-2"></i> Danh sách bài
                        </a>
                     </div>
                  </div>
               </div>

            </div>
         </div>
      </div>
   </main>

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
            <h4 class="mb-2" style="font-weight: 700; color: #991b1b;">Xác nhận hủy bài làm?</h4>
            <p class="text-muted mb-4" style="font-size: 14.5px;">
               Lưu ý: Hủy bài làm <strong>vẫn được tính là 1 lượt làm bài</strong> (kết quả Chưa đạt).<br>Bạn có chắc chắn muốn kết thúc bài thi không?
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

   <!-- Modal Hết giờ làm bài (Ở giữa màn hình) -->
   <div class="modal fade" id="timeoutModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" style="max-width: 440px;">
         <div class="modal-content text-center p-4" style="border-radius: 16px; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.15);">
            <div class="mb-3">
               <div style="width: 64px; height: 64px; line-height: 64px; border-radius: 50%; background: #fee2e2; color: #dc2626; margin: 0 auto; font-size: 28px;">
                  <i class="far fa-clock"></i>
               </div>
            </div>
            <h4 class="mb-2" style="font-weight: 700; color: #00225a;">Hết giờ làm bài!</h4>
            <p class="text-muted mb-4" style="font-size: 14.5px;">
               Thời gian làm bài đã kết thúc.<br>Hệ thống đang tự động thu bài, chấm số câu đúng và ghi nhận kết quả lượt làm bài này...
            </p>
            <div class="d-flex justify-content-center align-items-center gap-2">
               <div class="spinner-border text-warning" role="status" style="width: 2rem; height: 2rem;">
                  <span class="visually-hidden">Đang nộp...</span>
               </div>
               <span class="text-muted fw-bold ms-2">Đang chấm điểm...</span>
            </div>
         </div>
      </div>
   </div>

   @include('frontend.partials.footer')
   
   <script src="{{ asset('assets/js/jquery.js') }}"></script>                     
   <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>      
   <script src="{{ asset('assets/js/purecounter.js') }}"></script>          
   <script src="{{ asset('assets/js/range-slider.js') }}"></script>          
   <script src="{{ asset('assets/js/nice-select.js') }}"></script>             
   <script src="{{ asset('assets/js/swiper-bundle.min.js') }}"></script>         
   <script src="{{ asset('assets/js/slick.min.js') }}"></script>                 
   <script src="{{ asset('assets/js/magnific-popup.js') }}"></script>           
   <script src="{{ asset('assets/js/wow.js') }}"></script>                    
   <script src="{{ asset('assets/js/main.js') }}"></script>
   
   <script>
      $(document).ready(function() {
         var timerInterval = null;
         var autoSubmitted = false;

         const testStorageKey = 'test_start_time_{{ $test->id }}_{{ auth()->id() ?? "guest" }}';
         const testAnswersKey = 'test_answers_{{ $test->id }}_{{ auth()->id() ?? "guest" }}';
         const testDurationMinutes = {{ (int)($test->duration ?? 0) }};
         const totalAllowedSeconds = testDurationMinutes * 60;
         const totalQuestionsCount = {{ $test->questions->count() }};
         const passScoreRequired = {{ (int)($test->pass_score ?? 0) }};

         // Helper hiển thị modal an toàn (hỗ trợ cả BS5 và jQuery)
         function showModal(modalId) {
            var el = document.getElementById(modalId);
            if (!el) return;
            if (typeof bootstrap !== 'undefined' && bootstrap.Modal) {
               var modal = bootstrap.Modal.getOrCreateInstance(el);
               modal.show();
            } else if (typeof $ !== 'undefined' && $.fn.modal) {
               $('#' + modalId).modal('show');
            }
         }

         // Helper ẩn modal an toàn
         function hideModal(modalId) {
            var el = document.getElementById(modalId);
            if (!el) return;
            if (typeof bootstrap !== 'undefined' && bootstrap.Modal) {
               var modal = bootstrap.Modal.getInstance(el);
               if (modal) modal.hide();
            } else if (typeof $ !== 'undefined' && $.fn.modal) {
               $('#' + modalId).modal('hide');
            }
         }

         // Thu thập dữ liệu đáp án hiện tại
         function collectAnswers() {
            var answers = [];
            $('.question-box').each(function() {
               var qInput = $(this).find('input');
               if (qInput.length === 0) return;
               var qId = qInput.first().attr('name').replace('q_', '').replace('[]', '');
               var selected = [];
               
               $(this).find('input:checked').each(function() {
                  selected.push(parseInt($(this).val()));
               });

               if (selected.length > 0) {
                  answers.push({
                     question_id: parseInt(qId),
                     answer_ids: selected
                  });
               }
            });
            return answers;
         }

         // Lưu các đáp án đã chọn vào localStorage
         function saveAnswersToStorage() {
            try {
               var answers = collectAnswers();
               localStorage.setItem(testAnswersKey, JSON.stringify(answers));
            } catch(e) {
               console.error('Error saving answers:', e);
            }
         }

         // Phục hồi các đáp án đã chọn từ localStorage
         function restoreAnswersFromStorage() {
            try {
               var saved = localStorage.getItem(testAnswersKey);
               if (!saved) return;
               var answers = JSON.parse(saved);
               if (Array.isArray(answers)) {
                  answers.forEach(function(item) {
                     if (item.question_id && Array.isArray(item.answer_ids)) {
                        item.answer_ids.forEach(function(ansId) {
                           $('input[name="q_' + item.question_id + '"][value="' + ansId + '"]').prop('checked', true);
                           $('input[name="q_' + item.question_id + '[]"][value="' + ansId + '"]').prop('checked', true);
                        });
                     }
                  });
               }
            } catch(e) {
               console.error('Error restoring answers:', e);
            }
         }

         // Cập nhật số câu đã làm
         function updateAnsweredCount() {
            var count = 0;
            $('.question-box').each(function() {
               if ($(this).find('input:checked').length > 0) {
                  count++;
               }
            });
            $('#answered-count').text(count);
            $('#modal-answered-count').text(count);
         }

         // 1. Phục hồi câu trả lời đã lưu từ phiên trước
         restoreAnswersFromStorage();
         updateAnsweredCount();

         // Lắng nghe sự kiện click/change để cập nhật tiến độ & lưu đáp án
         $(document).on('change click', '.question-box input', function() {
            updateAnsweredCount();
            saveAnswersToStorage();
         });

         // 2. Quản lý thời gian làm bài thực tế
         var now = Date.now();
         var savedStartTime = localStorage.getItem(testStorageKey);
         var startTime = null;

         if (savedStartTime) {
            var parsedTime = parseInt(savedStartTime, 10);
            if (!isNaN(parsedTime)) {
               var elapsed = Math.floor((now - parsedTime) / 1000);
               if (testDurationMinutes > 0 && elapsed >= totalAllowedSeconds) {
                  // Đã quá thời hạn cho phép -> Tự động nộp bài và tính 1 lần làm bài
                  autoSubmitted = true;
                  $('#test-timer').text('00:00');
                  showModal('timeoutModal');
                  executeSubmitTest();
                  return;
               } else {
                  startTime = parsedTime;
               }
            }
         }

         if (!startTime) {
            startTime = now;
            localStorage.setItem(testStorageKey, startTime);
         }

         function updateTimerDisplay() {
            var currentNow = Date.now();
            var elapsedSeconds = Math.max(0, Math.floor((currentNow - startTime) / 1000));
            var displaySeconds = 0;

            if (testDurationMinutes > 0) {
               var remaining = totalAllowedSeconds - elapsedSeconds;
               if (remaining <= 0) {
                  remaining = 0;
                  $('#test-timer').text('00:00');
                  if (!autoSubmitted) {
                     autoSubmitted = true;
                     if (timerInterval) {
                        clearInterval(timerInterval);
                     }
                     hideModal('submitConfirmModal');
                     hideModal('cancelConfirmModal');
                     showModal('timeoutModal');
                     executeSubmitTest();
                  }
                  return;
               }
               displaySeconds = remaining;
            } else {
               displaySeconds = elapsedSeconds;
            }

            var hours = Math.floor(displaySeconds / 3600);
            var mins = Math.floor((displaySeconds % 3600) / 60);
            var secs = displaySeconds % 60;
            
            var formatted = '';
            if (hours > 0) {
               formatted = (hours < 10 ? '0' : '') + hours + ':' + 
                           (mins < 10 ? '0' : '') + mins + ':' + 
                           (secs < 10 ? '0' : '') + secs;
            } else {
               formatted = (mins < 10 ? '0' : '') + mins + ':' + 
                           (secs < 10 ? '0' : '') + secs;
            }
            $('#test-timer').text(formatted);
         }

         // Khởi động đồng hồ đếm ngược
         updateTimerDisplay();
         timerInterval = setInterval(updateTimerDisplay, 1000);

         // 3. Xử lý Hủy bài làm
         $('#btn-cancel-test').on('click', function(e) {
            e.preventDefault();
            showModal('cancelConfirmModal');
         });

         $('#btn-confirm-cancel-action').on('click', function() {
            var cancelBtn = $(this);
            cancelBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-2"></i> Đang hủy...');

            var answers = collectAnswers();

            $.ajax({
               url: '{{ route('frontend.tests.submit', $test->id) }}',
               type: 'POST',
               data: {
                  _token: $('meta[name="csrf-token"]').attr('content'),
                  answers: answers,
                  is_cancelled: 1
               },
               complete: function() {
                  if (timerInterval) {
                     clearInterval(timerInterval);
                  }
                  localStorage.removeItem(testStorageKey);
                  localStorage.removeItem(testAnswersKey);
                  window.location.href = "{{ route('frontend.tests.index') }}";
               }
            });
         });

         // 4. Kích hoạt nộp bài chủ động từ thanh đáy
         $('#bottom-submit-btn').on('click', function(e) {
            e.preventDefault();
            updateAnsweredCount();
            showModal('submitConfirmModal');
         });

         $('#btn-confirm-submit-action').on('click', function() {
            hideModal('submitConfirmModal');
            executeSubmitTest();
         });

         // 5. Nộp bài lên hệ thống (Chấm điểm & Ghi nhận 1 lần làm bài)
         function executeSubmitTest() {
            var bottomBtn = $('#bottom-submit-btn');
            bottomBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-2"></i> Đang nộp...');

            var answers = collectAnswers();

            $.ajax({
               url: '{{ route('frontend.tests.submit', $test->id) }}',
               type: 'POST',
               data: {
                  _token: $('meta[name="csrf-token"]').attr('content'),
                  answers: answers
               },
               success: function(res) {
                  if (timerInterval) {
                     clearInterval(timerInterval);
                  }
                  // Xóa sạch trạng thái lưu tạm để lần làm sau làm mới hoàn toàn
                  localStorage.removeItem(testStorageKey);
                  localStorage.removeItem(testAnswersKey);

                  hideModal('timeoutModal');
                  hideModal('submitConfirmModal');
                  hideModal('cancelConfirmModal');
                  $('#test-bottom-bar').addClass('hidden');

                  $('#test-form').slideUp();
                  var resultBox = $('#result-box');
                  var iconWrapper = $('#result-icon-wrapper');
                  var data = res.result;

                  if (data.is_passed) {
                     iconWrapper.css({ 'background': '#dcfce7', 'color': '#15803d' }).html('<i class="far fa-trophy"></i>');
                     $('#result-title').css('color', '#15803d').text('🎉 Chúc mừng! Bạn đã ĐẠT bài kiểm tra.');
                  } else {
                     iconWrapper.css({ 'background': '#fee2e2', 'color': '#dc2626' }).html('<i class="far fa-times-circle"></i>');
                     $('#result-title').css('color', '#dc2626').text('⚠️ Rất tiếc! Bạn CHƯA ĐẠT bài kiểm tra.');
                  }

                  $('#result-text').html(`Số câu trả lời đúng: <strong class="fs-22 text-primary">${data.total_correct}</strong> / ${data.total_questions} câu`);
                  $('#result-subtext').html(`Yêu cầu đạt: <strong>${passScoreRequired}</strong>/${data.total_questions} câu. Kết quả này đã được ghi nhận vào lịch sử làm bài.`);
                  resultBox.slideDown();

                  $('html, body').animate({ scrollTop: $('.test-header-box').offset().top - 30 }, 400);
               },
               error: function(xhr, status, err) {
                  console.error('Submit error:', xhr);
                  hideModal('timeoutModal');
                  var errorMsg = 'Có lỗi xảy ra, vui lòng thử lại!';
                  if (xhr.responseJSON && xhr.responseJSON.message) {
                     errorMsg = xhr.responseJSON.message;
                  }
                  alert(errorMsg);
                  bottomBtn.prop('disabled', false).html('<i class="far fa-paper-plane me-2"></i> Nộp bài');
               }
            });
         }
      });
   </script>
</body>
</html>
