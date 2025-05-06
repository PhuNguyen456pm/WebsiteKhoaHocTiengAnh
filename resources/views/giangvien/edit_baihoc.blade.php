@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2 class="text-center mb-4">Chỉnh sửa bài học - {{ $khoahoc->ten_khoahoc }}</h2>

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
                    <form method="POST" action="{{ route('giangvien.updateBaiHoc', [$khoahoc->id_khoahoc, $baihoc->id_baihoc]) }}">
                        @csrf
                        <div class="mb-3">
                            <label for="tieude_baihoc" class="form-label">Tiêu đề bài học</label>
                            <input type="text" class="form-control" id="tieude_baihoc" name="tieude_baihoc" value="{{ $baihoc->tieude_baihoc }}" required>
                            @error('tieude_baihoc')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="noidung_baihoc" class="form-label">Nội dung</label>
                            <textarea class="form-control" id="noidung_baihoc" name="noidung_baihoc" rows="3" required>{{ $baihoc->noidung_baihoc }}</textarea>
                            @error('noidung_baihoc')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="thu_tu" class="form-label">Thứ tự</label>
                            <input type="number" class="form-control" id="thu_tu" name="thu_tu" min="1" value="{{ $baihoc->thu_tu }}" required>
                            @error('thu_tu')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">Cập nhật</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <a href="{{ route('giangvien.manageBaiHoc', $khoahoc->id_khoahoc) }}" class="btn btn-secondary mt-3">Quay lại</a>
</div>

<!-- Thêm CKEditor -->
<script src="https://cdn.ckeditor.com/ckeditor5/41.0.0/classic/ckeditor.js"></script>
<script>
    ClassicEditor
        .create(document.querySelector('#noidung_baihoc'))
        .catch(error => {
            console.error(error);
        });
</script>
@endsection