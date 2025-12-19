<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\PhieuMuonChiTiet;
use App\Models\PhieuMuon;
use App\Models\Sach;
use App\Models\DanhMuc;
use App\Models\Phat;
use App\Models\NguoiDung;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class HomepageLoginController extends Controller
{
    public function index()
    {
        $user = Auth::user();



        $danhMucs = DanhMuc::withCount('sach')->get();

        //start
        $tongSach = Sach::sum('soLuong');

        $tongNguoiDung = DB::table('nguoi_dung')
            ->where('vaiTro', 'reader')
            ->count();

        $today = Carbon::today();
        $luotMuonHomNay = PhieuMuonChiTiet::whereDate('created_at', $today)->count();

        $sachDangMuon = PhieuMuonChiTiet::where("ghiChu", 'borrow')->count();

        //sach yeu thich
        $sachYeuThich = Sach::withCount('muonChiTiets')
            ->orderByDesc('muon_chi_tiets_count')
            ->take(4)
            ->get();


        $tongPhieuMuon = PhieuMuon::count();
        
        $user = Auth::user();

        $tongPhat = 0;
        if ($user) {
            $tongPhat = Phat::where('idNguoiDung', $user->idNguoiDung)
                ->where('trangThaiThanhToan', 'pending')
                ->sum('soTienPhat');
        }


        $phieuMuonCuaToi = collect();
        if ($user) {
            $phieuMuonCuaToi = PhieuMuon::with(['chiTietPhieuMuon.sach'])
                ->where('idNguoiDung', $user->idNguoiDung)
                ->latest()
                ->take(5)
                ->get();
        }

        $sachMoi = Sach::latest()->take(6)->get();





        return view('user.homepage-login-user', [
            'user' => $user,
            'sachYeuThich' => $sachYeuThich,
            'sachMoi' => $sachMoi,
            'danhMucs' => $danhMucs,
            'tongSach' => $tongSach,
            'tongNguoiDung' => $tongNguoiDung,
            'tongPhieuMuon' => $tongPhieuMuon,
            'tongPhat' => $tongPhat,
            'phieuMuonCuaToi' => $phieuMuonCuaToi,
            'luotMuonHomNay' => $luotMuonHomNay,
            'sachDangMuon' => $sachDangMuon,
        ]);
    }
}
