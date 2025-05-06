<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DanhMuc extends Model
{
    use HasFactory;

    protected $table = 'danhmuc';
    protected $primaryKey = 'id_danhmuc';
    protected $fillable = ['ten_danhmuc', 'id_admin'];
    public $timestamps = false;
    public function admin()
    {
        return $this->belongsTo(Admin::class, 'id_admin');
    }
    public function khoahocs()
    {
        return $this->hasMany(Khoahoc::class, 'id_danhmuc');
    }
}
