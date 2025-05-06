<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Khoahoc extends Model
{
      // Khai báo rõ ràng tên bảng
      protected $table = 'khoahoc';

      // Khai báo khóa chính (nếu không phải là 'id')
      protected $primaryKey = 'id_khoahoc';
  
      // Tắt timestamps nếu bảng không có cột created_at và updated_at
      public $timestamps = false;
  
      // Khai báo các cột có thể fill
      protected $fillable = [
        'ten_khoahoc',
        'id_danhmuc',
        'id_giangvien',
        'mota_khoahoc',
        'hinhanh_khoahoc',
        'gia_khoahoc'
    ]; 
  
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
