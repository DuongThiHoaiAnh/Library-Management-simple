<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HelpController extends Controller
{
    public function index()
    {
        // Dữ liệu hướng dẫn tĩnh (hoặc bạn có thể lấy từ DB)
        $helps = [
            [
                'id' => 'borrow-book',
                'title' => 'Hướng dẫn mượn sách',
                'description' => 'Tìm hiểu cách tìm kiếm và mượn sách trực tuyến',
                'content' => '<iframe width="560" height="315" href="https://youtu.be/Sz_wWzgh-vQ?si=12lEHbb3j6BQORmy" frameborder="0" allowfullscreen></iframe>',
                'color' => 'blue'
            ],
            [
                'id' => 'account',
                'title' => 'Quản lý tài khoản',
                'description' => 'Cập nhật thông tin cá nhân và cài đặt bảo mật',
                'content' => '<p>Hướng dẫn chi tiết cập nhật thông tin cá nhân, đổi mật khẩu, bảo mật tài khoản...</p>',
                'color' => 'green'
            ],
            [
                'id' => 'payment',
                'title' => 'Thanh toán trực tuyến',
                'description' => 'Hướng dẫn thanh toán tiền phạt và phí dịch vụ',
                'content' => '<iframe width="560" height="315" href="https://youtu.be/QcuV8h_I1y0?si=evFkcklPE_1iMNWm" frameborder="0" allowfullscreen></iframe>',
                'color' => 'pink'
            ],
            [
                'id' => 'contact',
                'title' => 'Liên hệ hỗ trợ',
                'description' => 'Gửi yêu cầu hỗ trợ trực tiếp đến đội ngũ kỹ thuật',
                'content' => '<p><br>Email: support@example.com<br><br>Hotline: 1234 5678<br></p>',
                'color' => 'orange'
            ]
        ];

        return view('user.help-user', compact('helps'));
    }
}
