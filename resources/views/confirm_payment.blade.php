@extends('layouts.app')

@section('content')
<div class="container my-5">
    <h2 class="mb-4">Xác nhận thanh toán</h2>

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow-sm p-4">
        <h4>Thông tin học viên</h4>
        <p><strong>Họ tên:</strong> {{ $hocvien->hoten_hocvien }}</p>
        <p><strong>Email:</strong> {{ $hocvien->email_hocvien }}</p>
        <p><strong>Số điện thoại:</strong> {{ $hocvien->sodienthoai_hocvien }}</p>
        <p><strong>Địa chỉ:</strong> {{ $registrationData['address'] }}</p>
        <p><strong>Phương thức thanh toán:</strong> {{ $registrationData['payment_method'] }}</p>

        <h4 class="mt-4">Thông tin khóa học</h4>
        <p><strong>Tên khóa học:</strong> {{ $khoahoc->ten_khoahoc }}</p>
        <p><strong>Giá:</strong> {{ number_format($khoahoc->gia_khoahoc, 0, ',', '.') }} VNĐ</p>
        <p><strong>Danh mục:</strong> {{ $khoahoc->danhMuc ? $khoahoc->danhMuc->ten_danhmuc : 'Chưa có danh mục' }}</p>
        <p><strong>Giảng viên:</strong> {{ $khoahoc->giangVien ? $khoahoc->giangVien->hoten_giangvien : 'Chưa có giảng viên' }}</p>

        <form method="POST" action="{{ route('submit.payment', $khoahoc->id_khoahoc) }}">
            @csrf
            <button type="submit" class="btn btn-success mt-3">Xác nhận và thanh toán</button>
            <a href="{{ route('khoahoc.show', $khoahoc->id_khoahoc) }}" class="btn btn-secondary mt-3">Hủy</a>
        </form>
    </div>
</div>
@endsection