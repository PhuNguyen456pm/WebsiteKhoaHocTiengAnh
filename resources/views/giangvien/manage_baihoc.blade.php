@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2 class="text-center mb-4">Quản lý bài học - {{ $khoahoc->ten_khoahoc }}</h2>

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
        <div class="col-md-10">
            <div class="card">
                <div class="card-body">
                    <div class="mb-3">
                        <a href="{{ route('giangvien.dashboard') }}" class="btn btn-primary text-white">Quay lại</a>
                        <button class="btn btn-primary text-white ms-2" data-bs-toggle="modal" data-bs-target="#addBaiHocModal">Thêm bài học</button>
                    </div>
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Tiêu đề bài học</th>
                                <th>Nội dung bài học</th>
                                <th>Thứ tự</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($baihocs as $index => $baihoc)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $baihoc->tieude_baihoc }}</td>
                                <td>{!! $baihoc->noidung_baihoc !!}</td>
                                <td>{{ $baihoc->thu_tu }}</td>
                                <td>
                                    <a href="{{ route('giangvien.manageTaiLieu', [$khoahoc->id_khoahoc, $baihoc->id_baihoc]) }}" class="btn btn-primary btn-sm me-1 text-white">Quản lý tài liệu</a>
                                    <a href="{{ route('giangvien.editBaiHoc', [$khoahoc->id_khoahoc, $baihoc->id_baihoc]) }}" class="btn btn-primary btn-sm me-1 text-white">Sửa</a>
                                    <a href="{{ route('giangvien.deleteBaiHoc', [$khoahoc->id_khoahoc, $baihoc->id_baihoc]) }}" class="btn btn-primary btn-sm text-white" onclick="return confirm('Bạn có chắc chắn muốn xóa bài học này?')">Xóa</a>
                                </td>
                            </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">Chưa có bài học nào.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Thêm bài học -->
    <div class="modal fade" id="addBaiHocModal" tabindex="-1" aria-labelledby="addBaiHocModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addBaiHocModalLabel">Thêm bài học mới</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addBaiHocForm" method="POST" action="{{ route('giangvien.createBaiHoc', $khoahoc->id_khoahoc) }}">
                        @csrf
                        <div class="mb-3">
                            <label for="tieude_baihoc" class="form-label">Tiêu đề bài học</label>
                            <input type="text" class="form-control" id="tieude_baihoc" name="tieude_baihoc" required>
                            @error('tieude_baihoc')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="noidung_baihoc" class="form-label">Nội dung bài học</label>
                            <textarea class="form-control" id="noidung_baihoc" name="noidung_baihoc" rows="3">{{ old('noidung_baihoc') }}</textarea>
                            @error('noidung_baihoc')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="thu_tu" class="form-label">Thứ tự</label>
                            <input type="number" class="form-control" id="thu_tu" name="thu_tu" min="1" required>
                            @error('thu_tu')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">Thêm</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Thêm CKEditor -->
<script src="https://cdn.ckeditor.com/ckeditor5/41.0.0/classic/ckeditor.js"></script>
<script>
    let editorInstance;

    document.addEventListener('DOMContentLoaded', function() {
        ClassicEditor
            .create(document.querySelector('#noidung_baihoc'), {
                // Cấu hình tùy chọn nếu cần
            })
            .then(editor => {
                editorInstance = editor; // Lưu instance của CKEditor
            })
            .catch(error => {
                console.error('Error initializing CKEditor:', error);
            });

        // Đảm bảo nội dung CKEditor được cập nhật vào textarea trước khi submit
        document.getElementById('addBaiHocForm').addEventListener('submit', function() {
            if (editorInstance) {
                const textarea = document.querySelector('#noidung_baihoc');
                textarea.value = editorInstance.getData();
            }
        });
    });
</script>
@endsection