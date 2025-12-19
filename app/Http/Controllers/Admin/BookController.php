<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sach;
use App\Models\DanhMuc;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Helpers\FileHelper;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class BookController extends Controller
{
    // Hiển thị danh sách sách
    public function index()
    {
        $books = Sach::with('danhMuc')->get();
        $categories = DanhMuc::all();
        return view('admin.book-management-admin', compact('books', 'categories'));
    }

    // Thêm sách mới
    public function store(Request $request)
    {
        try {
            $currentYear = date('Y');

            $validator = Validator::make($request->all(), [
                'maSach' => 'required|string|max:50',
                'tenSach' => 'required|string|max:200',
                'tacGia' => 'nullable|string|max:200',
                'namXuatBan' => "nullable|integer|min:1000|max:$currentYear",
                'soLuong' => 'required|integer|min:0',
                'idDanhMuc' => 'required|exists:danh_muc,idDanhMuc',
                'moTa' => 'nullable|string',
                'vitri' => 'nullable|string|max:100',
                'anhBia' => 'nullable|image|mimes:jpg,jpeg,png,jfif,webp',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors()
                ], 422);
            }

            if (Sach::where('maSach', $request->maSach)
                ->orWhere('tenSach', $request->tenSach)
                ->exists()
            ) {
                return response()->json([
                    'success' => false,
                    'message' => '❌ Mã sách hoặc tên sách đã tồn tại'
                ], 409);
            }

            $book = new Sach();
            $book->maSach = $request->maSach;
            $book->tenSach = $request->tenSach;
            $book->tacGia = $request->tacGia;
            $book->namXuatBan = $request->namXuatBan;
            $book->soLuong = $request->soLuong;
            $book->idDanhMuc = $request->idDanhMuc;
            $book->moTa = $request->moTa;
            $book->vitri = $request->vitri;
            $book->trangThai = $request->soLuong == 0 ? 'unavailable' : 'available';

            if ($request->hasFile('anhBia')) {
                $file = $request->file('anhBia');

                if (!$file->isValid()) {
                    return response()->json([
                        'success' => false,
                        'message' => '❌ File ảnh không hợp lệ'
                    ], 422);
                }

                $fileName = Str::uuid() . '.' . $file->getClientOriginalExtension();
                $destination = public_path('images');

                if (!is_dir($destination)) {
                    mkdir($destination, 0755, true);
                }

                try {
                    $file->move($destination, $fileName);
                } catch (\Throwable $e) {
                    return response()->json([
                        'success' => false,
                        'message' => '❌ Không thể lưu ảnh bìa'
                    ], 500);
                }

                $book->anhBia = 'images/' . $fileName;
            }



            $book->save();

            app(\App\Http\Controllers\Admin\BorrowReturnController::class)
                ->notifyReservedUsers($book->idSach);

            return response()->json([
                'success' => true,
                'message' => '✅ Thêm sách thành công',
                'book' => $book
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Server error',
                'debug' => $e->getMessage()
            ], 500);
        }
    }

    // Cập nhật sách
    public function update(Request $request, $id)
    {
        $book = Sach::findOrFail($id);

        $request->validate([
            'tenSach' => 'required|string|max:200',
            'tacGia' => 'nullable|string|max:200',
            'namXuatBan' => 'nullable|digits:4|integer|max:' . date('Y'),
            'soLuong' => 'required|integer|min:0',
            'idDanhMuc' => 'required|exists:danh_muc,idDanhMuc',
            'moTa' => 'nullable|string',
            'vitri' => 'nullable|string|max:100',
            'anhBia' => 'nullable|image|mimes:jpg,jpeg,png|max:2048', // 2MB
        ]);

        $book->tenSach = $request->tenSach;
        $book->tacGia = $request->tacGia;
        $book->namXuatBan = $request->namXuatBan;
        $book->soLuong = $request->soLuong;
        $book->idDanhMuc = $request->idDanhMuc;
        $book->moTa = $request->moTa;
        $book->vitri = $request->vitri;
        $book->trangThai = ($request->soLuong == 0) ? 'unavailable' : 'available';

        // Xử lý upload ảnh vào public/images
        if ($request->hasFile('anhBia')) {
            $file = $request->file('anhBia');

            // Chuẩn hóa tên file
            $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $extension = $file->getClientOriginalExtension();
            $safeName = Str::slug($originalName) . '.' . $extension;

            $destination = public_path('images');
            if (!file_exists($destination)) {
                mkdir($destination, 0755, true);
            }

            $file->move($destination, $safeName);
            $book->anhBia = 'images/' . $safeName;
        } else {
            $book->anhBia = $request->anhBiaOld ?? $book->anhBia;
        }

        $book->save();

        if (class_exists(\App\Http\Controllers\Admin\BorrowReturnController::class)) {
            app(\App\Http\Controllers\Admin\BorrowReturnController::class)
                ->notifyReservedUsers($book->idSach);
        }

        return response()->json([
            'success' => true,
            'message' => '✅ Cập nhật sách thành công',
            'book' => $book
        ]);
    }

    // Xóa sách
    public function destroy($id)
    {
        $book = Sach::findOrFail($id);

        $reservationsCount = DB::table('dat_cho')
            ->where('idSach', $id)
            ->where('status', 'active')
            ->count();

        if ($reservationsCount > 0) {
            return response()->json([
                'success' => false,
                'message' => 'Không thể xóa sách này vì vẫn còn người đặt chỗ.'
            ]);
        }


        $activeBorrows = $book->muonChiTiets()
            ->where('ghiChu', 'borrow')
            ->whereIn('trangThaiCT', ['pending', 'approved'])
            ->whereNull('return_date')
            ->count();

        if ($activeBorrows > 0) {
            return response()->json([
                'success' => false,
                'message' => 'Không thể xóa sách này vì vẫn còn người mượn.'
            ]);
        }

        $book->delete();

        return response()->json([
            'success' => true,
            'message' => 'Đã xóa sách thành công.'
        ]);
    }
}
