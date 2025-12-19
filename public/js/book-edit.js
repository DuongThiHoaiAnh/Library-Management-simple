document.addEventListener('DOMContentLoaded', () => {

  const editModal = document.getElementById('editModal');
  const editOverlay = document.getElementById('editOverlay');
  const closeEditModal = document.getElementById('closeEditModal');
  const cancelEditBtn = document.getElementById('cancelEditBtn');
  const editForm = document.getElementById('editForm');

  const editMa = document.getElementById('editMa');
  const editTen = document.getElementById('editTen');
  const editTacGia = document.getElementById('editTacGia');
  const editNamXuatBan = document.getElementById('editNamXuatBan');
  const editMoTa = document.getElementById('editMoTa');
  const editTheLoai = document.getElementById('editTheLoai');
  const editSoLuong = document.getElementById('editSoLuong');
  const editVitri = document.getElementById('editvitri');
  const editAnhBia = document.getElementById('editAnhBia');
  const editAnhBiaOld = document.getElementById('editAnhBiaOld');

  let currentRow = null;

  function openEditPopup(row) {
    currentRow = row;
    const cells = row.querySelectorAll('td');

    editMa.value = cells[0].textContent;
    editTen.value = cells[1].textContent;
    editTacGia.value = cells[2].textContent;
    editNamXuatBan.value = cells[3].textContent;
    editMoTa.value = cells[4].textContent;
    editTheLoai.value = cells[5].dataset.id || '';
    editSoLuong.value = cells[6].textContent;
    editVitri.value = cells[7].textContent;
    editAnhBiaOld.value = currentRow.dataset.anhbia || '';

    editModal.style.display = 'block';
    editOverlay.style.display = 'block';
  }

  function closeEditPopup() {
    editModal.style.display = 'none';
    editOverlay.style.display = 'none';
    editForm.reset();
    currentRow = null;
  }

  document.querySelectorAll('.edit-icon').forEach(icon => {
    icon.addEventListener('click', () => {
      const row = icon.closest('tr');
      openEditPopup(row);
    });
  });

  closeEditModal.addEventListener('click', closeEditPopup);
  cancelEditBtn.addEventListener('click', closeEditPopup);
  editOverlay.addEventListener('click', closeEditPopup);

  editForm.addEventListener('submit', function (e) {
    e.preventDefault();
    if (!currentRow) return;

    const bookId = currentRow.dataset.id;
    const formData = new FormData();

    formData.append('tenSach', editTen.value.trim());
    formData.append('tacGia', editTacGia.value.trim());
    formData.append('namXuatBan', editNamXuatBan.value.trim());
    formData.append('moTa', editMoTa.value.trim());
    formData.append('idDanhMuc', editTheLoai.value);
    formData.append('soLuong', editSoLuong.value.trim());
    formData.append('vitri', editVitri.value.trim());
    formData.append('_method', 'PUT');
    formData.append('_token', document.querySelector('input[name="_token"]').value);

    const editAnhBiaOld = document.querySelector('#editAnhBiaOld');

    if (editAnhBia.files.length > 0) {
      const file = editAnhBia.files[0];
      const allowedTypes = ['image/png', 'image/jpeg'];
      if (!allowedTypes.includes(file.type)) {
        alert('❌ Ảnh bìa chỉ chấp nhận PNG hoặc JPG');
        return;
      }
      formData.append('anhBia', file);
    } else {
      formData.append('anhBiaOld', editAnhBiaOld.value);
    }

    fetch(`/admin/book-management-admin/${bookId}`, {
      method: 'POST',
      headers: {
        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
        'Accept': 'application/json'
      },
      body: formData
    })
      .then(res => res.json())
      .then(data => {
        if (data.success) {
          const cells = currentRow.querySelectorAll('td');
          cells[1].textContent = editTen.value.trim();
          cells[2].textContent = editTacGia.value.trim();
          cells[3].textContent = editNamXuatBan.value.trim();
          cells[4].textContent = editMoTa.value.trim();
          cells[5].textContent = editTheLoai.options[editTheLoai.selectedIndex].textContent;
          cells[5].dataset.id = editTheLoai.value;
          cells[6].textContent = editSoLuong.value.trim();
          cells[7].textContent = editVitri.value.trim();

          alert('✅ Cập nhật sách thành công!');
          closeEditPopup();
        } else {
          alert('❌ Cập nhật thất bại: ' + (data.message || 'Lỗi server'));
        }
      })
      .catch(err => {
        console.error(err);
        alert('❌ Có lỗi xảy ra khi cập nhật sách.');
      });
  });
});
