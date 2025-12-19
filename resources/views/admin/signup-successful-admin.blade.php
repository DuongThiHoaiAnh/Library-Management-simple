<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Đăng ký Quản trị viên thành công</title>
  <link rel="stylesheet" href="{{ asset('css/signup_successful-admin.css') }}">
  <link rel="stylesheet" href="{{ asset('css/header_homepage-admin.css') }}">
  <link rel="stylesheet" href="{{ asset('css/footer_login-admin.css') }}">
</head>
<body>
  <div class="page-container">

    {{-- Header --}}
    @include('admin.layouts.header-signup-successful-admin')

    {{-- Success Box --}}
    <div class="success-box">
      <div class="success-bg"></div>
      <div class="success-text">Đăng ký tài khoản quản trị viên thành công</div>
      <div class="success-circle">
        <div class="avatar">
          <div class="avatar-icon">
            <img src="{{ asset('images/iconstack.io - (Ticktick)-green.png') }}" alt="Thành công" />
          </div>
        </div>
      </div>

      <a href="{{ url('/admin/homepage-admin') }}" class="btn-comeback">Quay lại trang chủ</a>
    </div>

    {{-- Footer --}}
    @include('admin.layouts.footer-homepage-admin')

  </div>
  <script src="{{ asset('js/password-toggle.js') }}"></script>
</body>
</html>
