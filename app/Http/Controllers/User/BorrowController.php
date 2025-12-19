<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\ThongBao;
use App\Models\Sach;
use App\Models\PhieuMuon;
use App\Models\PhieuMuonChiTiet;
use App\Models\DatCho;
use App\Models\NguoiDung;
use Illuminate\Support\Facades\Log;


class BorrowController extends Controller
{
    public function index(Request $request)
    {
        $activeTab = $request->query('tab', 'sachdangmuon');
        $user = Auth::user();

        if (!($user instanceof NguoiDung)) {
            abort(403, "Người dùng hiện tại không hợp lệ hoặc chưa đăng nhập đúng.");
        }

        $muonChiTiets = $muonChiTietsMoi = $datChos = collect();

        if ($activeTab === 'sachdangmuon') {
            $muonChiTiets = $user->muonChiTiets()
                ->where('trangThaiCT', 'borrowed')
                ->with('sach')
                ->get();
        }

        if ($activeTab === 'muonsachmoi') {
            $muonChiTietsMoi = $user->muonChiTiets()
                ->where('trangThaiCT', 'pending')
                ->with('sach')
                ->get();
        }

        if ($activeTab === 'datcho') {
            $datChos = $user->datChos()->with('sach')->get();
        }

        return view('user.trangmuontra(sachdangmuon)', [
            'activeTab' => $activeTab,
            'muonChiTiets' => $muonChiTiets,   // thêm dòng này
            'muonChiTietsMoi' => $muonChiTietsMoi,
            'datChos' => $datChos
        ]);
    }

    // Nội dung tab Sách đang mượn (AJAX)
    public function contentSachdangMuon()
    {
        $user = Auth::user();
        if (!($user instanceof NguoiDung)) {
            abort(403, "Người dùng hiện tại không hợp lệ hoặc chưa đăng nhập đúng.");
        }

        $muonChiTiets = $user->muonChiTiets()
            ->where('phieu_muon_chi_tiet.trangThaiCT', 'approved')
            ->where('phieu_muon_chi_tiet.ghiChu', 'borrow')
            ->with('sach', 'phieuMuon.nguoiDung')
            ->get();

        $soSachDangMuon = $muonChiTiets->count();

        $activeTab = 'sachdangmuon';
        $books = collect();
        return view('user.content-mtra-sachdangmuon', compact('muonChiTiets', 'soSachDangMuon', 'activeTab', 'books'));
    }

    public function contentMuonSachMoi()
    {
        $user = Auth::user();
        if (!($user instanceof NguoiDung)) {
            abort(403, "Người dùng không hợp lệ.");
        }

        $books = Sach::where('trangThai', 'available')->get();

        $activeTab = 'muonsachmoi';
        return view('user.content-mtra-muonsachmoi', compact('books', 'activeTab'));
    }


    public function returnBook($idChiTiet)
    {
        $user = Auth::user();

        if (!($user instanceof NguoiDung)) {
            return response()->json(['message' => 'Người dùng không hợp lệ hoặc chưa đăng nhập.'], 403);
        }

        $chiTiet = PhieuMuonChiTiet::with(['sach', 'phieuMuon'])
            ->where('idPhieuMuonChiTiet', $idChiTiet)
            ->whereHas('phieuMuon', function ($query) use ($user) {
                $query->where('idNguoiDung', $user->idNguoiDung);
            })
            ->first();

        if (!$chiTiet) {
            return response()->json(['message' => 'Không tìm thấy thông tin sách cần trả.'], 404);
        }

        $returnDate = now();
        $dueDate = Carbon::parse($chiTiet->due_date);
        $borrowDate = Carbon::parse($chiTiet->borrow_date);

        if ($returnDate->gt($dueDate)) {
            $soNgayTre = ceil($dueDate->diffInHours($returnDate) / 24);
            $soTienPhat = $soNgayTre * 5000;

            $phat = \App\Models\Phat::create([
                'idPhieuMuonChiTiet' => $chiTiet->idPhieuMuonChiTiet,
                'idNguoiDung' => $user->idNguoiDung,
                'soNgayTre' => $soNgayTre,
                'soTienPhat' => $soTienPhat,
                'trangThaiThanhToan' => 'pending',
                'ghiChu' => "Trả sách muộn {$soNgayTre} ngày."
            ]);

            Log::info("📘 Tạo phiếu phạt:", $phat->toArray());

            ThongBao::create([
                'idNguoiDung' => $user->idNguoiDung,
                'idSach' => $chiTiet->idSach,
                'loaiThongBao' => "Phạt trễ hạn",
                'noiDung' => "Bạn bị phạt {$soTienPhat} VNĐ vì trả sách '{$chiTiet->sach->tenSach}' trễ {$soNgayTre} ngày.",
                'thoiGianGui' => now(),
                'trangThai' => 'unread'
            ]);
        }

        // --- Cập nhật chi tiết phiếu mượn ---
        try {
            $chiTiet->update([
                'trangThaiCT' => 'pending',
                'ghiChu' => 'return',
                'return_date' => $returnDate,
            ]);
        } catch (\Throwable $e) {
            Log::error("❌ Lỗi update chi tiết phiếu mượn: " . $e->getMessage());
            return response()->json(['message' => 'Có lỗi xảy ra khi trả sách'], 500);
        }

        $phieuTra = \App\Models\PhieuTra::create([
            'idPhieuMuonChiTiet' => $chiTiet->idPhieuMuonChiTiet,
            'idNguoiDung' => $user->idNguoiDung,
            'idSach' => $chiTiet->idSach,
            'ngayTra' => $returnDate,
            'ngayMuon' => $borrowDate,
            'hanTra' => $dueDate,
            'trangThai' => 'pending',
            'ghiChu' => "Đang chờ xử lý.",
        ]);

        Log::info("📗 Tạo phiếu trả:", $phieuTra->toArray());

        // --- Thông báo ---
        ThongBao::create([
            'idNguoiDung' => $user->idNguoiDung,
            'idSach' => $chiTiet->idSach,
            'idPhieuMuon' => $chiTiet->phieuMuon->idPhieuMuon,
            'loaiThongBao' => "Thông báo trả sách",
            'noiDung' => "Bạn đã gửi yêu cầu trả sách '{$chiTiet->sach->tenSach}'.",
            'thoiGianGui' => now(),
            'trangThai' => 'unread'
        ]);

        return response()->json([
            'message' => 'Yêu cầu trả sách đã được gửi, vui lòng chờ quản trị viên duyệt.',
            'data' => [
                'phieuTra' => $phieuTra,
                'phat' => $phat ?? null
            ]
        ]);
    }





    // Nội dung tab Đặt chỗ (AJAX)
    public function contentDatCho()
    {
        $user = Auth::user();
        if (!($user instanceof NguoiDung)) {
            abort(403, "Người dùng hiện tại không hợp lệ hoặc chưa đăng nhập đúng.");
        }

        $datChos = $user->datChos()->with('sach')->get();

        return view('user.content-datcho', [
            'datChos' => $datChos,
            'activeTab' => 'datcho'
        ]);
    }

    // Action mượn sách
    public function borrow($idSach)
    {
        $user = Auth::user();
        $userId = $user->idNguoiDung;

        $hasUnpaidPhat = \App\Models\Phat::where('idNguoiDung', $userId)
            ->where('trangThaiThanhToan', '!=', 'paid')
            ->exists();

        if ($hasUnpaidPhat) {
            return response()->json([
                'success' => false,
                'message' => '❌ Bạn còn tiền phạt chưa duyệt thanh toán, không thể mượn sách mới.'
            ]);
        }

        $alreadyBorrowed = PhieuMuonChiTiet::whereHas('phieuMuon', function ($q) use ($userId) {
            $q->where('idNguoiDung', $userId);
        })->where('idSach', $idSach)
            ->whereIn('trangThaiCT', ['pending', 'approved'])
            ->where('ghiChu', 'borrow')
            ->whereNull('return_date')
            ->exists();

        if ($alreadyBorrowed) {
            return response()->json([
                'success' => false,
                'message' => '❌ Bạn đã mượn cuốn sách này rồi.'
            ]);
        }

        $today = Carbon::today();
        $dueDate = $today->copy()->addDays(14);

        DB::transaction(function () use ($userId, $idSach, $today, $dueDate, $user) {
            $phieuMuonId = DB::table('phieu_muon')->insertGetId([
                'idNguoiDung' => $userId,
                'ngayMuon' => $today,
                'hanTra' => $dueDate,
                'trangThai' => 'pending',
                'ghiChu' => "Phiếu mượn của {$user->hoTen}",
                'created_at' => now(),
                'updated_at' => now()
            ], 'idPhieuMuon');  

            DB::table('phieu_muon_chi_tiet')->insert([
                'idPhieuMuon' => $phieuMuonId,
                'idSach' => $idSach,
                'borrow_date' => $today,
                'due_date' => $dueDate,
                'trangThaiCT' => 'pending',
                'ghiChu' => 'borrow',
                'created_at' => now(),
                'updated_at' => now()
            ]);

            $sach = Sach::find($idSach);
            ThongBao::create([
                'idNguoiDung' => $userId,
                'idSach' => $idSach,
                'idPhieuMuon' => $phieuMuonId,
                'loaiThongBao' => 'borrow',
                'noiDung' => "Yêu cầu mượn sách {$sach->tenSach} đã được gửi, vui lòng chờ quản trị viên duyệt",
                'thoiGianGui' => now(),
                'trangThai' => 'unread'
            ]);
        });

        return response()->json([
            'success' => true,
            'message' => 'Yêu cầu mượn sách đã được gửi, vui lòng chờ quản trị viên duyệt.'
        ]);
    }

    // Action đặt chỗ
    public function reserve($idSach)
    {
        $user = Auth::user();
        $userId = $user->idNguoiDung;
        $today = Carbon::today();

        $alreadyReserved = DB::table('dat_cho')
            ->where('idNguoiDung', $userId)
            ->where('idSach', $idSach)
            ->where('status', 'active')
            ->exists();

        if ($alreadyReserved) {
            return response()->json([
                'success' => false,
                'message' => '❌ Bạn đã đặt chỗ sách này rồi.'
            ]);
        }

        $queueOrder = DB::table('dat_cho')->where('idSach', $idSach)->count() + 1;
        $expireDate = $today->copy()->addDays(14);

        $datChoId = DB::table('dat_cho')->insertGetId([
            'idNguoiDung' => $userId,
            'idSach' => $idSach,
            'ngayDat' => $today,
            'queueOrder' => $queueOrder,
            'status' => 'active',
            'thoiGianHetHan' => $expireDate,
            'created_at' => now(),
            'updated_at' => now()
        ], 'idDatCho');

        $sach = Sach::find($idSach);
        ThongBao::create([
            'idNguoiDung' => $userId,
            'idSach' => $idSach,
            'idDatCho' => $datChoId,
            'loaiThongBao' => 'reserve',
            'noiDung' => "Bạn đã đặt chỗ sách {$sach->tenSach} thành công! Hết hạn: {$expireDate->format('d/m/Y')}",
            'thoiGianGui' => now(),
            'trangThai' => 'unread'
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Bạn đã đặt chỗ sách thành công!'
        ]);
    }
}
