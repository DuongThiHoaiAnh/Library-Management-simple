<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DanhMuc;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class CategoryController extends Controller
{
    // Hiển thị danh sách danh mục
    public function index()
    {
        $categories = DanhMuc::all();
        return view('admin.category-management-admin', compact('categories'));
    }

    // Thêm danh mục mới
    public function store(Request $request)
    {
        $validated = $request->validate([
            'tenDanhMuc' => 'required|unique:danh_muc,tenDanhMuc',
            'moTa' => 'nullable|string'
        ]);

        $category = DanhMuc::create([
            'tenDanhMuc' => $validated['tenDanhMuc'],
            'moTa' => $validated['moTa'] ?? null
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Thêm danh mục thành công!',
            'category' => $category
        ]);
    }

    // Cập nhật danh mục
    public function update(Request $request, $id)
    {
        $category = DanhMuc::findOrFail($id);
        $request->validate([
            'tenDanhMuc' => 'required',
            'moTa' => 'nullable'
        ]);

        $category->update($request->only('tenDanhMuc', 'moTa'));
        return response()->json(['success' => true]);
    }

    public function destroy($id)
    {
        $category = DanhMuc::find($id);

        if (!$category) {
            return response()->json([
                'success' => false,
                'message' => 'Danh mục không tồn tại.'
            ]);
        }

        if ($category->sach()->count() > 0) {
            return response()->json([
                'success' => false,
                'message' => 'Không thể xóa danh mục vì vẫn còn sách liên quan.'
            ]);
        }

        $category->delete();

        return response()->json([
            'success' => true,
            'message' => 'Danh mục đã xóa thành công.'
        ]);
    }
}
