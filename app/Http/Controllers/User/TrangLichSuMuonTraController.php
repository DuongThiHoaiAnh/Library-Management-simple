<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\NguoiDung;
use App\Models\PhieuMuonChiTiet;
use App\Models\DatCho;
use App\Models\Phat;

class TrangLichSuMuonTraController extends Controller
{
    /**
     * Trang chính lịch sử mượn trả
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        if (!($user instanceof NguoiDung)) {
            abort(403, "Người dùng không hợp lệ hoặc chưa đăng nhập.");
        }

        $tongMuon = $user->muonChiTiets()->count();

        $daTra = $user->muonChiTiets()
            ->where('trangThaiCT', 'approved')
            ->where('phieu_muon_chi_tiet.ghiChu', 'return')
            ->count();

        $user = Auth::user();

        $tongPhat = 0;
        if ($user) {
            $tongPhat = Phat::where('idNguoiDung', $user->idNguoiDung)
                ->where('trangThaiThanhToan', 'pending')
                ->sum('soTienPhat');
        }

        $activeTab = $request->query('tab', 'tatca');

        return view('user.tranglichmuontra', compact(
            'activeTab',
            'tongMuon',
            'daTra',
            'tongPhat'
        ));
    }

    /**
     * Nội dung tab "Tất cả"
     */
    public function contentAll()
    {
        $user = Auth::user();

        if (!($user instanceof NguoiDung)) {
            abort(403, "Người dùng hiện tại không hợp lệ hoặc chưa đăng nhập đúng.");
        }

        $muonChiTiets = $user->muonChiTiets()->with('sach')->get();
        $datChos = $user->datChos()->with('sach')->get();

        return view('user.content-all-lsmn', compact('muonChiTiets', 'datChos'));
    }

    /**
     * Nội dung tab "Đang mượn"
     */
    public function contentDangMuon()
    {
        $user = Auth::user();

        if (!($user instanceof NguoiDung)) {
            abort(403, "Người dùng hiện tại không hợp lệ hoặc chưa đăng nhập đúng.");
        }

        $muonChiTiets = $user->muonChiTiets()
            ->where('trangThaiCT', 'approved')
            ->where('phieu_muon_chi_tiet.ghiChu', 'borrow')
            ->with('sach')
            ->get();

        return view('user.content-dangmuon-lsmn', compact('muonChiTiets'));
    }

    /**
     * Nội dung tab "Đã trả"
     */
    public function contentDaTra()
    {
        $user = Auth::user();

        if (!($user instanceof NguoiDung)) {
            abort(403, "Người dùng hiện tại không hợp lệ hoặc chưa đăng nhập đúng.");
        }

        $muonChiTiets = $user->muonChiTiets()
            ->where('trangThaiCT', 'approved')
            ->where('phieu_muon_chi_tiet.ghiChu', 'return')
            ->with('sach')
            ->get();

        return view('user.content-datra-lsmn', compact('muonChiTiets'));
    }

    /**
     * Nội dung tab "Trả trễ"
     */
    public function contentTraTre()
    {
        $user = Auth::user();

        if (!($user instanceof NguoiDung)) {
            abort(403, "Người dùng hiện tại không hợp lệ hoặc chưa đăng nhập đúng.");
        }

        $muonChiTiets = $user->muonChiTiets()
            ->where('trangThaiCT', 'approved') 
            ->whereNotNull('return_date') 
            ->whereColumn('return_date', '>', 'due_date') 
            ->with(['sach', 'phieuMuon'])
            ->get();

        return view('user.content-tratre-lsmn', compact('muonChiTiets'));
    }

    /**
     * Nội dung tab "Đặt chỗ"
     */
    public function contentDatCho()
    {
        $user = Auth::user();

        if (!($user instanceof NguoiDung)) {
            abort(403, "Người dùng hiện tại không hợp lệ hoặc chưa đăng nhập đúng.");
        }

        $datChos = $user->datChos()
            ->with('sach')
            ->where('status', 'approved')
            ->get();

        return view('user.content-datcho', compact('datChos'));
    }
}
