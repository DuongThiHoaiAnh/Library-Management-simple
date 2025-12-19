 // Giả lập mật khẩu hiện tại đang lưu trong hệ thống
  let savedPassword = "123456";

  function changePassword() {
    const current = document.getElementById("password").value.trim();
    const newPass = document.getElementById("newPassword").value.trim();
    const confirm = document.getElementById("confirmPassword").value.trim();
    const messageBox = document.getElementById("messageBox");

    // Xóa thông báo cũ
    messageBox.textContent = "";
    messageBox.className = "message";

    // Kiểm tra nhập đủ
    if (!current || !newPass || !confirm) {
      showError("Vui lòng nhập đầy đủ thông tin!");
      return;
    }

    // Kiểm tra mật khẩu hiện tại
    if (current !== savedPassword) {
      showError("Mật khẩu hiện tại không đúng!");
      return;
    }

    // Kiểm tra mật khẩu mới trùng với mật khẩu hiện tại
    if (newPass === savedPassword) {
      showError("Mật khẩu mới không được giống mật khẩu hiện tại!");
      return;
    }

    // Kiểm tra xác nhận
    if (newPass !== confirm) {
      showError("Mật khẩu xác nhận không khớp!");
      return;
    }

    // Đổi mật khẩu thành công
    savedPassword = newPass;
    showSuccess("Đổi mật khẩu thành công!");
    clearForm();
  }

  function showError(message) {
    const box = document.getElementById("messageBox");
    box.textContent = message;
    box.classList.add("error");
  }

  function showSuccess(message) {
    const box = document.getElementById("messageBox");
    box.textContent = message;
    box.classList.add("success");
  }

  function clearForm() {
    document.getElementById("currentPassword").value = "";
    document.getElementById("newPassword").value = "";
    document.getElementById("confirmPassword").value = "";
  }