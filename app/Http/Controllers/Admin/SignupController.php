<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\NguoiDung;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class SignupController extends Controller
{
    // Hiển thị form signup (nếu muốn route riêng)
    public function showForm()
    {
        return view('admin.signup-admin');
    }

    // Xử lý submit form
    public function register(Request $request)
    {
        // Validate dữ liệu
        $validator = Validator::make($request->all(), [
            'hoTen' => 'required|string|max:100',
            'email' => 'required|email|unique:nguoi_dung,email',
            'soDienThoai' => 'nullable|regex:/^0\d{9}$/',
            'diaChi' => 'nullable|string|max:255',
            'matKhau' => 'required|string|min:6|confirmed', // confirmed để khớp matKhau_confirmation
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Tạo user mới
        NguoiDung::create([
            'hoTen' => $request->hoTen,
            'email' => $request->email,
            'soDienThoai' => $request->soDienThoai,
            'diaChi' => $request->diaChi,
            'vaiTro' => 'admin', // bắt buộc là admin
            'matKhau' => Hash::make($request->matKhau),
            'ngayDangKy' => now(),
            'trangThai' => 1,
        ]);

        return redirect()->route('admin.signup-successful-admin');
    }
}
