<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use App\Models\NguoiDung;

class UserInfoController extends Controller
{
    
    public function show()
    {
        $user = Auth::user();

        if (!($user instanceof NguoiDung)) {
            abort(403, 'Người dùng không hợp lệ.');
        }

        return view('user.info-user', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        if (!($user instanceof NguoiDung)) {
            return response()->json(['message' => 'Người dùng không hợp lệ.'], 403);
        }

        $validated = $request->validate([
            'hoTen' => 'required|string|max:100',
            'soDienThoai' => 'nullable|regex:/^0\d{9}$/',
            'diaChi' => 'nullable|string|max:255',
        ]);

        try {
            $user->fill($validated);
            $user->save();

            Log::info('User updated profile', ['idNguoiDung' => $user->idNguoiDung]);

            return response()->json([
                'success' => true,
                'message' => 'Cập nhật thông tin thành công.',
                'user' => $user->only(['idNguoiDung','hoTen','email','soDienThoai','diaChi','vaiTro'])
            ]);
        } catch (\Throwable $e) {
            Log::error('Error updating user profile', [
                'idNguoiDung' => $user->idNguoiDung ?? null,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Có lỗi khi cập nhật thông tin. Vui lòng thử lại.'
            ], 500);
        }
    }

    // public function changePassword(Request $request)
    // {
    //     $user = Auth::user();

    //     if (!($user instanceof NguoiDung)) {
    //         return response()->json(['message' => 'Người dùng không hợp lệ.'], 403);
    //     }

    //     $validated = $request->validate([
    //         'current_password' => 'required|string',
    //         'new_password' => 'required|string|min:8|confirmed', // requires new_password_confirmation
    //     ]);

    //     if (!Hash::check($validated['current_password'], $user->matKhau)) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Mật khẩu hiện tại không đúng.'
    //         ], 422);
    //     }

    //     try {
    //         $user->matKhau = Hash::make($validated['new_password']);
    //         $user->save();

    //         Log::info('User changed password', ['idNguoiDung' => $user->idNguoiDung]);

    //         return response()->json([
    //             'success' => true,
    //             'message' => 'Đổi mật khẩu thành công.'
    //         ]);
    //     } catch (\Throwable $e) {
    //         Log::error('Error changing password', [
    //             'idNguoiDung' => $user->idNguoiDung ?? null,
    //             'error' => $e->getMessage()
    //         ]);

    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Có lỗi khi đổi mật khẩu. Vui lòng thử lại.'
    //         ], 500);
    //     }
    // }
}
