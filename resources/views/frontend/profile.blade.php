<!doctype html>
<html class="no-js" lang="vi">
<head>
   <meta charset="utf-8">
   <meta http-equiv="x-ua-compatible" content="ie=edge">
   <title>Trang cá nhân -- Indochine</title>
   <meta name="description" content="">
   <meta name="viewport" content="width=device-width, initial-scale=1">

   <link rel="shortcut icon" type="image/x-icon" href="{{ $siteSetting->favicon_url ?? asset('assets/img/favicon.png') }}">

   <!-- CSS Here -->
   <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">        
   <link rel="stylesheet" href="{{ asset('assets/css/font-awesome-pro.css') }}">     
   <link rel="stylesheet" href="{{ asset('assets/css/swiper-bundle.min.css') }}">   
   <link rel="stylesheet" href="{{ asset('assets/css/slick.css') }}">              
   <link rel="stylesheet" href="{{ asset('assets/css/magnific-popup.css') }}">      
   <link rel="stylesheet" href="{{ asset('assets/css/nice-select.css') }}">          
   <link rel="stylesheet" href="{{ asset('assets/css/custom-animation.css') }}">

   <!-- Theme / Main CSS -->
   <link rel="stylesheet" href="{{ asset('assets/css/spacing.css') }}">          
   <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}?v={{ time() }}">   

   <style>
      .sidebar-widget-list {
         cursor: pointer;
         text-decoration: none !important;
      }
      .sidebar-widget-list i {
         transition: 0.3s;
      }
      .sidebar-widget-list.active i,
      .sidebar-widget-list:hover i {
         color: var(--it-common-white) !important;
      }
      .sidebar-widget-list.active .text-danger,
      .sidebar-widget-list:hover .text-danger {
         color: var(--it-common-white) !important;
      }
      .sidebar-widget .form-control {
         height: 52px;
         border-radius: 8px;
         border: 1px solid rgba(31, 36, 50, 0.15);
         padding: 10px 18px;
         font-size: 15px;
      }
      .sidebar-widget .form-control:focus {
         border-color: var(--it-theme-1);
         box-shadow: 0 0 0 0.2rem rgba(3, 89, 78, 0.15);
      }
      .it-btn-profile {
         background-color: #03594e;
         color: #ffffff !important;
         font-weight: 600;
         padding: 13px 30px;
         border-radius: 8px;
         border: none;
         display: inline-flex;
         align-items: center;
         justify-content: center;
         transition: all 0.3s ease;
         font-size: 15px;
         cursor: pointer;
      }
      .it-btn-profile:hover {
         background-color: #02463d;
         color: #ffffff !important;
         transform: translateY(-2px);
         box-shadow: 0 6px 15px rgba(3, 89, 78, 0.25);
      }
   </style>
</head>

<body>

   <!-- back-to-top-start  -->
   <button class="scroll-top scroll-to-target" data-target="html">
      <i class="far fa-angle-double-up"></i>
   </button>

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
                  <div class="tab-content" id="profileTabContent">
                     
                     <!-- Tab Thông tin cá nhân & Mật khẩu -->
                     <div class="tab-pane fade show active" id="tab-info" role="tabpanel" aria-labelledby="tab-info-link">
                        <div class="sidebar-widget mb-40" style="background-color: #fff;">
                           <h4 class="sidebar-widget-title mb-25 pb-15 border-bottom">Thông tin cá nhân</h4>
                           
                           <form action="{{ route('frontend.profile.update') }}" method="POST">
                              @csrf
                              
                              <!-- Thông tin cá nhân -->
                              <div class="row mb-20">
                                 <div class="col-md-6 mb-20 mb-md-0">
                                    <label class="form-label fw-semibold">Họ và tên <span class="text-danger">*</span></label>
                                    <input type="text" name="name" class="form-control" value="{{ old('name', Auth::user()->name) }}" required>
                                    @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                                 </div>
                                 <div class="col-md-6">
                                    <label class="form-label fw-semibold">Email</label>
                                    <input type="email" class="form-control bg-light" value="{{ Auth::user()->email }}" disabled>
                                    <small class="text-muted">Email không thể thay đổi</small>
                                 </div>
                              </div>

                              <div class="row mb-25">
                                 <div class="col-md-6 mb-20 mb-md-0">
                                    <label class="form-label fw-semibold">Số điện thoại</label>
                                    <input type="text" name="phone" class="form-control" value="{{ old('phone', Auth::user()->phone) }}">
                                    @error('phone') <small class="text-danger">{{ $message }}</small> @enderror
                                 </div>
                                 <div class="col-md-6">
                                    <label class="form-label fw-semibold">Địa chỉ</label>
                                    <input type="text" name="address" class="form-control" value="{{ old('address', Auth::user()->address) }}">
                                    @error('address') <small class="text-danger">{{ $message }}</small> @enderror
                                 </div>
                              </div>

                              <!-- Đổi mật khẩu section -->
                              <div class="pt-25 border-top mt-25">
                                 <div class="form-check mb-15 d-flex align-items-center">
                                    <input class="form-check-input mt-0" type="checkbox" id="changePasswordCheckbox" name="change_password" value="1" {{ old('change_password') || (!empty($errors) && $errors->has('password')) ? 'checked' : '' }} style="width: 19px; height: 19px; cursor: pointer;">
                                    <label class="form-check-label fw-bold ms-2 mb-0" for="changePasswordCheckbox" style="font-size: 15px; color: #1a2c5e; cursor: pointer;">
                                       <i class="far fa-key me-1 text-muted"></i> Đổi mật khẩu
                                    </label>
                                 </div>

                                 <div id="passwordFields" style="{{ old('change_password') || (!empty($errors) && $errors->has('password')) ? 'display: block;' : 'display: none;' }}">
                                    <p class="text-muted mb-20" style="font-size: 13px;">Nhập mật khẩu mới (ít nhất 6 ký tự) để thay đổi mật khẩu tài khoản của bạn.</p>

                                    <div class="row mb-20">
                                       <div class="col-md-6 mb-20 mb-md-0">
                                          <label class="form-label fw-semibold">Mật khẩu mới <span class="text-danger">*</span></label>
                                          <input type="password" name="password" id="inputNewPassword" class="form-control" minlength="6" placeholder="Nhập mật khẩu mới" autocomplete="new-password" {{ old('change_password') || (!empty($errors) && $errors->has('password')) ? '' : 'disabled' }}>
                                          @error('password') <small class="text-danger">{{ $message }}</small> @enderror
                                       </div>
                                       <div class="col-md-6">
                                          <label class="form-label fw-semibold">Xác nhận mật khẩu mới <span class="text-danger">*</span></label>
                                          <input type="password" name="password_confirmation" id="inputConfirmPassword" class="form-control" minlength="6" placeholder="Nhập lại mật khẩu mới" autocomplete="new-password" {{ old('change_password') || (!empty($errors) && $errors->has('password')) ? '' : 'disabled' }}>
                                       </div>
                                    </div>
                                 </div>
                              </div>

                              <div class="mt-30 text-end">
                                 <button type="submit" class="it-btn-profile">
                                    <i class="far fa-save me-2"></i> Lưu thay đổi
                                 </button>
                              </div>
                           </form>
                        </div>
                     </div>

                     <!-- Tab Lịch sử học tập -->
                     <div class="tab-pane fade" id="tab-learning-history" role="tabpanel" aria-labelledby="tab-learning-history-link">
                        <div class="sidebar-widget mb-40" style="background-color: #fff;">
                           <div class="d-flex justify-content-between align-items-center mb-25 pb-15 border-bottom flex-wrap gap-2">
                              <h4 class="sidebar-widget-title mb-0">Lịch sử học tập</h4>
                              @php $learnedList = $learnedCourses ?? collect(); @endphp
                              <span class="badge" style="background-color: #03594e; font-size: 13px; padding: 7px 14px; border-radius: 20px;">
                                 Đã học: {{ $learnedList->count() }} khóa học
                              </span>
                           </div>

                           @if($learnedList->count() > 0)
                              <div class="row g-3">
                                 @foreach($learnedList as $item)
                                    @if($item->post)
                                    <div class="col-12">
                                       <div class="p-3 rounded border d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3" style="background: #fafbfc;">
                                          <div class="d-flex align-items-center gap-3">
                                             <img src="{{ $item->post->image ? asset($item->post->image) : asset('assets/img/course/course-1-5.jpg') }}" alt="{{ $item->post->title }}" style="width: 80px; height: 60px; object-fit: cover; border-radius: 8px;" class="flex-shrink-0">
                                             <div>
                                                <h6 class="mb-1 fw-bold">
                                                   <a href="{{ $item->post->frontend_url }}" class="text-dark text-decoration-none">
                                                      {{ $item->post->title }}
                                                   </a>
                                                </h6>
                                                <div class="text-muted small d-flex flex-wrap align-items-center gap-3">
                                                   @if($item->post->category)
                                                      <span class="badge bg-light text-secondary border">{{ $item->post->category->name }}</span>
                                                   @endif
                                                   <span>
                                                      <i class="far fa-clock me-1"></i> Học gần nhất: {{ $item->last_learned_at ? $item->last_learned_at->timezone('Asia/Ho_Chi_Minh')->format('d/m/Y H:i') : $item->updated_at->timezone('Asia/Ho_Chi_Minh')->format('d/m/Y H:i') }}
                                                   </span>
                                                </div>
                                             </div>
                                          </div>
                                          <div class="flex-shrink-0 text-md-end">
                                             <a href="{{ $item->post->learn_url }}" class="it-btn-profile" style="padding: 9px 20px; font-size: 13px; text-decoration: none;">
                                                <i class="far fa-play-circle me-1"></i> Tiếp tục học
                                             </a>
                                          </div>
                                       </div>
                                    </div>
                                    @endif
                                 @endforeach
                              </div>
                           @else
                              <div class="text-center py-5">
                                 <div style="font-size: 48px; color: #adb5bd;" class="mb-3">
                                    <i class="far fa-graduation-cap"></i>
                                 </div>
                                 <h6 class="text-muted mb-3">Bạn chưa có lịch sử học khóa học nào.</h6>
                                 <a href="{{ route('frontend.home') }}" class="it-btn-profile text-decoration-none" style="padding: 10px 24px; font-size: 14px;">
                                    <i class="far fa-compass me-2"></i> Khám phá các khóa học
                                 </a>
                              </div>
                           @endif
                        </div>
                     </div>

                     <!-- Tab Lịch sử làm bài kiểm tra -->
                     <div class="tab-pane fade" id="tab-test-history" role="tabpanel" aria-labelledby="tab-test-history-link">
                        <div class="sidebar-widget mb-40" style="background-color: #fff;">
                           <div class="d-flex justify-content-between align-items-center mb-25 pb-15 border-bottom flex-wrap gap-2">
                              <h4 class="sidebar-widget-title mb-0">Lịch sử làm bài kiểm tra</h4>
                              @php $testList = $testResults ?? collect(); @endphp
                              <span class="badge" style="background-color: #03594e; font-size: 13px; padding: 7px 14px; border-radius: 20px;">
                                 Đã làm: {{ $testList->count() }} lượt
                              </span>
                           </div>

                           @if($testList->count() > 0)
                              <div class="table-responsive">
                                 <table class="table table-hover align-middle mb-0">
                                    <thead class="table-light">
                                       <tr style="font-size: 14px;">
                                          <th>Bài kiểm tra</th>
                                          <th class="text-center">Điểm số</th>
                                          <th class="text-center">Kết quả</th>
                                          <th>Thời gian hoàn thành</th>
                                          <th class="text-end">Hành động</th>
                                       </tr>
                                    </thead>
                                    <tbody>
                                       @foreach($testList as $result)
                                       <tr style="font-size: 14px;">
                                          <td>
                                             <strong class="text-dark">{{ $result->test ? $result->test->title : 'Bài kiểm tra #' . $result->test_id }}</strong>
                                             @if($result->test)
                                                <div class="small text-muted">Điểm qua: {{ $result->test->pass_score }}</div>
                                             @endif
                                          </td>
                                          <td class="text-center fw-bold" style="font-size: 15px;">
                                             {{ $result->score }}
                                          </td>
                                          <td class="text-center">
                                             @if($result->is_passed)
                                                <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-2 rounded-pill">
                                                   <i class="far fa-check-circle me-1"></i> ĐẠT
                                                </span>
                                             @else
                                                <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-3 py-2 rounded-pill">
                                                   <i class="far fa-times-circle me-1"></i> CHƯA ĐẠT
                                                </span>
                                             @endif
                                          </td>
                                          <td class="text-muted">
                                             <i class="far fa-calendar-alt me-1"></i>
                                             {{ $result->completed_at ? $result->completed_at->timezone('Asia/Ho_Chi_Minh')->format('d/m/Y H:i') : $result->created_at->timezone('Asia/Ho_Chi_Minh')->format('d/m/Y H:i') }}
                                          </td>
                                          <td class="text-end">
                                             <a href="{{ route('frontend.tests.show', $result->test_id) }}" class="btn btn-sm btn-outline-secondary rounded-pill px-3" style="font-size: 12px;">
                                                <i class="far fa-redo me-1"></i> Làm lại
                                             </a>
                                          </td>
                                       </tr>
                                       @endforeach
                                    </tbody>
                                 </table>
                              </div>
                           @else
                              <div class="text-center py-5">
                                 <div style="font-size: 48px; color: #adb5bd;" class="mb-3">
                                    <i class="far fa-clipboard-list"></i>
                                 </div>
                                 <h6 class="text-muted mb-3">Bạn chưa tham gia bài kiểm tra nào.</h6>
                                 <a href="{{ route('frontend.tests.index') }}" class="it-btn-profile text-decoration-none" style="padding: 10px 24px; font-size: 14px;">
                                    <i class="far fa-pen-nib me-2"></i> Làm bài kiểm tra ngay
                                 </a>
                              </div>
                           @endif
                        </div>
                     </div>

                  </div>
               </div>

            </div>
         </div>
      </div>
   </main>

   @include('frontend.partials.footer')
   
   <!-- JS  Libraries -->
   <script src="{{ asset('assets/js/jquery.js') }}"></script>                     
   <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>      
   <script src="{{ asset('assets/js/purecounter.js') }}"></script>          
   <script src="{{ asset('assets/js/range-slider.js') }}"></script>          
   <script src="{{ asset('assets/js/nice-select.js') }}"></script>             
   <script src="{{ asset('assets/js/swiper-bundle.min.js') }}"></script>         
   <script src="{{ asset('assets/js/isotope-pkgd.js') }}"></script>     
   <script src="{{ asset('assets/js/slick.min.js') }}"></script>            
   <script src="{{ asset('assets/js/wow.js') }}"></script>                
   <script src="{{ asset('assets/js/countdown.js') }}"></script>                
   <script src="{{ asset('assets/js/magnific-popup.js') }}"></script>                
   <script src="{{ asset('assets/js/imagesloaded-pkgd.js') }}"></script>                
   <script src="{{ asset('assets/js/parallax.js') }}"></script>                

   <!-- Custom JS -->
   <script src="{{ asset('assets/js/slider.js') }}"></script>                
   <script src="{{ asset('assets/js/main.js') }}"></script>  
   <script>
      $(document).ready(function() {
         var hash = window.location.hash;
         if (hash === '#tab-password') {
            hash = '#tab-info';
            $('#changePasswordCheckbox').prop('checked', true);
            $('#passwordFields').show();
            $('#inputNewPassword, #inputConfirmPassword').prop('disabled', false);
         }
         if (hash) {
            var tabBtn = document.querySelector('a[href="' + hash + '"]');
            if (tabBtn) {
               var tab = new bootstrap.Tab(tabBtn);
               tab.show();
            }
         }

         // Toggle password fields
         $('#changePasswordCheckbox').on('change', function() {
            if ($(this).is(':checked')) {
               $('#passwordFields').stop(true, true).slideDown(200);
               $('#inputNewPassword, #inputConfirmPassword').prop('disabled', false);
            } else {
               $('#passwordFields').stop(true, true).slideUp(200);
               $('#inputNewPassword, #inputConfirmPassword').prop('disabled', true).val('');
            }
         });

         // Update URL hash when tab is switched
         $('a[data-bs-toggle="pill"]').on('shown.bs.tab', function(e) {
            var target = $(e.target).attr('href');
            if (target && target.startsWith('#')) {
               history.replaceState(null, null, target);
            }
         });
      });
   </script>
</body>
</html>
