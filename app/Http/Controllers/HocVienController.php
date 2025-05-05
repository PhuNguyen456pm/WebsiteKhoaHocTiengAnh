<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HocVien;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;

class HocVienController extends Controller
{
    public function index()
    {
        return view('welcome');
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