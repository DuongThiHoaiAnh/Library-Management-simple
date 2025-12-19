document.addEventListener('DOMContentLoaded', () => {
    // Các phần tử popup
    const editOverlay = document.getElementById('editOverlay');
    const editModal = document.getElementById('editReaderModal');
    const closeEditModalBtn = document.getElementById('closeEditReaderModal');
    const cancelEditBtn = document.getElementById('cancelEditReader');

    // Các input trong form
    const editMa = document.getElementById('editMaReader');
    const editTen = document.getElementById('editTenReader');
    const editEmail = document.getElementById('editEmailReader');
    const editPhone = document.getElementById('editPhoneReader');
    const editReaderForm = document.getElementById('editReaderForm');

    let currentRow = null;

    document.addEventListener('click', (e) => {
        const editBtn = e.target.closest('.edit-icon');
        if (!editBtn) return;

        currentRow = editBtn.closest('tr');
        if (!currentRow) return;

        const cells = currentRow.querySelectorAll('td');

        editMa.value = cells[0].textContent.trim();
        editTen.value = cells[1].textContent.trim();
        editEmail.value = cells[2].textContent.trim();
        editPhone.value = cells[3].textContent.trim();

        editOverlay.style.display = 'block';
        editModal.style.display = 'block';
    });

    function closeEditPopup() {
        editOverlay.style.display = 'none';
        editModal.style.display = 'none';
        currentRow = null;
        if (editReaderForm) editReaderForm.reset();
    }

    if (closeEditModalBtn) closeEditModalBtn.addEventListener('click', closeEditPopup);
    if (cancelEditBtn) cancelEditBtn.addEventListener('click', closeEditPopup);
    if (editOverlay) editOverlay.addEventListener('click', closeEditPopup);

    if (editReaderForm) {
        editReaderForm.addEventListener('submit', (e) => {
            e.preventDefault();

            const idNguoiDung = editMa.value.replace(/^R0*/, '');
            const hoTen = editTen.value.trim();
            const email = editEmail.value.trim();
            const soDienThoai = editPhone.value.trim();

            if (!hoTen || !email) {
                alert("⚠ Vui lòng nhập đầy đủ tên và email.");
                return;
            }

            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email)) {
                alert("⚠ Email không hợp lệ.");
                return;
            }

            if (soDienThoai) {
                const phoneRegex = /^0\d{9}$/;
                if (!phoneRegex.test(soDienThoai)) {
                    alert("⚠ Số điện thoại không hợp lệ. Phải bắt đầu bằng 0 và đủ 10 chữ số.");
                    return;
                }
            }

            const token = editReaderForm.querySelector('input[name="_token"]').value;

            fetch(`/admin/reader-management-admin/${idNguoiDung}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token
                },
                body: JSON.stringify({
                    hoTen,
                    email,
                    soDienThoai
                })
            })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        if (currentRow) {
                            const cells = currentRow.querySelectorAll('td');
                            cells[1].textContent = hoTen;
                            cells[2].textContent = email;
                            cells[3].textContent = soDienThoai || '-';
                        }
                        alert('✅ Cập nhật thông tin độc giả thành công!');
                        closeEditPopup();
                    } else {
                        alert('❌ Lỗi: ' + (data.message || 'Không thể cập nhật độc giả.'));
                    }
                })
                .catch(err => {
                    console.error(err);
                    alert('❌ Có lỗi xảy ra, vui lòng thử lại.');
                });
        });
    }
});
