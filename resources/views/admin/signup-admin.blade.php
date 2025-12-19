<!DOCTYPE html>
<html lang="vi">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Đăng ký Quản trị viên</title>
  <link rel="stylesheet" href="{{ asset('css/signup-admin.css') }}">
  <link rel="stylesheet" href="{{ asset('css/header_homepage-admin.css') }}">
  <link rel="stylesheet" href="{{ asset('css/footer_login-admin.css') }}">
</head>

<body>
  <div class="page-container">

    {{-- Header --}}
    @include('admin.layouts.header-signup-admin')

    <main class="login-box">
      <div class="avatar">
        <div class="avatar-icon">
          <img src="{{ asset('images/iconstack.io - (People Fill).png') }}" alt="Quản trị viên logo" />
        </div>
      </div>

      <h1>Đăng ký<br />Quản Trị Viên</h1>
      <p class="desc">
        Tạo tài khoản quản trị viên mới để quản lý hệ thống
      </p>

      <form class="login-form" action="{{ route('admin.signup.submit') }}" method="POST">
        @csrf

        <label for="fullname">Họ và tên</label>
        <div class="input-box">
          <input type="text" name="hoTen" id="fullname" placeholder="Nhập họ và tên" required />
          @error('fullname')
          <span class="error" style="color: red; font-size: 0.875rem; font-weight: 500;">
            {{ $message }}
          </span>
          @enderror
        </div>

        <label for="email">Email</label>
        <div class="input-box">
          <input type="email" name="email" id="email" placeholder="Nhập email của bạn" required />
          @error('email')
          <span class="error" style="color: red; font-size: 0.875rem; font-weight: 500;">
            {{ $message }}
          </span>
          @enderror
        </div>

        <label for="phone">Số điện thoại</label>
        <div class="input-box">
          <input type="text" name="soDienThoai" id="phone" placeholder="Nhập số điện thoại" />
          @error('email')
          <span class="error" style="color: red; font-size: 0.875rem; font-weight: 500;">
            {{ $message }}
          </span>
          @enderror
        </div>

        <label for="address">Địa chỉ</label>
        <div class="input-box">
          <input type="text" name="diaChi" id="address" placeholder="Nhập địa chỉ" />
          @error('email')
          <span class="error" style="color: red; font-size: 0.875rem; font-weight: 500;">
            {{ $message }}
          </span>
          @enderror
        </div>

        <label for="password">Mật khẩu</label>
        <div class="input-box">
          <div class="password-wrapper">
            <input type="password" name="matKhau" id="password" placeholder="Nhập mật khẩu" required />
            <button type="button" class="pwd-toggle" aria-label="Hiện/ẩn mật khẩu">
              {{-- SVG Icon --}}
            </button>
          </div>
          @error('email')
          <span class="error" style="color: red; font-size: 0.875rem; font-weight: 500;">
            {{ $message }}
          </span>
          @enderror
        </div>

        <label for="confirm-password">Xác nhận mật khẩu</label>
        <div class="input-box">
          <div class="password-wrapper">
            <input type="password" name="matKhau_confirmation" id="confirm-password" placeholder="Nhập lại mật khẩu" required />
            <button type="button" class="pwd-toggle" aria-label="Hiện/ẩn mật khẩu">
              {{-- SVG Icon --}}
            </button>
          </div>
          @error('email')
          <span class="error" style="color: red; font-size: 0.875rem; font-weight: 500;">
            {{ $message }}
          </span>
          @enderror
        </div>

        <button type="submit" class="btn-login">Đăng ký</button>
      </form>
    </main>

    {{-- Footer --}}
    @include('admin.layouts.footer-homepage-admin')

  </div>
  <script src="{{ asset('js/password-toggle.js') }}"></script>
</body>

</html>