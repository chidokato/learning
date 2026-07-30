@extends('backend.layouts.app')

@section('title', 'Dashboard')
@section('page_title', 'Dashboard')
@section('breadcrumb', 'Dashboard')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card bg-primary-subtle border-0 shadow-sm">
                <div class="card-body p-4">
                    <span class="badge bg-success mb-3">COURSE MANAGEMENT</span>
                    <h2 class="mb-3">Bang dieu khien quan tri Course</h2>
                    <p class="text-muted mb-4">Quan ly nhanh cac khoa hoc (Courses), bai viet (News) va tai khoan nguoi dung tu admin.</p>
                    <div class="d-flex gap-2 flex-wrap">
                        <a href="{{ route('frontend.home') }}" class="btn btn-light">Xem trang chu</a>
                        <a href="{{ route('backend.courses.index') }}" class="btn btn-primary">Quan ly Courses</a>
                        <a href="{{ route('backend.users.index') }}" class="btn btn-outline-primary">Quan ly user</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-3 col-md-6">
            <div class="card card-animate">
                <div class="card-body">
                    <p class="text-uppercase fw-medium text-muted mb-3">Courses</p>
                    <h2 class="mb-2">{{ $stats['courses'] ?? $stats['properties'] }}</h2>
                    <p class="text-muted mb-0">Tong so khoa hoc dang quan ly</p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card card-animate">
                <div class="card-body">
                    <p class="text-uppercase fw-medium text-muted mb-3">Instructors</p>
                    <h2 class="mb-2">{{ $stats['agents'] }}</h2>
                    <p class="text-muted mb-0">Nhan su / giang vien hoat dong</p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card card-animate">
                <div class="card-body">
                    <p class="text-uppercase fw-medium text-muted mb-3">Hoc vien</p>
                    <h2 class="mb-2">{{ $stats['customers'] }}</h2>
                    <p class="text-muted mb-0">Lien he tu hoc viên quan tam</p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card card-animate">
                <div class="card-body">
                    <p class="text-uppercase fw-medium text-muted mb-3">Cho duyet</p>
                    <h2 class="mb-2">{{ $stats['pending_posts'] }}</h2>
                    <p class="text-muted mb-0">Khoa hoc / tin tuc can kiem tra</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Hoat dong gan day</h4>
                </div>
                <div class="card-body">
                    <div class="list-group list-group-flush">
                        @foreach ($activities as $activity)
                            <div class="list-group-item px-0">
                                <h5 class="mb-1">{{ $activity['title'] }}</h5>
                                <p class="text-muted mb-0">{{ $activity['detail'] }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Thao tac nhanh</h4>
                </div>
                <div class="card-body d-grid gap-2">
                    <a href="{{ route('backend.courses.create') }}" class="btn btn-primary">Add New Course</a>
                    <a href="{{ route('backend.courses.index') }}" class="btn btn-soft-primary">Course List</a>
                    <a href="{{ route('backend.news.create') }}" class="btn btn-soft-success">Them News moi</a>
                    <a href="{{ route('backend.customer-inquiries.index') }}" class="btn btn-soft-info">Khach hang gui form</a>
                </div>
            </div>
        </div>
    </div>
@endsection
