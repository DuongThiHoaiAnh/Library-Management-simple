// book-filter.js
document.addEventListener('DOMContentLoaded', () => {
  const filterSelect = document.getElementById('filterCategory');
  const searchInput = document.getElementById('searchBook');
  let tableRows = document.querySelectorAll('.book-table tbody tr');

  function filterBooks() {
    const selectedCategory = filterSelect.value.trim(); // idDanhMuc
    const keyword = searchInput.value.trim().toLowerCase();

    tableRows.forEach(row => {
      const cells = row.cells;
      if (!cells || cells.length < 8) return;

      const maSach = cells[0].textContent.trim().toLowerCase();
      const tenSach = cells[1].textContent.trim().toLowerCase();
      const tacGia = cells[2].textContent.trim().toLowerCase();
      const categoryId = cells[5].dataset.id ? cells[5].dataset.id.trim() : '';

      const matchCategory = (selectedCategory === "" || categoryId === selectedCategory);
      const matchKeyword = (maSach.includes(keyword) || tenSach.includes(keyword) || tacGia.includes(keyword));

      row.style.display = (matchCategory && matchKeyword) ? "" : "none";
    });
  }

  if (filterSelect) filterSelect.addEventListener('change', filterBooks);
  if (searchInput) searchInput.addEventListener('input', filterBooks);

  function updateTableRows() {
    tableRows = document.querySelectorAll('.book-table tbody tr');
    filterBooks();
  }

  window.updateTableRows = updateTableRows;

  filterBooks();
});
