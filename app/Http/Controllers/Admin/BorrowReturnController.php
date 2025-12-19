<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PhieuMuonChiTiet;
use App\Models\ThongBao;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\PhieuTra;
use App\Models\Sach;
use App\Models\DatCho;

class BorrowReturnController extends Controller
{
    public function index(Request $request)
    {
        $query = PhieuMuonChiTiet::with(['phieuMuon.nguoiDung', 'sach'])
            ->whereHas('phieuMuon.nguoiDung', function ($q) {
                $q->where('vaiTro', 'reader');
            });

        // Lọc tìm kiếm
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('phieuMuon.nguoiDung', function ($q2) use ($search) {
                    $q2->where('hoTen', 'like', "%$search%");
                })
                    ->orWhereHas('sach', function ($q3) use ($search) {
                        $q3->where('tenSach', 'like', "%$search%");
                    })
                    ->orWhere('idPhieuMuon', 'like', "%$search%")
                    ->orWhere('trangThaiCT', 'like', "%$search%");
            });
        }

        $borrowReturns = $query->orderBy('created_at', 'desc')->get();

        return view('admin.borrow-return-management-admin', compact('borrowReturns'));
    }

    public function notifyReservedUsers($idSach)
    {
        $sach = Sach::findOrFail($idSach);

        $waitingReservations = DB::table('dat_cho')
            ->where('idSach', $idSach)
            ->where('status', 'active')
            ->orderBy('queueOrder')
            ->get();

        foreach ($waitingReservations as $datCho) {
            if ($sach->soLuong >= $datCho->queueOrder) {

                DB::table('dat_cho')->where('idDatCho', $datCho->idDatCho)
                    ->update(['status' => 'approved', 'updated_at' => now()]);

                ThongBao::create([
                    'idNguoiDung' => $datCho->idNguoiDung,
                    'idSach' => $idSach,
                    'idDatCho' => $datCho->idDatCho,
                    'loaiThongBao' => 'reserve-ready',
                    'noiDung' => "Sách {$sach->tenSach} đã có sẵn cho bạn mượn! Vui lòng thực hiện mượn trong thời gian sớm nhất.",
                    'thoiGianGui' => now(),
                    'trangThai' => 'unread'
                ]);
            } else {
                break;
            }
        }
    }

    // duyet muon sach
    public function approveBorrow($idChiTiet)
    {
        $chiTiet = PhieuMuonChiTiet::with(['phieuMuon.nguoiDung', 'sach'])->findOrFail($idChiTiet);

        if ($chiTiet->trangThaiCT !== 'pending') {
            return response()->json([
                'success' => false,
                'message' => 'Yêu cầu đã được xử lý trước đó.'
            ]);
        }

        $sach = $chiTiet->sach;
        $userId = $chiTiet->phieuMuon->idNguoiDung;

        if (!$sach) {
            return response()->json([
                'success' => false,
                'message' => 'Sách không tồn tại.'
            ]);
        }

        $datChos = DatCho::where('idSach', $sach->idSach)
            ->where('status', 'active')
            ->orderBy('created_at', 'asc')
            ->get();

        // $earlierReservation = $datChos->first(); 

        // if ($earlierReservation && $earlierReservation->idNguoiDung !== $userId) {
        //     $chiTiet->trangThaiCT = 'rejected';
        //     $chiTiet->save();

        //     ThongBao::create([
        //         'idNguoiDung' => $userId,
        //         'idSach' => $sach->idSach,
        //         'idPhieuMuon' => $chiTiet->idPhieuMuon,
        //         'loaiThongBao' => 'Thông báo mượn sách',
        //         'noiDung' => "Không thể duyệt mượn sách {$sach->tenSach} vì đã có người đặt chỗ trước bạn.",
        //         'thoiGianGui' => now(),
        //         'trangThai' => 'unread'
        //     ]);

        //     return response()->json([
        //         'success' => false,
        //         'message' => 'Không thể duyệt mượn vì sách đã có người đặt chỗ trước.'
        //     ]);
        // }

        if ($sach->soLuong <= 0) {
            $chiTiet->trangThaiCT = 'rejected';
            $chiTiet->save();

            ThongBao::create([
                'idNguoiDung' => $userId,
                'idSach' => $sach->idSach,
                'idPhieuMuon' => $chiTiet->idPhieuMuon,
                'loaiThongBao' => 'Thông báo mượn sách',
                'noiDung' => "Duyệt mượn sách {$sach->tenSach} thất bại vì sách đã hết. Phiếu đặt chỗ vẫn giữ nguyên.",
                'thoiGianGui' => now(),
                'trangThai' => 'unread'
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Không thể duyệt mượn vì sách đã hết. Phiếu đặt chỗ vẫn giữ nguyên.'
            ]);
        }

        DB::transaction(function () use ($chiTiet, $sach, $userId) {
            $chiTiet->trangThaiCT = 'approved';
            $chiTiet->save();

            $sach->soLuong = max(0, $sach->soLuong - 1);
            if ($sach->soLuong === 0) {
                $sach->trangThai = 'unavailable';
            }
            $sach->save();

            ThongBao::create([
                'idNguoiDung' => $userId,
                'idSach' => $sach->idSach,
                'idPhieuMuon' => $chiTiet->idPhieuMuon,
                'loaiThongBao' => 'Thông báo mượn sách',
                'noiDung' => "Yêu cầu mượn sách {$sach->tenSach} đã được duyệt thành công!",
                'thoiGianGui' => now(),
                'trangThai' => 'unread'
            ]);
        });

        return response()->json([
            'success' => true,
            'message' => 'Yêu cầu mượn đã được duyệt thành công.'
        ]);
    }


    //danh sach muon tra sach
    public function manageBorrowReturns(Request $request)
    {
        $query = PhieuMuonChiTiet::with(['phieuMuon.nguoiDung', 'sach'])
            ->whereHas('phieuMuon.nguoiDung', function ($q) {
                $q->where('vaiTro', 'reader');
            });

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('phieuMuon.nguoiDung', function ($q2) use ($search) {
                    $q2->where('hoTen', 'like', "%$search%");
                })
                    ->orWhereHas('sach', function ($q3) use ($search) {
                        $q3->where('tenSach', 'like', "%$search%");
                    })
                    ->orWhere('idPhieuMuon', 'like', "%$search%")
                    ->orWhere('trangThaiCT', 'like', "%$search%");
            });
        }

        if ($request->has('pending') && $request->pending == 1) {
            $query->where('trangThaiCT', 'pending');
        }

        $borrowReturns = PhieuMuonChiTiet::where('trangThaiCT', 'pending')
            ->with('phieuMuon', 'sach', 'phieuMuon.nguoiDung')
            ->get();
        return view('admin.borrow-return-management-admin', compact('borrowReturns'));
    }

    //duyet tra sach    
    public function approveReturn(Request $request, $idChiTiet)
    {
        $status = $request->input('trangThaiCT', 'approved');

        $chiTiet = PhieuMuonChiTiet::with(['phieuMuon.nguoiDung', 'sach'])->findOrFail($idChiTiet);

        if ($chiTiet->trangThaiCT !== 'pending') {
            return response()->json(['success' => false, 'message' => 'Yêu cầu đã được xử lý trước đó.']);
        }

        DB::transaction(function () use ($chiTiet, $status) {

            if ($chiTiet->ghiChu === 'return' && $status === 'approved') {

                PhieuTra::create([
                    'idPhieuMuonChiTiet' => $chiTiet->idPhieuMuonChiTiet,
                    'ngayTra' => Carbon::today(),
                    'trangThaiXuLy' => 'processed',
                    'ghiChu' => 'Đã xử lý'
                ]);

                if ($chiTiet->sach) {
                    $chiTiet->sach->soLuong += 1;

                    if ($chiTiet->sach->trangThai === 'unavailable') {
                        $chiTiet->sach->trangThai = 'available';
                    }

                    $chiTiet->sach->save();

                    $this->notifyReservedUsers($chiTiet->sach->idSach);
                }
            }

            $chiTiet->trangThaiCT = $status;
            $chiTiet->save();

            ThongBao::create([
                'idNguoiDung' => $chiTiet->phieuMuon->idNguoiDung,
                'idSach' => $chiTiet->idSach,
                'idPhieuMuon' => $chiTiet->idPhieuMuon,
                'loaiThongBao' => $chiTiet->ghiChu === 'borrow' ? 'Thông báo mượn sách' : 'Thông báo trả sách',
                'noiDung' => $status === 'approved' ?
                    "Yêu cầu trả sách {$chiTiet->sach->tenSach} đã được duyệt." :
                    "Yêu cầu trả sách {$chiTiet->sach->tenSach} đã bị từ chối.",
                'thoiGianGui' => now(),
                'trangThai' => 'unread'
            ]);
        });

        return response()->json(['success' => true, 'message' => 'Yêu cầu đã được cập nhật.']);
    }
}
