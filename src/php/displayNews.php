<?php
include 'libs.php';

// Đọc mã bài báo từ URL parameter
$newsId = isset($_GET['newsId']) ? trim($_GET['newsId']) : '';

// Kiểm tra newsId có được cung cấp không
if (empty($newsId)) {
    http_response_code(400);
    echo "<h3 class='text__style--title text__color--trending'>Vui lòng cung cấp mã bài báo</h3>";
    exit;
}

// Kết nối CSDL
$db_connect = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Báo lỗi khi kết nối (nếu có)
if($db_connect->connect_error) {
    http_response_code(500);
    echo "Lỗi kết nối CSDL: " . $db_connect->connect_error;
    exit;
}
// Đặt charset đúng để tránh lỗi mã hóa
$db_connect->set_charset("utf8mb4");

// Tạo truy vấn với prepared statement để tránh SQL injection
$db_sql = "SELECT TIEU_DE_BAI_BAO, BANNER_BAI_BAO, NOI_DUNG_BAI_BAO, NGAY_DANG_BAI_BAO FROM BAI_BAO WHERE MA_BAI_BAO = ?";

$stmt = $db_connect->prepare($db_sql);
if(!$stmt) {
    http_response_code(500);
    echo "Lỗi chuẩn bị truy vấn: " . $db_connect->error;
    $db_connect->close();
    exit;
}

// Bind parameter
$stmt->bind_param('s', $newsId);

// Thực thi truy vấn
if (!$stmt->execute()) {
    http_response_code(500);
    echo "Lỗi thực thi truy vấn: " . $stmt->error;
    $stmt->close();
    $db_connect->close();
    exit;
}

// Lấy kết quả
$db_data = $stmt->get_result();

header('Content-Type: text/html; charset=utf-8');

if (!$db_data || $db_data->num_rows === 0) {
    echo "<h3 class='text__style--title text__color--trending'>Không có dữ liệu bài báo!</h3>";
    $stmt->close();
    $db_connect->close();
    exit;
}

// Lấy một hàng duy nhất rồi trích xuất trường
$row = $db_data->fetch_assoc();
if (!$row) {
    echo "<h3 class='text__style--title text__color--trending'>Không có dữ liệu bài báo!</h3>";
    $stmt->close();
    $db_connect->close();
    exit;
}

$newsTitle = htmlspecialchars($row['TIEU_DE_BAI_BAO']);
$newsBanner = htmlspecialchars($row['BANNER_BAI_BAO']);
$newsContent = $row['NOI_DUNG_BAI_BAO'];
$newsDateRaw = $row['NGAY_DANG_BAI_BAO'];
$newsDate = $newsDateRaw ? date('d/m/Y', strtotime($newsDateRaw)) : "";

echo '<h3 class="my__px--med text__style--title text__align--left text__color--dark">' . $newsTitle . '</h3>';
echo '<p class="my__px--med text__style--content text__color--dark">' . $newsDate . '</p>';
echo '<img class="mx__auto border__radius--sm w-50 display__block" src="' . $newsBanner . '" alt="' . $newsTitle . '">';
// Hiển thị nội dung bài báo: escape để tránh XSS rồi chuyển newline thành <br>
echo '<p class="my__px--lg text__style--content">' . nl2br(htmlspecialchars($newsContent)) . '</p>';

$stmt->close();
$db_connect->close();
?>