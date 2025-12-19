<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\NguoiDung;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ReadersExport;
use Illuminate\Support\Facades\Log;


class ReaderController extends Controller
{
    /**
     * Hiển thị danh sách độc giả
     */
    public function index(Request $request)
    {
        $keyword = $request->input('keyword', '');
        $readers = NguoiDung::where('vaiTro', 'reader')
            ->when($keyword, function ($query, $keyword) {
                $query->where(function ($q) use ($keyword) {
                    $q->where('idNguoiDung', 'like', "%$keyword%")
                        ->orWhere('hoTen', 'like', "%$keyword%")
                        ->orWhere('email', 'like', "%$keyword%");
                });
            })
            ->orderBy('idNguoiDung', 'asc')
            ->get();

        return view('admin.reader-management-admin', compact('readers'));
    }

    /**
     * Reset mật khẩu độc giả
     */
    public function resetPassword($id)
    {
        $reader = NguoiDung::find($id);

        if (!$reader || $reader->vaiTro !== 'reader') {
            return response()->json([
                'success' => false,
                'message' => 'Độc giả không tồn tại.'
            ]);
        }

        // Reset mật khẩu về mặc định "12345678"
        $reader->matKhau = Hash::make('12345678');
        $reader->save();

        return response()->json([
            'success' => true,
            'message' => 'Đã đặt lại mật khẩu thành công. Mật khẩu mặc định: 12345678'
        ]);
    }

    /**
     * Xuất danh sách độc giả ra Excel
     */
    public function export()
    {
        return Excel::download(new ReadersExport, 'danh_sach_doc_gia.xlsx');
    }

    public function update(Request $request, $id)
    {
        try {
            $reader = NguoiDung::find($id);

            if (!$reader) {
                return response()->json([
                    'success' => false,
                    'message' => 'Không tìm thấy độc giả.'
                ], 404);
            }

            $reader->hoTen = $request->hoTen;
            $reader->email = $request->email;
            $reader->soDienThoai = $request->soDienThoai;
            $reader->save();

            return response()->json([
                'success' => true,
                'message' => 'Cập nhật thành công.'
            ]);
        } catch (\Exception $e) {
            Log::error('Lỗi cập nhật độc giả: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Lỗi server: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Xóa độc giả
     */
    public function destroy($id)
    {
        try {
            $reader = NguoiDung::find($id);

            if (!$reader || $reader->vaiTro !== 'reader') {
                return response()->json([
                    'success' => false,
                    'message' => 'Không tìm thấy độc giả hoặc không hợp lệ.'
                ], 404);
            }

            $reader->delete();

            return response()->json([
                'success' => true,
                'message' => 'Đã xóa độc giả thành công.'
            ]);
        } catch (\Exception $e) {
            Log::error('Lỗi xóa độc giả: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Lỗi server: ' . $e->getMessage()
            ], 500);
        }
    }
}
