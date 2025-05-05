<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GiangVien extends Authenticatable
{
    use HasFactory;

    protected $table = 'giangvien';
    protected $primaryKey = 'id_giangvien';
    protected $fillable = ['hoten_giangvien', 'email_giangvien', 'sodienthoai_giangvien', 'password_giangvien'];
    protected $hidden = ['password_giangvien'];
        // Tắt timestamps vì bảng giangvien không có cột created_at và updated_at
        public $timestamps = false;

    public function getAuthIdentifierName()
    {
        return 'id_giangvien';
    }

    public function getAuthPassword()
    {
        return $this->password_giangvien;
    }

    public function khoahocs()
    {
        return $this->hasMany(Khoahoc::class, 'id_giangvien');
    }

    public function hoidaps()
    {
        return $this->hasMany(HoiDap::class, 'id_giangvien');
    }
}