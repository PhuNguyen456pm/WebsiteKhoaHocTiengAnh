<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HocVien;
use App\Models\Khoahoc;
use App\Models\DanhMuc;
use App\Models\DangKyKhoahoc;
use App\Models\BaiHoc;
use App\Models\BaiKiemTra;
use App\Models\ChiTietLamBai;
use App\Models\TaiLieu;
use App\Models\HoiDap;
use App\Models\GiangVien;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;

class HocVienController extends Controller
{
    public function index()
    {
        // Lấy tất cả danh mục
        $danhmucs = DanhMuc::all();
        
        // Lấy 6 khóa học bất kỳ
        $khoahocs = Khoahoc::with('danhMuc', 'giangVien')
            ->take(6)
            ->get();

        return view('welcome', compact('danhmucs', 'khoahocs'));
    }
    public function showKhoahoc($id)
    {
        // Lấy thông tin khóa học theo ID
        $khoahoc = Khoahoc::with('danhMuc', 'giangVien', 'baiHocs')->findOrFail($id);

        return view('khoahoc_detail', compact('khoahoc'));
    }
    public function indexByCategory($id)
    {
        // Lấy tất cả danh mục
        $danhmucs = DanhMuc::all();
        
        // Lấy khóa học thuộc danh mục cụ thể
        $khoahocs = Khoahoc::with('danhMuc', 'giangVien')
            ->where('id_danhmuc', $id)
            ->get();

        return view('welcome', compact('danhmucs', 'khoahocs'));
    }
    public function registerCourse($id)
    {
        if (!Session::has('hocvien_id')) {
            return redirect('/')->with('error', 'Vui lòng đăng nhập để đăng ký khóa học.');
        }

        $khoahoc = Khoahoc::findOrFail($id);
        $hocvien = HocVien::find(Session::get('hocvien_id'));

        // Kiểm tra xem học viên đã đăng ký khóa học này chưa
        $existingRegistration = DangKyKhoahoc::where('id_khoahoc', $id)
            ->where('id_hocvien', $hocvien->id_hocvien)
            ->first();

        if ($existingRegistration) {
            return redirect('/')->with('error', 'Bạn đã đăng ký khóa học này.');
        }

        return view('register_course', compact('khoahoc', 'hocvien'));
    }

    public function submitRegisterCourse(Request $request, $id)
    {
        if (!Session::has('hocvien_id')) {
            return redirect('/')->with('error', 'Vui lòng đăng nhập để đăng ký khóa học.');
        }

        $validator = Validator::make($request->all(), [
            'address' => ['required', 'string', 'max:255'],
            'payment_method' => ['required', 'string', 'in:Bank Card,Credit Card'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        Session::put('registration_data', [
            'address' => $request->input('address'),
            'payment_method' => $request->input('payment_method'),
            'khoahoc_id' => $id,
        ]);

        return redirect()->route('confirm.payment', $id);
    }

    public function confirmPayment($id)
    {
        if (!Session::has('hocvien_id') || !Session::has('registration_data')) {
            return redirect('/')->with('error', 'Thông tin đăng ký không hợp lệ.');
        }

        $registrationData = Session::get('registration_data');
        if ($registrationData['khoahoc_id'] != $id) {
            return redirect('/')->with('error', 'Dữ liệu không hợp lệ.');
        }

        $khoahoc = Khoahoc::findOrFail($id);
        $hocvien = HocVien::find(Session::get('hocvien_id'));

        return view('confirm_payment', compact('khoahoc', 'hocvien', 'registrationData'));
    }

    public function submitPayment($id)
    {
        if (!Session::has('hocvien_id') || !Session::has('registration_data')) {
            return redirect('/')->with('error', 'Thông tin đăng ký không hợp lệ.');
        }

        $registrationData = Session::get('registration_data');
        if ($registrationData['khoahoc_id'] != $id) {
            return redirect('/')->with('error', 'Dữ liệu không hợp lệ.');
        }

        $khoahoc = Khoahoc::findOrFail($id);
        $hocvienId = Session::get('hocvien_id');

        // Tạo bản ghi đăng ký khóa học
        DangKyKhoahoc::create([
            'thoigian_thanhtoan' => now(),
            'trangthai_thanhtoan' => 'Đã thanh toán',
            'phuongthuc_thanhtoan' => $registrationData['payment_method'],
            'tong_tien' => $khoahoc->gia_khoahoc,
            'id_khoahoc' => $id,
            'id_hocvien' => $hocvienId,
        ]);

        // Xóa session sau khi hoàn tất
        Session::forget('registration_data');

        return redirect('/')->with('success', 'Đăng ký và thanh toán thành công!');
    }


    public function register(Request $request)
    {
        // Validate dữ liệu
        $validator = Validator::make($request->all(), [
            'username_hocvien' => ['required', 'string', 'max:50'],
            'hoten_hocvien' => ['required', 'string', 'max:100'],
            'email_hocvien' => ['required', 'string', 'email', 'max:100', 'unique:hocvien,email_hocvien'],
            'sodienthoai_hocvien' => ['required', 'string', 'max:50'],
            'password' => ['required', 'string', 'min:3', 'confirmed'],
        ]);

        if ($validator->fails()) {
            return redirect('/')->withErrors($validator)->withInput();
        }

        // Lưu dữ liệu vào database
        HocVien::create([
            'username_hocvien' => $request->input('username_hocvien'),
            'hoten_hocvien' => $request->input('hoten_hocvien'),
            'email_hocvien' => $request->input('email_hocvien'),
            'sodienthoai_hocvien' => $request->input('sodienthoai_hocvien'),
            'password_hocvien' => Hash::make($request->input('password')),
        ]);

        // Chuyển hướng về trang chủ với thông báo thành công
        return redirect('/')->with('success', 'Đăng ký thành công, vui lòng đăng nhập!');
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email_hocvien' => ['required', 'string', 'email', 'max:100'],
            'password' => ['required', 'string', 'min:3'],
        ]);

        if ($validator->fails()) {
            return redirect('/')->withErrors($validator)->withInput();
        }

        $hocvien = HocVien::where('email_hocvien', $request->input('email_hocvien'))->first();

        if ($hocvien && Hash::check($request->input('password'), $hocvien->password_hocvien)) {
            Session::put('hocvien_id', $hocvien->id_hocvien);
            Session::put('hocvien_username', $hocvien->username_hocvien);

            return redirect('/')->with('success', 'Đăng nhập thành công!');
        }

        return redirect('/')->with('error', 'Email hoặc mật khẩu không đúng.');
    }

    public function logout()
    {
        Session::flush();
        return redirect('/')->with('success', 'Đăng xuất thành công!');
    }

    public function showUpdateForm()
    {
        $hocvien = HocVien::find(Session::get('hocvien_id'));
        if (!$hocvien) {
            return redirect('/')->with('error', 'Không tìm thấy thông tin học viên.');
        }
        return view('hocvien.update', compact('hocvien'));
    }

    public function update(Request $request)
    {
        $hocvien = HocVien::find(Session::get('hocvien_id'));
        if (!$hocvien) {
            return redirect('/')->with('error', 'Không tìm thấy thông tin học viên.');
        }

        $validator = Validator::make($request->all(), [
            'username_hocvien' => ['required', 'string', 'max:50'],
            'hoten_hocvien' => ['required', 'string', 'max:100'],
            'email_hocvien' => ['required', 'string', 'email', 'max:100', 'unique:hocvien,email_hocvien,' . $hocvien->id_hocvien . ',id_hocvien'],
            'sodienthoai_hocvien' => ['required', 'string', 'max:50'],
            'password' => ['nullable', 'string', 'min:3', 'confirmed'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $hocvien->username_hocvien = $request->input('username_hocvien');
        $hocvien->hoten_hocvien = $request->input('hoten_hocvien');
        $hocvien->email_hocvien = $request->input('email_hocvien');
        $hocvien->sodienthoai_hocvien = $request->input('sodienthoai_hocvien');

        if ($request->filled('password')) {
            $hocvien->password_hocvien = Hash::make($request->input('password'));
        }

        $hocvien->save();

        Session::put('hocvien_username', $hocvien->username_hocvien);

        return redirect('/')->with('success', 'Cập nhật thông tin thành công!');
    }
}