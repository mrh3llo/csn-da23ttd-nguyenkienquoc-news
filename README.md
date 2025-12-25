# 📰 Báo Tin Tức Online

Đây là một trang web báo tin tức trực tuyến được phát triển bằng thư viện thành phần giao diện và có một hệ thống thiết kế cơ bản.

## 📋 Giới Thiệu Dự Án

**Báo Online** là một nền tảng đơn giản để xem, tìm kiếm và quản lý các bài báo tin tức. Trang web được xây dựng bằng:

- **Frontend**: HTML, CSS, JavaScript
- **Backend**: PHP
- **Database**: MySQL/MariaDB
- **Server**: XAMPP (Apache + MySQL)

## ✨ Tính Năng Chính

- 📰 Hiển thị danh sách tin tức
- 🔥 Hiển thị tin tức nóng hổi (Hot News)
- 🔍 Tìm kiếm bài báo theo từ khóa
- 👤 Chức năng đăng nhập / đăng ký
- 🔐 Quên mật khẩu
- 📱 Giao diện responsive, thân thiện với thiết bị di động

## 🗂️ Cấu Trúc Thư Mục

```
Code/
├── configs/          # Các trang cấu hình (HTML)
│   ├── home.html              # Trang chủ
│   ├── news.html              # Trang chi tiết tin tức
│   ├── sign_in.html           # Trang đăng nhập
│   ├── sign_up.html           # Trang đăng ký
│   ├── forgot_password.html   # Trang quên mật khẩu
│   └── ...
├── libs/             # Thư viện JavaScript
│   └── libs.js
├── media/            # Tài nguyên đa phương tiện
│   ├── banner/       # Ảnh banner
│   ├── icons/        # Biểu tượng
│   └── logo/         # Logo website
├── php/              # Các tập tin PHP
│   ├── signIn.php             # Xử lý đăng nhập
│   ├── signUp.php             # Xử lý đăng ký
│   ├── displayNews.php        # Hiển thị tin tức
│   ├── displayListNews.php    # Hiển thị danh sách
│   ├── displayHotNews.php     # Hiển thị tin nóng
│   ├── searchNews.php         # Tìm kiếm tin tức
│   ├── libs.php               # Thư viện PHP
│   └── ...
├── sql/              # Cơ sở dữ liệu
│   └── online_news_db_n_data.sql
├── style/            # Tệp CSS
│   ├── style.css
│   └── components.css
├── index.html        # Trang chuyển hướng chính
└── README.md         # Tài liệu này
```

## 🚀 Hướng Dẫn Cài Đặt và Chạy

### Yêu Cầu Hệ Thống
- XAMPP (hoặc AMP stack tương đương)
- Trình duyệt web hiện đại
- Git (để đồng bộ code)

## 📞 Thông Tin Liên Hệ

### Liên Hệ Nhóm Tác Giả

| Họ và Tên | Email | Điện Thoại |
|-----------|-------|-----------|
| Nguyễn Kiên Quốc | quocmrh3llo@gmail.com | 0705 317 150 |

## 📚 Tài Liệu Bổ Sung

- **Tài Liệu Quá Trình**: Xem `progress-report/` trong thư mục `git/`
- **Repository Git**: https://github.com/mrh3llo/csn-da23ttd-nguyenkienquoc-news.git

## 📝 Ghi Chú Phát Triển

- Đường dẫn CSS/JS: Cần cập nhật khi đưa vào môi trường sản xuất
- Tham khảo file `.process.txt` để hiểu quy trình phát triển
- Tham khảo file `toXAMPP.txt` để hướng dẫn cấu hình XAMPP cụ thể

## 📄 Giấy Phép

Dự án này được tạo cho mục đích học tập. Vui lòng liên hệ với các tác giả trước khi sử dụng.

---

**Phiên bản**: 1.2  
**Cập nhật lần cuối**: Tháng 12, 2025