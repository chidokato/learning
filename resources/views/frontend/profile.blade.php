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

      /* Card bao bọc form thông tin cá nhân */
      .sidebar-widget.profile-form-widget {
         background: #ffffff;
         border: 1px solid #eef2f6;
         border-radius: 16px;
         padding: 26px 26px 30px;
         box-shadow: 0 4px 20px -2px rgba(15, 23, 42, 0.05);
      }
      .profile-widget-title {
         font-size: 18px;
         font-weight: 700;
         color: #1a2c5e;
         margin-bottom: 20px;
         padding-bottom: 12px;
         border-bottom: 1px solid #f1f4f8;
         display: flex;
         align-items: center;
         gap: 8px;
      }

      /* Nhãn tiêu đề (Label) nhỏ gọn, rõ ràng */
      .sidebar-widget .form-label {
         font-size: 13px;
         font-weight: 600;
         color: #374151;
         margin-bottom: 5px;
         display: inline-block;
         line-height: 1.3;
      }
      .sidebar-widget .form-label .text-danger {
         font-size: 13px;
      }

      /* Thẻ input nhỏ gọn, thanh thoát, tinh tế */
      .sidebar-widget .form-control {
         height: 40px;
         min-height: 40px;
         border-radius: 6px;
         border: 1px solid #d1d5db;
         padding: 6px 13px;
         font-size: 13.5px;
         color: #1f2937;
         background-color: #ffffff;
         transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
         box-shadow: 0 1px 2px rgba(0, 0, 0, 0.03);
      }
      .sidebar-widget .form-control::placeholder {
         color: #9ca3af;
         font-size: 13px;
      }
      .sidebar-widget .form-control:focus {
         border-color: #03594e;
         box-shadow: 0 0 0 3px rgba(3, 89, 78, 0.12);
         outline: none;
      }
      .sidebar-widget .form-control:disabled,
      .sidebar-widget .form-control.bg-light {
         background-color: #f8fafc !important;
         border-color: #e2e8f0 !important;
         color: #64748b !important;
         cursor: not-allowed !important;
         box-shadow: none;
      }

      /* Thông báo lỗi & ghi chú nhỏ dưới input */
      .sidebar-widget small.text-danger {
         font-size: 12px;
         margin-top: 3px;
         display: block;
         font-weight: 500;
         color: #dc2626 !important;
      }
      .sidebar-widget small.text-muted {
         font-size: 12px;
         margin-top: 3px;
         display: block;
         color: #64748b !important;
      }

      /* Nút lưu thay đổi cân đối với input */
      .it-btn-profile {
         background-color: #03594e;
         color: #ffffff !important;
         font-weight: 600;
         height: 40px;
         padding: 0 22px;
         border-radius: 6px;
         border: none;
         display: inline-flex;
         align-items: center;
         justify-content: center;
         gap: 7px;
         transition: all 0.25s ease;
         font-size: 13.5px;
         cursor: pointer;
      }
      .it-btn-profile:hover {
         background-color: #02463d;
         color: #ffffff !important;
         transform: translateY(-1px);
         box-shadow: 0 4px 12px rgba(3, 89, 78, 0.25);
      }

      /* Nút gạt chuyển đổi đổi mật khẩu nhỏ gọn */
      .custom-toggle-wrap {
         display: inline-flex;
         align-items: center;
         gap: 10px;
         cursor: pointer;
         user-select: none;
      }
      .custom-toggle-label {
         font-size: 13.5px;
         font-weight: 600;
         color: #1e293b;
      }
      .custom-toggle-switch {
         position: relative;
         display: inline-block;
         width: 40px;
         height: 22px;
         margin-bottom: 0;
         flex-shrink: 0;
      }
      .custom-toggle-switch input {
         opacity: 0;
         width: 0;
         height: 0;
         position: absolute;
      }
      .custom-toggle-slider {
         position: absolute;
         cursor: pointer;
         top: 0;
         left: 0;
         right: 0;
         bottom: 0;
         background-color: #cbd5e1;
         transition: all 0.25s ease-in-out;
         border-radius: 22px;
      }
      .custom-toggle-slider::before {
         position: absolute;
         content: "";
         height: 16px;
         width: 16px;
         left: 3px;
         bottom: 3px;
         background-color: #ffffff;
         transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
         border-radius: 50%;
         box-shadow: 0 1px 3px rgba(0, 0, 0, 0.25);
      }
      .custom-toggle-switch input:checked + .custom-toggle-slider {
         background-color: #03594e;
         box-shadow: 0 0 0 3px rgba(3, 89, 78, 0.15);
      }
      .custom-toggle-switch input:checked + .custom-toggle-slider::before {
         transform: translateX(18px);
      }

      /* Khối nhập mật khẩu khi tắt */
      .password-inputs-box {
         transition: opacity 0.25s ease;
      }
      .password-inputs-box.is-disabled {
         opacity: 0.55;
      }
      .password-inputs-box.is-disabled .form-control {
         background-color: #f8fafc !important;
         border-color: #e2e8f0 !important;
         cursor: not-allowed !important;
         color: #94a3b8 !important;
      }
      .password-inputs-box.is-disabled label {
         color: #64748b !important;
         cursor: not-allowed !important;
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
                  <div class="sidebar-widget profile-form-widget mb-40">
                     <h4 class="profile-widget-title">
                        <i class="far fa-user-edit text-muted me-1"></i> Thông tin cá nhân
                     </h4>

                      <form action="{{ route('frontend.profile.update') }}" method="POST">
                        @csrf
                        
                        <!-- Thông tin cá nhân: lưới 2x2 gọn gàng, khoảng cách chuẩn -->
                        <div class="row g-3 mb-3">
                           <div class="col-md-6">
                              <label class="form-label">Họ và tên <span class="text-danger">*</span></label>
                              <input type="text" name="name" class="form-control" value="{{ old('name', Auth::user()->name) }}" placeholder="Nhập họ và tên..." required>
                              @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                           </div>
                           <div class="col-md-6">
                              <label class="form-label">Email</label>
                              <input type="email" class="form-control bg-light" value="{{ Auth::user()->email }}" disabled>
                              <small class="text-muted"><i class="fas fa-lock me-1"></i> Email không thể thay đổi</small>
                           </div>
                           <div class="col-md-6">
                              <label class="form-label">Số điện thoại</label>
                              <input type="text" name="phone" class="form-control" value="{{ old('phone', Auth::user()->phone) }}" placeholder="Nhập số điện thoại...">
                              @error('phone') <small class="text-danger">{{ $message }}</small> @enderror
                           </div>
                           <div class="col-md-6">
                              <label class="form-label">Địa chỉ</label>
                              <input type="text" name="address" class="form-control" value="{{ old('address', Auth::user()->address) }}" placeholder="Nhập địa chỉ của bạn...">
                              @error('address') <small class="text-danger">{{ $message }}</small> @enderror
                           </div>
                        </div>

                        <!-- Đổi mật khẩu section -->
                        <div class="pt-20 border-top mt-20">
                           @php
                              $isChangePasswordActive = old('change_password') || (!empty($errors) && $errors->has('password'));
                           @endphp
                           <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-12">
                              <label class="custom-toggle-wrap mb-0" for="changePasswordToggle">
                                 <span class="custom-toggle-switch">
                                    <input type="checkbox" id="changePasswordToggle" name="change_password" value="1" {{ $isChangePasswordActive ? 'checked' : '' }}>
                                    <span class="custom-toggle-slider"></span>
                                 </span>
                                 <span class="custom-toggle-label">
                                    <i class="far fa-key me-1 text-muted"></i> Đổi mật khẩu
                                 </span>
                              </label>
                              <span id="toggleStatusBadge" class="badge" style="{{ $isChangePasswordActive ? 'background: rgba(3, 89, 78, 0.1); color: #03594e;' : 'background: #f1f5f9; color: #64748b;' }} font-size: 11.5px; font-weight: 600; padding: 4px 10px; border-radius: 20px;">
                                 {{ $isChangePasswordActive ? 'Đang bật' : 'Đang tắt' }}
                              </span>
                           </div>

                           <p id="toggleHelpText" class="text-muted mb-15" style="font-size: 12.5px;">
                              {{ $isChangePasswordActive ? 'Nhập mật khẩu mới ít nhất 6 ký tự để thay đổi mật khẩu tài khoản của bạn.' : 'Bật công tắc trên nếu bạn muốn cập nhật mật khẩu mới.' }}
                           </p>

                           <div id="passwordFieldsWrap" class="password-inputs-box {{ $isChangePasswordActive ? '' : 'is-disabled' }}">
                              <div class="row g-3">
                                 <div class="col-md-6">
                                    <label class="form-label">Mật khẩu mới <span class="text-danger required-star" style="{{ $isChangePasswordActive ? '' : 'display: none;' }}">*</span></label>
                                    <input type="password" name="password" id="inputNewPassword" class="form-control" minlength="6" placeholder="{{ $isChangePasswordActive ? 'Nhập mật khẩu mới (tối thiểu 6 ký tự)' : 'Bật công tắc để nhập mật khẩu' }}" autocomplete="new-password" {{ $isChangePasswordActive ? '' : 'disabled' }}>
                                    @error('password') <small class="text-danger">{{ $message }}</small> @enderror
                                 </div>
                                 <div class="col-md-6">
                                    <label class="form-label">Xác nhận mật khẩu mới <span class="text-danger required-star" style="{{ $isChangePasswordActive ? '' : 'display: none;' }}">*</span></label>
                                    <input type="password" name="password_confirmation" id="inputConfirmPassword" class="form-control" minlength="6" placeholder="{{ $isChangePasswordActive ? 'Nhập lại mật khẩu mới' : 'Bật công tắc để xác nhận mật khẩu' }}" autocomplete="new-password" {{ $isChangePasswordActive ? '' : 'disabled' }}>
                                 </div>
                              </div>
                           </div>
                        </div>

                        <div class="mt-25 text-end">
                           <button type="submit" class="it-btn-profile">
                              <i class="far fa-save me-1"></i> Lưu thay đổi
                           </button>
                        </div>
                     </form>
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
         $('#changePasswordToggle').on('change', function() {
            var isChecked = $(this).is(':checked');
            var $wrap = $('#passwordFieldsWrap');
            var $badge = $('#toggleStatusBadge');
            var $help = $('#toggleHelpText');
            var $inputs = $('#inputNewPassword, #inputConfirmPassword');
            var $stars = $('.required-star');

            if (isChecked) {
               $wrap.removeClass('is-disabled');
               $inputs.prop('disabled', false);
               $badge.css({'background': 'rgba(3, 89, 78, 0.1)', 'color': '#03594e'}).text('Đang bật');
               $help.text('Nhập mật khẩu mới ít nhất 6 ký tự để thay đổi mật khẩu tài khoản của bạn.');
               $stars.show();
               $('#inputNewPassword').attr('placeholder', 'Nhập mật khẩu mới (tối thiểu 6 ký tự)').focus();
               $('#inputConfirmPassword').attr('placeholder', 'Nhập lại mật khẩu mới');
            } else {
               $wrap.addClass('is-disabled');
               $inputs.prop('disabled', true).val('');
               $badge.css({'background': '#f1f5f9', 'color': '#64748b'}).text('Đang tắt');
               $help.text('Bật công tắc trên nếu bạn muốn cập nhật mật khẩu mới.');
               $stars.hide();
               $('#inputNewPassword').attr('placeholder', 'Bật công tắc để nhập mật khẩu');
               $('#inputConfirmPassword').attr('placeholder', 'Bật công tắc để xác nhận mật khẩu');
            }
         });
      });
   </script>
</body>
</html>
