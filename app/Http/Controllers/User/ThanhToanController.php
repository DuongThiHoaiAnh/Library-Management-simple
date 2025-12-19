<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Phat;
use App\Models\ThongBao;

class ThanhToanController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $phats = Phat::with(['phieuMuonChiTiet.sach', 'phieuTra'])
            ->where('idNguoiDung', $user->idNguoiDung)
            ->where('trangThaiThanhToan', 'pending')
            ->get();

        return view('user.trangphat', compact('phats'));
    }

    public function contentThanhToan()
    {
        $user = Auth::user();
        $phats = Phat::with(['phieuMuonChiTiet.sach', 'phieuTra'])
            ->where('idNguoiDung', $user->idNguoiDung)
            ->where('trangThaiThanhToan', 'pending')
            ->get();

        return view('user.content-trangphat', compact('phats'));
    }

    public function xacNhanThanhToan(Request $request)
    {
        $user = Auth::user();

        $phuongThuc = $request->input('phuongThuc', 'chuyenkhoan');

        ThongBao::create([
            'idNguoiDung' => $user->idNguoiDung,
            'loaiThongBao' => "Phạt trễ hạn",
            'noiDung' => $phuongThuc === 'tienmat'
                ? 'Người dùng yêu cầu thanh toán tiền phạt tại quầy'
                : 'Người dùng yêu cầu thanh toán tiền phạt chuyển khoản',
            'thoiGianGui' => now(),
            'trangThai' => 'unread'
        ]);

        $message = $phuongThuc === 'tienmat'
            ? 'Đã gửi yêu cầu thanh toán tại quầy thành công!'
            : 'Đã gửi yêu cầu xác nhận thanh toán chuyển khoản thành công, vui lòng đợi!';

        return response()->json([
            'status' => 'success',
            'message' => $message
        ]);
    }
}
