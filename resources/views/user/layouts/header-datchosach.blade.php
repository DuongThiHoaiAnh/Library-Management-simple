{{-- HEADER (header.blade.php) --}}
<!-- Header -->
<header class="header">
  <div class="max-header">
    <div class="header-left">
      <a href="{{ url('user/homepage-user') }}" class="logo">
        <div class="logo-icon">
          <img src="{{ asset('images/iconstack.io - (Book).png') }}" alt="Thư viện Tri Thức logo" />
        </div>
        <div class="logo-text">Thư viện<br />Tri Thức</div>
      </a>

      <nav class="nav">
        <a href="{{ url('user/homepage-user') }}">Trang chủ
          <img src="{{ asset('images/iconstack.io - (Home).png') }}" alt="Trang chủ logo" />
        </a>
        <a href="{{ url('user/search-book-user') }}">Tra cứu sách
          <img src="{{ asset('images/iconstack.io - (Search).png') }}" alt="Tra cứu sách logo" />
        </a>
        <a href="{{ url('user/trangmuontra(sachdangmuon)') }}">Mượn/ Trả sách
          <img src="{{ asset('images/iconstack.io - (Book 2).png') }}" alt="Mượn/ Trả sách logo" />
        </a>
        <a href="{{ url('user/datchosach') }}" class="active">Đặt chỗ
          <img src="{{ asset('images/iconstack.io - (Bookmark) - purple bold.png') }}" alt="Đặt chỗ logo" />
        </a>
        <a href="{{ url('user/tranglichmuontra') }}">Lịch sử
          <img src="{{ asset('images/iconstack.io - (History) - normal.png') }}" alt="Lịch sử logo" />
        </a>
      </nav>
    </div>

    <div class="header-right">
      <a class="fine-box" href="{{ route('user.trangphat') }}">
        <svg width="50" height="50" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.5 8.5 0 0 1 8 8z"></path>
          <text x="10" y="14" font-size="8" font-weight="bold">$</text>
        </svg>

        <span class="fine-text">
          <span class="line1">Thanh toán</span>
          <span class="line2">tiền phạt</span>
        </span>
      </a>

      <!-- Icon thông báo -->
      <!-- Thông báo -->
      <div class="notification-icon" onclick="toggleNotifications()">
        <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" viewBox="0 0 24 24" fill="none"
          stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M18 8a6 6 0 0 0-12 0c0 7-3 9-3 9h18s-3-2-3-9"></path>
          <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
        </svg>

        @php
        use Illuminate\Support\Facades\Auth;
        use App\Models\ThongBao;

        $thongBaos = Auth::check()
        ? ThongBao::where('idNguoiDung', Auth::id())
        ->latest()
        ->take(5)
        ->get()
        : collect();

        $soThongBao = $thongBaos->where('trangThai', 'unread')->count();
        @endphp

        @if($soThongBao > 0)
        <span class="badge">{{ $soThongBao }}</span>
        @endif
      </div>

      <!-- Popup thông báo -->
      <div id="notificationPopup" class="popup notification-popup">
        <div class="popup-header">
          <strong>Thông báo của bạn</strong>
        </div>

        @if($thongBaos->isEmpty())
        <p class="no-noti">Không có thông báo nào</p>
        @else
        <ul class="notification-list">
          @foreach($thongBaos as $tb)
          <li class="notification-item {{ $tb->trangThai === 'unread' ? 'unread' : '' }}" data-id="{{ $tb->idThongBao }}">
            <p>{!! $tb->noiDung !!}</p>
            @if($tb->sach)
            <small>Sách: {{ $tb->sach->tenSach }}</small><br>
            @endif
            <span class="time">{{ \Carbon\Carbon::parse($tb->thoiGianGui)->diffForHumans() }}</span>
          </li>
          @endforeach
        </ul>
        @endif
      </div>


      <!-- Tài khoản người dùng -->
      <div class="user-box" onclick="togglePopup()">
        <div class="avatar">
          {{ strtoupper(substr(Auth::user()->tenNguoiDung ?? 'U', 0, 1)) }}
        </div>
        <svg width="25" height="25" fill="none" stroke="currentColor" stroke-width="2"
          stroke-linecap="round" stroke-linejoin="round">
          <line x1="12" y1="4" x2="12" y2="19"></line>
          <line x1="5" y1="12" x2="12" y2="19"></line>
          <line x1="19" y1="12" x2="12" y2="19"></line>
        </svg>
      </div>

      <!-- Popup tài khoản -->
      <div id="userPopup" class="popup">
        <div class="popup-header">
          <div class="avatar">
            {{ strtoupper(substr(Auth::user()->tenNguoiDung ?? 'U', 0, 1)) }}
          </div>
          <div class="info">
            <h3>{{ Auth::user()->hoTen ?? 'Người dùng' }}</h3>
            <p>{{ Auth::user()->email ?? '' }}</p>
          </div>
        </div>

        <a href="{{ route('user.info-user') }}" class="popup-item-link">
          <div class="popup-item">
            <div class="icon-popup">
              <img src="{{ asset('images/iconstack.io - (Ic Fluent People Search 24 Filled)-popup.png') }}" alt="">
            </div>
            <div>
              <strong>Thông tin tài khoản</strong>
              <p>Quản lý hồ sơ cá nhân</p>
            </div>
          </div>
        </a>

        <a href="{{ route('user.setting-user') }}" class="popup-item-link">
          <div class="popup-item">
            <div class="icon-popup">
              <img src="{{ asset('images/iconstack.io - (Lock Password)-popup.png') }}" alt="">
            </div>
            <div>
              <strong>Đổi mật khẩu</strong>
              <p>Đổi mật khẩu tài khoản</p>
            </div>
          </div>
        </a>

        <a href="{{ route('user.help') }}" class="popup-item-link">
          <div class="popup-item">
            <div class="icon-popup">
              <img src="{{ asset('images/iconstack.io - (Question Bold)-popup.png') }}" alt="">
            </div>
            <div>
              <strong>Trợ giúp</strong>
              <p>Hướng dẫn sử dụng</p>
            </div>
          </div>
        </a>

        <!-- Đăng xuất -->
        <form action="{{ route('user.logout') }}" method="POST" class="popup-item-link">
          @csrf
          <button type="submit" class="popup-item logout-ee">
            <div class="icon-popup">
              <img src="{{ asset('images/iconstack.io - (Log Out)-popup.png') }}" alt="">
            </div>
            <div>
              <strong>Đăng xuất</strong>
              <p>Thoát khỏi tài khoản</p>
            </div>
          </button>
        </form>
      </div>
    </div>
  </div>
</header>