<!DOCTYPE html>
<html lang="vi">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Mượn trả sách - Người dùng</title>

  <link rel="stylesheet" href="{{ asset('css/styleguide.css') }}" />
  <link rel="stylesheet" href="{{ asset('css/globals.css') }}" />
  <link rel="stylesheet" href="{{ asset('css/header-homepage-user.css') }}" />
  <link rel="stylesheet" href="{{ asset('css/footer_login-admin.css') }}">
  <link rel="stylesheet" href="{{ asset('css/tranglichsumuontra.css') }}" />
  <link rel="stylesheet" href="{{ asset('css/datchosach.css') }}" />
  <link rel="stylesheet" href="{{ asset('css/trangmuontra(sachdangmuon).css') }}" />
</head>

<body>
  <div class="trang-lch-s-mn-tr">
    @include('user.layouts.header-trangmuontra(sachdangmuon)')

    <div class="body">
      <div class="group">
        <div class="group-2">
          <div class="text-wrapper">Quản lý Mượn/ Trả sách</div>
          <p class="p">Theo dõi và quản lý các cuốn sách bạn đang mượn</p>
        </div>
      </div>

      <!-- Đây là nơi sẽ load content tab -->
      <div id="main-content-3"></div>
    </div>

    @include('user.layouts.footer-login-user')
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


  <!-- Script muon sach moi -->
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