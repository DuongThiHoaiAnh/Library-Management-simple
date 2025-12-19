{{-- resources/views/user/partials/content-datchosach.blade.php --}}
<div class="khoi-group3-4-14">
  <div class="group-2-choosen">
    <div class="div">
      <a class="group-6" data-url="{{ url('user/content-datchosach') }}">
        <div class="rectangle-6">
          <div class="text-wrapper-5">Đặt chỗ của tôi</div>
          <div class="">
            <img class="iconstack-io-book-2" src="{{ asset('images/iconstack.io - (Bookmark) - white.png') }}" />
          </div>
        </div>
      </a>
      <a class="group-7" data-url="{{ url('user/content-sachhot') }}">
        <div class="rectangle-7">
          <div class="">
            <img class="iconstack-io" src="{{ asset('images/iconstack.io - (Ic Fluent Fire 24 Regular).png') }}" />
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
      <h1 class="tieu-de">Đặt chỗ của tôi ({{ $datChos->count() }})</h1>
      <p class="ghi-chu">Theo dõi tình trạng đặt chỗ và thời gian dự kiến có sách</p>
    </div>
  </div>

  <div class="group-ngoai-khoi-sach">
    <div class="group-khoi-sach">

      @foreach($datChos as $datCho)
      <div class="khung-chung-sach-lch" data-id-datcho="{{ $datCho->idDatCho }}" data-id-sach="{{ $datCho->idSach }}">

        <div class="khung-anh-sach-lch">
          <img class="image" src="{{ asset($datCho->sach->anhBia) }}" />
        </div>
        <div class="khung-chu-sach-lch">
          <div class="text-wrapper-8">{{ $datCho->sach->tenSach }}</div>
          <div class="text-wrapper-9">Tác giả: {{ $datCho->sach->tacGia }}</div>
          <div class="thoi-gian-sach">
            <div class="text-wrapper-7">Ngày đặt: {{ \Carbon\Carbon::parse($datCho->ngayDat)->format('d/m/Y') }}</div>
            <div class="text-wrapper-10">Dự kiến có sách: {{ \Carbon\Carbon::parse($datCho->thoiGianHetHan)->format('d/m/Y') }}</div>
          </div>

          @php
          $status = $datCho->status;
          @endphp

          <div class="rectangle-8"></div>
          <div class="text-wrapper-12 vi-tri-hang-cho">
            Vị trí {{ $datCho->queueOrder }} trong hàng chờ
          </div>


          <div class="group-chung-lenh-dat-cho">
            @if($status == 'active')
            <div class="rectangle-23 rectangle-dang-cho">
              <img class="icon-thoi-gian" src="{{ asset('images/iconstack.io - (Time).png') }}" />
              <div class="text-wrapper-23">
                <p class="text-wrapper-dang-cho">Đang chờ</p>
              </div>
            </div>
            @elseif($status == 'approved')
            <div class="rectangle-23 rectangle-muon-ngay">
              <img class="icon-thoi-gian" src="{{ asset('images/iconstack.io - (Book) - white.png') }}" />
              <div class="text-wrapper-23">
                <p class="text-wrapper-muon-ngay">Mượn ngay</p>
              </div>
            </div>
            @endif

            <div class="rectangle-24 rectangle-huy-dat-cho">
              <img class="icon-thoi-gian" src="{{ asset('images/iconstack.io - (Cancel 01).png') }}" />
              <div class="text-wrapper-24">
                <p class="text-wrapper-huy-dat-cho">Hủy đặt chỗ</p>
              </div>
            </div>
          </div>
        </div>
      </div>
      @endforeach

    </div>
  </div>
</div>