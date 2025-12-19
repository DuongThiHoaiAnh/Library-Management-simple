@include('admin.layouts.mold-borrow-return-management-admin')
<meta name="csrf-token" content="{{ csrf_token() }}">

<section class="dashboard-content">
  <div class="dashboard-header">
    <h1 class="title">Quản lý mượn trả</h1>
    <h3 class="subtitle">Danh sách yêu cầu mượn trả chưa duyệt</h3>

  </div>

  <!-- Tìm kiếm -->
  <div class="borrow-return-filter-container">
    <form method="GET" action="{{ route('admin.borrow-returns') }}" class="search-box">
      <img src="{{ asset('images/iconstack.io - (Search)-grey.png') }}">
      <input type="text" name="search" placeholder="Tìm kiếm theo mã yêu cầu, tên độc giả, tên sách, loại yêu cầu..." value="{{ request('search') }}">
    </form>
  </div>

  <!-- Bảng danh sách yêu cầu mượn trả -->
  <div class="table-wrapper">
    <div class="table-scroll">
      <table class="borrow-return-table">
        <thead>
          <tr>
            <th>Mã yêu cầu</th>
            <th>Tên độc giả</th>
            <th>Tên sách</th>
            <th>Loại yêu cầu</th>
            <th>Ngày yêu cầu</th>
            <th>Trạng thái</th>
            <th>Thao tác</th>
          </tr>
        </thead>
        <tbody id="borrow-return-tbody">
          @forelse($borrowReturns as $item)
          <tr id="row-{{ $item->idPhieuMuonChiTiet }}">
            <td>{{ 'BR'.str_pad($item->idPhieuMuonChiTiet, 3, '0', STR_PAD_LEFT) }}</td>
            <td>{{ $item->nguoiMuon }}</td>
            <td>{{ $item->tenSach }}</td>
            <td>
              @if($item->ghiChu == 'borrow')
              <span class="sta borrow">Mượn sách</span>
              @else
              <span class="sta return">Trả sách</span>
              @endif
            </td>
            <td>{{ $item->phieuMuon->created_at->format('d/m/Y') }}</td>
            <td>
              <span class="status pending">Chờ duyệt</span>
            </td>
            <td class="actions">
              <!-- Chấp nhận -->
              <svg class="icon-tick" data-id="{{ $item->idPhieuMuonChiTiet }}" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="20 6 9 17 4 12"></polyline>
              </svg>
              <!-- Từ chối -->
              <svg class="icon-x" data-id="{{ $item->idPhieuMuonChiTiet }}" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                <line x1="18" y1="6" x2="6" y2="18"></line>
                <line x1="6" y1="6" x2="18" y2="18"></line>
              </svg>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="7" class="text-center">Không có yêu cầu đang chờ được duyệt</td>
          </tr>
          @endforelse
        </tbody>

      </table>
    </div>
  </div>
</section>

<!-- Popup xác nhận -->
<div id="confirmation-popup" style="display:none; position: fixed; top:50%; left:50%; transform:translate(-50%,-50%); background:#fff; padding:20px; border-radius:10px; box-shadow:0 4px 12px rgba(0,0,0,0.3); z-index:9999;">
  <p id="popup-message"></p>
  <button id="popup-close" style="margin-top:10px;padding:5px 10px;">Đóng</button>
</div>




<script src="{{ asset('js/borrow-return-filter.js') }}"></script>
<!-- <script src="{{ asset('js/borrow-return-request.js') }}"></script> -->

<script>
  document.addEventListener('DOMContentLoaded', () => {
    const token = document.querySelector('meta[name="csrf-token"]').content;

    const popup = document.getElementById('confirmation-popup');
    const popupMessage = document.getElementById('popup-message');
    const popupClose = document.getElementById('popup-close');
    popupClose.addEventListener('click', () => popup.style.display = 'none');

    function showPopup(message) {
      popupMessage.textContent = message;
      popup.style.display = 'block';
      setTimeout(() => popup.style.display = 'none', 5000);
    }

    function handleAction(idChiTiet, type, status) {
      const url = type === 'borrow' ?
        `/admin/approve-borrow/${idChiTiet}` :
        `/admin/approve-return/${idChiTiet}`;

      fetch(url, {
          method: 'POST',
          headers: {
            'X-CSRF-TOKEN': token,
            'Accept': 'application/json',
            'Content-Type': 'application/json'
          },
          body: JSON.stringify({
            trangThaiCT: status
          })
        })
        .then(res => res.json())
        .then(data => {
          showPopup(data.message);
          const row = document.getElementById(`row-${idChiTiet}`);
          if (row) row.remove();
        })
        .catch(err => console.error(err));
    }

    document.querySelectorAll('.icon-tick').forEach(el => {
      el.addEventListener('click', () => {
        const idChiTiet = el.dataset.id;
        const type = el.closest('tr').querySelector('td:nth-child(4) .sta').classList.contains('borrow') ?
          'borrow' :
          'return';
        handleAction(idChiTiet, type, 'approved');
      });

    });

    document.querySelectorAll('.icon-x').forEach(el => {
      el.addEventListener('click', () => {
        const idChiTiet = el.dataset.id;
        handleAction(idChiTiet, 'rejected');
      });
    });
  });
</script>
</main>
</body>

</html>