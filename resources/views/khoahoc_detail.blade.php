@extends('layouts.app')

@section('content')
<div class="container my-5">
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

    <div class="card shadow-sm">
        <div class="row g-0">
            <div class="col-md-4">
                @if($khoahoc->hinhanh_khoahoc)
                    <img src="{{ asset('storage/' . $khoahoc->hinhanh_khoahoc) }}" class="card-img-top" alt="{{ $khoahoc->ten_khoahoc }}" style="height: 100%; object-fit: cover;">
                @else
                    <img src="https://via.placeholder.com/300x400" class="card-img-top" alt="Placeholder">
                @endif
            </div>
            <div class="col-md-8">
                <div class="card-body">
                    <h2 class="card-title">{{ $khoahoc->ten_khoahoc }}</h2>
                    <p class="card-text"><strong>Danh mục:</strong> {{ $khoahoc->danhMuc ? $khoahoc->danhMuc->ten_danhmuc : 'Chưa có danh mục' }}</p>
                    <p class="card-text"><strong>Giảng viên:</strong> {{ $khoahoc->giangVien ? $khoahoc->giangVien->hoten_giangvien : 'Chưa có giảng viên' }}</p>
                    <p class="card-text"><strong>Giá:</strong> {{ number_format($khoahoc->gia_khoahoc, 0, ',', '.') }} VNĐ</p>
                    <div class="text-warning mb-3">★★★★☆ (123)</div>
                    <h4>Mô tả khóa học</h4>
                    <div class="card-text mb-4">{!! $khoahoc->mota_khoahoc !!}</div>
                    <h4>Danh sách bài học</h4>
                    <ul class="list-group mb-4">
                        @forelse($khoahoc->baiHocs as $baiHoc)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{ $baiHoc->tieude_baihoc }}
                                <span class="badge bg-primary rounded-pill">{{ $baiHoc->thu_tu }}</span>
                            </li>
                        @empty
                            <li class="list-group-item">Chưa có bài học nào.</li>
                        @endforelse
                    </ul>
                    <a href="{{ route('register.course', $khoahoc->id_khoahoc) }}" class="btn btn-success btn-lg">Đăng ký học ngay</a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.card-text { line-height: 1.6; }
.list-group-item { transition: background-color 0.3s; }
.list-group-item:hover { background-color: #f8f9fa; }
.btn-success { padding: 10px 20px; font-size: 1.1rem; }
</style>
@endsection