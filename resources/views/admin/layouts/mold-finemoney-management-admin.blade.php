<!DOCTYPE html>
<html lang="vi">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'Quản lý Admin')</title>

  <!-- CSS chung -->
  <link rel="stylesheet" href="{{ asset('css/mold-dashboard-admin.css') }}">
  <link rel="stylesheet" href="{{ asset('css/finemoney-management-admin.css') }}">
  <link rel="stylesheet" href="{{ asset('css/borrow-return-management-admin.css') }}">

  <!-- CSRF token cho AJAX -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  @stack('styles')
</head>

<body>
  <div class="container">

    <!-- Sidebar menu -->
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

      <!-- Menu -->
      <nav>
        <a href="{{ url('/admin/dashboard-admin') }}">
          <img src="{{ asset('images/iconstack.io - (Layout Dashboard)-black.png') }}" class="icon-img"> Dashboard
        </a>
        <a href="{{ url('/admin/book-management-admin') }}">
          <img src="{{ asset('images/iconstack.io - (Book 2)-black.png') }}" class="icon-img"> Quản lý sách
        </a>
        <a href="{{ url('/admin/category-management-admin') }}">
          <img src="{{ asset('images/thu-muc-black.png') }}" class="icon-img"> Quản lý danh mục
        </a>
        <a href="{{ url('/admin/reader-management-admin') }}">
          <img src="{{ asset('images/doc-gia-black.png') }}" class="icon-img"> Quản lý độc giả
        </a>
        <a href="{{ url('/admin/borrow-return-management-admin') }}">
          <img src="{{ asset('images/iconstack.io - (Exchange 01)-black.png') }}" class="icon-img"> Quản lý mượn/ trả
        </a>
        <a href="{{ url('/admin/finemoney-management-admin') }}" class="active">
          <img src="{{ asset('images/tien-phat-orange.png') }}" class="icon-img"> Quản lý phạt
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

      <!-- Content chính -->
      <section class="content">
        @yield('content')
      </section>

    </main>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', () => {
      const token = document.querySelector('meta[name="csrf-token"]')?.content;

      const popup = document.getElementById('confirmation-popup');
      const popupMessage = document.getElementById('popup-message');
      const popupClose = document.getElementById('popup-close');

      if (popupClose) popupClose.addEventListener('click', () => popup.style.display = 'none');

      function showPopup(message) {
        if (!popup || !popupMessage) return;
        popupMessage.textContent = message;
        popup.style.display = 'block';
        setTimeout(() => popup.style.display = 'none', 2000);
      }

      // Duyệt phiếu phạt
      function approveFine(id) {
        fetch(`/admin/fines/${id}/update-status`, {
            method: 'POST',
            headers: {
              'X-CSRF-TOKEN': token,
              'Accept': 'application/json',
              'Content-Type': 'application/json'
            },
            body: JSON.stringify({})
          })
          .then(res => res.json())
          .then(data => {
            showPopup(data.message);
            const row = document.getElementById(`row-${id}`);
            if (row) row.remove();
          })
          .catch(err => console.error(err));
      }

      // Gắn sự kiện duyệt cho các icon tick
      document.querySelectorAll('.icon-tick-fine').forEach(el => {
        const id = el.dataset.id;
        if (id) {
          el.addEventListener('click', () => approveFine(id));
        }
      });

      // Tìm kiếm trực tiếp
      const searchInput = document.querySelector('.search-input');
      if (searchInput) {
        searchInput.addEventListener('input', () => {
          const keyword = searchInput.value.trim().toLowerCase();
          const tableRows = document.querySelectorAll('.finemoney-table tbody tr');

          tableRows.forEach(row => {
            if (!row.dataset.id) return;

            const maPhieu = row.cells[0]?.textContent.toLowerCase() || "";
            const tenNguoi = row.cells[1]?.textContent.toLowerCase() || "";
            const tenSach = row.cells[2]?.textContent.toLowerCase() || "";

            const match = maPhieu.includes(keyword) || tenNguoi.includes(keyword) || tenSach.includes(keyword);
            row.style.display = match ? '' : 'none';
          });
        });
      }
    });
  </script>
</body>

</html>