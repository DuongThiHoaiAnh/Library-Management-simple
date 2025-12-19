<!DOCTYPE html>
<html lang="vi">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'Quản lý độc giả')</title>
  <link rel="stylesheet" href="{{ asset('css/category-management-admin.css') }}">

  <link rel="stylesheet" href="{{ asset('css/mold-dashboard-admin.css') }}">
  <link rel="stylesheet" href="{{ asset('css/reader-management-admin.css') }}">
</head>

<body>
  <div class="container">
    <!-- Thanh Menu -->
    <aside class="sidebar">
      <!-- Logo Admin -->
      <div class="sidebar-title">
        <div class="avatar">
          <div class="avatar-icon">
            <img src="{{ asset('images/iconstack.io - (User Lock 01)-admin.png') }}" alt="Quản trị viên logo" />
          </div>
        </div>
        <span class="sidebar-text">Quản trị viên</span>
      </div>

      <!-- Các Menu -->
      <nav>
        <a href="{{ url('/admin/dashboard-admin') }}">
          <img src="{{ asset('images/iconstack.io - (Layout Dashboard)-black.png') }}" alt="Dashboard icon" class="icon-img">
          Dashboard
        </a>
        <a href="{{ url('/admin/book-management-admin') }}">
          <img src="{{ asset('images/iconstack.io - (Book 2)-black.png') }}" alt="Quản lý sách" class="icon-edit-img">
          Quản lý sách
        </a>
        <a href="{{ url('/admin/category-management-admin') }}">
          <img src="{{ asset('images/thu-muc-black.png') }}" alt="Quản lý danh mục" class="icon-img">
          Quản lý danh mục
        </a>
        <a href="{{ url('/admin/reader-management-admin') }}" class="active">
          <img src="{{ asset('images/doc-gia-orange.png') }}" alt="Quản lý độc giả" class="icon-img">
          Quản lý độc giả
        </a>
        <a href="{{ url('/admin/borrow-return-management-admin') }}">
          <img src="{{ asset('images/iconstack.io - (Exchange 01)-black.png') }}" alt="Quản lý mượn trả" class="icon-img">
          Quản lý mượn/ trả
        </a>
        <a href="{{ url('/admin/finemoney-management-admin') }}">
          <img src="{{ asset('images/tien-phat-black.png') }}" alt="Quản lý phạt" class="icon-img">
          Quản lý phạt
        </a>
      </nav>
    </aside>

    <!-- Main content -->
    <main class="main">
      <header class="header">
        <div class="header-right">
          <span class="admin">
            <img src="{{ asset('images/icon-group-admin-greyblack.png') }}" alt="Admin icon"> Quản trị viên
          </span>
          <a href="{{ url('/admin/homepage-admin') }}" class="home">Trang chủ</a>
        </div>
      </header>

      <!-- Nội dung động -->
      @yield('content')
    </main>
  </div>

  @yield('scripts')
</body>

</html>