<div class="khoi-group3-4-14">
  <div class="group-2-choosen">
    <div class="div">
      <a class="group-6 @if($activeTab == 'sachdangmuon') active @endif" data-url="{{ route('user.content-mtra-sachdangmuon') }}">
        <div class="rectangle-6">
          <div class="text-wrapper-5">Sách đang mượn</div>
          <div>
            <img class="iconstack-io-book-2" src="{{ asset('images/iconstack.io - (Book) - white.png') }}" alt="Icon sách đang mượn" />
          </div>
        </div>
      </a>
      <a class="group-7 @if($activeTab == 'muonsachmoi') active @endif" data-url="{{ route('user.content-mtra-muonsachmoi') }}">
        <div class="rectangle-7">
          <div>
            <img class="iconstack-io" src="{{ asset('images/iconstack.io - (Bookmark) - Purple.png') }}" alt="Icon mượn sách mới" />
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
      <h1 class="tieu-de">Sách đang mượn ({{ $soSachDangMuon }})</h1>

      <p class="ghi-chu">Quản lý các cuốn sách bạn đang mượn và theo dõi hạn trả</p>
    </div>
  </div>
  <div class="group-ngoai-khoi-sach">
    <div class="group-khoi-sach">
      @foreach($muonChiTiets as $chiTiet)
      @php
      $dueDate = \Carbon\Carbon::parse($chiTiet->due_date);
      $today = \Carbon\Carbon::today();
      $daysRemaining = $today->diffInDays($dueDate, false);
      @endphp
      <div class="khung-chung-sach-lch">
        <div class="khung-anh-sach-lch">
          <img class="image"
            src="{{ $chiTiet->sach && $chiTiet->sach->anhBia ? asset($chiTiet->sach->anhBia) : asset('images/default-book.jpg') }}"
            alt="{{ $chiTiet->tenSach }}">
        </div>
        <div class="khung-chu-sach-lch">
          <div class="text-wrapper-8">{{ $chiTiet->tenSach }}</div>
          <div class="text-wrapper-9">Tác giả: {{ $chiTiet->sach->tacGia }}</div>
          <div class="thoi-gian-sach">
            <div class="text-wrapper-7">Ngày mượn: {{ \Carbon\Carbon::parse($chiTiet->borrow_date)->format('d/m/Y') }}</div>
            <div class="text-wrapper-10">Hạn trả: {{ $dueDate->format('d/m/Y') }}</div>
          </div>
          @if($daysRemaining >= 0)
          <div class="rectangle-10 rectangle-con-han"></div>
          <div class="text-wrapper-12 text-wrapper-con-han">Còn {{ $daysRemaining }} ngày</div>
          @else
          <div class="rectangle-8 rectangle-qua-han"></div>
          <div class="text-wrapper-12 text-wrapper-qua-han">Quá hạn {{ abs($daysRemaining) }} ngày</div>
          @endif

          <!-- Nút Trả sách -->
          <div class="group-chung-lenh-dat-cho">
            <button class="rectangle-23 return-book-btn" data-id="{{ $chiTiet->idPhieuMuonChiTiet }}">
              <img class="icon-thoi-gian" src="{{ asset('images/iconstack.io - (Book) - white.png') }}" alt="Trả sách icon" />
              <div class="text-wrapper-23">
                <p class="text-wrapper-dang-cho">Trả sách</p>
              </div>
            </button>
          </div>



        </div>
      </div>
      @endforeach
      @if($muonChiTiets->isEmpty())
      <p>Bạn chưa mượn sách nào.</p>
      @endif

      

    </div>
  </div>
</div>