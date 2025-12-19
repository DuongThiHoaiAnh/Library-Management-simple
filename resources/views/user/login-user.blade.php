<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập Người dùng</title>

    {{-- CSS --}}
    <link rel="stylesheet" href="{{ asset('css/login-user.css') }}">
    <link rel="stylesheet" href="{{ asset('css/header_login-admin.css') }}">
    <link rel="stylesheet" href="{{ asset('css/footer_login-admin.css') }}">
</head>

<body>
    <div class="page-container">

        {{-- Header --}}
        @include('user.layouts.header-login-user')

        {{-- Nội dung đăng nhập --}}
        <main class="login-box">
            <div class="avatar">
                <div class="avatar-icon">
                    <img src="{{ asset('images/iconstack.io - (People Fill)-blue.png') }}" alt="Người dùng logo">
                </div>
            </div>

            <h1>Đăng nhập</h1>
            <p class="desc">Đăng nhập vào tài khoản của bạn để tiếp tục</p>

            {{-- Form đăng nhập --}}

            @if ($errors->any())
            <div style="color: red; font-weight: 600; margin-top: 10px;">
                @foreach ($errors->all() as $error)
                <p>⚠️ {{ $error }}</p>
                @endforeach
            </div>
            @endif

            <form class="login-form" method="POST" action="{{ route('user.login.submit') }}">
                @csrf

                {{-- Email --}}
                <label for="email">Email</label>
                <div class="input-box">
                    <input
                        type="email"
                        id="email"
                        name="email"
                        placeholder="Nhập email của bạn"
                        value="{{ old('email') }}"
                        required>
                </div>

                {{-- Password --}}
                <label for="password">Mật khẩu</label>
                <div class="input-box">
                    <div class="password-wrapper">
                        <input
                            type="password"
                            id="password"
                            name="password"
                            placeholder="Nhập mật khẩu"
                            required>
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

                {{-- Nút đăng nhập --}}
                <button type="submit" class="btn-login">Đăng nhập</button>
            </form>

            {{-- Đăng ký mới --}}
            <p class="signup-link">
                Chưa có tài khoản?
                <a href="{{ url('/user/signup-user') }}">Đăng ký ngay</a>
            </p>

            <p>
                Quên mật khẩu? Gửi ngay yêu cầu đến email hoaianh16022005@gmail.com
            </p>
        </main>

        {{-- Footer --}}
        @include('user.layouts.footer-login-user')
    </div>

    {{-- JS --}}
    <script defer src="{{ asset('js/password-toggle.js') }}"></script>
    <script>
        document.querySelectorAll('a[href="#"]').forEach(function(link) {
            link.addEventListener('click', function(event) {
                event.preventDefault();
                alert("⚠️ Bạn cần đăng nhập để sử dụng chức năng này!");
            });
        });
    </script>

</body>

</html>