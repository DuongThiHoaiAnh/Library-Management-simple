<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhieuTra extends Model
{
    use HasFactory;

    protected $table = 'phieu_tra';

    protected $primaryKey = 'idPhieuTra';

    protected $keyType = 'int';

    protected $fillable = [
        'idPhieuMuonChiTiet',
        'ngayTra',
        'trangThaiXuLy',
        'ghiChu',
    ];

    public $timestamps = true;

    public function phieuMuonChiTiet()
    {
        return $this->belongsTo(PhieuMuonChiTiet::class, 'idPhieuMuonChiTiet', 'idPhieuMuonChiTiet');
    }
}
