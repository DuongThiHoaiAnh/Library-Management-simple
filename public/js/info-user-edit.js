window.onload = function () {
    document.getElementById("name").value = localStorage.getItem("name") || "Nguyễn Văn A";
    document.getElementById("phone").value = localStorage.getItem("phone") || "0123456789";
    document.getElementById("email").value = localStorage.getItem("email") || "nguyenvana@email.com";
    document.getElementById("address").value = localStorage.getItem("address") || "123 Đường ABC, Quận 1, TP.HCM";
  };

  function enableEdit() {
    document.querySelectorAll("input").forEach(input => input.disabled = false);
    document.querySelector(".edit-btn").style.display = "none";
    document.querySelector(".save-btn").style.display = "inline-block";
  }

  function saveInfo() {
    // Lưu vào localStorage
    localStorage.setItem("name", document.getElementById("name").value);
    localStorage.setItem("phone", document.getElementById("phone").value);
    localStorage.setItem("email", document.getElementById("email").value);
    localStorage.setItem("address", document.getElementById("address").value);

    document.querySelectorAll("input").forEach(input => input.disabled = true);
    document.querySelector(".edit-btn").style.display = "inline-block";
    document.querySelector(".save-btn").style.display = "none";
    alert("✅ Lưu thông tin thành công (tạm trên trình duyệt)");
  }