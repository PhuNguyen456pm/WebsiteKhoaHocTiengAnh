<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Admin extends Authenticatable
{
    use HasFactory;

    protected $table = 'admin';
    protected $primaryKey = 'id_admin';
    protected $fillable = ['username_admin', 'password_admin', 'email_admin'];
    protected $hidden = ['password_admin'];
        // Tắt timestamps vì bảng admin không có cột created_at và updated_at
        public $timestamps = false;

    public function getAuthIdentifierName()
    {
        return 'id_admin';
    }

    public function getAuthPassword()
    {
        return $this->password_admin;
    }

    public function danhMucs()
    {
        return $this->hasMany(DanhMuc::class, 'id_admin');
    }
}