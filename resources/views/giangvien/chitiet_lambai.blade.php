@extends('layouts.app')

@section('content')
<div class="container-fluid p-4">
    <h2 class="mb-4">Chi tiết bài làm</h2>

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
        <div class="card-header bg-light">
            <h5 class="mb-0">Thông tin bài làm</h5>
        </div>
        <div class="card-body">
            <p><strong>Học viên:</strong> {{ $lambai->hocVien->hoten_hocvien }}</p>
            <p><strong>Bài kiểm tra:</strong> {{ $lambai->baiKiemTra->ten_baikiemtra }}</p>
            <p><strong>Điểm:</strong> {{ $lambai->diem }}</p>
            <p><strong>Ngày nộp:</strong> {{ $lambai->ngay_lambai }}</p>
            <p><strong>Thời gian làm bài:</strong> {{ $lambai->thoigian_lambai }}</p>
        </div>
    </div>

    <div class="card shadow-sm mt-4">
        <div class="card-header bg-light">
            <h5 class="mb-0">Chi tiết câu trả lời</h5>
        </div>
        <div class="card-body">
            @forelse($lambai->chitietlambaies as $index => $chitiet)
            <div class="mb-4">
                <h6>Câu {{ $index + 1 }}: {{ $chitiet->cauHoi->noidung_cauhoi }}</h6>
                <p><strong>Đáp án chọn:</strong> {{ $chitiet->dapAn->noidung_dapan }} 
                    @if($chitiet->dapAn->dungsai)
                        <span class="badge bg-success">Đúng</span>
                    @else
                        <span class="badge bg-danger">Sai</span>
                    @endif
                </p>
                <p><strong>Đáp án đúng:</strong> 
                    @foreach($chitiet->cauHoi->dapAns as $dapan)
                        @if($dapan->dungsai)
                            {{ $dapan->noidung_dapan }}
                        @endif
                    @endforeach
                </p>
                @if($chitiet->cauHoi->giaithich)
                    <p><strong>Giải thích:</strong> {{ $chitiet->cauHoi->giaithich }}</p>
                @else
                    <p><strong>Giải thích:</strong> Không có giải thích.</p>
                @endif
            </div>
            @empty
                <p>Không có chi tiết bài làm.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection