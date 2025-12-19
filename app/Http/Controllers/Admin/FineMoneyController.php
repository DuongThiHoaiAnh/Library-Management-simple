<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Phat;
use App\Models\ThongBao;

class FineMoneyController extends Controller
{
    /**
     * Trang quản lý tiền phạt
     */
    public function index(Request $request)
    {
        $query = Phat::with(['nguoiDung', 'phieuMuonChiTiet.sach'])
            ->where('soNgayTre', '>', 0)
            ->whereHas('nguoiDung', function ($q) {
                $q->where('vaiTro', '<>', 'admin');
            })
            ->whereHas('phieuMuonChiTiet');

        // Nếu có từ khóa tìm kiếm
        if ($request->has('search') && $request->search) {
            $keyword = strtolower(trim($request->search));
            $query->where(function ($q) use ($keyword) {
                $q->whereHas('nguoiDung', function ($q2) use ($keyword) {
                    $q2->whereRaw('LOWER("hoTen") LIKE ?', ["%{$keyword}%"]);
                })
                ->orWhereHas('phieuMuonChiTiet.sach', function ($q3) use ($keyword) {
                    $q3->whereRaw('LOWER("tenSach") LIKE ?', ["%{$keyword}%"]);
                })
                ->orWhereHas('phieuMuonChiTiet', function ($q4) use ($keyword) {
                    $q4->whereRaw('LOWER("idPhieuMuonChiTiet") LIKE ?', ["%{$keyword}%"]);
                });
            });
        }

        $fines = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('admin.finemoney-management-admin', compact('fines'));
    }

    /**
     * Duyệt phiếu phạt: chuyển trạng thái thành paid và gửi thông báo
     */
    public function approveFine(Request $request, $id)
    {
        $fine = Phat::with('nguoiDung')->find($id);

        if (!$fine) {
            return response()->json([
                'status' => 'error',
                'message' => 'Không tìm thấy phiếu phạt'
            ]);
        }

        if ($fine->trangThaiThanhToan !== 'pending') {
            return response()->json([
                'status' => 'error',
                'message' => 'Phiếu phạt này đã được xử lý'
            ]);
        }

        // Chuyển trạng thái thành paid
        $fine->trangThaiThanhToan = 'paid';
        $fine->save();

        // Gửi thông báo cho người dùng
        ThongBao::create([
            'idNguoiDung' => $fine->idNguoiDung,
            'loaiThongBao' => 'Phạt trễ hạn',
            'noiDung' => 'Xác nhận thanh toán tiền phạt thành công!',
            'thoiGianGui' => now(),
            'trangThai' => 'unread'
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Đã xác nhận thanh toán tiền phạt thành công!'
        ]);
    }

    /**
     * Từ chối phiếu phạt (nếu muốn)
     */
    public function rejectFine(Request $request, $id)
    {
        $fine = Phat::with('nguoiDung')->find($id);

        if (!$fine) {
            return response()->json([
                'status' => 'error',
                'message' => 'Không tìm thấy phiếu phạt'
            ]);
        }

        if ($fine->trangThaiThanhToan !== 'pending') {
            return response()->json([
                'status' => 'error',
                'message' => 'Phiếu phạt này đã được xử lý'
            ]);
        }

        // Chuyển trạng thái thành rejected
        $fine->trangThaiThanhToan = 'rejected';
        $fine->save();

        // Có thể gửi thông báo từ chối nếu muốn
        ThongBao::create([
            'idNguoiDung' => $fine->idNguoiDung,
            'loaiThongBao' => 'Phạt trễ hạn',
            'noiDung' => 'Yêu cầu thanh toán tiền phạt bị từ chối!',
            'thoiGianGui' => now(),
            'trangThai' => 'unread'
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Đã từ chối phiếu phạt!'
        ]);
    }
}
