@extends('layouts.app')

@section('content')
<div class="container-fluid p-4">
    <h2 class="mb-4">Tạo bài kiểm tra mới</h2>

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
        <div class="card-body">
            <form method="POST" action="{{ route('giangvien.createBaiKiemTra') }}">
                @csrf
                <div class="mb-3">
                    <label for="ten_baikiemtra" class="form-label">Tên bài kiểm tra</label>
                    <input type="text" class="form-control" id="ten_baikiemtra" name="ten_baikiemtra" required>
                    @error('ten_baikiemtra')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="thoigian_baikiemtra" class="form-label">Thời gian làm bài (phút)</label>
                    <input type="number" class="form-control" id="thoigian_baikiemtra" name="thoigian_baikiemtra" min="1" required>
                    @error('thoigian_baikiemtra')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <h5 class="mt-4">Câu hỏi</h5>
                <div id="cauhoi-container">
                    <div class="cauhoi-group mb-3 p-3 border rounded">
                        <div class="mb-3">
                            <label class="form-label">Nội dung câu hỏi</label>
                            <textarea class="form-control" name="cauhoi[0][noidung_cauhoi]" rows="3" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Giải thích đáp án</label>
                            <textarea class="form-control" name="cauhoi[0][giaithich]" rows="3"></textarea>
                        </div>
                        <div class="dapan-group">
                            <label class="form-label">Đáp án</label>
                            <div class="mb-2">
                                <input type="text" class="form-control" name="cauhoi[0][dapan][0][noidung_dapan]" placeholder="Đáp án 1" required>
                                <div class="form-check mt-2">
                                    <input type="checkbox" class="form-check-input" name="cauhoi[0][dapan][0][dungsai]" value="1">
                                    <label class="form-check-label">Đáp án đúng</label>
                                </div>
                            </div>
                            <div class="mb-2">
                                <input type="text" class="form-control" name="cauhoi[0][dapan][1][noidung_dapan]" placeholder="Đáp án 2" required>
                                <div class="form-check mt-2">
                                    <input type="checkbox" class="form-check-input" name="cauhoi[0][dapan][1][dungsai]" value="1">
                                    <label class="form-check-label">Đáp án đúng</label>
                                </div>
                            </div>
                            <button type="button" class="btn btn-outline-primary btn-sm mt-2 add-dapan">Thêm đáp án</button>
                        </div>
                    </div>
                </div>
                <button type="button" class="btn btn-outline-primary mb-3" id="add-cauhoi">Thêm câu hỏi</button>
                <button type="submit" class="btn btn-primary">Tạo bài kiểm tra</button>
            </form>
        </div>
    </div>
</div>

<script>
let cauhoiIndex = 1;
document.getElementById('add-cauhoi').addEventListener('click', function() {
    const container = document.getElementById('cauhoi-container');
    const newCauhoi = document.createElement('div');
    newCauhoi.classList.add('cauhoi-group', 'mb-3', 'p-3', 'border', 'rounded');
    newCauhoi.innerHTML = `
        <div class="mb-3">
            <label class="form-label">Nội dung câu hỏi</label>
            <textarea class="form-control" name="cauhoi[${cauhoiIndex}][noidung_cauhoi]" rows="3" required></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Giải thích đáp án</label>
            <textarea class="form-control" name="cauhoi[${cauhoiIndex}][giaithich]" rows="3"></textarea>
        </div>
        <div class="dapan-group">
            <label class="form-label">Đáp án</label>
            <div class="mb-2">
                <input type="text" class="form-control" name="cauhoi[${cauhoiIndex}][dapan][0][noidung_dapan]" placeholder="Đáp án 1" required>
                <div class="form-check mt-2">
                    <input type="checkbox" class="form-check-input" name="cauhoi[${cauhoiIndex}][dapan][0][dungsai]" value="1">
                    <label class="form-check-label">Đáp án đúng</label>
                </div>
            </div>
            <div class="mb-2">
                <input type="text" class="form-control" name="cauhoi[${cauhoiIndex}][dapan][1][noidung_dapan]" placeholder="Đáp án 2" required>
                <div class="form-check mt-2">
                    <input type="checkbox" class="form-check-input" name="cauhoi[${cauhoiIndex}][dapan][1][dungsai]" value="1">
                    <label class="form-check-label">Đáp án đúng</label>
                </div>
            </div>
            <button type="button" class="btn btn-outline-primary btn-sm mt-2 add-dapan">Thêm đáp án</button>
        </div>
        <button type="button" class="btn btn-outline-danger btn-sm mt-2 remove-cauhoi">Xóa câu hỏi</button>
    `;
    container.appendChild(newCauhoi);
    cauhoiIndex++;
});

document.addEventListener('click', function(e) {
    if (e.target.classList.contains('add-dapan')) {
        const dapanGroup = e.target.parentElement;
        const cauhoiGroup = dapanGroup.parentElement;
        const dapanIndex = dapanGroup.querySelectorAll('.mb-2').length;
        const cauhoiIndex = cauhoiGroup.querySelector('textarea[name*="noidung_cauhoi"]').name.match(/\d+/)[0];
        const newDapan = document.createElement('div');
        newDapan.classList.add('mb-2');
        newDapan.innerHTML = `
            <input type="text" class="form-control" name="cauhoi[${cauhoiIndex}][dapan][${dapanIndex}][noidung_dapan]" placeholder="Đáp án ${dapanIndex + 1}" required>
            <div class="form-check mt-2">
                <input type="checkbox" class="form-check-input" name="cauhoi[${cauhoiIndex}][dapan][${dapanIndex}][dungsai]" value="1">
                <label class="form-check-label">Đáp án đúng</label>
            </div>
        `;
        dapanGroup.insertBefore(newDapan, e.target);
    }
    if (e.target.classList.contains('remove-cauhoi')) {
        e.target.parentElement.remove();
    }
});
</script>
<a href="{{ route('giangvien.dashboard') }}" class="btn btn-secondary m-3">Quay lại</a>
@endsection