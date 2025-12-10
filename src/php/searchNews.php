<?php
// Endpoint: searchNews.php?q=keyword
// Trả về HTML các thẻ ngang cho kết quả tìm kiếm
include 'libs.php';

$q = isset($_GET['q']) ? trim($_GET['q']) : '';
if ($q === '') {
    echo '';
    exit;
}

$db = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ($db->connect_error) {
    http_response_code(500);
    echo '';
    exit;
}
$db->set_charset('utf8mb4');

$sql = "SELECT MA_BAI_BAO, TIEU_DE_BAI_BAO, BANNER_BAI_BAO, NGAY_DANG_BAI_BAO FROM BAI_BAO WHERE TIEU_DE_BAI_BAO LIKE ? OR NOI_DUNG_BAI_BAO LIKE ? ORDER BY NGAY_DANG_BAI_BAO DESC LIMIT 20";
$stmt = $db->prepare($sql);
if (!$stmt) {
    http_response_code(500);
    echo '';
    $db->close();
    exit;
}

$like = '%' . $q . '%';
$stmt->bind_param('ss', $like, $like);
if (!$stmt->execute()) {
    http_response_code(500);
    echo '';
    $stmt->close();
    $db->close();
    exit;
}

$res = $stmt->get_result();
$out = '';
if ($res && $res->num_rows > 0) {
    while ($row = $res->fetch_assoc()) {
        $id = urlencode($row['MA_BAI_BAO']);
        $title = htmlspecialchars($row['TIEU_DE_BAI_BAO']);
        $banner = $row['BANNER_BAI_BAO'] ? htmlspecialchars($row['BANNER_BAI_BAO']) : '../media/logo/logo_vn.png';
        $date = $row['NGAY_DANG_BAI_BAO'] ? date('d/m/Y', strtotime($row['NGAY_DANG_BAI_BAO'])) : '';

        $out .= '<a class="link--none search-result display__flex flex--no-wrap my__px--med border__radius--sm p__px--sm" href="news.html?newsId=' . $id . '" style="align-items:center; text-decoration:none; color:inherit;">
            <div style="flex:0 0 120px; max-width:120px; margin-right:12px;">
                <img src="' . $banner . '" alt="' . $title . '" style="width:120px; height:80px; object-fit:cover; border-radius:6px;">
            </div>
            <div style="flex:1 1 auto;">
                <h4 class="text__style--title" style="margin:0 0 6px 0;">' . $title . '</h4>
                <p class="text__style--content text__color--dark" style="margin:0; font-size:0.9em;">' . $date . '</p>
            </div>
        </a>';
    }
} else {
    $out = '<p class="mb__px--sm">Không tìm thấy kết quả.</p>';
}

echo $out;

$stmt->close();
$db->close();

?>
