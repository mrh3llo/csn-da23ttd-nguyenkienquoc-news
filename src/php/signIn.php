<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
require 'libs.php';

// Chỉ chấp nhận POST
if($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(400);
    echo "Yêu cầu không hợp lệ";
    exit;
}

$input_username = isset($_POST['user_name']) ? trim($_POST['user_name']) : '';
$input_password = isset($_POST['user_password']) ? $_POST['user_password'] : '';

if(empty($input_username) || empty($input_password)) {
    http_response_code(400);
    echo "Không được để trống tên người dùng hoặc mật khẩu";
    exit;
}

// Kết nối DB
$db_connect = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if($db_connect->connect_error) {
    http_response_code(500);
    echo "Lỗi kết nối CSDL: " . $db_connect->connect_error;
    exit;
}
$db_connect->set_charset("utf8");

// Lấy hash password từ DB theo username
$db_sql = "SELECT MAT_KHAU_TAI_KHOAN FROM TAI_KHOAN WHERE TEN_TAI_KHOAN = ? LIMIT 1";
$stmt = $db_connect->prepare($db_sql);
if(!$stmt) {
    http_response_code(500);
    echo "Lỗi chuẩn bị truy vấn: " . $db_connect->error;
    $db_connect->close();
    exit;
}

$stmt->bind_param('s', $input_username);
$stmt->execute();
$stmt->bind_result($db_password_hashed);

if($stmt->fetch()) {
    // Kiểm tra password
    if(password_verify($input_password, $db_password_hashed)) {
        // (Tùy chọn) khởi tạo session ở đây
        http_response_code(200);
        echo "Đăng nhập thành công!";
    } else {
        http_response_code(401);
        echo "Tên đăng nhập hoặc mật khẩu không đúng";
    }
} else {
    http_response_code(401);
    echo "Tên đăng nhập hoặc mật khẩu không đúng";
}

$stmt->close();
$db_connect->close();
?>
