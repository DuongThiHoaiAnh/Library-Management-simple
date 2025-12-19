<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PhieuMuonChiTiet extends Model
{
    protected $table = 'phieu_muon_chi_tiet';
    protected $primaryKey = 'idPhieuMuonChiTiet';
    protected $fillable = [
        'idPhieuMuon',
        'idSach',
        'borrow_date',
        'due_date',
        'trangThaiCT',
        'return_date',
        'ghiChu',
    ];


    public function phieuMuon()
    {
        return $this->belongsTo(PhieuMuon::class, 'idPhieuMuon', 'idPhieuMuon');
    }

    public function sach()
    {
        return $this->belongsTo(Sach::class, 'idSach', 'idSach');
    }

    public function getTrangThaiAttribute()
    {
        return $this->trangThaiCT; // hoặc tên cột trạng thái thực tế
    }

    public function getTenSachAttribute()
    {
        return $this->sach ? $this->sach->tenSach : null;
    }

    public function getNguoiMuonAttribute()
    {
        return $this->phieuMuon ? $this->phieuMuon->nguoiDung->hoTen : null;
    }

    public function getLoaiYeuCauAttribute()
    {
        return strpos($this->trangThaiCT, 'returned') !== false ? 'returned' : 'borrowed';
    }

    public function scopeBorrowedReaders($query)
    {
        return $query->where('ghiChu', 'borrow')
            ->whereHas('phieuMuon.nguoiDung', function ($q) {
                $q->where('vaiTro', 'reader');
            });
    }

    public function phats()
    {
        return $this->hasMany(Phat::class, 'idPhieuMuonChiTiet', 'idPhieuMuonChiTiet');
    }
}
