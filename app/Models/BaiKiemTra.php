<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BaiKiemTra extends Model
{
    public function cauHois()
    {
        return $this->hasMany(CauHoi::class, 'id_baikiemtra');
    }
    public function lambaies()
    {
        return $this->hasMany(LamBai::class, 'id_baikiemtra');
    }
}
