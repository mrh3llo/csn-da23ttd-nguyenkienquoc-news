<?php
require 'libs.php';

// Các biến toàn cục
// Biến lưu dữ liệu từ người dùng
$input_username = $_GET["user_name"];
$input_userpasswd = $_GET["user_password"];

echo "user name: " . $input_username . "<br>";
echo "user password: " . md5($input_userpasswd) . "<br>";

// Biến liên quan đến CSDL
$db_connect = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME); // Tạo kết nối đến CSDL

// Kiểm tra kết nối
if($db_connect->connect_error) {
    echo "Kết nối CSDL: Lỗi kết nối!<br>";
} else {
    echo "Kết nối CSDL: Kết nối thành công!<br>";
}

// Biến lưu dữ liệu từ CSDL
$db_username;
$db_userpasswd;

$stmt = $db_connect->prepare('SELECT TEN_TAI_KHOAN, MAT_KHAU_TAI_KHOAN FROM TAI_KHOAN WHERE TEN_TAI_KHOAN = ?');
if (!$stmt) {
    echo "Lỗi chuẩn bị truy vấn<br>";
    return false;
}
$stmt->bind_param('s', $input_username);
$stmt->execute();
$stmt->bind_result($db_username, $db_userpasswd);
if ($stmt->fetch()) {
    // compare hashed password (example assumes DB stores MD5; use password_hash in real apps)
    if (md5($input_userpasswd) == $db_userpasswd) {
        echo "Đăng nhập thành công!<br>";
        $stmt->close();
        return true;
    } else {
        echo "Mật khẩu không đúng<br>";
    }
} else {
    echo "Không tìm thấy người dùng<br>";
}

$stmt->close();
return false;
?>