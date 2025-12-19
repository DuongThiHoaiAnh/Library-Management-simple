<header class="header">
    <a href="{{ url('/user/homepage-login-user') }}" class="logo">
        <div class="logo-icon">
            <img src="{{ asset('images/iconstack.io - (Book).png') }}" alt="Thư viện Tri Thức logo" />
        </div>
        <div class="logo-text">Thư viện<br />Tri Thức</div>
    </a>
    
    <nav class="nav">
        <a href="{{ url('user/homepage-login-user') }}">Trang chủ
            <img src="{{ asset('images/iconstack.io - (Home).png') }}" alt="Trang chủ logo" />
        </a>
        <a href="#">Tra cứu sách
            <img src="{{ asset('images/iconstack.io - (Search).png') }}" alt="Tra cứu sách logo" />
        </a>
        <a href="#">Mượn/ Trả sách
            <img src="{{ asset('images/iconstack.io - (Book 2).png') }}" alt="Mượn/ Trả sách logo" />
        </a>
        <a href="#">Đặt chỗ
            <img src="{{ asset('images/iconstack.io - (Bookmark).png') }}" alt="Đặt chỗ logo" />
        </a>
        <a href="#">Lịch sử
            <img src="{{ asset('images/iconstack.io - (History).png') }}" alt="Lịch sử logo" />
        </a>
    </nav>
    
    <div class="buttons">
        <a href="{{ url('/admin/login-admin') }}" class="btn admin">Quản Trị Viên</a>
        <a href="{{ url('/user/login-user') }}" class="btn login">Đăng nhập</a>
        <a href="{{ url('/user/signup-user') }}" class="btn signup">Đăng ký</a>
    </div>
</header>
