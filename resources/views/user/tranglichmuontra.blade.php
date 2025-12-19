<!-- resources/views/tranglichsumuontra.blade.php -->
<!DOCTYPE html>
<html lang="vi">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Lịch sử mượn trả - Người dùng</title>
  <link rel="stylesheet" href="{{ asset('css/globals.css') }}">
  <link rel="stylesheet" href="{{ asset('css/styleguide.css') }}">
  <link rel="stylesheet" href="{{ asset('css/header-homepage-user.css') }}">
  <link rel="stylesheet" href="{{ asset('css/tranglichsumuontra.css') }}">
  <link rel="stylesheet" href="{{ asset('css/footer_login-admin.css') }}">

</head>

<body>
  <div class="trang-lch-s-mn-tr">
    @include('user.layouts.header-tranglichsumuontra')

    <div class="body">
      <div class="group">
        <div class="group-2">
          <div class="text-wrapper">Lịch sử mượn trả</div>
          <p class="p">Xem lại toàn bộ lịch sử mượn trả và đặt chỗ của bạn</p>
        </div>
      </div>

      <div class="khoi-group3-4-14">
        <div class="max-group3-4-14">
          <div class="group-3">
            <div class="rectangle-2"></div>
            <div class="rectangle-3"></div>
            <div class="iconstack-io-book">
              <img src="{{ asset('images/iconstack.io - (Book 2) - white.png') }}" />
            </div>
            <div class="text-wrapper-2">{{ $tongMuon }}</div>
            <div class="text-wrapper-3">Tổng số lần mượn</div>
          </div>

          <div class="group-4">
            <div class="rectangle-4"></div>
            <div class="rectangle-5"></div>
            <div class="iconstack-io-book">
              <img src="{{ asset('images/iconstack.io - (Book 2) - white.png') }}" />
            </div>
            <div class="text-wrapper-2">{{ $daTra }}</div>
            <div class="text-wrapper-4">Đã trả</div>
          </div>

          <div class="group-14">
            <div class="rectangle-18"></div>
            <div class="rectangle-19"></div>
            <div class="text-wrapper-39">{{ number_format($tongPhat, 0, ',', '.') }}đ</div>
            <div class="text-wrapper-40">Tổng phạt</div>
            <div class="dollar-sign">
              <img class="icon" src="{{ asset('images/Dollar sign.png') }}" />
            </div>
          </div>
        </div>
      </div>

      <div id="main-content"></div>
    </div>

    @include('user.layouts.footer-login-user')
  </div>

  <script>
    function loadPage(page) {
      fetch(page)
        .then(response => response.text())
        .then(html => {
          document.getElementById("main-content").innerHTML = html;
        })
        .catch(error => console.error('Lỗi khi tải trang:', error));
    }

    window.onload = () => loadPage("{{ url('user/content-all-lsmn') }}");

    document.addEventListener("click", function(e) {
      if (e.target.closest(".group-6")) { // Lịch sử mượn trả
        e.preventDefault();
        loadPage("{{ url('user/content-all-lsmn') }}");
      }
      if (e.target.closest(".group-7")) { // Lịch sử đặt chỗ
        e.preventDefault();
        loadPage("{{ url('user/content-datcho') }}");
      }
    });

    document.addEventListener("click", function(e) {
      if (e.target.closest(".group-8")) { // Tất cả
        e.preventDefault();
        loadPage("{{ url('user/content-all-lsmn') }}");
      }
      if (e.target.closest(".group-9")) { // Đã trả
        e.preventDefault();
        loadPage("{{ url('user/content-datra-lsmn') }}");
      }
      if (e.target.closest(".group-10")) { // Đang mượn
        e.preventDefault();
        loadPage("{{ url('user/content-dangmuon-lsmn') }}");
      }
      if (e.target.closest(".group-11")) { // Trả trễ
        e.preventDefault();
        loadPage("{{ url('user/content-tratre-lsmn') }}");
      }
    });
  </script>

  <script>
    function togglePopup() {
      const popup = document.getElementById("userPopup");
      popup.style.display = popup.style.display === "block" ? "none" : "block";
    }

    window.onclick = function(event) {
      if (!event.target.closest(".user-box") && !event.target.closest("#userPopup")) {
        document.getElementById("userPopup").style.display = "none";
      }
    }
  </script>

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

    .trang-pht .rectangle-9 {
      left: 690px;
      width: 145px;
      background-color: #d7e8ff;
    }
  </style>

  @include('partials.chat')

</body>

</html>