<!DOCTYPE html>
<html lang="vi">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Thông tin cá nhân - Người dùng</title>

  {{-- CSS --}}
  <link rel="stylesheet" href="{{ asset('css/styleguide.css') }}">
  <link rel="stylesheet" href="{{ asset('css/globals.css') }}">
  <link rel="stylesheet" href="{{ asset('css/info-user.css') }}">
  <link rel="stylesheet" href="{{ asset('css/header-info-user.css') }}">
  <link rel="stylesheet" href="{{ asset('css/footer_login-admin.css') }}">
</head>

<body>
  <div class="page-container">
    {{-- Header --}}
    @include('user.layouts.header-info-user')

    <div class="title-box">
      <h2 class="main-title">Thông tin tài khoản</h2>
      <p class="sub-title">Quản lý thông tin cá nhân</p>
    </div>

    <div class="profile-card">
      <div class="profile-header">
        <h2>Thông tin cá nhân</h2>
        <button class="edit-btn" onclick="enableEdit()">
          <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M12 20h9" />
            <path d="M16.5 3.5a2.121 2.121 0 1 1 3 3L7 19l-4 1 1-4 12.5-12.5z" />
          </svg>
          Chỉnh sửa
        </button>
        <button class="save-btn" onclick="saveInfo()">
          <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path>
            <polyline points="17 21 17 13 7 13 7 21"></polyline>
            <polyline points="7 3 7 8 15 8"></polyline>
          </svg>
          Lưu
        </button>
      </div>

      <form id="userInfoForm">
        @csrf
        <div class="form-group">
          <label>Họ và tên</label>
          <div class="form-input">
            <input type="text" id="hoTen" name="hoTen" value="{{ $user->hoTen }}" disabled>
          </div>
        </div>

        <div class="form-group">
          <label>Số điện thoại</label>
          <div class="form-input">
            <input type="text" id="soDienThoai" name="soDienThoai" value="{{ $user->soDienThoai }}" disabled>
          </div>
        </div>

        <div class="form-group">
          <label>Email</label>
          <div class="form-input">
            <input type="email" id="email" name="email" value="{{ $user->email }}" disabled>
          </div>
        </div>

        <div class="form-group">
          <label>Địa chỉ</label>
          <div class="form-input">
            <input type="text" id="diaChi" name="diaChi" value="{{ $user->diaChi }}" disabled>
          </div>
        </div>
      </form>
    </div>

    {{-- Footer --}}
    @include('user.layouts.footer-login-user')
  </div>

  {{-- JS --}}
  <script>
    window.onload = function() {
      document.querySelector(".save-btn").style.display = "none";
    };

    function enableEdit() {
      document.querySelectorAll("#userInfoForm input").forEach(input => input.disabled = false);
      document.querySelector(".edit-btn").style.display = "none";
      document.querySelector(".save-btn").style.display = "inline-block";
    }

    async function saveInfo() {
      const form = document.getElementById("userInfoForm");

      document.querySelectorAll("#userInfoForm input").forEach(i => i.disabled = false);

      const formData = new FormData(form);

      try {
        const res = await fetch("{{ route('user.info.update') }}", {
          method: "POST",
          headers: {
            "X-CSRF-TOKEN": form.querySelector("[name=_token]").value,
            "Accept": "application/json"
          },
          body: formData
        });

        const data = await res.json().catch(() => ({}));

        if (!res.ok) {
          const msg = data.message || "❌ Có lỗi xảy ra. Vui lòng thử lại.";
          alert(msg);
          return;
        }

        alert(data.message || "✅ Cập nhật thông tin thành công!");

        document.querySelectorAll("#userInfoForm input").forEach(i => i.disabled = true);
        document.querySelector(".edit-btn").style.display = "inline-block";
        document.querySelector(".save-btn").style.display = "none";

      } catch (error) {
        console.error("Lỗi khi gửi yêu cầu:", error);
        alert("❌ Không thể kết nối đến máy chủ. Vui lòng thử lại.");
      }
    }
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
    popup-item.logout-ee {
      display: flex;
      align-items: center;
      gap: 15px;
      padding: 15px;
      cursor: pointer;

      padding-top: 22px;
      padding-bottom: 22px;
      border-color: #ffffffff;
      background-color: #fecdcdff;
      width: 300px;
      height: 86px;


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