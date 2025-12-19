@extends('admin.layouts.mold-finemoney-management-admin')

@section('title', 'Quản lý phạt')

@section('content')
<section class="dashboard-content">
  <div class="dashboard-header-fine">
    <h1 class="title">Quản lý phạt</h1>
    <h3 class="subtitle">Danh sách phiếu phạt chưa duyệt thanh toán</h3>
  </div>

  <!-- Tìm kiếm -->
  <div class="borrow-return-filter-container">
    <div class="search-box">
      <img src="{{ asset('images/iconstack.io - (Search)-grey.png') }}">
      <input type="text" class="search-input" placeholder="Tìm kiếm theo mã phiếu, tên độc giả, tên sách..." />
    </div>
  </div>

  <!-- Bảng danh sách phiếu phạt pending -->
  <div class="table-wrapper">
    <div class="table-scroll">
      <table class="finemoney-table">
        <thead>
          <tr>
            <th>Mã phiếu mượn</th>
            <th>Tên độc giả</th>
            <th>Tên sách</th>
            <th>Số ngày trễ</th>
            <th>Số tiền phạt</th>
            <th>Thao tác</th>
          </tr>
        </thead>
        <tbody>
          @forelse($fines as $fine)
          @if($fine->trangThaiThanhToan === 'pending')
          <tr id="row-{{ $fine->idPhat }}" data-id="{{ $fine->idPhat }}">
            <td>{{ 'BR'.str_pad($fine->phieuMuonChiTiet->idPhieuMuonChiTiet ?? 0, 3, '0', STR_PAD_LEFT) }}</td>
            <td>{{ $fine->nguoiDung->hoTen }}</td>
            <td>{{ $fine->phieuMuonChiTiet?->sach?->tenSach ?? '-' }}</td>
            <td>{{ $fine->soNgayTre ?? '-' }}</td>
            <td>{{ $fine->soNgayTre ? number_format($fine->soNgayTre*5000,0,',','.') : '-' }}</td>
            <td class="actions">
              <!-- Duyệt phiếu phạt -->
              <svg class="icon-tick-fine" data-id="{{ $fine->idPhat }}" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="20 6 9 17 4 12"></polyline>
              </svg>

            </td>
          </tr>
          @endif
          @empty
          <tr>
            <td colspan="6" class="text-center">Không có phiếu phạt pending</td>
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
@endsection
