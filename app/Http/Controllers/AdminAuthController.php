<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\NguoiDung;
use App\Models\Sach;
use App\Models\PhieuMuon;

class AdminAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('admin.login-admin');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'matKhau' => 'required|string',
        ]);

        $user = NguoiDung::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->matKhau, $user->matKhau)) {
            return back()
                ->withInput($request->only('email')) 
                ->withErrors(['email' => 'Email hoặc mật khẩu không đúng.']);
        }

        // Kiểm tra quyền admin
        if ($user->vaiTro !== 'admin') {
            return back()
                ->withInput($request->only('email'))
                ->withErrors(['email' => 'Tài khoản này không có quyền truy cập quản trị viên.']);
        }

        // Đăng nhập thành công
        Auth::login($user);

        return redirect()->route('admin.homepage-admin');
    }


    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login-admin'); 
    }

    

    
}
