<!DOCTYPE html>
<html lang="vi">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Trung tâm hỗ trợ - Người dùng</title>

  <!-- CSS chung -->
  <link rel="stylesheet" href="{{ asset('css/styleguide.css') }}" />
  <link rel="stylesheet" href="{{ asset('css/globals.css') }}" />

  <link rel="stylesheet" href="{{ asset('css/header-info-user.css') }}">
  <link rel="stylesheet" href="{{ asset('css/footer_login-admin.css') }}">
  <link rel="stylesheet" href="{{ asset('css/help-user.css') }}">
</head>

<body>
  <div class="page-container">

    {{-- Include Header --}}
    @include('user.layouts.header-info-user')

    <section class="cta-section">
      <h2>Trung tâm hỗ trợ</h2>
      <p>Tìm câu trả lời cho mọi thắc mắc về hệ thống thư viện</p>
    </section>

    <section class="help-cards">
      <!-- Hướng dẫn mượn sách -->
      <div class="help-card" onclick="openHelp('borrow')">
        <div class="icon-circle blue">
          <svg xmlns="http://www.w3.org/2000/svg" width="40" height="50" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20" />
            <path d="M4 4h16v16H4z" />
          </svg>
        </div>
        <h3>Hướng dẫn mượn sách</h3>
        <p>Tìm hiểu cách tìm kiếm và mượn sách trực tuyến</p>
      </div>

      <!-- Quản lý tài khoản -->
      <div class="help-card" onclick="openHelp('account')">
        <div class="icon-circle green">
          <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="white">
            <path d="M15.5 7a3.5 3.5 0 1 1-7 0a3.5 3.5 0 0 1 7 0zM4 21a8 8 0 1 1 16 0H4z" stroke="white" stroke-width="2"></path>
          </svg>
        </div>
        <h3>Quản lý tài khoản</h3>
        <p>Cập nhật thông tin cá nhân và cài đặt bảo mật</p>
      </div>

      <!-- Thanh toán trực tuyến -->
      <div class="help-card" onclick="openHelp('payment')">
        <div class="icon-circle pink">
          <svg xmlns="http://www.w3.org/2000/svg" width="45" height="30" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <rect x="2" y="5" width="20" height="14" rx="2"></rect>
            <rect x="6" y="9" width="4" height="3" rx="0.5" />
            <line x1="2" y1="10" x2="22" y2="10" />
          </svg>
        </div>
        <h3>Thanh toán trực tuyến</h3>
        <p>Hướng dẫn thanh toán tiền phạt và phí dịch vụ</p>
      </div>

      <!-- Liên hệ hỗ trợ -->
      <div class="help-card" onclick="openHelp('contact')">
        <div class="icon-circle orange">
          <svg xmlns="http://www.w3.org/2000/svg" width="45" height="45" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M4 12a8 8 0 0 1 16 0" />
            <rect x="2" y="12" width="4" height="6" rx="2" />
            <rect x="18" y="12" width="4" height="6" rx="2" />
            <path d="M12 18v2a4 4 0 0 0 4 4h1" />
          </svg>
        </div>
        <h3>Liên hệ hỗ trợ</h3>
        <p>Gửi yêu cầu hỗ trợ trực tiếp đến đội ngũ kỹ thuật</p>
      </div>
    </section>

    <!-- Popup modal -->
    <div id="helpModal" style="display:none; position:fixed; top:50%; left:50%; transform:translate(-50%,-50%); background:#fff; padding:20px; max-width:90%; max-height:90%; overflow:auto; border-radius:10px; z-index:9999;">
      <span onclick="closeHelp()" style="cursor:pointer; position:absolute; top:10px; right:15px; font-size:24px;">&times;</span>
      <div id="modalContent"></div>
    </div>

    @include('user.layouts.footer-login-user')
  </div>

  {{-- Script --}}
  <script src="{{ asset('js/info-user-edit.js') }}"></script>
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

  <script>
    const helpContents = {
      borrow: '<a href="https://youtu.be/euT9loeZNUw?si=-yS8f0bigekzQhYT" target="_blank">Xem video hướng dẫn mượn sách</a>',
      account: '<p>Hướng dẫn cập nhật thông tin cá nhân và đổi mật khẩu...</p>',
      payment: '<a href="https://youtu.be/euT9loeZNUw?si=-yS8f0bigekzQhYT" target="_blank">Xem video hướng dẫn thanh toán</a>',
      contact: '<p><br>Email: hoaianh16022005@example.com<br><br>Hotline: 1234 5678<br></p>'
    };


    function openHelp(id) {
      const modal = document.getElementById('helpModal');
      document.getElementById('modalContent').innerHTML = helpContents[id] || '<p>Không có nội dung</p>';
      modal.style.display = 'block';
    }

    function closeHelp() {
      const modal = document.getElementById('helpModal');
      modal.style.display = 'none';
      document.getElementById('modalContent').innerHTML = '';
    }

    // Click ngoài modal để đóng
    window.onclick = function(event) {
      const modal = document.getElementById('helpModal');
      if (event.target === modal) closeHelp();
    }
  </script>

  <style>
    #helpModal::before {
      content: "";
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(240, 223, 255, 0.83);
      z-index: -1;
      border-radius: 10px;
    }

    #helpModal {
      display: none;
      position: fixed;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      background: #fff;
      padding: 30px 20px;
      max-width: 90%;
      max-height: 90%;
      overflow-y: auto;
      border-radius: 12px;
      box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
      z-index: 9999;
      transition: all 0.3s ease;
    }

    #helpModal span {
      cursor: pointer;
      position: absolute;
      top: 10px;
      right: 15px;
      font-size: 28px;
      color: #333;
      transition: color 0.2s;
    }

    #helpModal span:hover {
      color: #e74c3c;
    }

    #helpModal a {
      display: inline-block;
      margin: 10px 0;
      color: #3498db;
      text-decoration: none;
      font-weight: 500;
    }

    #helpModal a:hover {
      text-decoration: underline;
    }

    #helpModal iframe {
      width: 100%;
      height: 400px;
      border: none;
      border-radius: 8px;
    }
  </style>

  @include('partials.chat')
</body>

</html>