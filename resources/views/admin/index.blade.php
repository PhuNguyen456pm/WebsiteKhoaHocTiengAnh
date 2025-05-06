@extends('layouts.app')

@section('content')
<div class="d-flex" id="wrapper">
    <!-- Sidebar -->
    <div class="bg-dark text-light border-right" id="sidebar-wrapper" style="width: 250px; min-height: 100vh;">
        <div class="sidebar-heading text-center py-4">
            <h5>Admin Dashboard</h5>
        </div>
        <div class="list-group list-group-flush">
            <a href="#account-management" class="list-group-item list-group-item-action bg-dark text-light" data-bs-toggle="collapse" data-bs-target="#accountSubmenu">
                Quản lý tài khoản
            </a>
            <div class="collapse" id="accountSubmenu">
                <a href="#" class="list-group-item list-group-item-action bg-secondary text-light">Học viên</a>
                <a href="#" class="list-group-item list-group-item-action bg-secondary text-light">Giảng viên</a>
            </div>
            <a href="#" class="list-group-item list-group-item-action bg-dark text-light active">Quản lý danh mục khóa học</a>
            <a href="#" class="list-group-item list-group-item-action bg-dark text-light">Quản lý giao dịch</a>
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
                    @if(Session::has('admin_id'))
                        <div class="dropdown">
                            <button class="btn btn-secondary dropdown-toggle" type="button" id="adminDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                {{ Session::get('admin_username') }}
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="adminDropdown">
                                <li><a class="dropdown-item" href="{{ route('admin.logout') }}">Đăng xuất</a></li>
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

            <!-- Quản lý danh mục khóa học -->
            <h2 class="mb-4">Quản lý danh mục khóa học</h2>
            <div class="card shadow-sm">
                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Danh sách danh mục</h5>
                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addCategoryModal">Thêm danh mục</button>
                </div>
                <div class="card-body">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Tên danh mục</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($danhmucs as $index => $danhmuc)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $danhmuc->ten_danhmuc }}</td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-primary me-1" data-bs-toggle="modal" data-bs-target="#editCategoryModal{{ $danhmuc->id_danhmuc }}">Sửa</button>
                                        <form action="{{ route('admin.category.delete', $danhmuc->id_danhmuc) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Bạn có chắc muốn xóa danh mục này?')">Xóa</button>
                                        </form>
                                    </td>
                                </tr>

                                <!-- Modal Sửa danh mục -->
                                <div class="modal fade" id="editCategoryModal{{ $danhmuc->id_danhmuc }}" tabindex="-1" aria-labelledby="editCategoryModalLabel{{ $danhmuc->id_danhmuc }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editCategoryModalLabel{{ $danhmuc->id_danhmuc }}">Sửa danh mục</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('admin.category.update', $danhmuc->id_danhmuc) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="mb-3">
                                                        <label for="ten_danhmuc_{{ $danhmuc->id_danhmuc }}" class="form-label">Tên danh mục</label>
                                                        <input type="text" class="form-control" id="ten_danhmuc_{{ $danhmuc->id_danhmuc }}" name="ten_danhmuc" value="{{ $danhmuc->ten_danhmuc }}" required>
                                                        @error('ten_danhmuc')
                                                            <div class="text-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                    <button type="submit" class="btn btn-primary">Cập nhật</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center">Không có danh mục nào.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Thêm danh mục -->
<div class="modal fade" id="addCategoryModal" tabindex="-1" aria-labelledby="addCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addCategoryModalLabel">Thêm danh mục mới</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.category.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="ten_danhmuc" class="form-label">Tên danh mục</label>
                        <input type="text" class="form-control" id="ten_danhmuc" name="ten_danhmuc" required>
                        @error('ten_danhmuc')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">Thêm</button>
                </form>
            </div>
        </div>
    </div>
</div>

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