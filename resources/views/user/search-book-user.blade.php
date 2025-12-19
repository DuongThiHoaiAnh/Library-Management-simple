<!DOCTYPE html>
<html lang="vi">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tra cứu sách - Người dùng</title>

  <!-- CSS -->
  <link rel="stylesheet" href="{{ asset('css/styleguide.css') }}" />
  <link rel="stylesheet" href="{{ asset('css/globals.css') }}" />
  <link rel="stylesheet" href="{{ asset('css/search-book-user.css') }}" />
  <link rel="stylesheet" href="{{ asset('css/header-homepage-user.css') }}" />
  <link rel="stylesheet" href="{{ asset('css/footer_login-admin.css') }}" />
</head>

<body>
  <div class="page-container">

    {{-- Header --}}
    @include('user.layouts.header-search-book-user')

    <section class="cta-section">
      <h2>Tra cứu sách</h2>
      <p>Tìm kiếm trong kho tàng tri thức với hàng nghìn đầu sách</p>
      <div class="search-box">
        <form action="{{ route('user.search-book-user') }}" method="GET">
          <input type="text" name="q" placeholder="Tìm kiếm theo tên sách, tác giả..." value="{{ request('q') }}">
          <select name="category">
            <option value="">Tất cả</option>
            @php
            $categories = DB::table('danh_muc')->get();
            @endphp
            @foreach($categories as $cat)
            <option value="{{ $cat->idDanhMuc }}" {{ request('category') == $cat->idDanhMuc ? 'selected' : '' }}>{{ $cat->tenDanhMuc }}</option>
            @endforeach
          </select>
          <button type="submit" class="search-btn">
            <svg class="search-icon" xmlns="http://www.w3.org/2000/svg" width="20" height="20"
              viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2"
              stroke-linecap="round" stroke-linejoin="round">
              <circle cx="11" cy="11" r="8"></circle>
              <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
            </svg>
            Tìm kiếm
          </button>
        </form>
      </div>
    </section>

    <section class="favorite-books">
      <div class="section-header">
        <div>
          <h2>Sách</h2>
          <p>Danh sách sách hiện có trong thư viện</p>
        </div>
      </div>

      <section class="book-list">
        @forelse ($books as $book)
        <div class="book-card">
          <div class="book-img">
            <img src="{{ $book->anhBia ? asset($book->anhBia) : asset('images/default-book.jpg') }}" alt="{{ $book->tenSach }}">
          </div>
          <div class="tag-status-container">
            <span class="book-tag purple">{{ $book->tenDanhMuc }}</span>
            <span class="book-status">
              @if ($book->trangThai === 'available')
              Có sẵn
              @else
              Hết sách
              @endif
            </span>
          </div>

          <h3 class="book-title">{{ $book->tenSach }}</h3>
          <p class="book-author">Tác giả: {{ $book->tacGia ?? 'Không rõ' }}</p>
          <p class="book-year">Năm xuất bản: {{ $book->namXuatBan ?? 'Không rõ' }}</p>
          <p class="book-info">{{ $book->moTa ?? 'Chưa có mô tả' }}</p>

          <div class="book-action">
            @if ($book->trangThai === 'available')
            <button class="borrow-btn" onclick="borrowBook('{{ $book->idSach }}')">Mượn ngay</button>
            @else
            <button class="borrow-btn disabled-btn">Mượn ngay</button>
            <button class="reserve-btn" onclick="reserveBook('{{ $book->idSach }}')">
              <svg xmlns="http://www.w3.org/2000/svg" class="reserve-icon" width="19" height="19"
                viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2"
                stroke-linecap="round" stroke-linejoin="round">
                <path d="M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z" />
              </svg>
            </button>
            @endif
          </div>
        </div>
        @empty
        <p>Không tìm thấy sách nào.</p>
        @endforelse
      </section>
    </section>

    {{-- Footer --}}
    @include('user.layouts.footer-login-user')

  </div>

  <script>
    function borrowBook(bookId) {
      fetch(`/borrow-book/${bookId}`, {
          method: 'POST',
          headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
          }
        })
        .then(res => res.json())
        .then(data => alert(data.message))
        .catch(err => alert('Đã có lỗi xảy ra!'));
    }

    function reserveBook(bookId) {
      fetch(`/reserve-book/${bookId}`, {
          method: 'POST',
          headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
          }
        })
        .then(res => res.json())
        .then(data => alert(data.message))
        .catch(err => alert('Đã có lỗi xảy ra!'));
    }
  </script>

  @include('partials.chat')


</body>

</html>