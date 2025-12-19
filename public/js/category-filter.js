document.addEventListener('DOMContentLoaded', () => {
  const searchInput = document.querySelector('#searchCategory'); 
  const tableBody = document.querySelector('.category-table tbody');

  if (!searchInput || !tableBody) return;

  function filterCategories() {
    const keyword = searchInput.value.trim().toLowerCase();
    const tableRows = tableBody.querySelectorAll('tr');

    tableRows.forEach(row => {
      const tenDanhMucCell = row.cells[1]; 
      if (!tenDanhMucCell) return;

      const tenDanhMuc = tenDanhMucCell.textContent.trim().toLowerCase();
      row.style.display = tenDanhMuc.includes(keyword) ? '' : 'none';
    });
  }

  searchInput.addEventListener('input', filterCategories);
});
