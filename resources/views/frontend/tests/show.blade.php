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
         padding: 30px;
         border-radius: 15px;
         box-shadow: 0 5px 20px rgba(0,0,0,0.05);
         margin-bottom: 40px;
         border: 1px solid #f1f1f1;
      }
      .test-header-title {
         font-size: 28px;
         font-weight: 700;
         color: #00225a;
         margin-bottom: 10px;
      }
      .question-box {
         background: #fff;
         padding: 30px;
         border-radius: 15px;
         margin-bottom: 30px;
         box-shadow: 0 4px 15px rgba(0,0,0,0.03);
         border: 1px solid #eee;
      }
      .question-title {
         font-size: 18px;
         font-weight: 600;
         margin-bottom: 20px;
         color: #111;
         line-height: 1.5;
      }
      .answer-option {
         display: flex;
         align-items: center;
         margin-bottom: 12px;
         padding: 15px 20px;
         background: #f8f9fa;
         border: 1px solid #e9ecef;
         border-radius: 8px;
         cursor: pointer;
         transition: all 0.3s ease;
      }
      .answer-option:hover {
         background: #f0f4ff;
         border-color: #00225a;
      }
      .answer-option input {
         margin-right: 15px;
         width: 18px;
         height: 18px;
         cursor: pointer;
      }
      .answer-text {
         font-size: 16px;
         color: #444;
      }
      #result-box {
         display: none;
         margin-top: 30px;
         padding: 40px 30px;
         border-radius: 15px;
         text-align: center;
      }
      .pass { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
      .fail { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
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
                     <span class="badge bg-secondary p-2 mt-2" style="font-size: 14px;">
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

                     <div class="text-center mt-5 mb-5">
                        <button type="submit" class="it-btn-yellow" id="submit-btn" style="padding: 15px 40px; font-size: 18px; border: none;">
                           <span>
                              <span class="text-1">Nộp bài kiểm tra</span>
                              <span class="text-2">Nộp bài kiểm tra</span>
                           </span>
                        </button>
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
         $('#test-form').on('submit', function(e) {
            e.preventDefault();
            
            if(!confirm('Bạn có chắc chắn muốn nộp bài?')) return;

            let submitBtn = $('#submit-btn');
            submitBtn.prop('disabled', true).html('<span>Đang chấm điểm...</span>');

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
               },
               error: function(err) {
                  alert('Có lỗi xảy ra, vui lòng thử lại!');
                  submitBtn.prop('disabled', false).html('<span>Nộp bài kiểm tra</span>');
               }
            });
         });
      });
   </script>
</body>
</html>
