<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PhieuMuon extends Model
{
    protected $table = 'phieu_muon';
    protected $primaryKey = 'idPhieuMuon';

    public $incrementing = true;
    protected $keyType = 'int';
    protected $fillable = [
        'idNguoiDung',
        'ngayMuon',
        'hanTra',
        'trangThai',
        'ghiChu',
    ];

    public function nguoiDung()
    {
        return $this->belongsTo(NguoiDung::class, 'idNguoiDung', 'idNguoiDung');
    }

    public function chiTiets()
    {
        return $this->hasMany(PhieuMuonChiTiet::class, 'idPhieuMuon', 'idPhieuMuon');
    }

    public function chiTietPhieuMuon()
    {
        return $this->hasMany(PhieuMuonChiTiet::class, 'idPhieuMuon', 'idPhieuMuon');
    }
}
