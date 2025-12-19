document.querySelectorAll('.reset-icon').forEach(icon => {
    icon.addEventListener('click', function() {
        const row = this.closest('tr');
        const readerId = row.dataset.id; 
        const email = row.cells[2].textContent.trim();
        const defaultPassword = "12345678";

        if (!confirm(`Bạn có chắc muốn đặt lại mật khẩu cho ${email} về mặc định [123456]?`)) return;

        fetch(`/admin/reader-management-admin/reset-password/${readerId}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            }
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                alert(`✅ Mật khẩu của tài khoản ${email} đã được đặt lại thành: ${defaultPassword}`);
            } else {
                alert(`❌ ${data.message}`);
            }
        })
        .catch(err => {
            console.error(err);
            alert('❌ Có lỗi xảy ra, vui lòng thử lại.');
        });
    });
});
