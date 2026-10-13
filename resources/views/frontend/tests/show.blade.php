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
         z-index: 99;
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
                     <span class="test-header-badge">
                        Điểm qua môn: {{ $test->pass_score }} / {{ $test->questions->count() }}
                     </span>
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
                                 <span>Thời gian:</span>
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

                  <div id="result-box">
                     <h3 id="result-title"></h3>
                     <p id="result-text" class="fs-18 mt-2"></p>
                     <a href="{{ route('frontend.tests.index') }}" class="it-btn mt-3"><span>Quay lại danh sách</span></a>
                  </div>
               </div>

            </div>
         </div>
      </div>
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
   </main>

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
         // 1. Đồng hồ thời gian thực (Lưu vào localStorage để load trang không bị reset)
         const testStorageKey = 'test_start_time_{{ $test->id }}_{{ auth()->id() ?? "guest" }}';
         let startTime = localStorage.getItem(testStorageKey);
         if (!startTime) {
            startTime = Date.now();
            localStorage.setItem(testStorageKey, startTime);
         } else {
            startTime = parseInt(startTime);
         }

         function updateTimerDisplay() {
            let elapsedSeconds = Math.max(0, Math.floor((Date.now() - startTime) / 1000));
            let hours = Math.floor(elapsedSeconds / 3600);
            let mins = Math.floor((elapsedSeconds % 3600) / 60);
            let secs = elapsedSeconds % 60;
            
            let formatted = '';
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

         updateTimerDisplay();
         let timerInterval = setInterval(updateTimerDisplay, 1000);

         // 2. Cập nhật số câu đã làm
         function updateAnsweredCount() {
            let count = 0;
            $('.question-box').each(function() {
               if ($(this).find('input:checked').length > 0) {
                  count++;
               }
            });
            $('#answered-count').text(count);
         }
         $('input[type="radio"], input[type="checkbox"]').on('change', updateAnsweredCount);
         updateAnsweredCount();

         // 2.5. Xử lý Hủy bài làm (Hiện Modal ở giữa màn hình)
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
         function executeSubmitTest() {

            let submitBtn = $('#submit-btn');
            let bottomBtn = $('#bottom-submit-btn');
            submitBtn.prop('disabled', true).html('<span>Đang chấm điểm...</span>');
            bottomBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-2"></i> Đang nộp...');

            // Format dữ liệu gửi đi
            let answers = [];
            $('.question-box').each(function() {
               let qId = $(this).find('input').attr('name').replace('q_', '').replace('[]', '');
               let selected = [];
               
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

            $.ajax({
               url: '/api/tests/{{ $test->id }}/submit',
               type: 'POST',
               data: {
                  _token: $('meta[name="csrf-token"]').attr('content'),
                  answers: answers
               },
               success: function(res) {
                  // Dừng đồng hồ, xóa bộ nhớ thời gian & ẩn thanh bottom bar
                  clearInterval(timerInterval);
                  localStorage.removeItem(testStorageKey);
                  $('#test-bottom-bar').addClass('hidden');

                  $('#test-form').slideUp();
                  let resultBox = $('#result-box');
                  let data = res.result;

                  if(data.is_passed) {
                     resultBox.addClass('pass');
                     $('#result-title').text('Chúc mừng! Bạn đã ĐẠT.');
                  } else {
                     resultBox.addClass('fail');
                     $('#result-title').text('Rất tiếc! Bạn CHƯA ĐẠT.');
                  }

                  $('#result-text').text(`Số câu đúng: ${data.total_correct} / ${data.total_questions}`);
                  resultBox.slideDown();

                  // Cuộn lên đầu xem kết quả
                  $('html, body').animate({ scrollTop: $('.test-header-box').offset().top - 30 }, 400);
               },
               error: function(err) {
                  alert('Có lỗi xảy ra, vui lòng thử lại!');
                  submitBtn.prop('disabled', false).html('<span>Nộp bài kiểm tra</span>');
                  bottomBtn.prop('disabled', false).html('<i class="far fa-paper-plane me-2"></i> Nộp bài');
               }
            });
         }
      });
   </script>
</body>
</html>
