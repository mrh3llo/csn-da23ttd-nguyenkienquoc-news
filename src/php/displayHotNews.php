<?php
include 'libs.php';

// Kết nối tới CSDL
$db_connect = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Báo lỗi khi kết nối (nếu có)
if ($db_connect->connect_error) {
    http_response_code(500);
    echo "Lỗi kết nối CSDL: " . $db_connect->connect_error;
    exit;
}
$db_connect->set_charset("utf8");

// Truy vấn 10 bài báo mới nhất
$db_sql = "SELECT MA_BAI_BAO, TIEU_DE_BAI_BAO, BANNER_BAI_BAO, NGAY_DANG_BAI_BAO
           FROM BAI_BAO
           ORDER BY NGAY_DANG_BAI_BAO DESC
           LIMIT 3";

// Chủân bị truy vấn. Báo lỗi (nếu có)
$stmt = $db_connect->prepare($db_sql);
if (!$stmt) {
    http_response_code(500);
    echo "Lỗi chuẩn bị truy vấn: " . $db_connect->error;
    $db_connect->close();
    exit;
}

// Thực thi truy vấn
if (!$stmt->execute()) {
    http_response_code(500);
    echo "Lỗi thực thi truy vấn: " . $stmt->error;
    $stmt->close();
    $db_connect->close();
    exit;
}

$result = $stmt->get_result();

// Trả về HTML cho phần hiển thị danh sách bài báo
header('Content-Type: text/html; charset=utf-8');

if ($result->num_rows === 0) {
    echo '<p>Không có bài báo nào.</p>';
    $stmt->close();
    $db_connect->close();
    exit;
}

// Xuất danh sách bài báo ra màn hình
while ($row = $result->fetch_assoc()) {
    $newsId = htmlspecialchars($row['MA_BAI_BAO']);
    $newsTitle = htmlspecialchars($row['TIEU_DE_BAI_BAO']);
    $newsBanner = htmlspecialchars($row['BANNER_BAI_BAO']);
    $newsDate = $row['NGAY_DANG_BAI_BAO'];
    $dateFormatted = $newsDate ? date('d/m/Y', strtotime($newsDate)) : '';
    // Mỗi mục: dùng các lớp sẵn có trong components.css
    echo '<a class="link--none my__px--sm display__block" href="news.html?newsId=' . $newsId . '">';
    echo '  <div class="card m__px--med border__radius--med border__color--trending">';
    echo '    <img class="card__img" src="' . $newsBanner . '" alt="' . $newsTitle . '">';
    echo '    <div class="news-info">';
    echo '      <h3 class="card__title">' . $newsTitle . '</h3>';
    echo '      <p class="my__px--med text__style--content text__color--dark text__align--center">' . htmlspecialchars($dateFormatted) . '</p>';
    echo '    </div>';
    echo '  </div>';
    echo '</a>';
}

$stmt->close();
$db_connect->close();
?>