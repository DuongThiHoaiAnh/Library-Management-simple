document.addEventListener('DOMContentLoaded', () => {
  // --- DOM elements ---
  const deleteModal = document.getElementById('deleteModal');
  const deleteCancelBtn = document.getElementById('deleteCancelBtn');
  const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');
  const deleteMessage = document.getElementById('deleteMessage');

  let rowToDelete = null;

  // --- Hàm mở popup xóa ---
  function openDeleteModal(row) {
    rowToDelete = row;
    const cells = row.querySelectorAll('td');
    const categoryName = (cells[1]?.textContent || '').trim(); // tên danh mục
    const categoryId = row.dataset.id; // <tr data-id="...">
    deleteMessage.textContent = `Bạn có chắc muốn xóa danh mục "${categoryName}" (ID: ${categoryId})?`;
    deleteModal.style.display = 'block';
  }

  // --- Hàm đóng popup ---
  function closeDeleteModal() {
    deleteModal.style.display = 'none';
    rowToDelete = null;
  }

  // --- Event click icon delete ---
  function initDeleteEvents() {
    document.querySelectorAll('.delete-icon').forEach(icon => {
      icon.removeEventListener('click', () => {}); // tránh bind trùng
      icon.addEventListener('click', () => {
        const row = icon.closest('tr');
        if (!row) return;
        openDeleteModal(row);
      });
    });
  }

  initDeleteEvents();

  // --- Event đóng popup ---
  deleteCancelBtn.addEventListener('click', closeDeleteModal);

  // --- Xóa danh mục ---
  confirmDeleteBtn.addEventListener('click', () => {
    if (!rowToDelete) return;

    const categoryId = rowToDelete.dataset.id;

    fetch(`/admin/category-management-admin/${categoryId}`, {
      method: 'DELETE',
      headers: {
        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
        'Accept': 'application/json'
      }
    })
    .then(res => res.json())
    .then(data => {
      if (data.success) {
        rowToDelete.remove();
        alert('✅ ' + data.message);
      } else {
        alert('❌ ' + data.message); // ví dụ: "Không thể xóa danh mục vì còn sách liên quan"
      }
      closeDeleteModal();
    })
    .catch(err => {
      console.error(err);
      alert('❌ Lỗi hệ thống, vui lòng thử lại sau.');
      closeDeleteModal();
    });
  });

  // --- Nếu table thêm row mới, gọi lại để gán sự kiện delete ---
  function refreshDeleteEvents() {
    initDeleteEvents();
  }
});
