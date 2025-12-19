@include('user.layouts.header-homepage-user')

<!-- Hero Section -->
<section class="hero-bg">
  <h1><span>Chào mừng đến với</span> Thư viện Hiện đại</h1>
  <p>
    Khám phá kho tàng tri thức với hàng nghìn đầu sách đa dạng.<br>
    Mượn sách, đặt chỗ và quản lý thông tin một cách dễ dàng.
  </p>

  <div class="hero-buttons">
    <a href="{{ route('user.search-book-user') }}" class="btn primary-btn">
      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <circle cx="11" cy="11" r="8"></circle>
        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
      </svg>
      Tra cứu sách
    </a>
    <a href="{{ route('user.signup') }}" class="btn secondary-btn">
      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
        <circle cx="9" cy="7" r="4" />
        <path d="M2 21v-1a7 7 0 0 1 14 0v1" />
        <line x1="20" y1="8" x2="20" y2="14" />
        <line x1="17" y1="11" x2="23" y2="11" />
      </svg>
      Đăng ký thành viên
    </a>
  </div>
</section>

<!-- Stats Section -->
<section class="stats-container">
  <div class="stat-box-tongsosach">
    <div class="stat-icon"><img src="{{ asset('images/Tongsosach-blue-hp.png') }}" alt="Tổng số sách"></div>
    <div class="stat-number">{{ number_format($tongSach) }}</div>
    <div class="stat-title">Tổng số sách</div>
  </div>

  <div class="stat-box-docgiadangky">
    <div class="stat-icon"><img src="{{ asset('images/Docgiadangky-blue-hp.png') }}" alt="Độc giả đăng ký"></div>
    <div class="stat-number">{{ number_format($tongNguoiDung) }}</div>
    <div class="stat-title">Độc giả đăng ký</div>
  </div>

  <div class="stat-box-luotmuonhomnay">
    <div class="stat-icon"><img src="{{ asset('images/Luotmuonhomnay-blue-hp.png') }}" alt="Lượt mượn hôm nay"></div>
    <div class="stat-number">{{ number_format($luotMuonHomNay) }}</div>
    <div class="stat-title">Lượt mượn hôm nay</div>
  </div>

  <div class="stat-box-sachdangmuon">
    <div class="stat-icon"><img src="{{ asset('images/Sachdangmuon-blue-hp.png') }}" alt="Sách đang mượn"></div>
    <div class="stat-number">{{ number_format($sachDangMuon) }}</div>
    <div class="stat-title">Sách đang mượn</div>
  </div>
</section>

<!-- Features Section -->
<section class="features-section">
  <h2>Tính năng nổi bật</h2>
  <p>Hệ thống quản lý thư viện hiện đại, giúp bạn có trải nghiệm tốt nhất</p>

  <div class="features-grid">
    <a href="{{ route('user.search-book-user') }}" class="feature-link">
      <div class="feature-box">
        <div class="feature-icon">
          <img src="{{ asset('images/iconstack.io - (Search)-thin-white.png') }}" alt="Tra cứu sách" />
        </div>
        <div class="feature-title">Tra cứu sách</div>
        <div class="feature-desc">Tìm kiếm sách theo tên, tác giả, thể loại nhanh chóng và chính xác</div>
      </div>
    </a>

    <a href="{{ route('user.trangmuontra(sachdangmuon)') }}" class="feature-link">
      <div class="feature-box">
        <div class="feature-icon">
          <img src="{{ asset('images/iconstack.io - (Book 2)-thin-white.png') }}" alt="Mượn trả sách" />
        </div>
        <div class="feature-title">Mượn / Trả sách</div>
        <div class="feature-desc">Theo dõi hạn trả, tình trạng sách và quản lý mượn trả thuận tiện</div>
      </div>
    </a>

    <a href="{{ route('user.datchosach') }}" class="feature-link">
      <div class="feature-box">
        <div class="feature-icon">
          <img src="{{ asset('images/iconstack.io - (Bookmark)-thin-white.png') }}" alt="Đặt chỗ" />
        </div>
        <div class="feature-title">Đặt chỗ</div>
        <div class="feature-desc">Đặt trước những cuốn sách bạn yêu thích khi chúng đang được mượn</div>
      </div>
    </a>

    <a href="{{ route('user.tranglichmuontra') }}" class="feature-link">
      <div class="feature-box">
        <div class="feature-icon">
          <img src="{{ asset('images/iconstack.io - (History)-thin-white.png') }}" alt="Lịch sử mượn" />
        </div>
        <div class="feature-title">Lịch sử</div>
        <div class="feature-desc">Xem lại toàn bộ lịch sử mượn và trả sách của bạn</div>
      </div>
    </a>
  </div>
</section>

<!-- Favorite Books Section -->
<section class="favorite-books">
  <div class="section-header">
    <div>
      <h2>Sách được yêu thích</h2>
      <p>Những cuốn sách được mượn nhiều nhất trong tháng</p>
    </div>
    <a href="{{ route('user.search-book-user') }}" class="view-all">Xem tất cả →</a>
  </div>

  <div class="book-list">
    @forelse ($sachYeuThich as $sach)
    <div class="book-card">
      <div class="book-img">
        <img src="{{ $sach->anhBia ? asset($sach->anhBia) : asset('images/default-book.jpg') }}" alt="{{ $sach->tenSach }}">
      </div>
      <div class="tag-status-container">
        <span class="book-tag purple">{{ $sach->danhMuc->tenDanhMuc ?? 'Khác' }}</span>
        <span class="book-status">
          @if ($sach->trangThai === 'available')
          Có sẵn
          @else
          Hết sách
          @endif
        </span>
      </div>
      <h3 class="book-title">{{ $sach->tenSach }}</h3>
      <p class="book-author">Tác giả: {{ $sach->tacGia ?? 'Không rõ' }}</p>
      <p class="book-year">Năm xuất bản: {{ $sach->namXuatBan ?? 'Không rõ' }}</p>
      <p class="book-info">{{ Str::limit($sach->moTa, 100) }}</p>
    </div>
    @empty
    <p class="text-center">Hiện chưa có dữ liệu sách yêu thích.</p>
    @endforelse
  </div>
</section>

<!-- CTA Section -->
<section class="cta-section">
  <h2>Quản lý Mượn / Trả sách</h2>
  <p>Theo dõi và quản lý các cuốn sách bạn đang mượn</p>
  <div class="cta-buttons">
    <a href="{{ route('user.signup') }}" class="btn btn-primary">
      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
        <circle cx="9" cy="7" r="4" />
        <path d="M2 21v-1a7 7 0 0 1 14 0v1" />
        <line x1="20" y1="8" x2="20" y2="14" />
        <line x1="17" y1="11" x2="23" y2="11" />
      </svg>
      Đăng ký miễn phí
    </a>

    <a href="{{ route('user.search-book-user') }}" class="btn btn-secondary">
      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <circle cx="11" cy="11" r="8"></circle>
        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
      </svg>
      Khám phá ngay
    </a>
  </div>
</section>

@include('user.layouts.footer-login-user')