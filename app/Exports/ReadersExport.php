<?php

namespace App\Exports;

use App\Models\NguoiDung;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;




class ReadersExport implements FromCollection, WithHeadings
{
    /**
     * Lấy dữ liệu độc giả để xuất
     */
    public function collection()
    {
        return NguoiDung::select(
                'idNguoiDung',
                'hoTen',
                'email',
                'soDienThoai',
                'ngayDangKy'
            )
            ->where('vaiTro', 'reader')
            ->get();
    }

    /**
     * Đặt tiêu đề cột cho Excel
     */
    public function headings(): array
    {
        return [
            'Mã độc giả',
            'Họ tên',
            'Email',
            'Số điện thoại',
            'Ngày đăng ký',
        ];
    }
}
