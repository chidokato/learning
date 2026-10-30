@extends('backend.layouts.app')

@section('title', 'Phòng ban')
@section('page_title', 'Phòng ban')
@section('breadcrumb', 'Phòng ban')

@section('content')
    <div class="card">
        <div class="card-header d-flex align-items-center justify-content-between">
            <div>
                <h4 class="card-title mb-1">Cơ cấu tổ chức & Phòng ban</h4>
                <p class="text-muted mb-0">Quản lý sơ đồ phòng ban theo cấu trúc hình cây (đệ quy đa cấp).</p>
            </div>
            <a href="{{ route('backend.departments.create') }}" class="btn btn-primary">
                <i class="ri-add-line align-bottom me-1"></i> Thêm phòng ban
            </a>
        </div>
        <div class="card-body">
            @if ($departmentTree->isEmpty())
                <div class="text-center text-muted py-5">
                    <div class="fs-1 text-primary mb-3">
                        <i class="ri-building-line"></i>
                    </div>
                    <h5>Chưa có phòng ban nào</h5>
                    <p class="text-muted">Bắt đầu thiết lập cơ cấu tổ chức bằng cách thêm phòng ban đầu tiên.</p>
                    <a href="{{ route('backend.departments.create') }}" class="btn btn-sm btn-primary">
                        <i class="ri-add-line align-bottom me-1"></i> Thêm phòng ban ngay
                    </a>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th style="min-width: 280px;">Tên phòng ban</th>
                                <th style="width: 140px;">Mã phòng ban</th>
                                <th style="width: 150px;">Nhân sự</th>
                                <th style="width: 110px;">Thứ tự</th>
                                <th style="width: 130px;">Trạng thái</th>
                                <th class="text-end" style="width: 220px;">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($departmentTree as $dept)
                                @include('backend.departments._row', ['department' => $dept, 'level' => 0])
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
@endsection
