# Website môn Lập trình PHP - nhóm Simple

# Dự án Quản Lý Thư Viện

## Mục đích dự án
Xây dựng hệ thống **quản lý thư viện** cho phép:

Người dùng (độc giả): 
- Đăng ký tài khoản, 
- Tra cứu sách
- Mượn – trả trực tuyến
- Xem lịch sử mượn 
- Đặt chỗ sách.

Quản trị viên: 
- quản lý sách.
- Quản lý danh mục.
- Quản lý độc giả.
- Quản lý tình trạng mượn/trả. 
- Quản lý xử lý phạt.

Dự án được phát triển trong khuôn khổ môn học **Lập trình PHP**, với mục tiêu thực hành quy trình phát triển ứng dụng web theo mô hình MVC.


## Công nghệ sử dụng (Tech Stack)

- **Ngôn ngữ**: PHP (Framework Laravel) 
- **Giao diện**: HTML, CSS, JavaScript 
- **Cơ sở dữ liệu**: MySQL (qua XAMPP) 
- **Máy chủ phát triển**: XAMPP tích hợp Apache + MySQL
- **Trình quản lý thư viện**: PHP: Composer 
- **Quản lý phiên bản**: Git & GitHub 
- **IDE khuyến nghị**: VS Code / PhpStorm 

## Hướng dẫn cài đặt nhanh (Local setup)

### 1️⃣ Cài đặt môi trường
- Cài XAMPP (phiên bản >= 8.0).
    https://www.apachefriends.org/download.html
    → Khởi động Apache và MySQL trong XAMPP Control Panel.

- Cài Composer (quản lý thư viện PHP).
    https://getcomposer.org/download/

- Đảm bảo PHP có trong biến môi trường (`php -v` hoạt động được trong terminal).

### 2️⃣ Quy trình làm việc từng thành viên

#### 🔹 Bước 1: Clone dự án về

```bash
git clone https://github.com/DuongThiHoaiAnh/Library-Management-simple.git

cd <library-management>
````

#### 🔹 Bước 2: Tạo nhánh riêng để làm việc

```bash
git checkout -b home
```

#### 🔹 Bước 3: Làm việc, chỉnh sửa, thêm code

Thêm file HTML, CSS, JS... vào thư mục.

#### 🔹 Bước 4: Commit thay đổi

```bash
git add .
git commit -m "Thêm giao diện trang home"
```

#### 🔹 Bước 5: Push nhánh lên GitHub

```bash
git push origin home
```
---

### 3️⃣ Cài đặt thư viện Laravel

```bash
composer install
```

### 4️⃣ Tạo file môi trường

```bash
cp .env.example .env
```

Sau đó mở file `.env` và chỉnh các thông tin kết nối MySQL:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=quanly_thuvien
DB_USERNAME=root
DB_PASSWORD=
```

### 5️⃣ Tạo khóa ứng dụng

```bash
php artisan key:generate
```

### 6️⃣ Tạo cơ sở dữ liệu

* Mở **phpMyAdmin** tại `http://localhost/phpmyadmin`
* Tạo database có tên: `quanly_thuvien`
* Nếu có file `database.sql`, import file này vào.

Hoặc nếu dùng Migration:

```bash
php artisan migrate
```

### 7️⃣ Chạy ứng dụng

```bash
php artisan serve
```

Ứng dụng sẽ chạy tại:
    [http://127.0.0.1:8000](http://127.0.0.1:8000)

---

## Ghi chú cho nhóm phát triển

* Không push file `.env` hoặc thư mục `/vendor`.
* Khi cập nhật cơ sở dữ liệu, export lại `database.sql` hoặc cập nhật migration tương ứng.
* Commit code rõ ràng theo chức năng (ví dụ: `feat: thêm chức năng mượn sách`).

---

## Thành viên nhóm

- 49.01.103.002 - Dương Thị Hoài Anh
- 49.01.103.036 - Hứa Ngọc Bảo Khanh
- 49.01.103.077 - Châu Hoàn Thiện
- 49.01.103.065 - Đặng Minh Phúc


# Update
- Link Deploy Render : `https://library-management-simple.onrender.com`