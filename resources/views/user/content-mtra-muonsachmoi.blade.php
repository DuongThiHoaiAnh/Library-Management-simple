<!-- trangmuontra-muonsachmoi.blade.php -->
<!DOCTYPE html>
<html lang="vi">

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta charset="utf-8" />

  <link rel="stylesheet" href="{{ asset('css/styleguide.css') }}" />
  <link rel="stylesheet" href="{{ asset('css/globals.css') }}" />

  <link rel="stylesheet" href="{{ asset('css/header-homepage-user.css') }}" />
  <link rel="stylesheet" href="{{ asset('css/tranglichsumuontra.css') }}" />
  <link rel="stylesheet" href="{{ asset('css/datchosach.css') }}" />
  <link rel="stylesheet" href="{{ asset('css/search-book-user.css') }}" />
  <link rel="stylesheet" href="{{ asset('css/sachhot.css') }}" />
  <link rel="stylesheet" href="{{ asset('css/trangmuontra(muonsachmoi).css') }}" />
</head>

<body>
  <div class="khoi-group3-4-14">
    <div class="group-2-choosen">
      <div class="div">
        <a class="group-6 @if($activeTab == 'sachdangmuon') active @endif" data-url="{{ route('user.content-mtra-sachdangmuon') }}">
          <div class="rectangle-6">
            <div class="text-wrapper-5">Sách đang mượn</div>
            <div>
              <img class="iconstack-io-book-2" style="height: 30px; width: 30px;" src="{{ asset('images/iconstack.io - (Book) - purple.png') }}" alt="Icon sách đang mượn" />
            </div>
          </div>
        </a>
        <a class="group-7 @if($activeTab == 'muonsachmoi') active @endif" data-url="{{ route('user.content-mtra-muonsachmoi') }}">
          <div class="rectangle-7">
            <div>
              <img class="iconstack-io" src="{{ asset('images/iconstack.io - (Bookmark) - white.png') }}" alt="Icon mượn sách mới" />
            </div>
            <div class="text-wrapper-6">Mượn sách mới</div>
          </div>
        </a>
      </div>
    </div>
  </div>

  <div class="rectangle">
    <div class="can-giua-group-chon-lenh">
      <div class="group-chon-lenh">
        <h1 class="tieu-de">Mượn sách mới</h1>
        <p class="ghi-chu">Chọn những cuốn sách bạn muốn mượn</p>
      </div>
    </div>



    <section class="favorite-books">
      <section class="book-list">
        @forelse ($books as $book)
        <div class="book-card">
          <div class="book-img">
            <img src="{{ $book->anhBia ? asset($book->anhBia) : asset('images/default-book.jpg') }}" alt="{{ $book->tenSach }}">
          </div>
          <div class="tag-status-container">
            <span class="book-tag purple">{{ $book->danhMuc->tenDanhMuc ?? 'Khác' }}</span>
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


  </div>

  <script>
    document.addEventListener('DOMContentLoaded', () => {
      const mainContent = document.getElementById("main-content-3");

      // Load tab mặc định
      fetch("{{ url('user/content-mtra-sachdangmuon') }}", {
          credentials: 'same-origin'
        })
        .then(res => res.text())
        .then(html => mainContent.innerHTML = html);

      // Event delegation cho tab
      document.addEventListener('click', function(e) {
        const tab = e.target.closest('a[data-url]');
        if (!tab) return;
        e.preventDefault();
        const url = tab.dataset.url;

        fetch(url, {
            credentials: 'same-origin'
          })
          .then(res => res.text())
          .then(html => mainContent.innerHTML = html);

        document.querySelectorAll('a[data-url]').forEach(el => el.classList.remove('active'));
        tab.classList.add('active');
      });
    });
  </script>


  <script>
    document.addEventListener('click', function(e) {
      const btn = e.target.closest('.return-book-btn');
      if (!btn) return;

      e.preventDefault();

      const chiTietId = btn.dataset.id;
      if (!chiTietId) return;

      btn.disabled = true;
      const originalHTML = btn.innerHTML;
      btn.innerHTML = 'Đang gửi...';

      fetch("{{ url('/user/return-book-btn') }}/" + chiTietId, {
          method: 'POST',
          headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json',
            'Content-Type': 'application/json'
          }
        })
        .then(res => {
          if (!res.ok) throw new Error('Server lỗi');
          return res.json();
        })
        .then(data => {
          alert(data.message);

          // Update button trạng thái đã gửi
          btn.innerHTML = '<img class="icon-thoi-gian" src="{{ asset("images/iconstack.io - (Book) - white.png") }}" alt="Trả sách icon"><div class="text-wrapper-23"><p class="text-wrapper-dang-cho">Yêu cầu đã gửi</p></div>';
          btn.disabled = true;

          // Nếu muốn, có thể thêm class disabled để style khác
          btn.classList.add('disabled');
        })
        .catch(err => {
          console.error(err);
          alert('Có lỗi xảy ra, vui lòng thử lại!');
          btn.disabled = false;
          btn.innerHTML = originalHTML;
        });
    });

    // xử lý data url
    document.querySelectorAll('a[data-url]').forEach(link => {
      link.addEventListener('click', function(e) {
        e.preventDefault();
        const url = this.dataset.url;

        fetch(url)
          .then(res => res.text())
          .then(html => {
            document.querySelector('#tab-content').innerHTML = html;
          })
          .catch(err => console.error(err));
      });
    });
  </script>


  @include('partials.chat')


</body>

</html>