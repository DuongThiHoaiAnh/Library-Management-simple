<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('nguoi_dung')->insert([
            'hoTen' => 'Quản trị viên 2',
            'email' => 'admin2@gmail.com',
            'matKhau' => Hash::make('123456'), // Mã hoá mật khẩu
            'soDienThoai' => '0900000000',
            'diaChi' => 'Hà Nội',
            'vaiTro' => 'admin',
            'ngayDangKy' => now()->toDateString(),
            'trangThai' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
