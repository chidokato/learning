<!doctype html>
<html class="no-js" lang="vi">
<head>
   <meta charset="utf-8">
   <meta http-equiv="x-ua-compatible" content="ie=edge">
   <title>Trang cá nhân -- Indochine</title>
   <meta name="description" content="">
   <meta name="viewport" content="width=device-width, initial-scale=1">

   <link rel="shortcut icon" type="image/x-icon" href="{{ $siteSetting->favicon_url ?? asset('assets/img/favicon.png') }}">

   <!-- Google Fonts - Montserrat -->
   <link rel="preconnect" href="https://fonts.googleapis.com">
   <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
   <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

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
   <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}?v=1.0.1">   
   <link rel="stylesheet" href="{{ asset('assets/css/course-custom.css') }}?v=1.0.1">   
   <link rel="stylesheet" href="{{ asset('assets/css/header-custom.css') }}?v=1.0.1">   

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

      /* Khối liên kết tài khoản Google */
      .oauth-connect-box {
         background: #f8fafc;
         border: 1px solid #e2e8f0;
         border-radius: 12px;
         padding: 16px 20px;
         transition: all 0.2s ease;
      }
      .oauth-connect-box:hover {
         border-color: #cbd5e1;
      }
      .btn-google-action {
         display: inline-flex;
         align-items: center;
         gap: 8px;
         font-size: 13px;
         font-weight: 600;
         padding: 8px 16px;
         border-radius: 6px;
         transition: all 0.2s ease;
         text-decoration: none !important;
         cursor: pointer;
      }
      .btn-google-connect {
         background: #ffffff;
         color: #1f2937 !important;
         border: 1px solid #d1d5db;
         box-shadow: 0 1px 2px rgba(0,0,0,0.04);
      }
      .btn-google-connect:hover {
         background: #f3f4f6;
         border-color: #9ca3af;
         color: #111827 !important;
         box-shadow: 0 2px 4px rgba(0,0,0,0.08);
      }
      .btn-google-unlink {
         background: #ffffff;
         color: #dc2626 !important;
         border: 1px solid #fecaca;
      }
      .btn-google-unlink:hover {
         background: #fef2f2;
         border-color: #f87171;
         color: #b91c1c !important;
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

                        <!-- Khu vực liên kết Google -->
                        <div class="pt-20 border-top mt-20">
                           <div class="d-flex align-items-center justify-content-between mb-2">
                              <label class="form-label mb-0 d-flex align-items-center gap-2">
                                 <i class="fab fa-google text-danger"></i> Liên kết tài khoản Google
                              </label>
                           </div>
                           
                           <div class="oauth-connect-box d-flex align-items-center justify-content-between flex-wrap gap-3">
                              <div class="d-flex align-items-center gap-3">
                                 <div style="width: 44px; height: 44px; border-radius: 50%; background: #ffffff; border: 1px solid #e2e8f0; display: flex; align-items: center; justify-content: center; box-shadow: 0 1px 3px rgba(0,0,0,0.06); flex-shrink: 0;">
                                    <svg width="22" height="22" viewBox="0 0 48 48">
                                       <path fill="#EA4335" d="M24 9.5c3.54 0 6.71 1.22 9.21 3.6l6.85-6.85C35.9 2.38 30.47 0 24 0 14.62 0 6.51 5.38 2.56 13.22l7.98 6.19C12.43 13.72 17.74 9.5 24 9.5z"/>
                                       <path fill="#4285F4" d="M46.98 24.55c0-1.57-.15-3.09-.38-4.55H24v9.02h12.94c-.58 2.96-2.26 5.48-4.78 7.18l7.73 6c4.51-4.18 7.09-10.36 7.09-17.65z"/>
                                       <path fill="#FBBC05" d="M10.53 28.59c-.48-1.45-.76-2.99-.76-4.59s.27-3.14.76-4.59l-7.98-6.19C.92 16.46 0 20.12 0 24c0 3.88.92 7.54 2.56 10.79l7.97-6.2z"/>
                                       <path fill="#34A853" d="M24 48c6.48 0 11.93-2.13 15.89-5.81l-7.73-6c-2.15 1.45-4.92 2.3-8.16 2.3-6.26 0-11.57-4.22-13.47-9.91l-7.98 6.19C6.51 42.62 14.62 48 24 48z"/>
                                    </svg>
                                 </div>
                                 <div>
                                    <div class="d-flex align-items-center gap-2">
                                       <span style="font-size: 14px; font-weight: 600; color: #1e293b;">Google Account</span>
                                       @if(!empty(Auth::user()->google_id))
                                          <span class="badge" style="background: rgba(16, 185, 129, 0.12); color: #059669; font-size: 11px; font-weight: 600; padding: 3px 8px; border-radius: 20px;">
                                             <i class="fas fa-check-circle me-1"></i> Đã liên kết
                                          </span>
                                       @else
                                          <span class="badge" style="background: #f1f5f9; color: #64748b; font-size: 11px; font-weight: 600; padding: 3px 8px; border-radius: 20px;">
                                             <i class="far fa-circle me-1"></i> Chưa liên kết
                                          </span>
                                       @endif
                                    </div>
                                    <p class="text-muted mb-0" style="font-size: 12.5px; margin-top: 2px;">
                                       @if(!empty(Auth::user()->google_id))
                                          Tài khoản này đã được kết nối với Google. Bạn có thể sử dụng nút Đăng nhập bằng Google để vào hệ thống bất kỳ lúc nào.
                                       @else
                                          Liên kết tài khoản Google để có thể đăng nhập nhanh chóng chỉ với một cú nhấp chuột mà không cần gõ mật khẩu.
                                       @endif
                                    </p>
                                 </div>
                              </div>

                              <div>
                                 @if(!empty(Auth::user()->google_id))
                                    <button type="button" onclick="confirmUnlinkGoogle()" class="btn-google-action btn-google-unlink">
                                       <i class="far fa-unlink me-1"></i> Hủy liên kết
                                    </button>
                                 @else
                                    <a href="{{ route('auth.google') }}" class="btn-google-action btn-google-connect">
                                       <i class="fab fa-google text-danger me-1"></i> Liên kết Google ngay
                                    </a>
                                 @endif
                              </div>
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

                     <form id="unlinkGoogleForm" action="{{ route('frontend.profile.unlink-google') }}" method="POST" class="d-none">
                        @csrf
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
      function confirmUnlinkGoogle() {
         const showCenterModal = () => {
            Swal.fire({
               title: 'Hủy liên kết Google?',
               text: 'Sau khi hủy, bạn sẽ đăng nhập bằng email và mật khẩu bình thường.',
               icon: 'warning',
               showCancelButton: true,
               confirmButtonColor: '#dc2626',
               cancelButtonColor: '#64748b',
               confirmButtonText: '<i class="far fa-unlink me-1"></i> Đồng ý hủy',
               cancelButtonText: 'Không, giữ lại',
               reverseButtons: true,
               focusCancel: true
            }).then((result) => {
               if (result.isConfirmed) {
                  document.getElementById('unlinkGoogleForm').submit();
               }
            });
         };

         if (typeof Swal !== 'undefined') {
            showCenterModal();
         } else {
            const script = document.createElement('script');
            script.src = 'https://cdn.jsdelivr.net/npm/sweetalert2@11';
            script.onload = showCenterModal;
            script.onerror = () => {
               if (confirm('Bạn có chắc chắn muốn hủy liên kết với tài khoản Google này? Sau khi hủy, bạn sẽ đăng nhập bằng email và mật khẩu bình thường.')) {
                  document.getElementById('unlinkGoogleForm').submit();
               }
            };
            document.head.appendChild(script);
         }
      }
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
