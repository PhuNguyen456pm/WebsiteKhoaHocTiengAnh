<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DangKyKhoahoc extends Model
{
    protected $table = 'dangkykhoahoc';
    protected $primaryKey = ['id_khoahoc', 'id_hocvien'];
    public $incrementing = false;
    protected $fillable = [
        'thoigian_thanhtoan',
        'trangthai_thanhtoan',
        'phuongthuc_thanhtoan',
        'tong_tien',
        'id_khoahoc',
        'id_hocvien',
    ];
    
    public $timestamps = false;
    public function khoahoc()
    {
        return $this->belongsTo(Khoahoc::class, 'id_khoahoc');
    }
    public function hocVien()
    {
        return $this->belongsTo(HocVien::class, 'id_hocvien');
    }
}
