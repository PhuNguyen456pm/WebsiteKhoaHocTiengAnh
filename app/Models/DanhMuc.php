<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DanhMuc extends Model
{
    public function admin()
    {
        return $this->belongsTo(Admin::class, 'id_admin');
    }
    public function khoahocs()
    {
        return $this->hasMany(Khoahoc::class, 'id_danhmuc');
    }
}
