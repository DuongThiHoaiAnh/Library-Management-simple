<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Đăng ký Người dùng thành công</title>
    <link rel="stylesheet" href="{{ asset('css/signup_successful-user.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/header_login-admin.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/footer_login-admin.css') }}" />
</head>
<body>
<div class="page-container">

  {{-- Header --}}
  @include('user.layouts.header-signup-successful-user')

  {{-- Success Message --}}
  <div class="success-box">
    <div class="success-bg"></div>
    <div class="success-text">Đăng ký tài khoản người dùng thành công</div>
    <div class="success-circle">
      <div class="avatar">
        <div class="avatar-icon">
          <img src="{{ asset('images/iconstack.io - (Ticktick)-green.png') }}" alt="Tick thành công" />
        </div>
      </div>
    </div>

    <a href="{{ url('user/homepage-login-user') }}" class="btn-comeback">Quay lại trang chủ</a>
  </div>

  {{-- Footer --}}
  @include('user.layouts.footer-login-user')

</div>

<script defer src="{{ asset('js/password-toggle.js') }}"></script>
<script>
  document.querySelectorAll('a[href="#"]').forEach(function(link) {
    link.addEventListener('click', function(event) {
      event.preventDefault();
      alert("⚠️ Bạn cần đăng nhập để sử dụng chức năng này!");
    });
  });
</script>



</body>
</html>
