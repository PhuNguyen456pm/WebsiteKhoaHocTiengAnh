<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class HocVien extends Authenticatable
{
    use HasFactory;

    protected $table = 'hocvien';
    protected $primaryKey = 'id_hocvien';
    protected $fillable = ['username_hocvien', 'hoten_hocvien', 'email_hocvien', 'sodienthoai_hocvien', 'password_hocvien'];
    protected $hidden = ['password_hocvien'];
    // Tắt timestamps vì bảng hocvien không có cột created_at và updated_at
    public $timestamps = false;
    public function getAuthIdentifierName()
    {
        return 'id_hocvien';
    }

    public function getAuthPassword()
    {
        return $this->password_hocvien;
    }

    public function dangkykhoahocs()
    {
        return $this->hasMany(DangKyKhoahoc::class, 'id_hocvien');
    }

    public function lambaies()
    {
        return $this->hasMany(LamBai::class, 'id_hocvien');
    }

    public function hoidaps()
    {
        return $this->hasMany(HoiDap::class, 'id_hocvien');
    }
}