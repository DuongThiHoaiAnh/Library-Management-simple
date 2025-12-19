<div class="rectangle">
  <div class="group-2-choosen">
    <div class="div">
      <a class="group-6" href="{{ url('user/content-all-lsmn') }}">
        <div class="rectangle-6">
          <div class="text-wrapper-5">Lịch sử mượn trả</div>
          <div>
            <img class="iconstack-io-book-2" src="{{ asset('images/iconstack.io - (Book) - white.png') }}" alt="">
          </div>
        </div>
      </a>
      <a class="group-7" href="{{ url('user/content-datcho') }}">
        <div class="rectangle-7">
          <div>
            <img class="iconstack-io" src="{{ asset('images/iconstack.io - (Bookmark) - Purple.png') }}" alt="">
          </div>
          <div class="text-wrapper-6">Lịch sử đặt chỗ</div>
        </div>
      </a>
    </div>
  </div>

  <div class="can-giua-group-chon-lenh">
    <div class="group-chon-lenh">
      <a class="group-8" href="{{ url('user/content-all-lsmn') }}">
        <div class="rectangle-15"></div>
        <div class="text-wrapper-31">Tất cả</div>
      </a>
      <a class="group-9" href="{{ url('user/content-datra-lsmn') }}">
        <div class="rectangle-16"></div>
        <div class="text-wrapper-32">Đã trả</div>
      </a>
      <a class="group-10" href="{{ url('user/tranglichsumuontra/dangmuon') }}">
        <div class="rectangle-17"></div>
        <div class="text-wrapper-33">Đang mượn</div>
      </a>
      <a class="group-11" href="{{ url('user/tranglichsumuontra/tratre') }}">
        <div class="rectangle-31"></div>
        <div class="text-wrapper-34">Trả trễ</div>
      </a>
    </div>
  </div>

  <div class="group-ngoai-khoi-sach">
    <div class="group-khoi-sach">

      {{-- Lặp qua tất cả sách mượn --}}
      @forelse ($muonChiTiets as $chiTiet)
      <div class="khung-chung-sach-lch">
        <div class="khung-anh-sach-lch">
          <img class="image" src="{{ $chiTiet->sach->anhBia ? asset($chiTiet->sach->anhBia) : asset('images/default-book.jpg') }}" alt="{{ $chiTiet->sach->tenSach }}">
        </div>
        <div class="khung-chu-sach-lch">
          <div class="text-wrapper-7">Ngày mượn: {{ \Carbon\Carbon::parse($chiTiet->borrow_date)->format('d/m/Y') }}</div>
          <div class="text-wrapper-8">{{ $chiTiet->sach->tenSach }}</div>
          <div class="text-wrapper-9">Tác giả: {{ $chiTiet->sach->tacGia }}</div>

          <div class="text-wrapper-10">Hạn trả: {{ \Carbon\Carbon::parse($chiTiet->due_date)->format('d/m/Y') }}</div>
          <div class="text-wrapper-11">Ngày trả: {{ \Carbon\Carbon::parse($chiTiet->return_date)->format('d/m/Y') }}</div>
          @php
          $today = \Carbon\Carbon::today();
          $dueDate = \Carbon\Carbon::parse($chiTiet->due_date);
          $isLate = $today->gt($dueDate);
          @endphp

          @if($chiTiet->trangThaiCT === 'approved' && $chiTiet->ghiChu === 'return')

          <div class="rectangle-8"></div>
          <div class="text-wrapper-12 da-tra">Đã trả</div>

          @elseif($chiTiet->trangThaiCT === 'approved' && $chiTiet->ghiChu === 'borrow')
          <div class="rectangle-10"></div>
          <div class="text-wrapper-12 dang-muon">Đang mượn</div>
          @elseif($chiTiet->trangThaiCT === 'pending')
          <div class="rectangle-9"></div>
          <div class="text-wrapper-12 cho-duyet">Chờ duyệt</div>

          @endif

          @php
          $dueDate = \Carbon\Carbon::parse($chiTiet->due_date);
          $returnDate = $chiTiet->return_date ? \Carbon\Carbon::parse($chiTiet->return_date) : null;

          $isReturnedLate = (
          $chiTiet->trangThaiCT === 'approved' &&
          $chiTiet->ghiChu === 'return' &&
          $returnDate &&
          $returnDate->gt($dueDate)
          );

          $soTienPhat = $chiTiet->phats->sum('soTienPhat');
          @endphp

          @if($isReturnedLate)
          <div class="rectangle-12"></div>
          <div class="text-wrapper-12 tra-tre">Trả trễ</div>
          <div class="text-wrapper-13">
            Phạt: {{ number_format($soTienPhat, 0, ',', '.') }}đ
          </div>

          @endif


        </div>
      </div>
      @empty
      <p>Không có lịch sử mượn trả sách nào.</p>
      @endforelse


    </div>
  </div>