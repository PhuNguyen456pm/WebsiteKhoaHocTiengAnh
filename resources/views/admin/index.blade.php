@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1 class="text-center mb-4">Admin Dashboard</h1>
    <div class="row">
        <div class="col-md-4">
            <div class="card text-white bg-primary mb-3">
                <div class="card-header">Quản lý tài khoản</div>
                <div class="card-body">
                    <h5 class="card-title">Học viên & Giảng viên</h5>
                    <p class="card-text">Xem và chỉnh sửa thông tin tài khoản.</p>
                    <a href="#" class="btn btn-light">Xem chi tiết</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-success mb-3">
                <div class="card-header">Quản lý danh mục</div>
                <div class="card-body">
                    <h5 class="card-title">Khóa học</h5>
                    <p class="card-text">Thêm, sửa, xóa danh mục khóa học.</p>
                    <a href="#" class="btn btn-light">Xem chi tiết</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-warning mb-3">
                <div class="card-header">Quản lý giao dịch</div>
                <div class="card-body">
                    <h5 class="card-title">Thanh toán</h5>
                    <p class="card-text">Xem thống kê giao dịch học viên.</p>
                    <a href="#" class="btn btn-light">Xem chi tiết</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection