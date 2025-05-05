<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaiLieu extends Model
{
    public function baiHoc()
    {
        return $this->belongsTo(BaiHoc::class, 'id_baihoc');
    }
}
