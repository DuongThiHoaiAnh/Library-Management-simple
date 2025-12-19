<!DOCTYPE html>
<html lang="vi">

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta charset="utf-8" />

  {{-- ✅ ĐÃ CHỈNH: dùng asset() để Laravel trỏ đúng thư mục public --}}
  <link rel="stylesheet" href="{{ asset('css/styleguide.css') }}" />
  <link rel="stylesheet" href="{{ asset('css/globals.css') }}" />
  <link rel="stylesheet" href="{{ asset('css/header-homepage-user.css') }}" />
  <link rel="stylesheet" href="{{ asset('css/tranglichsumuontra.css') }}" />
  <link rel="stylesheet" href="{{ asset('css/datchosach.css') }}" />
  <link rel="stylesheet" href="{{ asset('css/sachhot.css') }}" />
</head>

<body>

  <div class="khoi-group3-4-14">
    <div class="group-2-choosen">
      <div class="div">
        <a class="group-6" data-url="{{ url('user/content-datchosach') }}" href="#">
          <div class="rectangle-6">
            <div class="text-wrapper-5">Đặt chỗ của tôi</div>
            <div class="">
              <img class="iconstack-io-book-2" src="{{ asset('images/iconstack.io - (Bookmark) - Purple.png') }}" />
            </div>
          </div>
        </a>
        <a class="group-7" data-url="{{ url('user/content-sachhot') }}" href="#">
          <div class="rectangle-7">
            <div class="">
              <img class="iconstack-io" src="{{ asset('images/iconstack.io - (Ic Fluent Fire 24 Regular) - white.png') }}" />
            </div>
            <div class="text-wrapper-6">Sách hot</div>
          </div>
        </a>
      </div>
    </div>
  </div>

  <div class="rectangle">
    <div class="can-giua-group-chon-lenh">
      <div class="group-chon-lenh">
        <h1 class="tieu-de">Sách được đặt chỗ nhiều nhất</h1>
        <p class="ghi-chu">Những cuốn sách hot nhất hiện tại đang có nhiều người chờ đợi</p>
      </div>
    </div>

    <div class="group-ngoai-khoi-sach">
      <div class="group-khoi-sach">
        @foreach($sachsHot as $sach)
        <div class="khung-chung-sach-lch" data-id-sach="{{ $sach->idSach }}">
          <div class="khung-anh-sach-lch">
            <img class="image" src="{{ asset($sach->anhBia) }}" />
          </div>
          <div class="khung-chu-sach-lch">
            <div class="danh-muc-sach">
              <div class="rectangle-8">
                <div class="text-wrapper-12">{{ $sach->danhMuc->tenDanhMuc ?? 'Khác' }}</div>
              </div>
              <div class="rectangle-25">
                <img class="icon-hot" src="{{ asset('images/iconstack.io - (Fire).png') }}" />
                <div class="text-wrapper-12">Hot</div>
              </div>
            </div>

            <div class="noi-dung-chi-tiet-sach">
              <div class="text-wrapper-8">{{ $sach->tenSach }}</div>
              <div class="text-wrapper-9">{{ $sach->tacGia }}</div>
              <div class="thoi-gian-sach">
                <div class="thoi-gian-cho">
                  <div class="text-wrapper-7">Đang chờ:</div>
                  <div class="text-wrapper-so-nguoi">{{ $sach->dat_chos_count }} người</div>
                </div>
                <div class="thoi-gian-cho-2">
                  <div class="text-wrapper-7">Thời gian chờ:</div>
                  <div class="text-wrapper-so-nguoi">14 ngày</div>
                </div>
              </div>

              <div class="group-chung-lenh-dat-cho">
                <div class="rectangle-23 rectangle-muon-ngay">
                  <img class="icon-thoi-gian" src="{{ asset('images/iconstack.io - (Bookmark) - white.png') }}" />
                  <div class="text-wrapper-23">
                    <p class="text-wrapper-muon-ngay">Đặt chỗ ngay</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        @endforeach

        <a class="khoi-ngoai-chuyen-tiep" href="{{ url('user/search-book-user') }}">
          <div class="khoi-chuyen-tiep">
            <div class="chuyen-tiep-chu">Tìm thêm sách khác</div>
            <img class="chuyen-tiep-icon" src="{{ asset('images/iconstack.io - (Arrow Narrow Right) - blue.png') }}" />
          </div>
        </a>

      </div>
    </div>
  </div>

  {{-- Script AJAX Đặt chỗ --}}
  <script>
    document.addEventListener('DOMContentLoaded', () => {
      const container = document.getElementById('main-content-2');

      container.addEventListener('click', (e) => {
        const btn = e.target.closest('.rectangle-muon-ngay');
        if (!btn) return;

        const khung = btn.closest('.khung-chung-sach-lch');
        const sachId = khung.dataset.idSach;

        fetch(`/user/datchosach/reserve/${sachId}`, {
            method: 'POST',
            headers: {
              'X-CSRF-TOKEN': '{{ csrf_token() }}',
              'Accept': 'application/json',
              'Content-Type': 'application/json'
            }
          })
          .then(res => res.json())
          .then(data => {
            alert(data.message);

            btn.innerHTML = `<img class="icon-thoi-gian" src="{{ asset('images/iconstack.io - (Time).png') }}"/>
                             <div class="text-wrapper-23">
                                 <p class="text-wrapper-dang-cho">Đang chờ</p>
                             </div>`;
            btn.classList.remove('rectangle-muon-ngay');
            btn.classList.add('rectangle-dang-cho');
          })
          .catch(err => {
            console.error(err);
            alert('Có lỗi xảy ra, vui lòng thử lại.');
          });
      });
    });
  </script>

  @include('partials.chat')

</body>

</html>