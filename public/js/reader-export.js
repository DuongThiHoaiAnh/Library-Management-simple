document.getElementById("exportReaderBtn").addEventListener("click", function () {
    const originalTable = document.querySelector(".reader-table");
    const tableClone = originalTable.cloneNode(true);

    const headerRow = tableClone.querySelector("thead tr");
    headerRow.deleteCell(-1); // xóa ô cuối cùng
    
    const bodyRows = tableClone.querySelectorAll("tbody tr");
    bodyRows.forEach(row => row.deleteCell(-1)); // xóa ô cuối cùng

    const workbook = XLSX.utils.table_to_book(tableClone, { sheet: "Danh sách độc giả" });
    XLSX.writeFile(workbook, "Danh_sach_doc_gia.xlsx");
});
