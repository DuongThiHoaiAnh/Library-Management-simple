@extends('admin.layouts.mold-reader-management-admin')

@section('content')
<!-- Nội dung chính -->
<section class="dashboard-content">
    <div class="dashboard-header">
        <h1 class="title">Quản lý độc giả</h1>
        <button class="btn-export-reader" id="exportReaderBtn">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                <polyline points="7 10 12 15 17 10" />
                <line x1="12" y1="15" x2="12" y2="3" />
            </svg>
            Xuất danh sách
        </button>
    </div>

    <!-- Thẻ tổng số độc giả -->
    <div class="cards">
        <div class="card">
            <div class="icon-box green">
                <img src="{{ asset('images/iconstack.io - (User)-white-admin.png') }}" alt="Readers icon">
            </div>
            <div>
                <p class="label">Độc giả đăng ký</p>
                <h2>{{ $readers->count() }}</h2>
            </div>
        </div>
    </div>

    <!-- Tìm kiếm -->
    <div class="reader-filter-container">
        <div class="search-box">
            <img src="{{ asset('images/iconstack.io - (Search)-grey.png') }}">
            <input type="text" id="searchReader" placeholder="Tìm kiếm theo mã, tên, email, SDT...">
        </div>
    </div>

    <!-- Bảng danh sách độc giả -->
    <div class="table-wrapper">
        <div class="table-scroll">
            <table class="reader-table">
                <thead>
                    <tr>
                        <th>Mã độc giả</th>
                        <th>Tên độc giả</th>
                        <th>Email</th>
                        <th>Số điện thoại</th>
                        <th>Thao tác</th>
                        <th>Đặt lại mật khẩu</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($readers as $reader)
                    <tr data-id="{{ $reader->idNguoiDung }}">
                        <td>{{ 'R'.str_pad($reader->idNguoiDung, 3, '0', STR_PAD_LEFT) }}</td>
                        <td>{{ $reader->hoTen }}</td>
                        <td>{{ $reader->email }}</td>
                        <td>{{ $reader->soDienThoai ?? '-' }}</td>
                        <td class="actions-edit-delete">
                            <svg xmlns="http://www.w3.org/2000/svg" class="edit-icon" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M4.5 2.25A2.25 2.25 0 002.25 4.5v15A2.25 2.25 0 004.5 21.75h15a2.25 2.25 0 002.25-2.25V12.75a.75.75 0 00-1.5 0V19.5a.75.75 0 01-.75.75h-15a.75.75 0 01-.75-.75v-15a.75.75 0 01.75-.75h7.5a.75.75 0 000-1.5h-7.5z" />
                                <path d="M16.862 3.487a1.5 1.5 0 012.121 2.126l-.793.792-2.12-2.12.792-.793zM14.729 5.616l-6.45 6.45a.75.75 0 00-.19.33l-.75 3a.75.75 0 00.928.928l3-.75a.75.75 0 00.33-.19l6.45-6.45-2.318-2.318z" />
                            </svg>
                            <svg xmlns="http://www.w3.org/2000/svg" class="delete-icon" viewBox="0 0 24 24" fill="currentColor">
                                <path fill-rule="evenodd" d="M9 3.75A1.5 1.5 0 0110.5 2.25h3A1.5 1.5 0 0115 3.75V4.5h4.5a.75.75 0 010 1.5H4.5a.75.75 0 010-1.5H9V3.75zm-3 4.5A.75.75 0 016.75 7.5h10.5a.75.75 0 01.75.75v10.5A2.25 2.25 0 0115.75 21h-7.5A2.25 2.25 0 016 18.75V8.25A.75.75 0 016.75 7.5zM10.5 10.5a.75.75 0 000 1.5v4.5a.75.75 0 001.5 0v-4.5a.75.75 0 00-1.5-1.5zm3 0a.75.75 0 000 1.5v4.5a.75.75 0 001.5 0v-4.5a.75.75 0 00-1.5-1.5z" clip-rule="evenodd" />
                            </svg>
                        </td>
                        <td class="actions">
                            <svg class="reset-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="1 4 1 10 7 10"></polyline>
                                <path d="M3.51 15a9 9 0 101.73-9.46L1 10"></path>
                            </svg>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</section>

{{-- Popup chỉnh sửa độc giả --}}
<div id="editOverlay" class="modal-overlay"></div>
<div id="editReaderModal" class="modal">
    <div class="modal-header">
        <h2>Chỉnh sửa thông tin độc giả</h2>
        <span id="closeEditReaderModal" class="modal-close">&times;</span>
    </div>
    <div class="modal-body">
        <form id="editReaderForm">
            @csrf

            <label for="editMaReader">Mã độc giả</label>
            <input type="text" id="editMaReader" name="idNguoiDung" disabled>

            <label for="editTenReader">Tên độc giả</label>
            <input type="text" id="editTenReader" name="hoTen" required>

            <label for="editEmailReader">Email</label>
            <input type="email" id="editEmailReader" name="email" required>

            <label for="editPhoneReader">Số điện thoại</label>
            <input type="text" id="editPhoneReader" name="soDienThoai">

            <div class="modal-footer">
                <button type="button" class="btn-cancel" id="cancelEditReader">Hủy</button>
                <button type="submit" class="btn-submit">Cập nhật</button>
            </div>
        </form>
    </div>
</div>

{{-- Popup xác nhận xóa độc giả --}}
<div id="deleteReaderModal" class="modal-delete">
    <h2>Xóa độc giả</h2>
    <p id="deleteReaderMessage">Bạn có chắc muốn xóa độc giả này khỏi hệ thống không?</p>
    <div class="modal-footer">
        <button class="btn-cancel" id="cancelDeleteReaderBtn">Hủy</button>
        <button class="btn-delete" id="confirmDeleteReaderBtn">Xóa</button>
    </div>
</div>


@endsection

@section('scripts')
<script src="{{ asset('js/reader-filter.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
<script src="{{ asset('js/reader-export.js') }}"></script>
<script src="{{ asset('js/reader-resetpw.js') }}"></script>
<script src="{{ asset('js/reader-edit.js') }}"></script>
<script src="{{ asset('js/reader-delete.js') }}"></script>
<style>
    /* 2 nút edit, delete */
    .actions-edit-delete {
        gap: 20px;
        font-size: 18px;
    }

    .edit-icon {
        width: 23px;
        height: 23px;
        color: #007bff;
        cursor: pointer;
        transition: 0.3s;
        margin-left: 12px;
    }

    .edit-icon:hover {
        color: #0056b3;
        transform: scale(1.1);
    }

    .delete-icon {
        width: 23px;
        height: 23px;
        color: #e74c3c;
        cursor: pointer;
        transition: 0.3s;
    }

    .delete-icon:hover {
        color: #c0392b;
        transform: scale(1.1);
    }
</style>
@endsection