@extends('layouts.app')

@section('content')
<div class="container my-5">
    <h2 class="mb-4">Đăng ký khóa học: {{ $khoahoc->ten_khoahoc }}</h2>

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow-sm p-4">
        <form method="POST" action="{{ route('submit.register.course', $khoahoc->id_khoahoc) }}">
            @csrf
            <div class="mb-3">
                <label for="hoten_hocvien" class="form-label">Họ tên</label>
                <input type="text" class="form-control" id="hoten_hocvien" name="hoten_hocvien" value="{{ $hocvien->hoten_hocvien }}" readonly>
            </div>
            <div class="mb-3">
                <label for="email_hocvien" class="form-label">Email</label>
                <input type="email" class="form-control" id="email_hocvien" name="email_hocvien" value="{{ $hocvien->email_hocvien }}" readonly>
            </div>
            <div class="mb-3">
                <label for="sodienthoai_hocvien" class="form-label">Số điện thoại</label>
                <input type="text" class="form-control" id="sodienthoai_hocvien" name="sodienthoai_hocvien" value="{{ $hocvien->sodienthoai_hocvien }}" readonly>
            </div>
            <div class="mb-3">
                <label for="address" class="form-label">Địa chỉ</label>
                <input type="text" class="form-control" id="address" name="address" required>
                @error('address')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="payment_method" class="form-label">Phương thức thanh toán</label>
                <select class="form-control" id="payment_method" name="payment_method" required>
                    <option value="">Chọn phương thức</option>
                    <option value="Bank Card">Thẻ ngân hàng</option>
                    <option value="Credit Card">Thẻ tín dụng</option>
                </select>
                @error('payment_method')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Tiếp tục</button>
            <a href="{{ route('khoahoc.show', $khoahoc->id_khoahoc) }}" class="btn btn-secondary">Hủy</a>
        </form>
    </div>
</div>
@endsection