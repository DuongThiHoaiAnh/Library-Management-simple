document.addEventListener('DOMContentLoaded', () => {
    const editOverlay = document.getElementById('editOverlay');
    const editModal = document.getElementById('editCategoryModal');
    const closeEditModalBtn = document.getElementById('closeEditCategoryModal');
    const cancelEditBtn = document.getElementById('cancelEditCategory');

    const editMa = document.getElementById('editMa');
    const editTen = document.getElementById('editTen');
    const editMoTa = document.getElementById('editMoTa');
    const editCategoryForm = document.getElementById('editCategoryForm');

    let currentRow = null;

    // Mở popup khi click icon edit
    document.addEventListener('click', (e) => {
        const editBtn = e.target.closest('.edit-icon');
        if (!editBtn) return;

        currentRow = editBtn.closest('tr');
        if (!currentRow) return;

        const cells = currentRow.querySelectorAll('td');
        editMa.value = cells[0].textContent.trim();
        editTen.value = cells[1].textContent.trim();
        editMoTa.value = cells[2].textContent.trim();

        editOverlay.style.display = 'block';
        editModal.style.display = 'block';
    });

    function closeEditPopup() {
        editOverlay.style.display = 'none';
        editModal.style.display = 'none';
        currentRow = null;
        if (editCategoryForm) editCategoryForm.reset();
    }

    if (closeEditModalBtn) closeEditModalBtn.addEventListener('click', closeEditPopup);
    if (cancelEditBtn) cancelEditBtn.addEventListener('click', closeEditPopup);
    if (editOverlay) editOverlay.addEventListener('click', closeEditPopup);

    // Submit form với AJAX
    if (editCategoryForm) {
        editCategoryForm.addEventListener('submit', (e) => {
            e.preventDefault();

            const idDanhMuc = editMa.value.trim();
            const tenDanhMuc = editTen.value.trim();
            const moTa = editMoTa.value.trim();

            if (!tenDanhMuc) {
                alert("⚠ Vui lòng nhập tên danh mục.");
                return;
            }

            // Lấy CSRF token
            const token = editCategoryForm.querySelector('input[name="_token"]').value;

            fetch(`/admin/category-management-admin/${idDanhMuc}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token
                },
                body: JSON.stringify({
                    tenDanhMuc: tenDanhMuc,
                    moTa: moTa
                })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    // Cập nhật row trong table
                    if (currentRow) {
                        const cells = currentRow.querySelectorAll('td');
                        cells[1].textContent = tenDanhMuc;
                        cells[2].textContent = moTa;
                    }
                    alert('✅ Cập nhật danh mục thành công!');
                    closeEditPopup();
                } else {
                    alert('❌ Lỗi: ' + (data.message || 'Không thể cập nhật danh mục'));
                }
            })
            .catch(err => {
                console.error(err);
                alert('❌ Có lỗi xảy ra, vui lòng thử lại.');
            });
        });
    }
});
