@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2 class="text-center mb-4">Chỉnh sửa tài liệu - {{ $baihoc->ten_baihoc }}</h2>

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
                    <form method="POST" action="{{ route('giangvien.updateTaiLieu', [$khoahoc->id_khoahoc, $baihoc->id_baihoc, $tailieu->id_tailieu]) }}" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="ten_tailieu" class="form-label">Tên tài liệu</label>
                            <input type="text" class="form-control" id="ten_tailieu" name="ten_tailieu" value="{{ $tailieu->ten_tailieu }}" required>
                            @error('ten_tailieu')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">File hiện tại</label>
                            <p>
                                @if($tailieu->file_tailieu)
                                    <a href="{{ asset('storage/' . $tailieu->file_tailieu) }}" target="_blank">Tải xuống file hiện tại</a>
                                @else
                                    Không có file
                                @endif
                            </p>
                        </div>
                        <div class="mb-3">
                            <label for="file_tailieu" class="form-label">Thay file mới (PDF, MP4, MP3, WAV - tối đa 10MB)</label>
                            <input type="file" class="form-control" id="file_tailieu" name="file_tailieu" accept=".pdf,.mp4,.mp3,.wav">
                            @error('file_tailieu')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">Cập nhật</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <a href="{{ route('giangvien.manageTaiLieu', [$khoahoc->id_khoahoc, $baihoc->id_baihoc]) }}" class="btn btn-secondary mt-3">Quay lại</a>
</div>
@endsection