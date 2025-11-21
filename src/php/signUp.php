<?php
ini_set('display_errors',1);
error_reporting(E_ALL);
require 'libs.php';

// Các biến toàn cục
// Biến lưu dữ liệu từ người dùng
$input_useremail = $_POST["user_email"];
$input_username = $_POST["user_name"];
$input_userpasswd = $_POST["user_password"];
$input_userpasswd_comfirm = $_POST["user_password_comfirm"];

// Kiểm tra dữ liệu được nhập vào có hợp lệ hay không?
$valid =  validateSignUpForm($input_username, $input_useremail, $input_userpasswd, $input_userpasswd_comfirm);

// In các lỗi ra màn hình đăng ký và dừng chương trình (nếu có).
if($valid != 1) {
    foreach($valid as $i)
        echo "$i <br>";
    exit;
}

// Tạo kết nối đến CSDL
$db_connect = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME); 

// Kiểm tra kết nối
$db_connect->connect_error ? consolePrint("CSDL: Lỗi kết nối!") : consolePrint("CSDL: Kết nối thành công!");

// SQL query
$db_sql = "INSERT INTO TAI_KHOAN(TEN_TAI_KHOAN, MAIL_TAI_KHOAN, MAT_KHAU_TAI_KHOAN) VALUES ('" . $input_username . "', '" . $input_useremail . "', '" .md5($input_userpasswd) . "')";

// Tạo truy vấn. Nếu lỗi, dừng chương trình.
$stmt = $db_connect->prepare($db_sql);
if (!$stmt) {
    consolePrint("Lỗi chuẩn bị truy vấn");
    return false;
}

// Thực hiện truy vấn. Nếu có lỗi, báo lỗi.
$stmt->execute();
if (!$stmt) {
    die('Prepare error: ' . $db_connect->error);
}

// Đóng truy vấn, dừng chương trình.
$stmt->close();
return false;
?>