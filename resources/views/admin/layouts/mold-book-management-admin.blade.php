<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>Quản lý sách - BookManagement</title>
  <link rel="stylesheet" href="{{ asset('css/mold-dashboard-admin.css') }}">
  <link rel="stylesheet" href="{{ asset('css/book-management-admin.css') }}">
</head>
<body>

<div class="container">
  <!-- Sidebar -->
  <aside class="sidebar">
    <div class="sidebar-title">
      <div class="avatar">
        <div class="avatar-icon">
          <img src="{{ asset('images/iconstack.io - (User Lock 01)-admin.png') }}" alt="Quản trị viên logo" />
        </div>
      </div>
      <span class="sidebar-text">Quản trị viên</span>
    </div>

    <nav>
      <a href="{{ url('/admin/dashboard-admin') }}">
        <img src="{{ asset('images/iconstack.io - (Layout Dashboard)-black.png') }}" class="icon-img" alt="Dashboard icon">
        Dashboard
      </a>
      <a href="{{ url('/admin/book-management-admin') }}" class="active">
        <img src="{{ asset('images/iconstack.io - (Book 2)-orange.png') }}" class="icon-edit-img" alt="Quản lý sách">
        Quản lý sách
      </a>
      <a href="{{ url('/admin/category-management-admin') }}">
        <img src="{{ asset('images/thu-muc-black.png') }}" class="icon-img" alt="Quản lý danh mục">
        Quản lý danh mục
      </a>
      <a href="{{ url('/admin/reader-management-admin') }}">
        <img src="{{ asset('images/doc-gia-black.png') }}" class="icon-img" alt="Quản lý độc giả">
        Quản lý độc giả
      </a>
      <a href="{{ url('/admin/borrow-return-management-admin') }}">
        <img src="{{ asset('images/iconstack.io - (Exchange 01)-black.png') }}" class="icon-img" alt="Quản lý mượn trả">
        Quản lý mượn/ trả
      </a>
      <a href="{{ url('/admin/finemoney-management-admin') }}">
        <img src="{{ asset('images/tien-phat-black.png') }}" class="icon-img" alt="Quản lý phạt">
        Quản lý phạt
      </a>
    </nav>
  </aside>

  <!-- Main content -->
  <main class="main">
    <!-- Header -->
    <header class="header">
      <div class="header-right">
        <span class="admin">
          <img src="{{ asset('images/icon-group-admin-greyblack.png') }}" alt="Admin icon"> Quản trị viên
        </span>
        <a href="{{ url('/admin/homepage-admin') }}" class="home">Trang chủ</a>
      </div>
    </header>

    <!-- Nội dung trang con sẽ được chèn ở đây -->
    <section class="dashboard-content">
      @yield('content')
    </section>

  </main>
</div>
@yield('scripts')

</body>
</html>

