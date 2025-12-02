<?php
define('DB_HOST', 'localhost');
define('DB_PORT', '3306');
define('DB_NAME', 'online_news');
define('DB_USER', 'root');
define('DB_PASS', '');

function consolePrint($string) {
    echo '<script>console.log(' . json_encode((string)$string) . ');</script>';
}
?>