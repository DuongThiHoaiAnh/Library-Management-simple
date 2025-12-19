<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Thư viện Hiện đại - Người dùng</title>
  <link rel="stylesheet" href="{{ asset('css/homepage-login-user.css') }}">
  <link rel="stylesheet" href="{{ asset('css/header-homepage-lg-user.css') }}">
  <link rel="stylesheet" href="{{ asset('css/footer_login-admin.css') }}">
</head>
<body>
  <div class="page-container">

    <!-- Header -->
    <header class="header">
      <div class="max-header">
        <div class="header-left">
          <a href="{{ url('/user/homepage-login-user') }}" class="logo">
            <div class="logo-icon">
              <img src="{{ asset('images/iconstack.io - (Book).png') }}" alt="Thư viện Tri Thức logo" />
            </div>
            <div class="logo-text">Thư viện<br />Tri Thức</div>
          </a>

          <nav class="nav">
            <a href="{{ url('/user/homepage-login-user') }}" class="active">Trang chủ
              <img src="{{ asset('images/Homepage-icon-pirple.png') }}" alt="Trang chủ logo" />
            </a>
            <a href="#">Tra cứu sách
              <img src="{{ asset('images/iconstack.io - (Search).png') }}" alt="Tra cứu sách logo" />
            </a>
            <a href="#">Mượn/ Trả sách
              <img src="{{ asset('images/iconstack.io - (Book 2).png') }}" alt="Mượn/ Trả sách logo" />
            </a>
            <a href="#">Đặt chỗ
              <img src="{{ asset('images/iconstack.io - (Bookmark).png') }}" alt="Đặt chỗ logo" />
            </a>
            <a href="#">Lịch sử
              <img src="{{ asset('images/iconstack.io - (History).png') }}" alt="Lịch sử logo" />
            </a>
          </nav>
        </div>

        <div class="header-right">
          <div class="buttons">
            <a href="{{ url('/admin/login-admin') }}" class="btn admin">Quản Trị Viên</a>
            <a href="{{ url('/user/login-user') }}" class="btn login">Đăng nhập</a>
            <a href="{{ url('/user/signup-user') }}" class="btn signup">Đăng ký</a>
          </div>
        </div>
      </div>
    </header>
