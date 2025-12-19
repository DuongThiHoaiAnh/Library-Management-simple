<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use App\Models\NguoiDung;

class UserSettingController extends Controller
{
    public function showChangePasswordForm()
    {
        return view('user.setting-user');
    }

    public function changePassword(Request $request)
    {
        $user = Auth::user();

        if (!($user instanceof NguoiDung)) {
            return response()->json(['success' => false, 'message' => 'Người dùng không hợp lệ.'], 403);
        }

        $validated = $request->validate([
            'current_password' => 'required|string',
            'new_password' => 'required|string|min:6|confirmed',
        ], [
            'current_password.required' => 'Vui lòng nhập mật khẩu hiện tại.',
            'new_password.required' => 'Vui lòng nhập mật khẩu mới.',
            'new_password.min' => 'Mật khẩu mới phải ít nhất 6 ký tự.',
            'new_password.confirmed' => 'Xác nhận mật khẩu mới không khớp.',
        ]);

        if (!Hash::check($validated['current_password'], $user->matKhau)) {
            return response()->json([
                'success' => false,
                'message' => '❌ Mật khẩu hiện tại không đúng.'
            ], 422);
        }

        try {
            $user->matKhau = Hash::make($validated['new_password']);
            $user->save();

            Log::info('User changed password', ['idNguoiDung' => $user->idNguoiDung]);

            // Logout và redirect
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            // Trả về URL login để JS redirect
            return response()->json([
                'success' => true,
                'message' => '✅ Đổi mật khẩu thành công. Vui lòng đăng nhập lại.',
                'redirect' => route('user.login')
            ]);
        } catch (\Throwable $e) {
            Log::error('Error changing password', [
                'idNguoiDung' => $user->idNguoiDung ?? null,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => '❌ Có lỗi khi đổi mật khẩu. Vui lòng thử lại.'
            ], 500);
        }
    }
}
