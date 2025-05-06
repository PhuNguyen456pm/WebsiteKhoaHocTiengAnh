<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\GiangVienController;
use App\Http\Controllers\HocVienController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [HocVienController::class, 'index'])->name('home');

// Route cho chi tiết khóa học
Route::get('/khoahoc/{id}', [HocVienController::class, 'showKhoahoc'])->name('khoahoc.show');

// Route cho lọc khóa học theo danh mục
Route::get('/khoahoc/category/{id}', [HocVienController::class, 'indexByCategory'])->name('khoahoc.by.category');
// Routes cho đăng ký khóa học
Route::get('/register-course/{id}', [HocVienController::class, 'registerCourse'])->name('register.course');
Route::post('/register-course/{id}/submit', [HocVienController::class, 'submitRegisterCourse'])->name('submit.register.course');
Route::get('/confirm-payment/{id}', [HocVienController::class, 'confirmPayment'])->name('confirm.payment');
Route::post('/confirm-payment/{id}/submit', [HocVienController::class, 'submitPayment'])->name('submit.payment');

// Routes cho admin
Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');
Route::get('/admin/login', [AdminController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AdminController::class, 'login'])->name('admin.login');
Route::get('/admin/logout', [AdminController::class, 'logout'])->name('admin.logout');

// Routes cho quản lý danh mục
Route::post('/admin/category/store', [AdminController::class, 'storeCategory'])->name('admin.category.store');
Route::put('/admin/category/{id}/update', [AdminController::class, 'updateCategory'])->name('admin.category.update');
Route::delete('/admin/category/{id}/delete', [AdminController::class, 'deleteCategory'])->name('admin.category.delete');

// Routes cho giảng viên
Route::get('/giangvien', [GiangVienController::class, 'index'])->name('giangvien.dashboard');
Route::get('/giangvien/login', [GiangVienController::class, 'showLoginForm'])->name('giangvien.showLoginForm');
Route::post('/giangvien/login', [GiangVienController::class, 'login'])->name('giangvien.login');
Route::get('/giangvien/register', [GiangVienController::class, 'showRegisterForm'])->name('giangvien.showRegisterForm');
Route::post('/giangvien/register', [GiangVienController::class, 'register'])->name('giangvien.register');
Route::get('/giangvien/logout', [GiangVienController::class, 'logout'])->name('giangvien.logout');

// CRUD Khoahoc
Route::post('/giangvien/khoahoc/create', [GiangVienController::class, 'createKhoahoc'])->name('giangvien.createKhoahoc');
Route::get('/giangvien/khoahoc/{id}/edit', [GiangVienController::class, 'editKhoahoc'])->name('giangvien.editKhoahoc');
Route::put('/giangvien/khoahoc/{id}/update', [GiangVienController::class, 'updateKhoahoc'])->name('giangvien.updateKhoahoc');
Route::get('/giangvien/khoahoc/{id}/delete', [GiangVienController::class, 'deleteKhoahoc'])->name('giangvien.deleteKhoahoc');

// CRUD BaiHoc
Route::get('/giangvien/khoahoc/{khoahoc_id}/baihoc', [GiangVienController::class, 'manageBaiHoc'])->name('giangvien.manageBaiHoc');
Route::post('/giangvien/khoahoc/{khoahoc_id}/baihoc/create', [GiangVienController::class, 'createBaiHoc'])->name('giangvien.createBaiHoc');
Route::get('/giangvien/khoahoc/{khoahoc_id}/baihoc/{baihoc_id}/edit', [GiangVienController::class, 'editBaiHoc'])->name('giangvien.editBaiHoc');
Route::post('/giangvien/khoahoc/{khoahoc_id}/baihoc/{baihoc_id}/update', [GiangVienController::class, 'updateBaiHoc'])->name('giangvien.updateBaiHoc');
Route::get('/giangvien/khoahoc/{khoahoc_id}/baihoc/{baihoc_id}/delete', [GiangVienController::class, 'deleteBaiHoc'])->name('giangvien.deleteBaiHoc');

// CRUD TaiLieu
Route::get('/giangvien/khoahoc/{khoahoc_id}/baihoc/{baihoc_id}/tailieu', [GiangVienController::class, 'manageTaiLieu'])->name('giangvien.manageTaiLieu');
Route::post('/giangvien/khoahoc/{khoahoc_id}/baihoc/{baihoc_id}/tailieu/create', [GiangVienController::class, 'createTaiLieu'])->name('giangvien.createTaiLieu');
Route::get('/giangvien/khoahoc/{khoahoc_id}/baihoc/{baihoc_id}/tailieu/{tailieu_id}/edit', [GiangVienController::class, 'editTaiLieu'])->name('giangvien.editTaiLieu');
Route::post('/giangvien/khoahoc/{khoahoc_id}/baihoc/{baihoc_id}/tailieu/{tailieu_id}/update', [GiangVienController::class, 'updateTaiLieu'])->name('giangvien.updateTaiLieu');
Route::get('/giangvien/khoahoc/{khoahoc_id}/baihoc/{baihoc_id}/tailieu/{tailieu_id}/delete', [GiangVienController::class, 'deleteTaiLieu'])->name('giangvien.deleteTaiLieu');

// CRUD BaiKiemTra
Route::get('/giangvien/baikiemtra/create', [GiangVienController::class, 'showCreateBaiKiemTraForm'])->name('giangvien.showCreateBaiKiemTraForm');
Route::post('/giangvien/baikiemtra/create', [GiangVienController::class, 'createBaiKiemTra'])->name('giangvien.createBaiKiemTra');

// Theo dõi học viên
Route::get('/giangvien/hocvien/monitor', [GiangVienController::class, 'monitorHocVien'])->name('giangvien.monitorHocVien');
Route::get('/giangvien/lambai/{id}/chitiet', [GiangVienController::class, 'viewChiTietLamBai'])->name('giangvien.viewChiTietLamBai');
Route::post('/giangvien/hoidap/{id}/reply', [GiangVienController::class, 'replyHoiDap'])->name('giangvien.replyHoiDap');

Route::get('/hocvien', [HocVienController::class, 'index']);
Auth::routes();

// Route cho đăng ký trong HocVienController
Route::post('/hocvien/register', [HocVienController::class, 'register'])->name('hocvien.register');
Route::post('/hocvien/login', [HocVienController::class, 'login'])->name('hocvien.login');
Route::get('/hocvien/logout', [HocVienController::class, 'logout'])->name('hocvien.logout');
Route::get('/hocvien/update', [HocVienController::class, 'showUpdateForm'])->name('hocvien.update');
Route::post('/hocvien/update', [HocVienController::class, 'update'])->name('hocvien.update.submit');
// Đổi tên route /home thành dashboard để tránh xung đột với route /
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('dashboard');