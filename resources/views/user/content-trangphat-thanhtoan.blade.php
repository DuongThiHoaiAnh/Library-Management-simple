<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thanh toán tiền phạt thành công - Thư viện Tri thức</title>

    {{-- CSS --}}
    <link rel="stylesheet" href="{{ asset('css/styleguide.css') }}">
    <link rel="stylesheet" href="{{ asset('css/globals.css') }}">
    <link rel="stylesheet" href="{{ asset('css/header-homepage-user.css') }}">
    <link rel="stylesheet" href="{{ asset('css/trangphat.css') }}">
    <link rel="stylesheet" href="{{ asset('css/trangphat-thanhtoan.css') }}">
    <link rel="stylesheet" href="{{ asset('css/footer_login-admin.css') }}">
</head>
<body>
    <div class="trang-pht">
        {{-- Header --}}
        @include('user.layouts.header-info-user')

        {{-- Nội dung thanh toán thành công --}}
        <div class="main-content">
            <div class="rectangle-da-thanh-toan">
                <img class="img-da-thanh-toan" src="{{ asset('images/tick-xanh-thanh-toan-done.png') }}" alt="Thanh toán thành công">
                
                <div class="text-da-thanh-toan">Thanh toán thành công!</div>

                <div class="ghi-chu-da-thanh-toan">
                    Tiền phạt của bạn đã được thanh toán thành công.<br>
                    Cảm ơn bạn đã sử dụng dịch vụ thư viện.
                </div>
                
                <a class="rectangle-xem-lich-su-thanh-toan ve-trang-chu" href="{{ url('homepage-user') }}">
                    <div class="text-xem-ls text-ve-trang-chu">Về trang chủ</div>
                </a>
            </div>
        </div>

        {{-- Footer --}}
        @include('user.layouts.footer-login-user')
    </div>

    @include('partials.chat')
</body>
</html>

<style>
.rectangle-da-thanh-toan {
    max-width: 500px;
    margin: 50px auto;
    text-align: center;
    padding: 30px;
    border-radius: 12px;
    background: #fff;
    box-shadow: 0 6px 18px rgba(0,0,0,0.1);
}
.img-da-thanh-toan {
    width: 100px;
    height: 100px;
    margin-bottom: 20px;
}
.text-da-thanh-toan {
    font-size: 24px;
    font-weight: bold;
    color: #28a745;
    margin-bottom: 10px;
}
.ghi-chu-da-thanh-toan {
    font-size: 16px;
    color: #555;
    margin-bottom: 25px;
}
.rectangle-xem-lich-su-thanh-toan {
    display: inline-block;
    padding: 12px 25px;
    border-radius: 8px;
    background-color: #007bff;
    color: #fff;
    text-decoration: none;
    font-weight: 500;
}
.rectangle-xem-lich-su-thanh-toan:hover {
    background-color: #0056b3;
}
</style>
