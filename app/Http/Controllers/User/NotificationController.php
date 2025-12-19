<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ThongBao;
use Illuminate\Support\Facades\Auth;


class NotificationController extends Controller
{
    /**
     * Đánh dấu thông báo là đã đọc
     */
    public function markAsRead($id)
    {
        $noti = ThongBao::find($id);
        if ($noti && $noti->trangThai === 'unread') {
            $noti->trangThai = 'read';
            $noti->save();
        }

        return response()->json(['success' => true]);
    }

    /**
     * Tùy chọn: lấy tất cả thông báo của người dùng
     */
    public function index()
    {
        $thongBaos = Auth::check()
            ? ThongBao::where('idNguoiDung', Auth::id())
            ->latest()
            ->get()
            : collect();

        return view('notifications.index', compact('thongBaos'));
    }
}
