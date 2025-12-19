document.addEventListener('DOMContentLoaded', () => {
  const addBookModal = document.getElementById('addBookModal');
  const addOverlay = document.getElementById('modalOverlay');
  const openAddBookModal = document.getElementById('openAddBookModal');
  const closeAddBookModal = document.getElementById('closeAddBookModal');
  const cancelAddBook = document.getElementById('cancelAddBook');
  const addBookForm = document.getElementById('addBookForm');
  const bookTableBody = document.querySelector('.book-table tbody');

  const currentYear = new Date().getFullYear();

  function closeAddModal() {
    addBookModal.style.display = 'none';
    addOverlay.style.display = 'none';
    addBookForm.reset();
  }

  openAddBookModal.addEventListener('click', () => {
    addBookModal.style.display = 'block';
    addOverlay.style.display = 'block';
  });

  closeAddBookModal.addEventListener('click', closeAddModal);
  cancelAddBook.addEventListener('click', closeAddModal);
  addOverlay.addEventListener('click', closeAddModal);

  addBookForm.addEventListener('submit', function (e) {
    e.preventDefault();

    const formData = new FormData(addBookForm);

    const addAnhBia = document.querySelector('#addAnhBia');
    if (addAnhBia && addAnhBia.files.length > 0) {
      formData.append('anhBia', addAnhBia.files[0]);
    }

    const year = parseInt(formData.get('namXuatBan'));
    if (year > currentYear) {
      alert('Năm xuất bản không được vượt quá năm hiện tại.');
      return;
    }

    fetch('/admin/book-management-admin', {
      method: 'POST',
      headers: {
        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
      },
      body: formData
    })
      .then(res => res.json())
      .then(data => {
        if (data.success) {
          const newBook = data.book;

          const newRow = document.createElement('tr');
          newRow.dataset.id = newBook.idSach;
          newRow.innerHTML = `
          <td>${newBook.maSach}</td>
          <td>${newBook.tenSach}</td>
          <td>${newBook.tacGia}</td>
          <td>${document.querySelector('#addTheLoai option:checked').textContent}</td>
          <td>${newBook.soLuong}</td>
          <td>${newBook.vitri}</td>
          <td>
            ${newBook.anhBia ? `<img src="${newBook.anhBia}" alt="Bìa sách" style="width:50px;height:auto;">` : 'Chưa có'}
          </td>
          <td class="actions">
            <svg xmlns="http://www.w3.org/2000/svg" class="edit-icon" data-id="${newBook.idSach}" viewBox="0 0 24 24" fill="currentColor">
              <path d="M4.5 2.25A2.25 2.25 0 002.25 4.5v15A2.25 2.25 0 004.5 21.75h15a2.25 2.25 0 002.25-2.25V12.75a.75.75 0 00-1.5 0V19.5a.75.75 0 01-.75.75h-15a.75.75 0 01-.75-.75v-15a.75.75 0 01.75-.75h7.5a.75.75 0 000-1.5h-7.5z"/>
              <path d="M16.862 3.487a1.5 1.5 0 012.121 2.126l-.793.792-2.12-2.12.792-.793zM14.729 5.616l-6.45 6.45a.75.75 0 00-.19.33l-.75 3a.75.75 0 00.928.928l3-.75a.75.75 0 00.33-.19l6.45-6.45-2.318-2.318z"/>
            </svg>
            <svg xmlns="http://www.w3.org/2000/svg" class="delete-icon" data-id="${newBook.idSach}" viewBox="0 0 24 24" fill="currentColor">
              <path fill-rule="evenodd" d="M9 3.75A1.5 1.5 0 0110.5 2.25h3A1.5 1.5 0 0115 3.75V4.5h4.5a.75.75 0 010 1.5H4.5a.75.75 0 010-1.5H9V3.75zm-3 4.5A.75.75 0 016.75 7.5h10.5a.75.75 0 01.75.75v10.5A2.25 2.25 0 0115.75 21h-7.5A2.25 2.25 0 016 18.75V8.25A.75.75 0 016.75 7.5zM10.5 10.5a.75.75 0 000 1.5v4.5a.75.75 0 001.5 0v-4.5a.75.75 0 00-1.5-1.5zm3 0a.75.75 0 000 1.5v4.5a.75.75 0 001.5 0v-4.5a.75.75 0 00-1.5-1.5z" clip-rule="evenodd"/>
            </svg>
          </td>
        `;

          bookTableBody.appendChild(newRow);

          newRow.querySelector('.edit-icon').addEventListener('click', () => {
            openEditPopup(newRow);
          });
          newRow.querySelector('.delete-icon').addEventListener('click', () => {
            openDeleteModal(newRow);
          });

          alert(data.message);
          closeAddModal();
        } else {
          alert(data.message);
        }
      })
      .catch(err => console.error(err));
  });

  if (typeof updateDashboardStats === 'function') {
    updateDashboardStats();
  }
});
