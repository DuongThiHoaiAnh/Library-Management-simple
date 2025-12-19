<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Sach;
use App\Models\PhieuMuonChiTiet;


class HomepageUserController extends Controller
{
    public function index()
    {
        //start
        $tongSach = Sach::sum('soLuong');

        $tongNguoiDung = DB::table('nguoi_dung')
            ->where('vaiTro', 'reader')
            ->count();

        $today = Carbon::today();
        $luotMuonHomNay = PhieuMuonChiTiet::whereDate('created_at', $today)->count();

        $sachDangMuon = PhieuMuonChiTiet::where('ghiChu', 'borrow')->count();

        //sach yeu thich
        $sachYeuThich = Sach::withCount('muonChiTiets')
            ->orderByDesc('muon_chi_tiets_count')
            ->take(4)
            ->get();

        return view('user.homepage-user', compact(
            'tongSach',
            'tongNguoiDung',
            'luotMuonHomNay',
            'sachDangMuon',
            'sachYeuThich'
        ));
    }
}
