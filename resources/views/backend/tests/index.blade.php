@extends('backend.layouts.app')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Quản lý Bài Kiểm Tra</h4>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="row">
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Thêm bài test mới (Import Excel)</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('backend.tests.import') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Tên bài test</label>
                            <input type="text" name="title" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Chọn Khóa học (Không bắt buộc)</label>
                            <select name="post_id" class="form-select">
                                <option value="">-- Bài kiểm tra chung (Không thuộc khóa nào) --</option>
                                @foreach($courses as $course)
                                    <option value="{{ $course->id }}">{{ $course->title }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Điểm qua môn (số câu đúng tối thiểu)</label>
                            <input type="number" name="pass_score" class="form-control" value="8" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">File Excel</label>
                            <input type="file" name="file" class="form-control" accept=".xlsx,.xls,.csv" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Import & Lưu</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Danh sách bài kiểm tra</h5>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Tên bài test</th>
                                <th>Thuộc khóa học</th>
                                <th>Số câu hỏi</th>
                                <th>Điểm qua</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($tests as $test)
                            <tr>
                                <td>{{ $test->id }}</td>
                                <td>{{ $test->title }}</td>
                                <td>
                                    @if($test->post_id)
                                        <span class="badge bg-info">Khóa học (ID: {{ $test->post_id }})</span>
                                    @else
                                        <span class="badge bg-secondary">Bài test chung</span>
                                    @endif
                                </td>
                                <td>{{ $test->questions->count() }}</td>
                                <td>{{ $test->pass_score }}</td>
                                <td>
                                    <form action="{{ route('backend.tests.destroy', $test->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa?');">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger btn-sm">Xóa</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $tests->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
