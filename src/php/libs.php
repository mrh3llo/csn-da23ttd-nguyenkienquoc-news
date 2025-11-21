<?php
define('DB_HOST', 'localhost');
define('DB_PORT', '3306');
define('DB_NAME', 'online_news');
define('DB_USER', 'root');
define('DB_PASS', '');

function consolePrint($string) {
    echo '<script>console.log(' . json_encode((string)$string) . ');</script>';
}

function validateSignUpForm($username, $useremail, $userpassword, $userpasswordcomfirm) {
    $errors = array();
    $valid = 1;

    // Kiểm tra dữ liệu trống hay không
    if(empty($username) || empty($useremail) || empty($userpassword) || empty($userpasswordcomfirm)) {
        array_push($errors, "Không được để trống dữ liệu!");
        $valid = 0;
    }

    // Kiểm tra tên người dùng có khoảng trống?
    if(preg_match('/\S/', $username)) {

        array_push($errors, "Tên người dùng không được chứa khoản trắng!");
        $valid = 0;
    }

    // Kiểm tra email hợp lệ hay không?
    if(!filter_var($useremail, FILTER_VALIDATE_EMAIL)) {
        array_push($errors, "Email không hợp lệ!");
        $valid = 0;
    }

    // Kiểm tra mật khẩu, điều kiện: không có khoảng trắng, ít nhất 8 ký tự
    if(preg_match('/\s/', $userpassword)) {
        array_push($errors, "Mật khẩu không được chứa khoảng trắng!");
        $valid = 0;
    }
    if(strlen($userpassword) < 8) {
        array_push($errors, "Mật khẩu có ít nhất 8 ký tự!");
        $valid = 0;
    }

    // Kiểm tra mật khẩu và xác nhận mật khẩu có trùng nhau không
    if($userpassword != $userpasswordcomfirm) {
        array_push($errors, "Mật khẩu không khớp!");
        $valid = 0;
    }

    return ($valid == 1) ? 1 : $errors;
}
?>