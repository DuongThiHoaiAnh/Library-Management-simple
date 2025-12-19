<!-- Header -->
<header class="header">
  <div class="max-header">
    <div class="header-left">
      <a href="{{ route('user.homepage-user') }}" class="logo">
        <div class="logo-icon">
          <img src="{{ asset('images/iconstack.io - (Book).png') }}" alt="Thư viện Tri Thức logo" />
        </div>
        <div class="logo-text">Thư viện<br />Tri Thức</div>
      </a>

      <nav class="nav">
        <a href="{{ route('user.homepage-user') }}">Trang chủ
          <img src="{{ asset('images/iconstack.io - (Home).png') }}" alt="Trang chủ logo" />
        </a>
        <a href="{{ route('user.search-book-user') }}" class="{{ request()->is('user/search-book-user') ? 'active' : '' }}">Tra cứu sách
          <img src="{{ asset('images/iconstack.io - (Search)-purple.png') }}" alt="Tra cứu sách logo" />
        </a>
        <a href="{{ route('user.trangmuontra(sachdangmuon)') }}">Mượn/ Trả sách
          <img src="{{ asset('images/iconstack.io - (Book 2).png') }}" alt="Mượn/ Trả sách logo" />
        </a>
        <a href="{{ route('user.datchosach') }}">Đặt chỗ
          <img src="{{ asset('images/iconstack.io - (Bookmark).png') }}" alt="Đặt chỗ logo" />
        </a>
        <a href="{{ route('user.tranglichmuontra') }}">Lịch sử
          <img src="{{ asset('images/iconstack.io - (History).png') }}" alt="Lịch sử logo" />
        </a>
      </nav>
    </div>

    <div class="header-right">
      <a class="fine-box" href="{{ route('user.trangphat') }}">
        <svg width="50" height="50" viewBox="0 0 24 24" fill="none" stroke="currentColor"
          stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.5 8.5 0 0 1 8 8z"></path>
          <text x="10" y="14" font-size="8" font-weight="bold">$</text>
        </svg>
        <span class="fine-text">
          <span class="line1">Thanh toán</span>
          <span class="line2">tiền phạt</span>
        </span>
      </a>

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