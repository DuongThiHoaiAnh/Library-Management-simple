document.addEventListener('DOMContentLoaded', () => {

    function updateDashboardStats() {
        fetch('/admin/dashboard-stats')
            .then(res => res.json())
            .then(data => {
                const totalBooksElem = document.getElementById('totalBooks');
                const totalReadersElem = document.getElementById('totalReaders');
                const booksBorrowedElem = document.getElementById('booksBorrowed');

                if(totalBooksElem) totalBooksElem.textContent = data.totalBooks;
                if(totalReadersElem) totalReadersElem.textContent = data.totalReaders;
                if(booksBorrowedElem) booksBorrowedElem.textContent = data.booksBorrowed;
            })
            .catch(err => console.error('Lỗi khi cập nhật dashboard:', err));
    }

    updateDashboardStats();

    window.updateDashboardStats = updateDashboardStats;

});
