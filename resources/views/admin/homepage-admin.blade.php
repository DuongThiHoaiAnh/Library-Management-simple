<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Trang chủ Quản trị viên</title>

  {{-- CSS --}}
  <link rel="stylesheet" href="{{ asset('css/homepage-admin.css') }}" />
  <link rel="stylesheet" href="{{ asset('css/header_homepage-admin.css') }}" />
  <link rel="stylesheet" href="{{ asset('css/footer_login-admin.css') }}" />
</head>
<body>
<div class="page-container">

  {{-- Header --}}
  @include('admin.layouts.header-homepage-admin')

  {{-- Hero Section --}}
  <section class="hero-bg">
    <h1>Chào mừng đến với<br><span>Thư viện Hiện đại</span></h1>
    <p>Khám phá kho tàng tri thức với hàng nghìn đầu sách đa dạng.
    <br />Mượn sách, đặt chỗ và quản lý thông tin một cách dễ dàng.</p>
  </section>

  {{-- Stats Section --}}
  <section class="stats-container">
    <div class="stat-box-tongsosach">
      <div class="stat-icon"><img src="{{ asset('images/iconstack.io - (Book 2)-white.png') }}" alt=""></div>
      <div class="stat-number">15,420</div>
      <div class="stat-title">Tổng số sách</div>
    </div>
    <div class="stat-box-docgiadangky">
      <div class="stat-icon"><img src="{{ asset('images/iconstack.io - (User Circle)-bold-white.png') }}" alt=""></div>
      <div class="stat-number">2,847</div>
      <div class="stat-title">Độc giả đăng ký</div>
    </div>
    <div class="stat-box-luotmuonhomnay">
      <div class="stat-icon"><img src="{{ asset('images/iconstack.io - (Book)-white.png') }}" alt=""></div>
      <div class="stat-number">1,234</div>
      <div class="stat-title">Lượt mượn hôm nay</div>
    </div>
    <div class="stat-box-sachdangmuon">
      <div class="stat-icon"><img src="{{ asset('images/iconstack.io - (Calendar)-bold-white.png') }}" alt=""></div>
      <div class="stat-number">89</div>
      <div class="stat-title">Sách đang mượn</div>
    </div>
  </section>

  {{-- Features Section --}}
  <section class="features-section">
    <h2>Tính năng nổi bật</h2>
    <p>Hệ thống quản lý thư viện với đầy đủ tính năng hiện đại, giúp bạn có trải nghiệm tốt nhất</p>

    <div class="features-grid">
      <div class="feature-box">
        <div class="feature-icon"><img src="{{ asset('images/iconstack.io - (Search)-thin-white.png') }}"></div>
        <div class="feature-title">Tra cứu sách</div>
        <div class="feature-desc">Tìm kiếm sách theo tên, tác giả, thể loại một cách nhanh chóng và chính xác</div>
      </div>
      <div class="feature-box">
        <div class="feature-icon"><img src="{{ asset('images/iconstack.io - (Book 2)-thin-white.png') }}"></div>
        <div class="feature-title">Mượn/Trả sách</div>
        <div class="feature-desc">Quản lý việc mượn và trả sách dễ dàng, theo dõi hạn trả</div>
      </div>
      <div class="feature-box">
        <div class="feature-icon"><img src="{{ asset('images/iconstack.io - (Bookmark)-thin-white.png') }}"></div>
        <div class="feature-title">Đặt chỗ</div>
        <div class="feature-desc">Đặt trước những cuốn sách yêu thích khi chúng đang được đọc</div>
      </div>
      <div class="feature-box">
        <div class="feature-icon"><img src="{{ asset('images/iconstack.io - (History)-thin-white.png') }}"></div>
        <div class="feature-title">Lịch sử</div>
        <div class="feature-desc">Xem lịch sử mượn trả và theo dõi tình trạng</div>
      </div>
    </div>
  </section>

  {{-- Footer --}}
  @include('admin.layouts.footer-homepage-admin')

</div>
</body>
</html>
