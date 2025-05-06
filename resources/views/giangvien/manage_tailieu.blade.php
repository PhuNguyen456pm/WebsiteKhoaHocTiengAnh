@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2 class="text-center mb-4">Quản lý tài liệu - {{ $baihoc->ten_baihoc }}</h2>

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

    <div class="card shadow-sm mb-4">
        <div class="card-header bg-light d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Danh sách tài liệu</h5>
            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addTaiLieuModal">Thêm tài liệu</button>
        </div>
        <div class="card-body">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Tên tài liệu</th>
                        <th>File</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tailieus as $index => $tailieu)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $tailieu->ten_tailieu }}</td>
                        <td>
                            @if($tailieu->file_tailieu)
                                <a href="{{ asset('storage/' . $tailieu->file_tailieu) }}" target="_blank">Tải xuống</a>
                            @else
                                Không có file
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('giangvien.editTaiLieu', [$khoahoc->id_khoahoc, $baihoc->id_baihoc, $tailieu->id_tailieu]) }}" class="btn btn-sm btn-outline-primary me-1">Sửa</a>
                            <a href="{{ route('giangvien.deleteTaiLieu', [$khoahoc->id_khoahoc, $baihoc->id_baihoc, $tailieu->id_tailieu]) }}" class="btn btn-sm btn-outline-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa tài liệu này?')">Xóa</a>
                        </td>
                    </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center">Chưa có tài liệu nào.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <a href="{{ route('giangvien.manageBaiHoc', $khoahoc->id_khoahoc) }}" class="btn btn-secondary">Quay lại</a>
</div>

<!-- Modal Thêm tài liệu -->
<div class="modal fade" id="addTaiLieuModal" tabindex="-1" aria-labelledby="addTaiLieuModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addTaiLieuModalLabel">Thêm tài liệu mới</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('giangvien.createTaiLieu', [$khoahoc->id_khoahoc, $baihoc->id_baihoc]) }}" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="ten_tailieu" class="form-label">Tên tài liệu</label>
                        <input type="text" class="form-control" id="ten_tailieu" name="ten_tailieu" required>
                        @error('ten_tailieu')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="file_tailieu" class="form-label">Chọn file (PDF, MP4, MP3, WAV)</label>
                        <input type="file" class="form-control" id="file_tailieu" name="file_tailieu" accept=".pdf,.mp4,.mp3,.wav" required>
                        @error('file_tailieu')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">Thêm</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection