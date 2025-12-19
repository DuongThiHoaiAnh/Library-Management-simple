@include('admin.layouts.header-login-admin')

<main class="login-box">
    <div class="avatar">
        <div class="avatar-icon">
            <img src="{{ asset('images/iconstack.io - (People Fill).png') }}" alt="Quản trị viên logo" />
        </div>
    </div>

    <h1>Đăng nhập<br />Quản Trị Viên</h1>
    <p class="desc">
        Đăng nhập vào tài khoản quản trị viên của bạn để quản lý hệ thống
    </p>

    <form class="login-form" method="POST" action="{{ route('admin.login.submit') }}">
        {{-- 🔹 CSRF bảo mật --}}
        @csrf

        {{-- 🔹 Hiển thị thông báo lỗi (nếu có) --}}
        
        @if ($errors->any())
        <div style="color: red; font-weight: 600; margin-top: 10px;">
            @foreach ($errors->all() as $error)
            <p>⚠️ {{ $error }}</p>
            @endforeach
        </div>
        @endif

        <label for="email">Email</label>
        <div class="input-box">
            <input type="email" id="email" name="email" placeholder="Nhập email của bạn" required />
        </div>

        <label for="password">Mật khẩu</label>
        <div class="input-box">
            <div class="password-wrapper">
                <input
                    type="password"
                    id="password"
                    name="matKhau"
                    placeholder="Nhập mật khẩu"
                    required />
                <button type="button" class="pwd-toggle" aria-label="Hiện/ẩn mật khẩu">
                    {{-- Icon SVG --}}
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <path d="M2 12s4-7 10-7 10 7 10 7-4 7-10 7S2 12 2 12z" stroke="#333" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round" />
                        <circle cx="12" cy="12" r="3" stroke="#333" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </button>
            </div>
        </div>

        {{-- 🔹 Nút gửi form --}}
        <button type="submit" class="btn-login">Đăng nhập</button>
    </form>
</main>

@include('admin.layouts.footer-homepage-admin')

<script src="{{ asset('js/password-toggle.js') }}"></script>
<script>
    document.querySelectorAll('a[href="#"]').forEach(function(link) {
      link.addEventListener('click', function(event) {
        event.preventDefault();
        alert("⚠️ Bạn cần đăng nhập hoặc đăng ký để sử dụng chức năng này!");
      });
    });
  </script>