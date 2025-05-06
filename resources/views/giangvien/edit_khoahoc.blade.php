@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2 class="text-center mb-4">Chỉnh sửa khóa học</h2>

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
                    <form method="POST" action="{{ route('giangvien.updateKhoahoc', $khoahoc->id_khoahoc) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="ten_khoahoc" class="form-label">Tên khóa học</label>
                            <input type="text" class="form-control" id="ten_khoahoc" name="ten_khoahoc" value="{{ $khoahoc->ten_khoahoc }}" required>
                            @error('ten_khoahoc')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="id_danhmuc" class="form-label">Danh mục</label>
                            <select class="form-control" id="id_danhmuc" name="id_danhmuc" required>
                                @forelse($danhmucs as $danhmuc)
                                    <option value="{{ $danhmuc->id_danhmuc }}" {{ $khoahoc->id_danhmuc == $danhmuc->id_danhmuc ? 'selected' : '' }}>{{ $danhmuc->ten_danhmuc }}</option>
                                @empty
                                    <option value="" disabled>Chưa có danh mục nào</option>
                                @endforelse
                            </select>
                            @error('id_danhmuc')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="mota_khoahoc" class="form-label">Mô tả</label>
                            <textarea class="form-control" id="mota_khoahoc" name="mota_khoahoc" rows="3" required>{{ $khoahoc->mota_khoahoc }}</textarea>
                            @error('mota_khoahoc')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="hinhanh_khoahoc" class="form-label">Hình ảnh khóa học</label>
                            <input type="file" class="form-control" id="hinhanh_khoahoc" name="hinhanh_khoahoc" accept="image/*">
                            @if($khoahoc->hinhanh_khoahoc)
                                <div class="mt-2">
                                    <p>Hình ảnh hiện tại:</p>
                                    <img src="{{ asset('storage/' . $khoahoc->hinhanh_khoahoc) }}" alt="Hình ảnh khóa học" style="max-width: 200px;">
                                </div>
                            @endif
                            @error('hinhanh_khoahoc')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="gia_khoahoc" class="form-label">Giá khóa học</label>
                            <input type="number" class="form-control" id="gia_khoahoc" name="gia_khoahoc" step="0.01" min="0" value="{{ $khoahoc->gia_khoahoc }}" required>
                            @error('gia_khoahoc')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <a href="{{ route('giangvien.dashboard') }}" class="btn btn-primary text-white">Quay lại</a>
                            <button type="submit" class="btn btn-primary ms-2 text-white">Cập nhật</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Thêm CKEditor -->
<script src="https://cdn.ckeditor.com/ckeditor5/41.0.0/classic/ckeditor.js"></script>
<script>
    ClassicEditor
        .create(document.querySelector('#mota_khoahoc'))
        .catch(error => {
            console.error(error);
        });
</script>
@endsection