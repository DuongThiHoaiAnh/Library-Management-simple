@extends('admin.layouts.mold-category-management-admin')

@section('content')
<section class="dashboard-content">
    <div class="dashboard-header">
        <h1 class="title">Quản lý danh mục</h1>
        <button class="btn-add-category" id="openAddCategoryModal">+ Thêm danh mục mới</button>
    </div>

    {{-- Search Box --}}
    <div class="category-filter-container">
        <div class="search-box">
            <img src="{{ asset('images/iconstack.io - (Search)-grey.png') }}" alt="Search Icon">
            <input type="text" id="searchCategory" placeholder="Tìm kiếm theo tên danh mục...">
        </div>
    </div>

    {{-- Bảng danh mục --}}
    <div class="table-wrapper">
        <div class="table-scroll">
            <table class="category-table">
                <thead>
                    <tr>
                        <th>Mã danh mục</th>
                        <th>Tên danh mục</th>
                        <th>Mô tả</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($categories as $dm)
                    <tr data-id="{{ $dm->idDanhMuc }}">
                        <td>{{ $dm->idDanhMuc }}</td>
                        <td>{{ $dm->tenDanhMuc }}</td>
                        <td>{{ $dm->moTa }}</td>
                        <td class="actions">
                            <svg xmlns="http://www.w3.org/2000/svg" class="edit-icon" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M4.5 2.25A2.25 2.25 0 002.25 4.5v15A2.25 2.25 0 004.5 21.75h15a2.25 2.25 0 002.25-2.25V12.75a.75.75 0 00-1.5 0V19.5a.75.75 0 01-.75.75h-15a.75.75 0 01-.75-.75v-15a.75.75 0 01.75-.75h7.5a.75.75 0 000-1.5h-7.5z" />
                                <path d="M16.862 3.487a1.5 1.5 0 012.121 2.126l-.793.792-2.12-2.12.792-.793zM14.729 5.616l-6.45 6.45a.75.75 0 00-.19.33l-.75 3a.75.75 0 00.928.928l3-.75a.75.75 0 00.33-.19l6.45-6.45-2.318-2.318z" />
                            </svg>
                            <svg xmlns="http://www.w3.org/2000/svg" class="delete-icon" viewBox="0 0 24 24" fill="currentColor">
                                <path fill-rule="evenodd" d="M9 3.75A1.5 1.5 0 0110.5 2.25h3A1.5 1.5 0 0115 3.75V4.5h4.5a.75.75 0 010 1.5H4.5a.75.75 0 010-1.5H9V3.75zm-3 4.5A.75.75 0 016.75 7.5h10.5a.75.75 0 01.75.75v10.5A2.25 2.25 0 0115.75 21h-7.5A2.25 2.25 0 016 18.75V8.25A.75.75 0 016.75 7.5zM10.5 10.5a.75.75 0 000 1.5v4.5a.75.75 0 001.5 0v-4.5a.75.75 0 00-1.5-1.5zm3 0a.75.75 0 000 1.5v4.5a.75.75 0 001.5 0v-4.5a.75.75 0 00-1.5-1.5z" clip-rule="evenodd" />
                            </svg>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</section>

{{-- Popup Thêm danh mục --}}
<div class="modal-overlay" id="modalOverlay"></div>
<div class="modal" id="addCategoryModal">
    <div class="modal-header">
        <h2>Thêm danh mục mới</h2>
        <span class="modal-close" id="closeAddCategoryModal">&times;</span>
    </div>
    <div class="modal-body">
        <form id="addCategoryForm">
            @csrf

            {{-- Mã danh mục hiển thị nhưng disabled, server sẽ cấp ID --}}
            <label>Mã danh mục</label>
            <input type="text" name="idDanhMuc" placeholder="ID sẽ được cấp tự động" disabled>

            <label>Tên danh mục</label>
            <input type="text" name="tenDanhMuc" placeholder="Nhập tên danh mục" required>

            <label>Mô tả</label>
            <textarea name="moTa" placeholder="Nhập mô tả"></textarea>

            <div class="modal-footer">
                <button type="button" class="btn-cancel" id="cancelAddCategory">Hủy</button>
                <button type="submit" class="btn-submit">Thêm danh mục</button>
            </div>
        </form>
    </div>
</div>


{{-- Popup chỉnh sửa danh mục --}}
<div id="editOverlay" class="modal-overlay"></div>
<div id="editCategoryModal" class="modal">
    <div class="modal-header">
        <h2>Chỉnh sửa danh mục</h2>
        <span id="closeEditCategoryModal" class="modal-close">&times;</span>
    </div>
    <div class="modal-body">
        <form id="editCategoryForm">
            @csrf
            <label>Mã danh mục</label>
            <input type="text" id="editMa" name="idDanhMuc" disabled>

            <label>Tên danh mục</label>
            <input type="text" id="editTen" name="tenDanhMuc">

            <label>Mô tả</label>
            <textarea id="editMoTa" name="moTa"></textarea>

            <div class="modal-footer">
                <button type="button" class="btn-cancel" id="cancelEditCategory">Hủy</button>
                <button type="submit" class="btn-submit">Cập nhật</button>
            </div>
        </form>
    </div>
</div>

{{-- Popup xác nhận xóa --}}
<div id="deleteModal" class="modal-delete">
    <h2>Xóa danh mục</h2>
    <p id="deleteMessage">Bạn có chắc muốn xóa danh mục này?</p>
    <div class="modal-footer">
        <button class="btn-cancel" id="deleteCancelBtn">Hủy</button>
        <button class="btn-delete" id="confirmDeleteBtn">Xóa</button>
    </div>
</div>

@endsection

@section('scripts')
<script src="{{ asset('js/category-add.js') }}"></script>
<script src="{{ asset('js/category-edit.js') }}"></script>
<script src="{{ asset('js/category-delete.js') }}"></script>
<script src="{{ asset('js/category-filter.js') }}"></script>
@endsection