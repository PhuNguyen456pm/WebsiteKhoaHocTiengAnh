<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaiLieu extends Model
{
    use HasFactory;

    protected $table = 'tailieu';

    protected $primaryKey = 'id_tailieu';

    protected $fillable = [
        'ten_tailieu',
        'id_baihoc',
        'file_tailieu',
    ];
            // Tắt timestamps vì bảng tailieu không có cột created_at và updated_at
            public $timestamps = false;
    public function baiHoc()
    {
        return $this->belongsTo(BaiHoc::class, 'id_baihoc');
    }
}
