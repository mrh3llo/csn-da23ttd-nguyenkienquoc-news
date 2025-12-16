<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
require 'libs.php';

// Kiểm tra dữ liệu được POST
if($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(400);
    echo "Yêu cầu không hợp lệ!";
    exit;
}

// Biến lưu dữ liệu từ người dùng
$input_random_id = strval(rand(0, 999999));
$input_username = isset($_POST["user_name"]) ? trim($_POST["user_name"]) : '';
$input_useremail = isset($_POST["user_email"]) ? trim($_POST["user_email"]) : '';
$input_userpasswd = isset($_POST["user_password"]) ? $_POST["user_password"] : '';
$input_userpasswd_comfirm = isset($_POST["user_password_comfirm"]) ? $_POST["user_password_comfirm"] : '';

// Tạo kết nối đến CSDL
$db_connect = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Kiểm tra kết nối
if($db_connect->connect_error) {
    http_response_code(500);
    echo "Lỗi kết nối CSDL: " . $db_connect->connect_error;
    exit;
}

// Set charset
$db_connect->set_charset("utf8");

// Hash mật khẩu
$hashed_password = password_hash($input_userpasswd, PASSWORD_DEFAULT);

// Chuẩn bị SQL query với placeholder
$db_sql = "INSERT INTO TAI_KHOAN(MA_TAI_KHOAN, TEN_TAI_KHOAN, MAIL_TAI_KHOAN, MAT_KHAU_TAI_KHOAN, MA_VAI_TRO) VALUES (?, ?, ?, ?, 'ND')";

// Tạo prepared statement
$stmt = $db_connect->prepare($db_sql);
if(!$stmt) {
    http_response_code(500);
    echo "Lỗi chuẩn bị truy vấn: " . $db_connect->error;
    exit;
}

// Bind parameters (sss = string, string, string)
$stmt->bind_param("ssss",$input_random_id, $input_username, $input_useremail, $hashed_password);

// Thực hiện truy vấn
if(!$stmt->execute()) {
    http_response_code(500);
    echo "Lỗi thực hiện truy vấn: " . $stmt->error;
    $stmt->close();
    $db_connect->close();
    exit;
}

// Đóng statement và connection
$stmt->close();
$db_connect->close();

// Trả về thông báo thành công
http_response_code(200);
echo "Đăng ký thành công!";
?>