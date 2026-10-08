@extends('backend.layouts.app')

@section('title', 'Sửa Slider')
@section('page_title', 'Sửa Slider')
@section('breadcrumb', 'Sửa Slider')

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('backend.sliders.update', $slider) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                @include('backend.sliders._form', ['slider' => $slider])
                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                    <a href="{{ route('backend.sliders.index') }}" class="btn btn-light">Hủy</a>
                </div>
            </form>
        </div>
    </div>
@endsection