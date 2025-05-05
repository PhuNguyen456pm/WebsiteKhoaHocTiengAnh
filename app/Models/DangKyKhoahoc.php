<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DangKyKhoahoc extends Model
{
    public function khoahoc()
    {
        return $this->belongsTo(Khoahoc::class, 'id_khoahoc');
    }
    public function hocVien()
    {
        return $this->belongsTo(HocVien::class, 'id_hocvien');
    }
}
