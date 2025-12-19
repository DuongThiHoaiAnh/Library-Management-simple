<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class SearchBookController extends Controller
{
    public function index(Request $request)
    {
        $query = DB::table('sach')
            ->join('danh_muc', 'sach.idDanhMuc', '=', 'danh_muc.idDanhMuc')
            ->select('sach.*', 'danh_muc.tenDanhMuc');

        if ($request->filled('q')) {
            $search = $request->q;
            $query->where(function($q) use ($search) {
                $q->where('sach.tenSach', 'like', "%{$search}%")
                  ->orWhere('sach.tacGia', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category')) {
            $query->where('sach.idDanhMuc', $request->category);
        }

        $books = $query->orderBy('tenSach', 'asc')->get();

        return view('user.search-book-user', compact('books'));
    }
}
