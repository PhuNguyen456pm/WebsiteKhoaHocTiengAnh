<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LamBai extends Model
{
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
