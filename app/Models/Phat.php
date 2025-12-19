<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Phat extends Model
{
    use HasFactory;

    protected $table = 'phat';

    protected $primaryKey = 'idPhat';

    protected $fillable = [
        'idPhieuTra',
        'idPhieuMuonChiTiet',
        'idNguoiDung',
        'soNgayTre',
        'soTienPhat',
        'trangThaiThanhToan',
        'ghiChu',
    ];

    public $timestamps = true;

    public function phieuTra()
    {
        return $this->belongsTo(PhieuTra::class, 'idPhieuTra', 'idPhieuTra');
    }

    public function phieuMuonChiTiet()
    {
        return $this->belongsTo(PhieuMuonChiTiet::class, 'idPhieuMuonChiTiet', 'idPhieuMuonChiTiet');
    }

    public function nguoiDung()
    {
        return $this->belongsTo(NguoiDung::class, 'idNguoiDung', 'idNguoiDung');
    }
}
