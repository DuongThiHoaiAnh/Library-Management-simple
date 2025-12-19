const tableRows = document.querySelectorAll('.borrow-return-table tbody tr');
const searchInput = document.querySelector('.search-box input');

function filterBooks() {
  const keyword = searchInput.value.trim().toLowerCase();

  tableRows.forEach(row => {
    const maYeuCau = row.cells[0]?.textContent.trim().toLowerCase() || "";
    const tenDocGia = row.cells[1]?.textContent.trim().toLowerCase() || "";
    const tenSach = row.cells[2]?.textContent.trim().toLowerCase() || "";
    const loaiYeuCau = row.cells[3]?.textContent.trim().toLowerCase() || "";

    // Kiểm tra nếu keyword xuất hiện trong bất kỳ cột nào
    const matchKeyword =
      maYeuCau.includes(keyword) ||
      tenDocGia.includes(keyword) ||
      tenSach.includes(keyword) ||
      loaiYeuCau.includes(keyword);

    // Ẩn hoặc hiện dòng
    row.style.display = matchKeyword ? "" : "none";
  });
}

// Gọi khi người dùng nhập
searchInput.addEventListener('input', filterBooks);
