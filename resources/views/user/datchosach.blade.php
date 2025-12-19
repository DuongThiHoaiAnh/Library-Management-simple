{{-- datchosach.blade.php --}}
<!DOCTYPE html>
<html>

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta charset="utf-8" />
  <title>Đặt chỗ sách - Người dùng</title>

  <link rel="stylesheet" href="{{ asset('css/styleguide.css') }}" />
  <link rel="stylesheet" href="{{ asset('css/globals.css') }}" />
  <link rel="stylesheet" href="{{ asset('css/header-homepage-user.css') }}" />
  <link rel="stylesheet" href="{{ asset('css/tranglichsumuontra.css') }}" />
  <link rel="stylesheet" href="{{ asset('css/datchosach.css') }}" />
  <link rel="stylesheet" href="{{ asset('css/footer_login-admin.css') }}">
</head>

<body>
  <div class="trang-lch-s-mn-tr">
    @include('user.layouts.header-datchosach')
    <div class="body">
      <div class="group">
        <div class="group-2">
          <div class="text-wrapper">Đặt chỗ sách</div>
          <p class="p">Đặt trước những cuốn sách yêu thích khi chúng đang được mượn</p>
        </div>
      </div>

      <div id="main-content-2"></div>
    </div>

    @include('user.layouts.footer-login-user')
  </div>



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


  <script>
    document.addEventListener('DOMContentLoaded', () => {
      const mainContent = document.getElementById("main-content-2");

      fetch("{{ url('user/content-datchosach') }}", {
          credentials: 'same-origin'
        })
        .then(res => res.text())
        .then(html => mainContent.innerHTML = html);

      document.addEventListener('click', function(e) {
        const tab = e.target.closest('a[data-url]');
        if (!tab) return;
        e.preventDefault();

        fetch(tab.dataset.url, {
            credentials: 'same-origin'
          })
          .then(res => res.text())
          .then(html => mainContent.innerHTML = html);

        document.querySelectorAll('a[data-url]').forEach(el => el.classList.remove('active'));
        tab.classList.add('active');
      });
    });
  </script>

  <script>
    document.addEventListener('DOMContentLoaded', () => {
      const mainContent = document.getElementById('main-content-2'); 

      function cancelDatCho(e) {
        const btn = e.target.closest('.rectangle-huy-dat-cho');
        if (!btn) return;

        const khung = btn.closest('.khung-chung-sach-lch');
        const datChoId = khung.dataset.idDatcho;

        if (!confirm("Bạn có chắc muốn hủy đặt chỗ này?")) return;

        fetch(`/user/datchosach/cancel/${datChoId}`, {
            method: 'POST',
            headers: {
              'X-CSRF-TOKEN': '{{ csrf_token() }}',
              'Accept': 'application/json',
              'Content-Type': 'application/json'
            }
          })
          .then(res => res.json())
          .then(data => {
            alert(data.message);
            khung.remove(); 
          })
          .catch(err => {
            console.error(err);
            alert("Có lỗi xảy ra, vui lòng thử lại.");
          });
      }

      function reserveSach(e) {
        const btn = e.target.closest('.rectangle-muon-ngay');
        if (!btn) return;

        const khung = btn.closest('.khung-chung-sach-lch');
        const sachId = khung.dataset.idSach;

        fetch(`/user/datchosach/reserve/${sachId}`, {
            method: 'POST',
            headers: {
              'X-CSRF-TOKEN': '{{ csrf_token() }}',
              'Accept': 'application/json',
              'Content-Type': 'application/json'
            }
          })
          .then(res => res.json())
          .then(data => {
            alert(data.message);

            // const statusDiv = khung.querySelector('.text-wrapper-12');
            // statusDiv.textContent = `Vị trí mới trong hàng chờ`;
            // statusDiv.className = 'text-wrapper-12 vi-tri-hang-cho';

            // const muonNgayBtn = khung.querySelector('.rectangle-muon-ngay');
            // if (muonNgayBtn) muonNgayBtn.remove();
          })
          .catch(err => {
            console.error(err);
            alert("Có lỗi xảy ra, vui lòng thử lại.");
          });
      }

      // Event delegation trên container
      mainContent.addEventListener('click', (e) => {
        cancelDatCho(e);
        reserveSach(e);
      });

      // Load mặc định tab "Đặt chỗ của tôi"
      fetch("{{ url('user/content-datchosach') }}", {
          credentials: 'same-origin'
        })
        .then(res => res.text())
        .then(html => mainContent.innerHTML = html);
    });
  </script>

  @include('partials.chat')

</body>

</html>