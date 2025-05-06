@extends('layouts.app')

@section('content')
<div class="container-fluid p-4">
    <h2 class="mb-4">Theo dõi và cố vấn học viên</h2>

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

    <!-- Điểm số học viên -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-light">
            <h5 class="mb-0">Điểm số học viên</h5>
        </div>
        <div class="card-body">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Học viên</th>
                        <th>Bài kiểm tra</th>
                        <th>Điểm</th>
                        <th>Ngày nộp</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($lambais as $index => $lambai)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $lambai->hocVien->hoten_hocvien }}</td>
                        <td>{{ $lambai->baiKiemTra->ten_baikiemtra }}</td>
                        <td>{{ $lambai->diem }}</td>
                        <td>{{ $lambai->ngay_lambai }}</td>
                        <td>
                            <a href="{{ route('giangvien.viewChiTietLamBai', $lambai->id_lambai) }}" class="btn btn-primary btn-sm text-white">Xem chi tiết</a>
                        </td>
                    </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">Chưa có bài làm nào.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Hỏi đáp -->
    <div class="card shadow-sm">
        <div class="card-header bg-light">
            <h5 class="mb-0">Hỏi đáp với học viên</h5>
        </div>
        <div class="card-body">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Học viên</th>
                        <th>Câu hỏi</th>
                        <th>Ngày hỏi</th>
                        <th>Trả lời</th>
                        <th>Ngày trả lời</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($hoidaps as $index => $hoidap)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $hoidap->hocVien->hoten_hocvien }}</td>
                        <td>{{ $hoidap->noidung_hoidap }}</td>
                        <td>{{ $hoidap->ngaytao_hoidap }}</td>
                        <td>{{ $hoidap->noidung_traloi ?: 'Chưa trả lời' }}</td>
                        <td>{{ $hoidap->ngaytao_traloi ?: 'Chưa trả lời' }}</td>
                        <td>
                            @if(!$hoidap->noidung_traloi)
                                <button class="btn btn-primary btn-sm text-white" data-bs-toggle="modal" data-bs-target="#traloiModal{{ $hoidap->id_hoidap }}">Trả lời</button>
                            @else
                                <button class="btn btn-primary btn-sm text-white" disabled>Đã trả lời</button>
                            @endif
                        </td>
                    </tr>
                    <!-- Modal trả lời hỏi đáp -->
                    <div class="modal fade" id="traloiModal{{ $hoidap->id_hoidap }}" tabindex="-1" aria-labelledby="traloiModalLabel{{ $hoidap->id_hoidap }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="traloiModalLabel{{ $hoidap->id_hoidap }}">Trả lời câu hỏi</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form method="POST" action="{{ route('giangvien.replyHoiDap', $hoidap->id_hoidap) }}">
                                        @csrf
                                        <div class="mb-3">
                                            <label class="form-label">Câu hỏi: {{ $hoidap->noidung_hoidap }}</label>
                                        </div>
                                        <div class="mb-3">
                                            <label for="noidung_traloi" class="form-label">Trả lời</label>
                                            <textarea class="form-control" id="noidung_traloi" name="noidung_traloi" rows="4" required></textarea>
                                            @error('noidung_traloi')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <button type="submit" class="btn btn-primary">Gửi trả lời</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">Chưa có câu hỏi nào.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
<a href="{{ route('giangvien.dashboard') }}" class="btn btn-secondary m-3">Quay lại</a>
@endsection