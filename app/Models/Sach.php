<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\PhieuMuonChiTiet;
use App\Models\DanhMuc;

class Sach extends Model
{
    use HasFactory;

    protected $table = 'sach';
    protected $primaryKey = 'idSach';

    protected $fillable = [
        'maSach',
        'tenSach',
        'tacGia',
        'namXuatBan',
        'soLuong',
        'idDanhMuc',
        'moTa',
        'vitri',
        'trangThai',
        'anhBia',
    ];

    // Quan hệ với danh mục
    public function danhMuc()
    {
        return $this->belongsTo(DanhMuc::class, 'idDanhMuc', 'idDanhMuc');
    }

    // Quan hệ với bảng chi tiết phiếu mượn
    public function muonChiTiets()
    {
        return $this->hasMany(PhieuMuonChiTiet::class, 'idSach', 'idSach');
    }

    // Tính tổng số lần sách đã được mượn
    public function getSoLanMuonAttribute()
    {
        return $this->muonChiTiets()->count();
    }

    // Tính số sách đang mượn (trạng thái = borrowed)
    public function getSoDangMuonAttribute()
    {
        return $this->muonChiTiets()->where('trangThaiCT', 'borrowed')->count();
    }

    public function datChos()
    {
        return $this->hasMany(\App\Models\DatCho::class, 'idSach', 'idSach');
    }
}
