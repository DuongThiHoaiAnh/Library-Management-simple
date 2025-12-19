<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class DanhMuc extends Model
{
    use HasFactory;

    protected $table = 'danh_muc';
    protected $primaryKey = 'idDanhMuc';
    // public $incrementing = false;
    // protected $keyType = 'string';

    protected $fillable = ['idDanhMuc', 'tenDanhMuc', 'moTa'];

    public function sach()
    {
        return $this->hasMany(Sach::class, 'idDanhMuc', 'idDanhMuc');
    }
}
