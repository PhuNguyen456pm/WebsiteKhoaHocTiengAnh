<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BaiHoc extends Model
{
    public function khoahoc()
    {
        return $this->belongsTo(Khoahoc::class, 'id_khoahoc');
    }
    public function taiLieus()
    {
        return $this->hasMany(TaiLieu::class, 'id_baihoc');
    }
}
