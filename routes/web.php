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

Route::get('/', function () {
    return view('welcome');
})->name('home');

// Cấu hình route cho các controller để xử lý các yêu cầu từ người dùng và thao tác giao diện và backend
Route::get('/admin', [AdminController::class, 'index']);
Route::get('/giangvien', [GiangVienController::class, 'index']);
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