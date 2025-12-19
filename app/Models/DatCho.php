<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DatCho extends Model
{
    use HasFactory;

    protected $table = 'dat_cho';
    protected $primaryKey = 'idDatCho';

    protected $fillable = [
        'idNguoiDung',
        'idSach',
        'ngayDat',
        'status',
        'queueOrder',
        'thoiGianHetHan',
    ];

    public $timestamps = true;

    public function nguoiDung()
    {
        return $this->belongsTo(NguoiDung::class, 'idNguoiDung', 'idNguoiDung');
    }

    public function sach()
    {
        return $this->belongsTo(Sach::class, 'idSach', 'idSach');
    }
}
