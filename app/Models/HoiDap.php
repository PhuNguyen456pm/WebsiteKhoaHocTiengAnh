<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HoiDap extends Model
{
    public function giangVien()
    {
        return $this->belongsTo(GiangVien::class, 'id_giangvien');
    }
    public function hocVien()
    {
        return $this->belongsTo(HocVien::class, 'id_hocvien');
    }
}
