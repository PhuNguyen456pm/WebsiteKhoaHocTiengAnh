@extends('layouts.app')

@section('content')
<div class="d-flex" id="wrapper">
    <!-- Sidebar -->
    <div class="bg-dark text-light border-right" id="sidebar-wrapper" style="width: 250px; min-height: 100vh;">
        <div class="sidebar-heading text-center py-4">
            <h5>Giảng viên Dashboard</h5>
        </div>
        <div class="list-group list-group-flush">
            <a href="{{ route('giangvien.dashboard') }}" class="list-group-item list-group-item-action bg-dark text-light active">Quản lý khóa học</a>
            <a href="{{ route('giangvien.showCreateBaiKiemTraForm') }}" class="list-group-item list-group-item-action bg-dark text-light">Tạo bài kiểm tra</a>
            <a href="{{ route('giangvien.monitorHocVien') }}" class="list-group-item list-group-item-action bg-dark text-light">Theo dõi học viên</a>
        </div>
    </div>

    <!-- Page Content -->
    <div id="page-content-wrapper" class="flex-grow-1">
        <!-- Header -->
        <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
            <div class="container-fluid">
                <button class="btn btn-outline-secondary" id="menu-toggle">
                    <i class="bi bi-list"></i>
                </button>
                <div class="ms-auto">
                    @if(Session::has('giangvien_id'))
                        <div class="dropdown">
                            <button class="btn btn-secondary dropdown-toggle" type="button" id="giangvienDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                {{ Session::get('giangvien_name') }}
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="giangvienDropdown">
                                <li><a class="dropdown-item" href="{{ route('giangvien.logout') }}">Đăng xuất</a></li>
                            </ul>
                        </div>
                    @endif
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <div class="container-fluid p-4">
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

            <!-- Quản lý khóa học (Mặc định) -->
            <h2 class="mb-4">Quản lý khóa học</h2>
            <div class="card shadow-sm">
                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Danh sách khóa học</h5>
                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addKhoahocModal">Thêm khóa học</button>
                </div>
                <div class="card-body">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Tên khóa học</th>
                                <th>Danh mục</th>
                                <th>Mô tả</th>
                                <th>Hình ảnh</th>
                                <th>Giá (VNĐ)</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($khoahocs as $index => $khoahoc)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $khoahoc->ten_khoahoc }}</td>
                                <td>{{ $khoahoc->danhMuc ? $khoahoc->danhMuc->ten_danhmuc : 'Không có danh mục' }}</td>
                                <td>{!! $khoahoc->mota_khoahoc !!}</td>
                                <td>
                                    @if($khoahoc->hinhanh_khoahoc)
                                        <img src="{{ asset('storage/' . $khoahoc->hinhanh_khoahoc) }}" alt="Hình ảnh khóa học" style="max-width: 100px; max-height: 100px;">
                                    @else
                                        Không có hình ảnh
                                    @endif
                                </td>
                                <td>{{ number_format($khoahoc->gia_khoahoc, 0, ',', '.') }}</td>
                                <td>
                                    <a href="{{ route('giangvien.manageBaiHoc', $khoahoc->id_khoahoc) }}" class="btn btn-primary btn-sm me-1 text-white">Quản lý bài học</a>
                                    <a href="{{ route('giangvien.editKhoahoc', $khoahoc->id_khoahoc) }}" class="btn btn-primary btn-sm me-1 text-white">Sửa</a>
                                    <a href="{{ route('giangvien.deleteKhoahoc', $khoahoc->id_khoahoc) }}" class="btn btn-primary btn-sm text-white" onclick="return confirm('Bạn có chắc chắn muốn xóa khóa học này?')">Xóa</a>
                                </td>
                            </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">Chưa có khóa học nào.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Thêm khóa học -->
<div class="modal fade" id="addKhoahocModal" tabindex="-1" aria-labelledby="addKhoahocModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addKhoahocModalLabel">Thêm khóa học mới</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addKhoahocForm" method="POST" action="{{ route('giangvien.createKhoahoc') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="ten_khoahoc" class="form-label">Tên khóa học</label>
                        <inputみる type="text" class="form-control" id="ten_khoahoc" name="ten_khoahoc" required>
                        @error('ten_khoahoc')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="id_danhmuc" class="form-label">Danh mục</label>
                        <select class="form-control" id="id_danhmuc" name="id_danhmuc" required>
                            @forelse($danhmucs as $danhmuc)
                                <option value="{{ $danhmuc->id_danhmuc }}">{{ $danhmuc->ten_danhmuc }}</option>
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
                        <textarea class="form-control" id="mota_khoahoc" name="mota_khoahoc" rows="3">{{ old('mota_khoahoc') }}</textarea>
                        <div id="mota_khoahoc_error" class="text-danger" style="display: none;">Mô tả không được để trống.</div>
                        @error('mota_khoahoc')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="hinhanh_khoahoc" class="form-label">Hình ảnh khóa học (tùy chọn)</label>
                        <input type="file" class="form-control" id="hinhanh_khoahoc" name="hinhanh_khoahoc" accept="image/*">
                        @error('hinhanh_khoahoc')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="gia_khoahoc" class="form-label">Giá khóa học</label>
                        <input type="number" class="form-control" id="gia_khoahoc" name="gia_khoahoc" step="0.01" min="0" required>
                        @error('gia_khoahoc')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">Thêm</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Thêm CKEditor -->
<script src="https://cdn.ckeditor.com/ckeditor5/41.0.0/classic/ckeditor.js"></script>
<script>
let editor;

ClassicEditor
    .create(document.querySelector('#mota_khoahoc'))
    .then(editorInstance => {
        editor = editorInstance;
    })
    .catch(error => {
        console.error(error);
    });

// Gán dữ liệu từ CKEditor vào textarea và validate trước khi submit
document.getElementById('addKhoahocForm').addEventListener('submit', function(e) {
    if (editor) {
        const textarea = document.querySelector('#mota_khoahoc');
        const motaError = document.getElementById('mota_khoahoc_error');
        const motaData = editor.getData().trim();

        // Gán dữ liệu từ CKEditor vào textarea
        textarea.value = motaData;

        // Kiểm tra nếu mô tả rỗng
        if (!motaData) {
            e.preventDefault(); // Ngăn submit form
            motaError.style.display = 'block'; // Hiển thị thông báo lỗi
        } else {
            motaError.style.display = 'none'; // Ẩn thông báo lỗi nếu có dữ liệu
        }
    }
});
</script>

<!-- Script để toggle sidebar -->
<script>
document.getElementById("menu-toggle").addEventListener("click", function() {
    document.getElementById("wrapper").classList.toggle("toggled");
});
</script>

<style>
#wrapper {
    transition: all 0.3s;
}

#wrapper.toggled #sidebar-wrapper {
    margin-left: -250px;
}

#sidebar-wrapper {
    position: fixed;
    top: 0;
    left: 0;
    z-index: 100;
    transition: all 0.3s;
}

#page-content-wrapper {
    width: 100%;
    padding-left: 250px;
    transition: all 0.3s;
}

#wrapper.toggled #page-content-wrapper {
    padding-left: 0;
}

.list-group-item-action:hover {
    background-color: #495057 !important;
}

.list-group-item.active {
    background-color: #6c757d !important;
    border-color: #6c757d !important;
}
</style>
@endsection