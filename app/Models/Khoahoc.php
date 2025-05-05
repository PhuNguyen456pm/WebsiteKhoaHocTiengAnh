<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Khoahoc extends Model
{
    public function danhMuc()
    {
        return $this->belongsTo(DanhMuc::class, 'id_danhmuc');
    }
    public function giangVien()
    {
        return $this->belongsTo(GiangVien::class, 'id_giangvien');
    }
    public function baiHocs()
    {
        return $this->hasMany(BaiHoc::class, 'id_khoahoc');
    }
    public function dangkykhoahocs()
    {
        return $this->hasMany(DangKyKhoahoc::class, 'id_khoahoc');
    }
}
