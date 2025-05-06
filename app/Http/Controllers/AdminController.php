<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\DanhMuc;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;

class AdminController extends Controller
{
    public function index()
    {
        // Kiểm tra nếu admin chưa đăng nhập, chuyển hướng đến trang đăng nhập
        if (!Session::has('admin_id')) {
            return redirect()->route('admin.login');
        }
        $danhmucs = DanhMuc::all();
        return view('admin.index', compact('danhmucs'));
    }

    public function showLoginForm()
    {
        // Nếu admin đã đăng nhập, chuyển hướng đến dashboard
        if (Session::has('admin_id')) {
            return redirect()->route('admin.dashboard');
        }
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username_admin' => ['required', 'string', 'max:50'],
            'password' => ['required', 'string', 'min:3'],
        ]);

        if ($validator->fails()) {
            return redirect()->route('admin.login')->withErrors($validator)->withInput();
        }

        $admin = Admin::where('username_admin', $request->input('username_admin'))->first();

        if ($admin && Hash::check($request->input('password'), $admin->password_admin)) {
            Session::put('admin_id', $admin->id_admin);
            Session::put('admin_username', $admin->username_admin);

            return redirect()->route('admin.dashboard')->with('success', 'Đăng nhập thành công!');
        }

        return redirect()->route('admin.login')->with('error', 'Tên đăng nhập hoặc mật khẩu không đúng.');
    }

    public function logout()
    {
        Session::flush();
        return redirect()->route('admin.login')->with('success', 'Đăng xuất thành công!');
    }

    // Thêm danh mục
    public function storeCategory(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ten_danhmuc' => ['required', 'string', 'max:100', 'unique:danhmuc'],
        ]);

        if ($validator->fails()) {
            return redirect()->route('admin.dashboard')->withErrors($validator)->withInput();
        }

        DanhMuc::create([
            'ten_danhmuc' => $request->ten_danhmuc,
            'id_admin' => Session::get('admin_id'),
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'Thêm danh mục thành công!');
    }

    // Sửa danh mục
    public function updateCategory(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'ten_danhmuc' => ['required', 'string', 'max:100', 'unique:danhmuc,ten_danhmuc,' . $id . ',id_danhmuc'],
        ]);

        if ($validator->fails()) {
            return redirect()->route('admin.dashboard')->withErrors($validator)->withInput();
        }

        $danhmuc = DanhMuc::findOrFail($id);
        $danhmuc->update([
            'ten_danhmuc' => $request->ten_danhmuc,
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'Cập nhật danh mục thành công!');
    }

    // Xóa danh mục
    public function deleteCategory($id)
    {
        $danhmuc = DanhMuc::findOrFail($id);
        if ($danhmuc->khoahocs()->count() > 0) {
            return redirect()->route('admin.dashboard')->with('error', 'Không thể xóa danh mục vì có khóa học liên quan.');
        }
        $danhmuc->delete();

        return redirect()->route('admin.dashboard')->with('success', 'Xóa danh mục thành công!');
    }
}