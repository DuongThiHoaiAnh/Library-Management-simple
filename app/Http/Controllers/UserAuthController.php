<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('user.login-user');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            if (Auth::user()->vaiTro === 'reader') {
                return redirect()->route('user.homepage-user');
            } else {
                Auth::logout();
                return back()->withErrors(['email' => 'Tài khoản này không có quyền truy cập vào khu vực người dùng.']);
            }
        }

        return back()->withErrors(['email' => 'Email hoặc mật khẩu không chính xác.']);
    }

    public function homepage()
    {
        return view('user.homepage-user');
    }

    public function logout(Request $request)
    {
        Auth::logout(); 

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('user.login');
    }


    public function showSignupForm()
    {
        return view('user.signup-user');
    }

    public function signup(Request $request)
    {
        $request->validate([
            'fullname' => 'required|string|max:100',
            'email' => 'required|email|unique:nguoi_dung,email',
            'phone' => 'nullable|regex:/^0\d{9}$/',
            'address' => 'nullable|string|max:255',
            'password' => 'required|string|min:6|confirmed', 
        ]);

        DB::table('nguoi_dung')->insert([
            'hoTen' => $request->fullname,
            'email' => $request->email,
            'soDienThoai' => $request->phone,
            'diaChi' => $request->address,
            'matKhau' => Hash::make($request->password),
            'vaiTro' => 'reader',
            'ngayDangKy' => now(),
            'trangThai' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('user.login')->with('success', 'Đăng ký thành công! Vui lòng đăng nhập để sử dụng hệ thống này.');
    }
}
