<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CauHoi extends Model
{
    public function baiKiemTra()
    {
        return $this->belongsTo(BaiKiemTra::class, 'id_baikiemtra');
    }
    public function dapAns()
    {
        return $this->hasMany(DapAn::class, 'id_cauhoi');
    }
    public function chitietlambaies()
    {
        return $this->hasMany(ChiTietLamBai::class, 'id_cauhoi');
    }
}
