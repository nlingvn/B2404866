
<?php
session_start();

// Xóa tất cả biến Session
$_SESSION = array();

// Xóa Cookie chứa mã phiên Session
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();

    setcookie(
        session_name(),
        "",
        time() - 3600,
        $params["path"],
        $params["domain"],
        $params["secure"],
        $params["httponly"]
    );
}

// Hủy Session trên máy chủ
session_destroy();

// Xóa các Cookie cũ của bài thực hành
setcookie("user", "", time() - 3600, "/");
setcookie("fullname", "", time() - 3600, "/");
setcookie("id", "", time() - 3600, "/");

// Quay về trang đăng nhập
header("Location: login.php");
exit();
?>
