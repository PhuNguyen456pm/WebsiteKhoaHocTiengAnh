@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1 class="text-center mb-4">Giảng viên Dashboard</h1>
    <div class="row">
        <div class="col-md-4">
            <div class="card text-white bg-info mb-3">
                <div class="card-header">Tạo khóa học</div>
                <div class="card-body">
                    <h5 class="card-title">Khóa học mới</h5>
                    <p class="card-text">Tạo và quản lý khóa học của bạn.</p>
                    <a href="#" class="btn btn-light">Xem chi tiết</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-secondary mb-3">
                <div class="card-header">Quản lý tài liệu</div>
                <div class="card-body">
                    <h5 class="card-title">Tài liệu học</h5>
                    <p class="card-text">Tải lên và chỉnh sửa tài liệu.</p>
                    <a href="#" class="btn btn-light">Xem chi tiết</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-dark mb-3">
                <div class="card-header">Theo dõi học viên</div>
                <div class="card-body">
                    <h5 class="card-title">Kết quả học tập</h5>
                    <p class="card-text">Xem điểm và hỗ trợ học viên.</p>
                    <a href="#" class="btn btn-light">Xem chi tiết</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection