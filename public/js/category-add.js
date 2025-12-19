console.log('JS is running');

document.addEventListener('DOMContentLoaded', () => {
    const addCategoryModal = document.getElementById('addCategoryModal');
    const addOverlay = document.getElementById('modalOverlay');
    const openAddCategoryModalBtn = document.getElementById('openAddCategoryModal');
    const closeAddCategoryModalBtn = document.getElementById('closeAddCategoryModal');
    const cancelAddCategoryBtn = document.getElementById('cancelAddCategory');
    const addCategoryForm = document.getElementById('addCategoryForm');
    const categoryTableBody = document.querySelector('.category-table tbody');

    function closeAddModal() {
        addCategoryModal.style.display = 'none';
        addOverlay.style.display = 'none';
        addCategoryForm.reset();
    }

    openAddCategoryModalBtn.addEventListener('click', () => {
        addCategoryModal.style.display = 'block';
        addOverlay.style.display = 'block';
    });

    closeAddCategoryModalBtn.addEventListener('click', closeAddModal);
    cancelAddCategoryBtn.addEventListener('click', closeAddModal);
    addOverlay.addEventListener('click', closeAddModal);

    addCategoryForm.addEventListener('submit', function (e) {
        e.preventDefault();
        const formData = new FormData(addCategoryForm);

        const tenDanhMuc = formData.get('tenDanhMuc').trim();
        if (!tenDanhMuc) {
            alert('⚠ Vui lòng nhập tên danh mục.');
            return;
        }

        let duplicate = false;
        document.querySelectorAll('.category-table tbody tr').forEach(row => {
            const existingTen = row.querySelector('td:nth-child(2)').textContent.trim();
            if (existingTen.toLowerCase() === tenDanhMuc.toLowerCase()) {
                duplicate = true;
            }
        });

        if (duplicate) {
            alert('⚠ Tên danh mục đã tồn tại!');
            return;
        }

        fetch(`${window.location.origin}/admin/category-management-admin`, {
            method: 'POST',
            credentials: 'include',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: formData
        })

            .then(res => {
                if (!res.ok) throw new Error(`HTTP error! status: ${res.status}`);
                return res.json();
            })
            .then(data => {
                if (data.success) {
                    alert('✅ Thêm danh mục thành công: ' + data.category.tenDanhMuc);

                    if (categoryTableBody) {
                        const newRow = document.createElement('tr');
                        newRow.setAttribute('data-id', data.category.idDanhMuc);
                        newRow.innerHTML = `
                <td>${data.category.idDanhMuc}</td>
                <td>${data.category.tenDanhMuc}</td>
                <td>${data.category.moTa || '-'}</td>
                <td class="actions-edit-delete">
                    <svg xmlns="http://www.w3.org/2000/svg" class="edit-icon" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M4.5 2.25A2.25 2.25 0 002.25 4.5v15A2.25 2.25 0 004.5 21.75h15a2.25 2.25 0 002.25-2.25V12.75a.75.75 0 00-1.5 0V19.5a.75.75 0 01-.75.75h-15a.75.75 0 01-.75-.75v-15a.75.75 0 01.75-.75h7.5a.75.75 0 000-1.5h-7.5z" />
                        <path d="M16.862 3.487a1.5 1.5 0 012.121 2.126l-.793.792-2.12-2.12.792-.793zM14.729 5.616l-6.45 6.45a.75.75 0 00-.19.33l-.75 3a.75.75 0 00.928.928l3-.75a.75.75 0 00.33-.19l6.45-6.45-2.318-2.318z" />
                    </svg>
                    <svg xmlns="http://www.w3.org/2000/svg" class="delete-icon" viewBox="0 0 24 24" fill="currentColor">
                        <path fill-rule="evenodd" d="M9 3.75A1.5 1.5 0 0110.5 2.25h3A1.5 1.5 0 0115 3.75V4.5h4.5a.75.75 0 010 1.5H4.5a.75.75 0 010-1.5H9V3.75zm-3 4.5A.75.75 0 016.75 7.5h10.5a.75.75 0 01.75.75v10.5A2.25 2.25 0 0115.75 21h-7.5A2.25 2.25 0 016 18.75V8.25A.75.75 0 016.75 7.5zM10.5 10.5a.75.75 0 000 1.5v4.5a.75.75 0 001.5 0v-4.5a.75.75 0 00-1.5-1.5zm3 0a.75.75 0 000 1.5v4.5a.75.75 0 001.5 0v-4.5a.75.75 0 00-1.5-1.5z" clip-rule="evenodd" />
                    </svg>
                </td>
            `;
                        categoryTableBody.appendChild(newRow);
                    }

                    closeAddModal();
                } else {
                    alert('❌ Lỗi: ' + (data.message || 'Không thể thêm danh mục.'));
                }
            })
            .catch(err => console.error('Fetch error:', err));
    });


    function initEditAndDeleteEvents() {
        if (typeof initEditCategoryEvents === 'function') initEditCategoryEvents();
        if (typeof initDeleteCategoryEvents === 'function') initDeleteCategoryEvents();
    }
});
