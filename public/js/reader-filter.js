document.addEventListener('DOMContentLoaded', () => {
    const searchInput = document.getElementById('searchReader');

    function filterReaders() {
        const keyword = searchInput.value.trim().toLowerCase();
        const tableRows = document.querySelectorAll('.reader-table tbody tr');

        tableRows.forEach(row => {
            const maDocGia = row.cells[0].textContent.trim().toLowerCase();
            const tenDocGia = row.cells[1].textContent.trim().toLowerCase();
            const email = row.cells[2].textContent.trim().toLowerCase();
            const soDienThoai = row.cells[3].textContent.trim().toLowerCase();

            const matchKeyword = (
                maDocGia.includes(keyword) || 
                tenDocGia.includes(keyword) || 
                email.includes(keyword) || 
                soDienThoai.includes(keyword)
            );

            row.style.display = matchKeyword ? '' : 'none';
        });
    }

    searchInput.addEventListener('input', filterReaders);
});
