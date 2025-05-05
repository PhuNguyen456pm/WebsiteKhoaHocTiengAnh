<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DapAn extends Model
{
    public function cauHoi()
    {
        return $this->belongsTo(CauHoi::class, 'id_cauhoi');
    }
    public function chitietlambaies()
    {
        return $this->hasMany(ChiTietLamBai::class, 'id_dapan');
    }
}
