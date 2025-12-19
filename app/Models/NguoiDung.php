<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use App\Models\DatCho;
use App\Models\PhieuMuon;
use App\Models\PhieuMuonChiTiet;
use Illuminate\Database\Eloquent\Factories\HasFactory;





class NguoiDung extends Authenticatable
{
    use Notifiable, HasFactory;

    protected $table = 'nguoi_dung';
    protected $primaryKey = 'idNguoiDung';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'hoTen',
        'email',
        'matKhau',
        'soDienThoai',
        'diaChi',
        'vaiTro',
        'ngayDangKy',
        'trangThai'
    ];

    protected $hidden = ['matKhau'];
    public $timestamps = true;

    public function phieuMuons(): HasMany
    {
        return $this->hasMany(PhieuMuon::class, 'idNguoiDung', 'idNguoiDung');
    }

    public function muonChiTiets()
    {
        return $this->hasManyThrough(
            PhieuMuonChiTiet::class,
            PhieuMuon::class,
            'idNguoiDung', 
            'idPhieuMuon',
            'idNguoiDung', 
            'idPhieuMuon'  
        )->with('sach', 'phieuMuon');
    }

    public function getSoSachDaMuonAttribute(): int
    {
        return $this->muonChiTiets()->count();
    }

    public function getSoSachDangMuonAttribute(): int
    {
        return $this->muonChiTiets()->where('trangThaiCT', 'borrowed')->count();
    }

    public function getAuthPassword()
    {
        return $this->matKhau;
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<DatCho>
     */
    public function datChos(): HasMany
    {
        return $this->hasMany(DatCho::class, 'idNguoiDung', 'idNguoiDung');
    }
}
