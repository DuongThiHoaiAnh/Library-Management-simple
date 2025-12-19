document.addEventListener('DOMContentLoaded', () => {
    const deleteModal = document.getElementById('deleteReaderModal');
    const cancelBtn = document.getElementById('cancelDeleteReaderBtn');
    const confirmBtn = document.getElementById('confirmDeleteReaderBtn');
    const messageEl = document.getElementById('deleteReaderMessage');

    let currentReaderId = null;
    let currentRow = null;

    document.querySelectorAll('.delete-icon').forEach(icon => {
        icon.addEventListener('click', () => {
            currentRow = icon.closest('tr');
            currentReaderId = currentRow.dataset.id;

            // Lấy tên độc giả từ cột thứ 2
            const readerName = currentRow.cells[1].textContent.trim();

            // Cập nhật message popup
            const messageEl = document.getElementById('deleteReaderMessage');
            messageEl.textContent = `Bạn có chắc muốn xóa độc giả "${readerName}" khỏi hệ thống không?`;

            deleteModal.style.display = 'block';
        });
    });


    cancelBtn.addEventListener('click', () => {
        deleteModal.style.display = 'none';
        currentReaderId = null;
        currentRow = null;
    });

    confirmBtn.addEventListener('click', () => {
        if (!currentReaderId) return;

        fetch(`/admin/reader-management-admin/${currentReaderId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                'Accept': 'application/json'
            }
        })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    if (currentRow) currentRow.remove();
                    alert('✅ Xóa độc giả thành công!');
                } else {
                    alert('❌ Xóa thất bại: ' + (data.message || 'Lỗi server.'));
                }
            })
            .catch(err => alert('Lỗi kết nối: ' + err))
            .finally(() => {
                deleteModal.style.display = 'none';
                currentReaderId = null;
                currentRow = null;
            });
    });

    // 🔹 Ẩn modal khi click ra ngoài
    window.addEventListener('click', (e) => {
        if (e.target === deleteModal) {
            deleteModal.style.display = 'none';
        }
    });
});
