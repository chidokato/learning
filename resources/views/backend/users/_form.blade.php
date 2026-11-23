@csrf

@php
    $avatarImage = old('existing_avatar', $user->avatar ?? '');
    $selectedCode = trim((string) old('employee_code', ($user->employee_code ?? '') ?: ($user->username ?? '')));
    $selectedPerm = (int) old('permission', $user->permission ?? 5);
@endphp

<div class="row">
    <div class="col-xl-9">
        <div class="card border">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="mb-3">
                            <label for="name" class="form-label">Tên</label>
                            <input
                                type="text"
                                class="form-control @error('name') is-invalid @enderror"
                                id="name"
                                name="name"
                                value="{{ old('name', $user->name ?? '') }}"
                                required
                            >
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="mb-3">
                            <label for="permission" class="form-label">Quyền (Permission)</label>
                            <select class="form-select @error('permission') is-invalid @enderror" id="permission" name="permission">
                                <option value="1" {{ $selectedPerm === 1 ? 'selected' : '' }}>Quản trị viên cấp cao (Super Admin)</option>
                                <option value="2" {{ $selectedPerm === 2 ? 'selected' : '' }}>Quản trị viên (Admin)</option>
                                <option value="3" {{ $selectedPerm === 3 ? 'selected' : '' }}>Quản lý (Moderator)</option>
                                <option value="4" {{ $selectedPerm === 4 ? 'selected' : '' }}>Giảng viên (Instructor)</option>
                                <option value="5" {{ $selectedPerm === 5 ? 'selected' : '' }}>Người dùng / Học viên (Student)</option>
                                <option value="6" {{ $selectedPerm === 6 ? 'selected' : '' }}>Khách (Guest)</option>
                            </select>
                            @error('permission')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-12 mt-3 mb-2">
                        <hr>
                        <h5 class="mb-0 text-primary">Cấu hình đăng nhập</h5>
                        <p class="text-muted small">Có thể dùng 1 trong 3 thông tin dưới đây để đăng nhập</p>
                    </div>

                    <div class="col-lg-4">
                        <div class="mb-3">
                            <label for="employee_code" class="form-label">Mã nhân viên (Liên kết nhân sự)</label>
                            <select class="form-select employee-select @error('employee_code') is-invalid @enderror" id="employee_code" name="employee_code">
                                <option value="">-- Chọn nhân viên --</option>
                                @php
                                    $foundSelected = false;
                                @endphp
                                @if(isset($employees))
                                    @foreach($employees as $employee)
                                        @php
                                            $empCode = trim((string) ($employee->employee_code ?? ''));
                                            if ($empCode === '') continue;
                                            $isSelected = ($selectedCode !== '' && (string) $selectedCode === $empCode);
                                            if ($isSelected) $foundSelected = true;
                                        @endphp
                                        <option
                                            value="{{ $empCode }}"
                                            data-name="{{ $employee->name ?? '' }}"
                                            data-email="{{ $employee->email ?? '' }}"
                                            data-phone="{{ $employee->phone ?? '' }}"
                                            {{ $isSelected ? 'selected' : '' }}
                                        >
                                            {{ $empCode }} - {{ $employee->name }}
                                        </option>
                                    @endforeach
                                @endif
                                @if($selectedCode !== '' && !$foundSelected)
                                    <option value="{{ $selectedCode }}" selected>{{ $selectedCode }}</option>
                                @endif
                            </select>
                            @error('employee_code')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input
                                type="email"
                                class="form-control @error('email') is-invalid @enderror"
                                id="email"
                                name="email"
                                value="{{ old('email', $user->email ?? '') }}"
                                required
                            >
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="mb-3">
                            <label for="phone" class="form-label">Số điện thoại</label>
                            <input
                                type="text"
                                class="form-control @error('phone') is-invalid @enderror"
                                id="phone"
                                name="phone"
                                value="{{ old('phone', $user->phone ?? '') }}"
                            >
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    @if(isset($user))
                        <div class="col-12 mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" role="switch" id="toggle-password-change">
                                <label class="form-check-label" for="toggle-password-change">Thay đổi mật khẩu</label>
                            </div>
                        </div>
                    @endif

                    <div class="col-lg-6 password-fields">
                        <div class="mb-0">
                            <label for="password" class="form-label">Mật khẩu {{ isset($user) ? '(để trống nếu không đổi)' : '' }}</label>
                            <input
                                type="password"
                                class="form-control @error('password') is-invalid @enderror"
                                id="password"
                                name="password"
                                autocomplete="new-password"
                                {{ isset($user) ? 'disabled' : '' }}
                            >
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-lg-6 password-fields">
                        <div class="mb-0">
                            <label for="password_confirmation" class="form-label">Nhập lại mật khẩu</label>
                            <input
                                type="password"
                                class="form-control"
                                id="password_confirmation"
                                name="password_confirmation"
                                autocomplete="new-password"
                                {{ isset($user) ? 'disabled' : '' }}
                            >
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3">
        <div class="card border mb-3">
            <div class="card-header">
                <h5 class="card-title mb-0">Avatar</h5>
            </div>
            <div class="card-body">
                <input type="hidden" name="remove_avatar" id="remove_avatar" value="0">
                <input type="hidden" name="existing_avatar" value="{{ $avatarImage }}">
                <input type="file" id="avatar_file" name="avatar_file" class="d-none" accept="image/*">
                <div class="border rounded p-3">
                    <div class="d-flex flex-column gap-2">
                        <button type="button" class="border rounded bg-light d-flex align-items-center justify-content-center overflow-hidden p-0 image-upload-trigger" data-input="avatar_file" style="height: 220px;">
                            @if ($avatarImage)
                                <img src="{{ \Illuminate\Support\Str::startsWith($avatarImage, ['http://', 'https://']) ? $avatarImage : asset($avatarImage) }}" alt="Avatar" class="w-100 h-100 object-fit-contain">
                            @else
                                <div class="text-center text-muted">
                                    <div class="display-6 mb-2"><i class="ri-image-line"></i></div>
                                    <div>No image</div>
                                </div>
                            @endif
                        </button>
                        <button type="button" class="btn btn-soft-danger btn-sm image-remove-trigger {{ $avatarImage ? '' : 'd-none' }}" data-input="avatar_file" data-remove="remove_avatar">Bỏ ảnh</button>
                    </div>
                    @error('avatar_file')
                        <div class="text-danger small mt-2">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var togglePasswordChange = document.getElementById('toggle-password-change');
        if (togglePasswordChange) {
            togglePasswordChange.addEventListener('change', function() {
                var passwordInput = document.getElementById('password');
                var passwordConfirmInput = document.getElementById('password_confirmation');

                if (this.checked) {
                    passwordInput.removeAttribute('disabled');
                    passwordConfirmInput.removeAttribute('disabled');
                    passwordInput.focus();
                } else {
                    passwordInput.setAttribute('disabled', 'disabled');
                    passwordConfirmInput.setAttribute('disabled', 'disabled');
                    passwordInput.value = '';
                    passwordConfirmInput.value = '';
                }
            });
        }

        document.querySelectorAll('.image-upload-trigger').forEach(function (button) {
            button.addEventListener('click', function () {
                var inputId = button.getAttribute('data-input');
                var input = document.getElementById(inputId);

                if (input) {
                    input.click();
                }
            });
        });

        document.querySelectorAll('input[type="file"]').forEach(function (input) {
            input.addEventListener('change', function (event) {
                var file = event.target.files[0];
                var trigger = document.querySelector('.image-upload-trigger[data-input="' + input.id + '"]');
                var removeButton = document.querySelector('.image-remove-trigger[data-input="' + input.id + '"]');
                var removeField = document.getElementById('remove_avatar');

                if (!file || !trigger) {
                    return;
                }

                if (removeField) {
                    removeField.value = '0';
                }

                var reader = new FileReader();
                reader.onload = function (e) {
                    trigger.innerHTML = '<img src="' + e.target.result + '" class="w-100 h-100 object-fit-contain" alt="preview">';
                    if (removeButton) {
                        removeButton.classList.remove('d-none');
                    }
                };
                reader.readAsDataURL(file);
            });
        });

        document.querySelectorAll('.image-remove-trigger').forEach(function (button) {
            button.addEventListener('click', function () {
                var inputId = button.getAttribute('data-input');
                var removeFieldId = button.getAttribute('data-remove');
                var input = document.getElementById(inputId);
                var removeField = document.getElementById(removeFieldId);
                var trigger = document.querySelector('.image-upload-trigger[data-input="' + inputId + '"]');

                if (input) {
                    input.value = '';
                }

                if (removeField) {
                    removeField.value = '1';
                }

                if (trigger) {
                    trigger.innerHTML = '<div class="text-center text-muted"><div class="display-6 mb-2"><i class="ri-image-line"></i></div><div>No image</div></div>';
                }

                button.classList.add('d-none');
            });
        });
    });
</script>

@once
    @push('styles')
        <link href="{{ asset('admin-assets/libs/select2/select2.min.css') }}" rel="stylesheet" type="text/css">
        <style>
            .select2-container { width: 100% !important; }
            .select2-container .select2-selection--single {
                height: 38px;
                border: 1px solid #ced4da;
                border-radius: .25rem;
            }
            .select2-container--default .select2-selection--single .select2-selection__rendered { line-height: 36px; }
            .select2-container--default .select2-selection--single .select2-selection__arrow { height: 36px; }
        </style>
    @endpush

    @push('scripts')
        <script src="{{ asset('assets/js/jquery.js') }}"></script>
        <script src="{{ asset('admin-assets/libs/select2/select2.min.js') }}"></script>
        <script>
            $(function () {
                var $empSelect = $('#employee_code');
                $empSelect.select2({
                    placeholder: '-- Chọn nhân viên --',
                    allowClear: true,
                    width: '100%'
                });

                // Khi chọn nhân viên từ DB chung, nếu Tên / Email / SĐT đang trống thì tự động điền
                $empSelect.on('change', function () {
                    var $opt = $(this).find('option:selected');
                    if (!$opt.val()) return;

                    var empName = $opt.data('name') || '';
                    var empEmail = $opt.data('email') || '';
                    var empPhone = $opt.data('phone') || '';

                    var $nameInput = $('#name');
                    var $emailInput = $('#email');
                    var $phoneInput = $('#phone');

                    if ($nameInput.length && !$nameInput.val().trim() && empName) {
                        $nameInput.val(empName);
                    }
                    if ($emailInput.length && !$emailInput.val().trim() && empEmail) {
                        $emailInput.val(empEmail);
                    }
                    if ($phoneInput.length && !$phoneInput.val().trim() && empPhone) {
                        $phoneInput.val(empPhone);
                    }
                });
            });
        </script>
    @endpush
@endonce
