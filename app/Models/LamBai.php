<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LamBai extends Model
{
    use HasFactory;

    protected $table = 'lambai'; 
    protected $fillable = [
        'id_hocvien',
        'id_baikiemtra',
        'ngay_lambai',
        'thoigian_lambai',
        'diem',
    ];

    public $timestamps = false; 

    public function hocVien()
    {
        return $this->belongsTo(HocVien::class, 'id_hocvien');
    }
    public function baiKiemTra()
    {
        return $this->belongsTo(BaiKiemTra::class, 'id_baikiemtra');
    }
    public function chitietlambaies()
    {
        return $this->hasMany(ChiTietLamBai::class, 'id_lambai');
    }
}
