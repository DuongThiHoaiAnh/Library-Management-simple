document.addEventListener("DOMContentLoaded", function() {
  const rows = document.querySelectorAll(".finemoney-table tbody tr");
  const FINE_PER_DAY = 5000; // tiền phạt mỗi ngày trễ

  rows.forEach(row => {
    const daysCell = row.querySelector(".dayslate");
    const fineCell = row.querySelector(".finemoney");
    const statusCell = row.querySelector(".status");

    // ----- Tính số tiền phạt -----
    let daysLate = daysCell.textContent.trim();

    if (!isNaN(daysLate) && daysLate !== "-") {
      let fineAmount = parseInt(daysLate) * FINE_PER_DAY;
      fineCell.textContent = fineAmount.toLocaleString("vi-VN");
    } else {
      fineCell.textContent = "-";
    }

    // ----- Gán class cho trạng thái -----
    let statusText = statusCell.textContent.trim().toLowerCase();

    statusCell.classList.remove("paiding", "notyetpaid", "unknown");

    if (statusText.includes("đã trả")) {
      statusCell.classList.add("paiding");
      statusCell.textContent = "Đã trả";
    } else if (statusText.includes("chưa trả")) {
      statusCell.classList.add("notyetpaid");
      statusCell.textContent = "Chưa trả";
    } else {
      statusCell.classList.add("unknown");
      statusCell.textContent = "-";
    }

    // ----- Chuẩn bị toggle trạng thái (click) -----
    statusCell.addEventListener("click", function() {
      const fineId = row.dataset.id; // mỗi row phải có data-id="{{ $fine->idPhat }}"
      if (!fineId) return;

      // xác định trạng thái mới
      let newStatus = statusCell.classList.contains("paiding") ? "pending" : "paid";

      // AJAX request cập nhật database
      fetch(`/admin/fine/${fineId}/toggle-status`, {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
          "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ trangThaiThanhToan: newStatus })
      })
      .then(res => res.json())
      .then(data => {
        if (data.success) {
          statusCell.textContent = data.newStatusText;
          statusCell.className = "status " + data.newStatusClass;
        } else {
          alert("Cập nhật thất bại: " + data.message);
        }
      })
      .catch(err => console.error(err));
    });
  });
});
