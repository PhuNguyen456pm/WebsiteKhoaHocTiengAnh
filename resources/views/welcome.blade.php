@extends('layouts.app')

@section('content')
<div class="container-fluid p-0">
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
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">Website Học Tiếng Anh</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="accountDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-person-circle"></i> 
                            @if(Session::has('hocvien_username'))
                                {{ Session::get('hocvien_username') }}
                            @else
                                Tài khoản
                            @endif
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="accountDropdown">
                            @if(Session::has('hocvien_id'))
                                <li><a class="dropdown-item" href="{{ route('hocvien.update') }}">Cập nhật thông tin tài khoản học viên</a></li>
                                <li><a class="dropdown-item" href="{{ route('hocvien.logout') }}">Đăng xuất</a></li>
                            @else
                                <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#loginModal">Đăng nhập</a></li>
                                <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#registerModal">Đăng ký</a></li>
                            @endif
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="bg-primary text-white text-center py-5">
        <h1>Chào mừng đến với Website Học Tiếng Anh</h1>
        <p>Học tiếng Anh dễ dàng, hiệu quả với các khóa học chất lượng cao!</p>
        <a href="#courses" class="btn btn-light btn-lg">Xem khóa học</a>
    </div>

    <!-- Courses Section -->
    <div class="container my-5" id="courses">
        <h2 class="text-center mb-4">Khóa học nổi bật</h2>
        <div class="row">
            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Tiếng Anh Giao Tiếp</h5>
                        <p class="card-text">Học cách giao tiếp tiếng Anh tự nhiên, lưu loát.</p>
                        <a href="#" class="btn btn-primary">Xem chi tiết</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Luyện Thi IELTS</h5>
                        <p class="card-text">Chuẩn bị kỹ lưỡng để đạt điểm cao trong kỳ thi IELTS.</p>
                        <a href="#" class="btn btn-primary">Xem chi tiết</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Tiếng Anh Trẻ Em</h5>
                        <p class="card-text">Khóa học vui nhộn, phù hợp cho trẻ từ 6-12 tuổi.</p>
                        <a href="#" class="btn btn-primary">Xem chi tiết</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Login Modal -->
    <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="loginModalLabel">Đăng nhập</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('hocvien.login') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="email_hocvien" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email_hocvien" name="email_hocvien" required>
                            @error('email_hocvien')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Mật khẩu</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                            @error('password')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">Đăng nhập</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Register Modal -->
    <div class="modal fade" id="registerModal" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="registerModalLabel">Đăng ký</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('hocvien.register') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="username_hocvien" class="form-label">Tên đăng nhập</label>
                            <input type="text" class="form-control" id="username_hocvien" name="username_hocvien" required>
                            @error('username_hocvien')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="hoten_hocvien" class="form-label">Họ tên</label>
                            <input type="text" class="form-control" id="hoten_hocvien" name="hoten_hocvien" required>
                            @error('hoten_hocvien')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="email_hocvien" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email_hocvien" name="email_hocvien" required>
                            @error('email_hocvien')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="sodienthoai_hocvien" class="form-label">Số điện thoại</label>
                            <input type="text" class="form-control" id="sodienthoai_hocvien" name="sodienthoai_hocvien" required>
                            @error('sodienthoai_hocvien')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Mật khẩu</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                            @error('password')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Xác nhận mật khẩu</label>
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                            @error('password_confirmation')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-success">Đăng ký</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection