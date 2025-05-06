<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BaiHoc extends Model
{
    use HasFactory;

    protected $table = 'baihoc';

    protected $primaryKey = 'id_baihoc';

    protected $fillable = [
        'tieude_baihoc',
        'id_khoahoc',
        'noidung_baihoc',
        'thu_tu',
    ];
            // Tắt timestamps vì bảng baihoc không có cột created_at và updated_at
            public $timestamps = false;
    public function khoahoc()
    {
        return $this->belongsTo(Khoahoc::class, 'id_khoahoc');
    }
    public function taiLieus()
    {
        return $this->hasMany(TaiLieu::class, 'id_baihoc');
    }
}
