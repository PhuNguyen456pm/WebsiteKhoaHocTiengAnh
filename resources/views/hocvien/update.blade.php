@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2 class="text-center mb-4">Cập nhật thông tin tài khoản học viên</h2>
    
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ route('hocvien.update.submit') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="username_hocvien" class="form-label">Tên đăng nhập</label>
                            <input type="text" class="form-control" id="username_hocvien" name="username_hocvien" value="{{ $hocvien->username_hocvien }}" required>
                            @error('username_hocvien')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="hoten_hocvien" class="form-label">Họ tên</label>
                            <input type="text" class="form-control" id="hoten_hocvien" name="hoten_hocvien" value="{{ $hocvien->hoten_hocvien }}" required>
                            @error('hoten_hocvien')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="email_hocvien" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email_hocvien" name="email_hocvien" value="{{ $hocvien->email_hocvien }}" required>
                            @error('email_hocvien')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="sodienthoai_hocvien" class="form-label">Số điện thoại</label>
                            <input type="text" class="form-control" id="sodienthoai_hocvien" name="sodienthoai_hocvien" value="{{ $hocvien->sodienthoai_hocvien }}" required>
                            @error('sodienthoai_hocvien')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Mật khẩu mới (để trống nếu không thay đổi)</label>
                            <input type="password" class="form-control" id="password" name="password">
                            @error('password')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Xác nhận mật khẩu mới</label>
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                            @error('password_confirmation')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('home') }}" class="btn btn-secondary">Quay lại</a>
                            <button type="submit" class="btn btn-primary">Cập nhật</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection