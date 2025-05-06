<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GiangVien;
use App\Models\Khoahoc;
use App\Models\BaiHoc;
use App\Models\TaiLieu;
use App\Models\BaiKiemTra;
use App\Models\CauHoi;
use App\Models\DapAn;
use App\Models\LamBai;
use App\Models\ChiTietLamBai;
use App\Models\HoiDap;
use App\Models\DanhMuc;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class GiangVienController extends Controller
{
    public function index()
    {
        if (!Session::has('giangvien_id')) {
            return redirect()->route('giangvien.showLoginForm');
        }
        $giangvien = GiangVien::find(Session::get('giangvien_id'));
        $khoahocs = $giangvien->khoahocs;
        $danhmucs = DanhMuc::all();
        return view('giangvien.index', compact('khoahocs', 'danhmucs'));
    }

    public function showLoginForm()
    {
        if (Session::has('giangvien_id')) {
            return redirect()->route('giangvien.dashboard');
        }
        return view('giangvien.login');
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email_giangvien' => ['required', 'string', 'email', 'max:100'],
            'password' => ['required', 'string', 'min:3'],
        ]);

        if ($validator->fails()) {
            return redirect()->route('giangvien.showLoginForm')->withErrors($validator)->withInput();
        }

        $giangvien = GiangVien::where('email_giangvien', $request->input('email_giangvien'))->first();

        if ($giangvien && Hash::check($request->input('password'), $giangvien->password_giangvien)) {
            Session::put('giangvien_id', $giangvien->id_giangvien);
            Session::put('giangvien_name', $giangvien->hoten_giangvien);
            return redirect()->route('giangvien.dashboard')->with('success', 'Đăng nhập thành công!');
        }

        return redirect()->route('giangvien.showLoginForm')->with('error', 'Email hoặc mật khẩu không đúng.');
    }

    public function showRegisterForm()
    {
        if (Session::has('giangvien_id')) {
            return redirect()->route('giangvien.dashboard');
        }
        return view('giangvien.register');
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'hoten_giangvien' => ['required', 'string', 'max:100'],
            'email_giangvien' => ['required', 'string', 'email', 'max:100', 'unique:giangvien,email_giangvien'],
            'sodienthoai_giangvien' => ['required', 'string', 'max:50'],
            'password' => ['required', 'string', 'min:3', 'confirmed'],
        ]);

        if ($validator->fails()) {
            return redirect()->route('giangvien.showRegisterForm')->withErrors($validator)->withInput();
        }

        GiangVien::create([
            'hoten_giangvien' => $request->input('hoten_giangvien'),
            'email_giangvien' => $request->input('email_giangvien'),
            'sodienthoai_giangvien' => $request->input('sodienthoai_giangvien'),
            'password_giangvien' => Hash::make($request->input('password')),
        ]);

        return redirect()->route('giangvien.showLoginForm')->with('success', 'Đăng ký thành công, vui lòng đăng nhập!');
    }

    public function logout()
    {
        Session::flush();
        return redirect()->route('giangvien.showLoginForm')->with('success', 'Đăng xuất thành công!');
    }

    // CRUD cho Khoahoc
    public function createKhoahoc(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ten_khoahoc' => ['required', 'string', 'max:100'],
            'id_danhmuc' => ['required', 'exists:danhmuc,id_danhmuc'],
            'mota_khoahoc' => ['required', 'string'],
            'hinhanh_khoahoc' => ['required', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            'gia_khoahoc' => ['required', 'numeric', 'min:0'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $path = $request->file('hinhanh_khoahoc')->store('images/khoahoc', 'public');

        Khoahoc::create([
            'ten_khoahoc' => $request->input('ten_khoahoc'),
            'id_danhmuc' => $request->input('id_danhmuc'),
            'id_giangvien' => Session::get('giangvien_id'),
            'mota_khoahoc' => $request->input('mota_khoahoc'),
            'hinhanh_khoahoc' => $path,
            'gia_khoahoc' => $request->input('gia_khoahoc'),
        ]);

        return redirect()->route('giangvien.dashboard')->with('success', 'Tạo khóa học thành công!');
    }

    public function editKhoahoc($id)
    {
        $khoahoc = Khoahoc::findOrFail($id);
        if ($khoahoc->id_giangvien != Session::get('giangvien_id')) {
            return redirect()->route('giangvien.dashboard')->with('error', 'Bạn không có quyền chỉnh sửa khóa học này.');
        }
        $danhmucs = DanhMuc::all();
        return view('giangvien.edit_khoahoc', compact('khoahoc', 'danhmucs'));
    }

    public function updateKhoahoc(Request $request, $id)
    {
        $khoahoc = Khoahoc::findOrFail($id);
        if ($khoahoc->id_giangvien != Session::get('giangvien_id')) {
            return redirect()->route('giangvien.dashboard')->with('error', 'Bạn không có quyền chỉnh sửa khóa học này.');
        }

        $validator = Validator::make($request->all(), [
            'ten_khoahoc' => ['required', 'string', 'max:100'],
            'id_danhmuc' => ['required', 'exists:danhmuc,id_danhmuc'],
            'mota_khoahoc' => ['required', 'string'],
            'hinhanh_khoahoc' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            'gia_khoahoc' => ['required', 'numeric', 'min:0'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = [
            'ten_khoahoc' => $request->input('ten_khoahoc'),
            'id_danhmuc' => $request->input('id_danhmuc'),
            'mota_khoahoc' => $request->input('mota_khoahoc'),
            'gia_khoahoc' => $request->input('gia_khoahoc'),
        ];

        if ($request->hasFile('hinhanh_khoahoc')) {
            if ($khoahoc->hinhanh_khoahoc) {
                Storage::disk('public')->delete($khoahoc->hinhanh_khoahoc);
            }
            $path = $request->file('hinhanh_khoahoc')->store('images/khoahoc', 'public');
            $data['hinhanh_khoahoc'] = $path;
        }

        $khoahoc->update($data);

        return redirect()->route('giangvien.dashboard')->with('success', 'Cập nhật khóa học thành công!');
    }

    public function deleteKhoahoc($id)
    {
        $khoahoc = Khoahoc::findOrFail($id);
        if ($khoahoc->id_giangvien != Session::get('giangvien_id')) {
            return redirect()->route('giangvien.dashboard')->with('error', 'Bạn không có quyền xóa khóa học này.');
        }
        if ($khoahoc->hinhanh_khoahoc) {
            Storage::disk('public')->delete($khoahoc->hinhanh_khoahoc);
        }
        $khoahoc->delete();
        return redirect()->route('giangvien.dashboard')->with('success', 'Xóa khóa học thành công!');
    }

    // CRUD cho BaiHoc
    public function manageBaiHoc($khoahoc_id)
    {
        $khoahoc = Khoahoc::findOrFail($khoahoc_id);
        if ($khoahoc->id_giangvien != Session::get('giangvien_id')) {
            return redirect()->route('giangvien.dashboard')->with('error', 'Bạn không có quyền quản lý bài học của khóa học này.');
        }
        $baihocs = $khoahoc->baiHocs;
        return view('giangvien.manage_baihoc', compact('khoahoc', 'baihocs'));
    }

    public function createBaiHoc(Request $request, $khoahoc_id)
    {
        $khoahoc = Khoahoc::findOrFail($khoahoc_id);
        if ($khoahoc->id_giangvien != Session::get('giangvien_id')) {
            return redirect()->route('giangvien.dashboard')->with('error', 'Bạn không có quyền thêm bài học.');
        }

        $validator = Validator::make($request->all(), [
            'tieude_baihoc' => ['required', 'string', 'max:150'],
            'noidung_baihoc' => ['nullable', 'string'],
            'thu_tu' => ['required', 'integer', 'min:1'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        BaiHoc::create([
            'tieude_baihoc' => $request->input('tieude_baihoc'),
            'id_khoahoc' => $khoahoc_id,
            'noidung_baihoc' => $request->input('noidung_baihoc') ?? '',
            'thu_tu' => $request->input('thu_tu'),
        ]);

        return redirect()->route('giangvien.manageBaiHoc', $khoahoc_id)->with('success', 'Tạo bài học thành công!');
    }

    public function editBaiHoc($khoahoc_id, $baihoc_id)
    {
        $khoahoc = Khoahoc::findOrFail($khoahoc_id);
        if ($khoahoc->id_giangvien != Session::get('giangvien_id')) {
            return redirect()->route('giangvien.dashboard')->with('error', 'Bạn không có quyền chỉnh sửa bài học.');
        }
        $baihoc = BaiHoc::findOrFail($baihoc_id);
        return view('giangvien.edit_baihoc', compact('khoahoc', 'baihoc'));
    }

    public function updateBaiHoc(Request $request, $khoahoc_id, $baihoc_id)
    {
        $khoahoc = Khoahoc::findOrFail($khoahoc_id);
        if ($khoahoc->id_giangvien != Session::get('giangvien_id')) {
            return redirect()->route('giangvien.dashboard')->with('error', 'Bạn không có quyền chỉnh sửa bài học.');
        }
        $baihoc = BaiHoc::findOrFail($baihoc_id);

        $validator = Validator::make($request->all(), [
            'tieude_baihoc' => ['required', 'string', 'max:150'],
            'noidung_baihoc' => ['nullable', 'string'],
            'thu_tu' => ['required', 'integer', 'min:1'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $baihoc->update([
            'tieude_baihoc' => $request->input('tieude_baihoc'),
            'noidung_baihoc' => $request->input('noidung_baihoc') ?? '',
            'thu_tu' => $request->input('thu_tu'),
        ]);

        return redirect()->route('giangvien.manageBaiHoc', $khoahoc_id)->with('success', 'Cập nhật bài học thành công!');
    }

    public function deleteBaiHoc($khoahoc_id, $baihoc_id)
    {
        $khoahoc = Khoahoc::findOrFail($khoahoc_id);
        if ($khoahoc->id_giangvien != Session::get('giangvien_id')) {
            return redirect()->route('giangvien.dashboard')->with('error', 'Bạn không có quyền xóa bài học.');
        }
        $baihoc = BaiHoc::findOrFail($baihoc_id);
        $baihoc->delete();
        return redirect()->route('giangvien.manageBaiHoc', $khoahoc_id)->with('success', 'Xóa bài học thành công!');
    }

    // CRUD cho TaiLieu
    public function manageTaiLieu($khoahoc_id, $baihoc_id)
    {
        $khoahoc = Khoahoc::findOrFail($khoahoc_id);
        if ($khoahoc->id_giangvien != Session::get('giangvien_id')) {
            return redirect()->route('giangvien.dashboard')->with('error', 'Bạn không có quyền quản lý tài liệu.');
        }
        $baihoc = BaiHoc::findOrFail($baihoc_id);
        $tailieus = $baihoc->taiLieus;
        return view('giangvien.manage_tailieu', compact('khoahoc', 'baihoc', 'tailieus'));
    }

    public function createTaiLieu(Request $request, $khoahoc_id, $baihoc_id)
    {
        $khoahoc = Khoahoc::findOrFail($khoahoc_id);
        if ($khoahoc->id_giangvien != Session::get('giangvien_id')) {
            return redirect()->route('giangvien.dashboard')->with('error', 'Bạn không có quyền thêm tài liệu.');
        }

        $validator = Validator::make($request->all(), [
            'ten_tailieu' => ['required', 'string', 'max:150'],
            'file_tailieu' => ['required', 'file', 'mimes:pdf,mp4,mp3,wav', 'max:20480'], // Tăng giới hạn lên 20MB
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $path = $request->file('file_tailieu')->store('documents/tailieu', 'public');

        TaiLieu::create([
            'ten_tailieu' => $request->input('ten_tailieu'),
            'id_baihoc' => $baihoc_id,
            'file_tailieu' => $path,
        ]);

        return redirect()->route('giangvien.manageTaiLieu', [$khoahoc_id, $baihoc_id])->with('success', 'Thêm tài liệu thành công!');
    }

    public function editTaiLieu($khoahoc_id, $baihoc_id, $tailieu_id)
    {
        $khoahoc = Khoahoc::findOrFail($khoahoc_id);
        if ($khoahoc->id_giangvien != Session::get('giangvien_id')) {
            return redirect()->route('giangvien.dashboard')->with('error', 'Bạn không có quyền chỉnh sửa tài liệu.');
        }
        $baihoc = BaiHoc::findOrFail($baihoc_id);
        $tailieu = TaiLieu::findOrFail($tailieu_id);
        return view('giangvien.edit_tailieu', compact('khoahoc', 'baihoc', 'tailieu'));
    }

    public function updateTaiLieu(Request $request, $khoahoc_id, $baihoc_id, $tailieu_id)
    {
        $khoahoc = Khoahoc::findOrFail($khoahoc_id);
        if ($khoahoc->id_giangvien != Session::get('giangvien_id')) {
            return redirect()->route('giangvien.dashboard')->with('error', 'Bạn không có quyền chỉnh sửa tài liệu.');
        }
        $tailieu = TaiLieu::findOrFail($tailieu_id);

        $validator = Validator::make($request->all(), [
            'ten_tailieu' => ['required', 'string', 'max:150'],
            'file_tailieu' => ['nullable', 'file', 'mimes:pdf,mp4,mp3,wav', 'max:20480'], // Tăng giới hạn lên 20MB
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = [
            'ten_tailieu' => $request->input('ten_tailieu'),
        ];

        if ($request->hasFile('file_tailieu')) {
            if ($tailieu->file_tailieu) {
                Storage::disk('public')->delete($tailieu->file_tailieu);
            }
            $path = $request->file('file_tailieu')->store('documents/tailieu', 'public');
            $data['file_tailieu'] = $path;
        }

        $tailieu->update($data);

        return redirect()->route('giangvien.manageTaiLieu', [$khoahoc_id, $baihoc_id])->with('success', 'Cập nhật tài liệu thành công!');
    }

    public function deleteTaiLieu($khoahoc_id, $baihoc_id, $tailieu_id)
    {
        $khoahoc = Khoahoc::findOrFail($khoahoc_id);
        if ($khoahoc->id_giangvien != Session::get('giangvien_id')) {
            return redirect()->route('giangvien.dashboard')->with('error', 'Bạn không có quyền xóa tài liệu.');
        }
        $tailieu = TaiLieu::findOrFail($tailieu_id);

        if ($tailieu->file_tailieu) {
            Storage::disk('public')->delete($tailieu->file_tailieu);
        }

        $tailieu->delete();
        return redirect()->route('giangvien.manageTaiLieu', [$khoahoc_id, $baihoc_id])->with('success', 'Xóa tài liệu thành công!');
    }
    // CRUD cho BaiKiemTra
public function showCreateBaiKiemTraForm()
{
if (!Session::has('giangvien_id')) {
return redirect()->route('giangvien.showLoginForm');
}
return view('giangvien.create_baikiemtra');
}

public function createBaiKiemTra(Request $request)
{
if (!Session::has('giangvien_id')) {
return redirect()->route('giangvien.showLoginForm');
}

$validator = Validator::make($request->all(), [
'ten_baikiemtra' => ['required', 'string', 'max:150'],
'thoigian_baikiemtra' => ['required', 'numeric', 'min:1'],
'cauhoi..noidung_cauhoi' => ['required', 'string'],
'cauhoi..dapan.*.noidung_dapan' => ['required', 'string'],
]);

if ($validator->fails()) {
return redirect()->back()->withErrors($validator)->withInput();
}

$baikiemtra = BaiKiemTra::create([
'ten_baikiemtra' => $request->input('ten_baikiemtra'),
'ngaytao_baikiemtra' => now(),
'thoigian_baikiemtra' => gmdate('H:i:s', $request->input('thoigian_baikiemtra') * 60),
]);

foreach ($request->input('cauhoi', []) as $cauhoiData) {
$cauhoi = CauHoi::create([
'noidung_cauhoi' => $cauhoiData['noidung_cauhoi'],
'id_baikiemtra' => $baikiemtra->id_baikiemtra,
'giaithich' => $cauhoiData['giaithich'] ?? '',
]);

foreach ($cauhoiData['dapan'] as $dapanData) {
DapAn::create([
'noidung_dapan' => $dapanData['noidung_dapan'],
'dungsai' => isset($dapanData['dungsai']) ? 1 : 0,
'id_cauhoi' => $cauhoi->id_cauhoi,
]);
}
}

return redirect()->route('giangvien.dashboard')->with('success', 'Tạo bài kiểm tra thành công!');
}

// Theo dõi học viên
public function monitorHocVien()
{
if (!Session::has('giangvien_id')) {
return redirect()->route('giangvien.showLoginForm');
}

$giangvien = GiangVien::find(Session::get('giangvien_id'));
$khoahocs = $giangvien->khoahocs()->pluck('id_khoahoc');
$lambais = LamBai::whereIn('id_baikiemtra', function ($query) use ($khoahocs) {
$query->select('id_baikiemtra')->from('baikiemtra')
->whereIn('id_baikiemtra', function ($subQuery) use ($khoahocs) {
$subQuery->select('id_baikiemtra')->from('cauhoi')
->whereIn('id_baikiemtra', function ($subSubQuery) use ($khoahocs) {
$subSubQuery->select('id_baikiemtra')->from('baikiemtra');
});
});
})->get();

$hoidaps = HoiDap::where('id_giangvien', $giangvien->id_giangvien)->get();

return view('giangvien.monitor_hocvien', compact('lambais', 'hoidaps'));
}

// Xem chi tiết bài làm
public function viewChiTietLamBai($id_lambai)
{
if (!Session::has('giangvien_id')) {
return redirect()->route('giangvien.showLoginForm');
}

$lambai = LamBai::findOrFail($id_lambai);
$giangvien = GiangVien::find(Session::get('giangvien_id'));
$khoahocs = $giangvien->khoahocs()->pluck('id_khoahoc');

// Kiểm tra quyền truy cập
$isValid = BaiKiemTra::where('id_baikiemtra', $lambai->id_baikiemtra)
->whereIn('id_baikiemtra', function ($query) use ($khoahocs) {
$query->select('id_baikiemtra')->from('baikiemtra');
})->exists();

if (!$isValid) {
return redirect()->route('giangvien.dashboard')->with('error', 'Bạn không có quyền xem bài làm này.');
}

return view('giangvien.chitiet_lambai', compact('lambai'));
}

// Trả lời hỏi đáp
public function replyHoiDap(Request $request, $id_hoidap)
{
if (!Session::has('giangvien_id')) {
return redirect()->route('giangvien.showLoginForm');
}

$validator = Validator::make($request->all(), [
'noidung_traloi' => ['required', 'string'],
]);

if ($validator->fails()) {
return redirect()->back()->withErrors($validator)->withInput();
}

$hoidap = HoiDap::findOrFail($id_hoidap);
if ($hoidap->id_giangvien != Session::get('giangvien_id')) {
return redirect()->route('giangvien.dashboard')->with('error', 'Bạn không có quyền trả lời câu hỏi này.');
}

$hoidap->update([
'noidung_traloi' => $request->input('noidung_traloi'),
'ngaytao_traloi' => now(),
]);

return redirect()->route('giangvien.monitorHocVien')->with('success', 'Trả lời câu hỏi thành công!');
}

}