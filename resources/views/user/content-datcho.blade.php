{{-- resources/views/user/tranglichsudatcho.blade.php --}}
<!DOCTYPE html>
<html lang="vi">

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta charset="utf-8" />

  {{-- ✅ Sửa đường dẫn tĩnh sang asset() --}}
  <link rel="stylesheet" href="{{ asset('css/styleguide.css') }}" />
  <link rel="stylesheet" href="{{ asset('css/globals.css') }}" />
  <link rel="stylesheet" href="{{ asset('css/header-homepage-user.css') }}" />
  <link rel="stylesheet" href="{{ asset('css/tranglichsumuontra.css') }}" />
  <link rel="stylesheet" href="{{ asset('css/tranglichsudatcho.css') }}" />

  <link rel="stylesheet" href="{{ asset('css/footer_login-admin.css') }}">

  <title>Lịch sử đặt chỗ</title>
</head>

<body>
  <div class="rectangle">
    <div class="group-2-choosen">
      <div class="div">

        <a class="group-6" href="{{ url('user/content-all-lsmn') }}">
          <div class="rectangle-6">
            <div class="text-wrapper-5">Lịch sử mượn trả</div>
            <div>
              <img class="iconstack-io-book-2" src="{{ asset('images/iconstack.io - (Book) - purple.png') }}" alt="Book icon" />
            </div>
          </div>
        </a>

        <a class="group-7" href="{{ url('user/content-datcho') }}">
          <div class="rectangle-7">
            <div>
              <img class="iconstack-io" src="{{ asset('images/iconstack.io - (Bookmark) - white.png') }}" alt="Bookmark icon" />
            </div>
            <div class="text-wrapper-6">Lịch sử đặt chỗ</div>
          </div>
        </a>
      </div>
    </div>

    <div class="group-ngoai-khoi-sach">
      <div class="group-khoi-sach">
        @forelse ($datChos as $datCho)
        <div class="khung-chung-sach-lch">
          <div class="khung-anh-sach-lch">
            <img class="image" src="{{ $datCho->sach->anhBia ? asset($datCho->sach->anhBia) : asset('images/default-book.jpg') }}" alt="{{ $datCho->sach->tenSach }}">
          </div>
          <div class="khung-chu-sach-lch">
            <div class="text-wrapper-7">Ngày đặt: {{ \Carbon\Carbon::parse($datCho->ngayDat)->format('d/m/Y') }}</div>
            <div class="text-wrapper-8">{{ $datCho->sach->tenSach }}</div>
            <div class="text-wrapper-9">Tác giả: {{ $datCho->sach->tacGia }}</div>

            <div class="text-wrapper-10">Đã hủy: {{ \Carbon\Carbon::parse($datCho->update_at)->format('d/m/Y') }}</div>
            <div class="rectangle-10 rectangle-dang-muon"></div>
            <div class="text-wrapper-12 dang-muon">Đã hủy</div>

          </div>
        </div>
        @empty
        <p>Hiện tại bạn chưa có đặt chỗ nào.</p>
        @endforelse
      </div>
    </div>

  </div>

  @include('partials.chat')
</body>

</html>