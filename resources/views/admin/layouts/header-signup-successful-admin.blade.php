<header class="header">
  <a href="{{ url('/admin/homepage-admin') }}" class="logo">
    <div class="logo-icon">
      <img src="{{ asset('images/iconstack.io - (Book).png') }}" alt="Thư viện Tri Thức logo" />
    </div>
    <div class="logo-text">Thư viện<br />Tri Thức</div>
  </a>

  <div class="buttons">
    <a href="{{ url('/admin/login-admin') }}" class="btn logout">ĐĂNG XUẤT</a>
    <a href="{{ url('/admin/dashboard-admin') }}" class="btn admin">QUẢN TRỊ VIÊN</a>
    <a href="{{ url('/admin/signup-admin') }}" class="btn signup-admin">ĐĂNG KÝ QUẢN TRỊ VIÊN</a>
  </div>
</header>
