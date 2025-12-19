<!DOCTYPE html>
<html lang="vi">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Thanh toán tiền phạt - Thư viện Tri thức</title>

  <link rel="stylesheet" href="{{ asset('css/styleguide.css') }}">
  <link rel="stylesheet" href="{{ asset('css/globals.css') }}">
  <link rel="stylesheet" href="{{ asset('css/header-homepage-user.css') }}">
  <link rel="stylesheet" href="{{ asset('css/tranglichsumuontra-v2.css') }}">
  <link rel="stylesheet" href="{{ asset('css/trangphat.css') }}">
  <link rel="stylesheet" href="{{ asset('css/footer_login-admin.css') }}">
</head>

<body>
  <div class="trang-pht">
    {{-- Header --}}
    @include('user.layouts.header-info-user')

    {{-- Vùng chứa nội dung động --}}
    <div id="main-content-4"></div>

    {{-- Footer --}}
    @include('user.layouts.footer-login-user')
  </div>

  <script>
    function loadContent(route) {
      fetch(route)
        .then(response => response.text())
        .then(html => {
          document.getElementById('main-content-4').innerHTML = html;
        });
    }

    window.onload = () => loadContent("{{ route('user.content-trangphat') }}");

    document.addEventListener('click', function(e) {
      const thanhToanBtn = e.target.closest('.rectangle-thanh-toan');
      if (thanhToanBtn) {
        e.preventDefault();

        const activeMethod = document.querySelector('.khung-chung-sach-lch.thanh-toan.active');
        const phuongThuc = activeMethod.querySelector('.text-wrapper-8').textContent.includes('tiền mặt') ?
          'tienmat' : 'chuyenkhoan';

        fetch("{{ route('user.xac-nhan-thanh-toan') }}", {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
              'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            body: JSON.stringify({
              phuongThuc: phuongThuc
            })
          })
          .then(res => res.json())
          .then(data => {
            alert(data.message);
            loadContent("{{ route('user.content-trangphat') }}");
          });
      }
    });
  </script>

  <script>
    document.addEventListener('click', function(e) {
      const method = e.target.closest('.khung-chung-sach-lch.thanh-toan');
      if (method) {
        const allMethods = document.querySelectorAll('.khung-chung-sach-lch.thanh-toan');
        allMethods.forEach(m => {
          m.classList.remove('active');
          const img = m.querySelector('.circle-pick');
          if (img) img.src = "{{ asset('images/circle-gray.png') }}";
        });

        method.classList.add('active');
        const imgActive = method.querySelector('.circle-pick');
        if (imgActive) imgActive.src = "{{ asset('images/circle-active.png') }}";
      }
    });
  </script>

  <!-- nút thong bao -->
  <script>
    function toggleNotifications() {
      const popup = document.getElementById("notificationPopup");
      popup.classList.toggle("active");

      document.querySelectorAll('.notification-item.unread').forEach(item => {
        const id = item.dataset.id;
        fetch(`/notification/read/${id}`, {
          method: 'POST',
          headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
          }
        }).then(() => {
          item.classList.remove('unread');
        });
      });
    }
  </script>

  <!-- nút tài khoản -->
  <script>
    function togglePopup() {
      const popup = document.getElementById("userPopup");
      popup.style.display = popup.style.display === "block" ? "none" : "block";
    }

    window.onclick = function(event) {
      if (!event.target.closest('.user-box') && !event.target.closest('#userPopup')) {
        document.getElementById("userPopup").style.display = "none";
      }
    }
  </script>

  <style>
    /* popup thông báo */
    .notification-popup {
      display: none;
      position: absolute;
      top: 60px;
      right: 80px;
      width: 320px;
      max-height: 450px;
      overflow-y: auto;
      background: #fff;
      border-radius: 12px;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
      padding: 15px;
      z-index: 999;
      transition: all 0.3s ease;
    }

    .notification-popup.active {
      display: block;
    }

    .notification-popup .popup-header {
      font-size: 18px;
      font-weight: bold;
      margin-bottom: 15px;
      border-radius: 15px;
      border-bottom: 1px solid #d1d5db;
      padding-bottom: 8px;
      text-align: center;
      color: #333;
    }

    .notification-list {
      list-style: none;
      margin: 0;
      padding: 0;
    }

    .notification-item {
      padding: 10px 12px;
      border-radius: 10px;
      border-bottom: 1px solid #eee;
      font-size: 14px;
      line-height: 1.4;
      background-color: #fff;
      margin-bottom: 8px;
      transition: background 0.2s ease;
    }

    .notification-item.unread {
      background-color: #fdf6e3;
      font-weight: 600;
    }

    .notification-item small {
      display: block;
      color: #555;
      font-size: 12px;
      margin-top: 2px;
    }

    .notification-item .time {
      display: block;
      color: #999;
      font-size: 11px;
      margin-top: 4px;
    }

    .notification-item:hover {
      background-color: #f5f5f5;
      cursor: default;
    }

    .no-noti {
      text-align: center;
      color: #777;
      padding: 20px 0;
      font-size: 14px;
    }


    /* nút logout */
    .popup-item.logout-ee {
      display: flex;
      align-items: center;
      gap: 15px;
      padding: 15px;
      cursor: pointer;

      padding-top: 22px;
      padding-bottom: 22px;
      border-color: #ffffffff;
      background-color: #fecdcdff;
      width: 100%;

    }

    .popup-item.logout-ee .icon-popup img {
      width: 32px;
      height: 32px;
      object-fit: contain;
    }

    .popup-item.logout-ee strong {
      color: red;
      font-size: 18px;
      font-weight: 700;
      display: block;
      margin-bottom: 2px;
    }

    .popup-item.logout-ee p {
      color: red;
      margin-top: 2px;
      font-size: 14px;
    }

    .popup-item.logout-ee:hover {
      background-color: #ffe1e1ff;
      transform: translateY(-1px);
    }
  </style>

  @include('partials.chat')

</body>

</html>