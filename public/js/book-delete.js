document.addEventListener('DOMContentLoaded', () => {
  const deleteModal = document.getElementById('deleteModal');
  const deleteCancelBtn = document.getElementById('deleteCancelBtn');
  const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');
  const deleteMessage = document.getElementById('deleteMessage');

  let rowToDelete = null;

  function openDeleteModal(row) {
    rowToDelete = row;
    const bookName = row.querySelectorAll('td')[1].textContent; 
    deleteMessage.textContent = `Bạn có chắc muốn xóa sách "${bookName}"?`;
    deleteModal.style.display = 'block';
  }

  function closeDeleteModal() {
    deleteModal.style.display = 'none';
    rowToDelete = null;
  }

  function initDeleteEvents() {
    document.querySelectorAll('.delete-icon').forEach(icon => {
      icon.removeEventListener('click', () => { }); 
      icon.addEventListener('click', () => {
        const row = icon.closest('tr');
        openDeleteModal(row);
      });
    });
  }

  initDeleteEvents();

  deleteCancelBtn.addEventListener('click', closeDeleteModal);

  confirmDeleteBtn.addEventListener('click', () => {
    if (!rowToDelete) return;

    const bookId = rowToDelete.dataset.id;

    fetch(`/admin/book-management-admin/${bookId}`, {
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
          alert('❌ ' + (data.message || 'Không thể xóa sách này.'));
        }
        closeDeleteModal();
      })
      .catch(err => {
        console.error(err);
        alert('❌ Có lỗi xảy ra, vui lòng thử lại.');
        closeDeleteModal();
      });
  });

  function updateTableRows() {
    return document.querySelectorAll('.book-table tbody tr');
  }

  if (typeof updateDashboardStats === 'function') {
    updateDashboardStats();
  }
});
