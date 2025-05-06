<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HoiDap extends Model
{
    use HasFactory;

    protected $table = 'hoidap'; // Chỉ định tên bảng

    protected $fillable = [
        'id_hocvien',
        'id_giangvien',
        'noidung_hoidap',
        'ngaytao_hoidap',
        'noidung_traloi',
        'ngaytao_traloi',
    ];

    public $timestamps = false; // Tắt timestamps

    public function giangVien()
    {
        return $this->belongsTo(GiangVien::class, 'id_giangvien');
    }
    public function hocVien()
    {
        return $this->belongsTo(HocVien::class, 'id_hocvien');
    }
}
