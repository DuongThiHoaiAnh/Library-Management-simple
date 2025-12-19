<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\NguoiDung;
use App\Models\Sach;
use App\Models\PhieuMuonChiTiet;

class DashBoardController extends Controller
{
    public function dashboard()
    {
        $totalBooks = Sach::sum('soLuong');

        $totalReaders = NguoiDung::where('vaiTro', 'reader')->count();

        $booksBorrowed = PhieuMuonChiTiet::where('trangThaiCT', 'approved')
            ->whereRaw('LOWER(TRIM("ghiChu")) = ?', ['borrow'])
            ->whereNull('return_date')
            ->count();

        $booksAvailable = $totalBooks - $booksBorrowed;

        $booksOverdue = Sach::whereHas('muonChiTiets', function ($q) {
            $q->where('trangThaiCT', 'approved')
                ->whereRaw('LOWER(TRIM("ghiChu")) = ?', ['borrow'])
                ->whereNull('return_date')
                ->where('due_date', '<', now());
        })->count();

        $bookStatusData = [
            'Đang mượn' => $booksBorrowed,
            'Sẵn có' => $booksAvailable,
            'Quá hạn' => $booksOverdue
        ];


        $topBooks = Sach::withCount(['muonChiTiets as timesBorrowed' => function ($q) {
            $q->where('trangThaiCT', 'approved')
                ->whereRaw('LOWER(TRIM("ghiChu")) = ?', ['borrow'])
                ->whereNull('return_date');
        }])
            ->orderByDesc('timesBorrowed')
            ->take(5)
            ->get();

        $topBookLabels = $topBooks->pluck('tenSach');
        $topBookValues = $topBooks->pluck('timesBorrowed');


        $readers = DB::table('nguoi_dung')
            ->leftJoin('phieu_muon', 'nguoi_dung.idNguoiDung', '=', 'phieu_muon.idNguoiDung')
            ->leftJoin('phieu_muon_chi_tiet', function ($join) {
                $join->on('phieu_muon.idPhieuMuon', '=', 'phieu_muon_chi_tiet.idPhieuMuon')
                    ->whereRaw('"phieu_muon_chi_tiet"."trangThaiCT" = ?', ['approved'])
                    ->whereRaw('TRIM(LOWER("phieu_muon_chi_tiet"."ghiChu")) = ?', ['borrow'])
                    ->whereNull('phieu_muon_chi_tiet.return_date');
            })
            ->where('nguoi_dung.vaiTro', 'reader')
            ->select(
                'nguoi_dung.idNguoiDung',
                'nguoi_dung.hoTen',
                'nguoi_dung.email',
                'nguoi_dung.soDienThoai',
                DB::raw('COUNT(DISTINCT "phieu_muon_chi_tiet"."idPhieuMuonChiTiet") as "soSachDangMuon" ')
            )
            ->groupBy(
                'nguoi_dung.idNguoiDung',
                'nguoi_dung.hoTen',
                'nguoi_dung.email',
                'nguoi_dung.soDienThoai'
            )
            ->get();

        return view('admin.dashboard-admin', compact(
            'readers',
            'totalBooks',
            'totalReaders',
            'booksBorrowed',
            'bookStatusData',
            'topBookLabels',
            'topBookValues'
        ));
    }
}
