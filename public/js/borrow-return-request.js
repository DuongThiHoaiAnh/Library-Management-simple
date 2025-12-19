const tickIcons = document.querySelectorAll('.icon-tick');
const xIcons = document.querySelectorAll('.icon-x');

function changeStatus(row, newStatusText, newStatusClass) {
  const statusSpan = row.querySelector('.status'); 

  statusSpan.classList.remove('pending', 'approved', 'rejected');
  statusSpan.classList.add(newStatusClass);
  statusSpan.textContent = newStatusText;
}

function updateStatusInDatabase(id, newStatus) {
  fetch(`/admin/borrow-returns/${id}/update-status`, {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
    },
    body: JSON.stringify({ trangThaiCT: newStatus })
  })
  .then(res => res.json())
  .then(data => {
    if (!data.success) {
      alert('Cập nhật thất bại: ' + data.message);
    }
  })
  .catch(err => console.error(err));
}

tickIcons.forEach(icon => {
  icon.addEventListener('click', function () {
    const row = this.closest('tr'); 
    const id = this.dataset.id;
    changeStatus(row, 'Đã duyệt', 'approved');
    updateStatusInDatabase(id, 'approved');
  });
});

xIcons.forEach(icon => {
  icon.addEventListener('click', function () {
    const row = this.closest('tr');
    const id = this.dataset.id;
    changeStatus(row, 'Từ chối', 'rejected');
    updateStatusInDatabase(id, 'rejected');
  });
});
