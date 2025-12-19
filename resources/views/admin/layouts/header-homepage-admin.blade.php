<div class="header">
    <!-- Logo -->
    <a href="{{ route('admin.homepage-admin') }}" class="logo">
        <div class="logo-icon">
            <img src="{{ asset('images/iconstack.io - (Book).png') }}" alt="Thư viện Tri Thức logo" />
        </div>
        <div class="logo-text">Thư viện<br>Tri Thức</div>
    </a>

    <!-- Buttons -->
    <div class="buttons">
        @auth
            <!-- Logout button -->
            <form action="{{ route('admin.logout') }}" method="POST" style="display:inline;">
                @csrf
                <button type="submit" class="btn logout">ĐĂNG XUẤT</button>
            </form>

            @if(Auth::user()->vaiTro === 'admin')
                <a href="{{ route('admin.dashboard-admin') }}" class="btn admin">QUẢN TRỊ VIÊN</a>
                <a href="{{ route('admin.signup-admin') }}" class="btn signup-admin">ĐĂNG KÝ QUẢN TRỊ VIÊN</a>
            @endif
        @else
            <a href="{{ route('admin.login-admin') }}" class="btn login">ĐĂNG NHẬP</a>
        @endauth
    </div>
</div>
