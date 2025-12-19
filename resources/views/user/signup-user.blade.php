<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Đăng ký Người dùng</title>

    <link rel="stylesheet" href="{{ asset('css/signup-user.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/header_login-admin.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/footer_login-admin.css') }}" />
</head>

<body>
    <div class="page-container">

        {{-- Header --}}
        @include('user.layouts.header-signup-user')

        {{-- Sign Up Content --}}
        <main class="login-box">
            <div class="avatar">
                <div class="avatar-icon">
                    <img src="{{ asset('images/iconstack.io - (People Fill)-blue.png') }}" alt="Người dùng logo" />
                </div>
            </div>

            <h1>Đăng ký</h1>
            <p class="desc">Tạo tài khoản người dùng mới để sử dụng thư viện</p>

            {{-- Form đăng ký --}}
            <form class="login-form" action="{{ url('/user/signup-user') }}" method="POST">
                @csrf

                {{-- Họ và tên --}}
                <label for="fullname">Họ và tên</label>
                <div class="input-box">
                    <input type="text" name="fullname" id="fullname" placeholder="Nhập họ và tên" value="{{ old('fullname') }}" required />
                    @error('fullname')
                    <span class="error" style="color: red; font-size: 0.875rem; font-weight: 500;">
                        {{ $message }}
                    </span>
                    @enderror

                </div>

                {{-- Email --}}
                <label for="email">Email</label>
                <div class="input-box">
                    <input type="email" name="email" id="email" placeholder="Nhập email" value="{{ old('email') }}" required />
                    @error('email')
                    <span class="error" style="color: red; font-size: 0.875rem; font-weight: 500;">
                        {{ $message }}
                    </span>
                    @enderror

                </div>

                {{-- Số điện thoại --}}
                <label for="phone">Số điện thoại</label>
                <div class="input-box">
                    <input type="text" name="phone" id="phone" placeholder="Nhập số điện thoại" value="{{ old('phone') }}" />
                    @error('phone')
                    <span class="error" style="color: red; font-size: 0.875rem; font-weight: 500;">
                        {{ $message }}
                    </span>
                    @enderror

                </div>

                {{-- Địa chỉ --}}
                <label for="address">Địa chỉ</label>
                <div class="input-box">
                    <input type="text" name="address" id="address" placeholder="Nhập địa chỉ" value="{{ old('address') }}" />
                    @error('address')
                    <span class="error" style="color: red; font-size: 0.875rem; font-weight: 500;">
                        {{ $message }}
                    </span>
                    @enderror

                </div>

                {{-- Mật khẩu --}}
                <label for="password">Mật khẩu</label>
                <div class="input-box">
                    <div class="password-wrapper">
                        <input type="password" name="password" id="password" placeholder="Nhập mật khẩu" required />
                        <button type="button" class="pwd-toggle" aria-label="Hiện/ẩn mật khẩu">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
                                <path d="M2 12s4-7 10-7 10 7 10 7-4 7-10 7S2 12 2 12z" stroke="#333" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round" />
                                <circle cx="12" cy="12" r="3" stroke="#333" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </button>
                    </div>
                    @error('password')
                    <span class="error" style="color: red; font-size: 0.875rem; font-weight: 500;">
                        {{ $message }}
                    </span>
                    @enderror

                </div>

                {{-- Xác nhận mật khẩu --}}
                <label for="confirm-password">Xác nhận mật khẩu</label>
                <div class="input-box">
                    <div class="password-wrapper">
                        <input type="password" name="password_confirmation" id="confirm-password" placeholder="Nhập lại mật khẩu" required />
                        <button type="button" class="pwd-toggle" aria-label="Hiện/ẩn mật khẩu">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
                                <path d="M2 12s4-7 10-7 10 7 10 7-4 7-10 7S2 12 2 12z" stroke="#333" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round" />
                                <circle cx="12" cy="12" r="3" stroke="#333" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </button>
                    </div>
                    @error('email')
                    <span class="error" style="color: red; font-size: 0.875rem; font-weight: 500;">
                        {{ $message }}
                    </span>
                    @enderror
                </div>

                {{-- Submit --}}
                <button type="submit" class="btn-login">Đăng ký</button>
            </form>
        </main>

        {{-- Footer --}}
        @include('user.layouts.footer-login-user')
    </div>

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