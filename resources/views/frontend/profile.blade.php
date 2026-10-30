@extends('frontend.layouts.profile')

@section('title', 'Thông Tin Cá Nhân')
@section('page_title', 'Thông tin cá nhân')

@section('breadcrumb')
   <li class="breadcrumb-item active">Thông tin cá nhân</li>
@endsection

@push('styles')
<style>
   /* Nhãn tiêu đề nhỏ gọn, rõ ràng */
   .profile-form-label {
      font-size: 13px;
      font-weight: 600;
      color: #374151;
      margin-bottom: 6px;
      display: inline-block;
      line-height: 1.3;
   }

   /* Input form thanh thoát */
   .profile-form-control {
      height: 42px;
      border-radius: 8px;
      border: 1px solid #d1d5db;
      padding: 8px 14px;
      font-size: 13.5px;
      color: #1f2937;
      background-color: #ffffff;
      transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
      box-shadow: 0 1px 2px rgba(0, 0, 0, 0.03);
      width: 100%;
   }
   .profile-form-control:focus {
      border-color: #03594e;
      box-shadow: 0 0 0 3px rgba(3, 89, 78, 0.12);
      outline: none;
   }
   .profile-form-control:disabled,
   .profile-form-control.bg-light {
      background-color: #f8fafc !important;
      border-color: #e2e8f0 !important;
      color: #64748b !important;
      cursor: not-allowed !important;
      box-shadow: none;
   }

   /* Nút gạt chuyển đổi đổi mật khẩu */
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

   /* Khối mật khẩu khi tắt */
   .password-inputs-box {
      transition: opacity 0.25s ease;
   }
   .password-inputs-box.is-disabled {
      opacity: 0.55;
   }
   .password-inputs-box.is-disabled .profile-form-control {
      background-color: #f8fafc !important;
      border-color: #e2e8f0 !important;
      cursor: not-allowed !important;
      color: #94a3b8 !important;
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
@endpush

@section('content')
<div class="profile-content-card">
   <form action="{{ route('frontend.profile.update') }}" method="POST">
      @csrf
      
      <!-- Thông tin cá nhân: lưới 2x2 gọn gàng -->
      <div class="row g-3 mb-4">
         <div class="col-md-6">
            <label class="profile-form-label">Họ và tên <span class="text-danger">*</span></label>
            <input type="text" name="name" class="profile-form-control" value="{{ old('name', Auth::user()->name) }}" placeholder="Nhập họ và tên..." required>
            @error('name') <small class="text-danger d-block mt-1">{{ $message }}</small> @enderror
         </div>
         <div class="col-md-6">
            <label class="profile-form-label">Email</label>
            <input type="email" class="profile-form-control bg-light" value="{{ Auth::user()->email }}" disabled>
            <small class="text-muted d-block mt-1"><i class="fas fa-lock me-1"></i> Email không thể thay đổi</small>
         </div>
         <div class="col-md-6">
            <label class="profile-form-label">Số điện thoại</label>
            <input type="text" name="phone" class="profile-form-control" value="{{ old('phone', Auth::user()->phone) }}" placeholder="Nhập số điện thoại...">
            @error('phone') <small class="text-danger d-block mt-1">{{ $message }}</small> @enderror
         </div>
         <div class="col-md-6">
            <label class="profile-form-label">Địa chỉ</label>
            <input type="text" name="address" class="profile-form-control" value="{{ old('address', Auth::user()->address) }}" placeholder="Nhập địa chỉ của bạn...">
            @error('address') <small class="text-danger d-block mt-1">{{ $message }}</small> @enderror
         </div>
      </div>

      <!-- Khu vực liên kết Google -->
      <div class="pt-20 border-top mt-20 mb-4">
         <div class="d-flex align-items-center justify-content-between mb-2">
            <label class="profile-form-label mb-0 d-flex align-items-center gap-2">
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
            $isChangePasswordActive = old('change_password') || (isset($errors) && $errors->has('password'));
         @endphp
         <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-2">
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

         <p id="toggleHelpText" class="text-muted mb-3" style="font-size: 12.5px;">
            {{ $isChangePasswordActive ? 'Nhập mật khẩu mới ít nhất 6 ký tự để thay đổi mật khẩu tài khoản của bạn.' : 'Bật công tắc trên nếu bạn muốn cập nhật mật khẩu mới.' }}
         </p>

         <div id="passwordFieldsWrap" class="password-inputs-box {{ $isChangePasswordActive ? '' : 'is-disabled' }}">
            <div class="row g-3">
               <div class="col-md-6">
                  <label class="profile-form-label">Mật khẩu mới <span class="text-danger required-star" style="{{ $isChangePasswordActive ? '' : 'display: none;' }}">*</span></label>
                  <input type="password" name="password" id="inputNewPassword" class="profile-form-control" minlength="6" placeholder="{{ $isChangePasswordActive ? 'Nhập mật khẩu mới (tối thiểu 6 ký tự)' : 'Bật công tắc để nhập mật khẩu' }}" autocomplete="new-password" {{ $isChangePasswordActive ? '' : 'disabled' }}>
                  @error('password') <small class="text-danger d-block mt-1">{{ $message }}</small> @enderror
               </div>
               <div class="col-md-6">
                  <label class="profile-form-label">Xác nhận mật khẩu mới <span class="text-danger required-star" style="{{ $isChangePasswordActive ? '' : 'display: none;' }}">*</span></label>
                  <input type="password" name="password_confirmation" id="inputConfirmPassword" class="profile-form-control" minlength="6" placeholder="{{ $isChangePasswordActive ? 'Nhập lại mật khẩu mới' : 'Bật công tắc để xác nhận mật khẩu' }}" autocomplete="new-password" {{ $isChangePasswordActive ? '' : 'disabled' }}>
               </div>
            </div>
         </div>
      </div>

      <div class="mt-4 pt-3 border-top text-end">
         <button type="submit" class="it-btn-profile">
            <i class="far fa-save me-1"></i> Lưu thay đổi
         </button>
      </div>
   </form>

   <form id="unlinkGoogleForm" action="{{ route('frontend.profile.unlink-google') }}" method="POST" class="d-none">
      @csrf
   </form>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
   function confirmUnlinkGoogle() {
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
@endpush
