@extends('layouts.app')

@section('content')
<div class="container-fluid p-0">
    <!-- Thông báo -->
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
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">Website Học Tiếng Anh</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-white" href="#" id="accountDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-person-circle"></i> 
                            @if(Session::has('hocvien_username'))
                                {{ Session::get('hocvien_username') }}
                            @else
                                Tài khoản
                            @endif
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="accountDropdown">
                            @if(Session::has('hocvien_id'))
                                <li><a class="dropdown-item" href="{{ route('hocvien.update') }}">Cập nhật thông tin</a></li>
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
    <div class="hero-section text-white text-center py-5" style="background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('https://images.unsplash.com/photo-1516321318423-f06f85e504b3'); background-size: cover; background-position: center;">
        <div class="container">
            <h1 class="display-4">Học Tiếng Anh Hiệu Quả</h1>
            <p class="lead">Khám phá các khóa học chất lượng cao, được thiết kế bởi các giảng viên hàng đầu!</p>
            <a href="#courses" class="btn btn-primary btn-lg mt-3">Khám phá ngay</a>
        </div>
    </div>

    <!-- Danh mục khóa học -->
    <div class="container my-5">
        <h2 class="text-center mb-4">Danh sách các môn học</h2>
        <div class="d-flex flex-wrap justify-content-center gap-3">
            @forelse($danhmucs as $danhmuc)
                <a href="{{ route('khoahoc.by.category', $danhmuc->id_danhmuc) }}" class="btn btn-outline-primary">{{ $danhmuc->ten_danhmuc }}</a>
            @empty
                <p class="text-center">Chưa có danh mục nào.</p>
            @endforelse
        </div>
    </div>

    <!-- Courses Section -->
    <div class="container my-5" id="courses">
        <h2 class="text-center mb-4">Combo đặc biệt</h2>
        <div class="row">
            @forelse($khoahocs as $khoahoc)
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-sm">
                        @if($khoahoc->hinhanh_khoahoc)
                            <img src="{{ asset('storage/' . $khoahoc->hinhanh_khoahoc) }}" class="card-img-top" alt="{{ $khoahoc->ten_khoahoc }}" style="height: 200px; object-fit: cover;">
                        @else
                            <img src="https://via.placeholder.com/300x200" class="card-img-top" alt="Placeholder">
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">{{ $khoahoc->ten_khoahoc }}</h5>
                            <p class="card-text text-muted">
                                {{ Str::limit($khoahoc->mota_khoahoc, 100) }}<br>
                                Giá: {{ number_format($khoahoc->gia_khoahoc, 0, ',', '.') }} VNĐ
                            </p>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="text-warning">★★★★☆ (123)</span>
                                <a href="{{ route('khoahoc.show', $khoahoc->id_khoahoc) }}" class="btn btn-primary">Xem chi tiết</a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center">
                    <p>Chưa có khóa học nào.</p>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-dark text-white text-center py-4">
        <div class="container">
            <p>&copy; 2025 Website Học Tiếng Anh. All Rights Reserved.</p>
            <p>
                <a href="#" class="text-white mx-2">Liên hệ</a> |
                <a href="#" class="text-white mx-2">Điều khoản sử dụng</a> |
                <a href="#" class="text-white mx-2">Chính sách bảo mật</a>
            </p>
        </div>
    </footer>

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

<style>
.hero-section {
    min-height: 400px;
    display: flex;
    align-items: center;
    justify-content: center;
}
.card:hover {
    transform: translateY(-5px);
    transition: transform 0.3s ease;
}
.card-img-top {
    border-bottom: 1px solid #e0e0e0;
}
.btn-outline-primary:hover {
    background-color: #007bff;
    color: white;
}
.card-body .text-warning {
    font-size: 0.9rem;
}
</style>
@endsection