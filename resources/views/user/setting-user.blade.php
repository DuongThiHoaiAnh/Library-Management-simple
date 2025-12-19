<!DOCTYPE html>
<html lang="vi">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Đổi mật khẩu - Người dùng</title>

  {{-- CSRF Token --}}
  <meta name="csrf-token" content="{{ csrf_token() }}">

  {{-- CSS --}}
  <link rel="stylesheet" href="{{ asset('css/styleguide.css') }}">
  <link rel="stylesheet" href="{{ asset('css/globals.css') }}">
  <link rel="stylesheet" href="{{ asset('css/setting-user.css') }}">
  <link rel="stylesheet" href="{{ asset('css/header-info-user.css') }}">
  <link rel="stylesheet" href="{{ asset('css/footer_login-admin.css') }}">
</head>

<body>
  <div class="page-container">
    {{-- Header --}}
    @include('user.layouts.header-info-user')

    {{-- Main --}}
    <div class="title-box">
      <h2 class="main-title">Đổi mật khẩu</h2>
      <p class="sub-title">Đổi mật khẩu cho tài khoản của bạn</p>
    </div>

    <div class="change-pw-container">
      {{-- Form đổi mật khẩu --}}
      <form id="changePasswordForm" method="POST" action="{{ route('user.setting-user.change-password') }}">
        @csrf
        <div class="change-password-container">
          <div class="title">
            <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 24 24"
              fill="none" stroke="#3259E5" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <circle cx="7.5" cy="7.5" r="3.5"></circle>
              <path d="M10 10l5 5"></path>
              <path d="M15 15l2 2"></path>
              <path d="M17 17l2-2"></path>
            </svg>
            Đổi mật khẩu
          </div>

          <div class="form-group">
            <label>Mật khẩu hiện tại</label>
            <div class="password-wrapper">
              <i>
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                  viewBox="0 0 24 24" aria-hidden="true">
                  <g fill="none" stroke="#888888" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M7 10V7a5 5 0 0 1 10 0v3" />
                    <rect x="5" y="10" width="14" height="11" rx="2" />
                    <circle cx="12" cy="15.5" r="1.5" fill="#888888" />
                  </g>
                </svg>
              </i>

              <input type="password" name="current_password" id="current_password" placeholder="Nhập mật khẩu hiện tại" required>
              <button type="button" class="pwd-toggle" aria-label="Hiện/ẩn mật khẩu">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                  xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                  <path d="M2 12s4-7 10-7 10 7 10 7-4 7-10 7S2 12 2 12z"
                    stroke="#333" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round" />
                  <circle cx="12" cy="12" r="3"
                    stroke="#333" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
              </button>
            </div>
          </div>

          <div class="form-group">
            <label>Mật khẩu mới</label>
            <div class="password-wrapper">
              <i>
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                  viewBox="0 0 24 24" aria-hidden="true">
                  <g fill="none" stroke="#888888" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M7 10V7a5 5 0 0 1 10 0v3" />
                    <rect x="5" y="10" width="14" height="11" rx="2" />
                    <circle cx="12" cy="15.5" r="1.5" fill="#888888" />
                  </g>
                </svg>
              </i>

              <input type="password" name="new_password" id="new_password" placeholder="Nhập mật khẩu mới" required>
              <button type="button" class="pwd-toggle" aria-label="Hiện/ẩn mật khẩu">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                  xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                  <path d="M2 12s4-7 10-7 10 7 10 7-4 7-10 7S2 12 2 12z"
                    stroke="#333" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round" />
                  <circle cx="12" cy="12" r="3"
                    stroke="#333" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
              </button>
            </div>
          </div>

          <div class="form-group">
            <label>Xác nhận mật khẩu mới</label>
            <div class="password-wrapper">
              <i>
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                  viewBox="0 0 24 24" aria-hidden="true">
                  <g fill="none" stroke="#888888" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M7 10V7a5 5 0 0 1 10 0v3" />
                    <rect x="5" y="10" width="14" height="11" rx="2" />
                    <circle cx="12" cy="15.5" r="1.5" fill="#888888" />
                  </g>
                </svg>
              </i>

              <input type="password" name="new_password_confirmation" id="new_password_confirmation" placeholder="Xác nhận lại mật khẩu mới" required>
              <button type="button" class="pwd-toggle" aria-label="Hiện/ẩn mật khẩu">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                  xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                  <path d="M2 12s4-7 10-7 10 7 10 7-4 7-10 7S2 12 2 12z"
                    stroke="#333" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round" />
                  <circle cx="12" cy="12" r="3"
                    stroke="#333" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
              </button>
            </div>
          </div>

          <button class="login-btn" type="submit">Đổi mật khẩu</button>
          <div class="message" id="messageBox"></div>
        </div>
      </form>
    </div>

    {{-- Footer --}}
    @include('user.layouts.footer-login-user')
  </div>

  {{-- Scripts --}}
  <!-- <script>
    const form = document.getElementById('changePasswordForm');
    console.log('Form:', form);
    form?.addEventListener('submit', function(e) {
      e.preventDefault();
      alert('Đổi mật khẩu thành công ✅');
    });
  </script> -->
  <script src="{{ asset('js/password-toggle.js') }}"></script>
  <script>
    document.getElementById('changePasswordForm').addEventListener('submit', async function(e) {
      e.preventDefault();

      const form = e.target;
      const data = new FormData(form);
      const messageBox = document.getElementById('messageBox');

      const oldPassword = form.querySelector('input[name="current_password"]').value.trim();
      const newPassword = form.querySelector('input[name="new_password"]').value.trim();
      const confirmPassword = form.querySelector('input[name="new_password_confirmation"]').value.trim();

      messageBox.textContent = '';
      messageBox.className = 'message';

      if (newPassword === oldPassword) {
        messageBox.textContent = '⚠️ Mật khẩu mới không được trùng với mật khẩu cũ.';
        messageBox.classList.add('error');
        return;
      }

      if (newPassword !== confirmPassword) {
        messageBox.textContent = '⚠️ Xác nhận mật khẩu không khớp.';
        messageBox.classList.add('error');
        return;
      }

      messageBox.textContent = '⏳ Đang xử lý, vui lòng chờ...';
      messageBox.classList.add('info');

      try {
        const response = await fetch(form.action, {
          method: 'POST',
          headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json'
          },
          body: data,
          credentials: 'same-origin'
        });

        const result = await response.json();

        if (result.success) {
          messageBox.textContent = result.message || '✅ Đổi mật khẩu thành công.';
          messageBox.className = 'message success';
          form.reset();

          if (result.redirect) {
            setTimeout(() => {
              window.location.href = result.redirect;
            }, 1000);
          }
        } else {
          messageBox.textContent = result.message || '❌ Đổi mật khẩu thất bại.';
          messageBox.className = 'message error';
        }

      } catch (error) {
        console.error(error);
        messageBox.textContent = '⚠️ Không thể kết nối tới máy chủ. Vui lòng thử lại.';
        messageBox.className = 'message error';
      }
    });
  </script>


  {{-- Popup User Info --}}

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

  @include('partials.chat')

</body>

</html>