<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChiTietLamBai extends Model
{
    public function lamBai()
    {
        return $this->belongsTo(LamBai::class, 'id_lambai');
    }
    public function cauHoi()
    {
        return $this->belongsTo(CauHoi::class, 'id_cauhoi');
    }
    public function dapAn()
    {
        return $this->belongsTo(DapAn::class, 'id_dapan');
    }
}
