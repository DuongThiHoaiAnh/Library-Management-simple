<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ThongBao extends Model
{
    use HasFactory;

    protected $table = 'thong_bao';

    protected $primaryKey = 'idThongBao';

    protected $fillable = [
        'idNguoiDung',
        'idSach',
        'idPhieuMuon',
        'idPhat',
        'idDatCho',
        'idPhieuTra',
        'loaiThongBao',
        'noiDung',
        'thoiGianGui',
        'trangThai',
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

    public function phieuMuon()
    {
        return $this->belongsTo(PhieuMuon::class, 'idPhieuMuon', 'idPhieuMuon');
    }

    public function phieuTra()
    {
        return $this->belongsTo(PhieuTra::class, 'idPhieuTra', 'idPhieuTra');
    }

    public function phat()
    {
        return $this->belongsTo(Phat::class, 'idPhat', 'idPhat');
    }

    public function datCho()
    {
        return $this->belongsTo(DatCho::class, 'idDatCho', 'idDatCho');
    }
}
