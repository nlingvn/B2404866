
<?php
session_start();

// Kiểm tra người dùng đã đăng nhập chưa
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

// Kết nối CSDL
$conn = new mysqli("localhost", "root", "", "qlbanhang");

if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

$thongbao = "";

// Xử lý khi nhấn nút Đổi mật khẩu
if (isset($_POST['btnDoiMK'])) {

    $mk_cu = $_POST['mk_cu'] ?? '';
    $mk_moi = $_POST['mk_moi'] ?? '';
    $nhap_lai = $_POST['nhap_lai'] ?? '';

    // Lấy ID của người đang đăng nhập
    $id = $_SESSION['id'];

    // Lấy mật khẩu hiện tại từ CSDL
    $sql = "SELECT password FROM customers WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();

    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $stmt->close();

    // Kiểm tra các điều kiện
    if (!$row) {
        $thongbao = "Không tìm thấy tài khoản!";
    }
    elseif ($mk_cu === "" || $mk_moi === "" || $nhap_lai === "") {
        $thongbao = "Vui lòng nhập đầy đủ thông tin!";
    }
    elseif (md5($mk_cu) !== $row['password']) {
        $thongbao = "Mật khẩu cũ không chính xác!";
    }
    elseif ($mk_moi !== $nhap_lai) {
        $thongbao = "Hai mật khẩu mới không khớp!";
    }
    elseif ($mk_moi === $mk_cu) {
        $thongbao = "Mật khẩu mới không được giống mật khẩu cũ!";
    }
    else {

        // Băm mật khẩu mới bằng MD5
        $mk_bam = md5($mk_moi);

        // Cập nhật mật khẩu vào CSDL
        $sql = "UPDATE customers SET password = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $mk_bam, $id);

        if ($stmt->execute()) {
            $thongbao = "Đổi mật khẩu thành công!";
        } else {
            $thongbao = "Đổi mật khẩu thất bại!";
        }

        $stmt->close();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đổi mật khẩu</title>
</head>
<body>

    <h2>ĐỔI MẬT KHẨU</h2>

    <form method="POST" action="">

        <label>Mật khẩu cũ:</label>
        <input type="password" name="mk_cu" required>
        <br><br>

        <label>Mật khẩu mới:</label>
        <input type="password" name="mk_moi" required>
        <br><br>

        <label>Nhập lại mật khẩu mới:</label>
        <input type="password" name="nhap_lai" required>
        <br><br>

        <button type="submit" name="btnDoiMK">
            Đổi mật khẩu
        </button>

    </form>

    <p>
        <?php echo htmlspecialchars($thongbao); ?>
    </p>

    <a href="homepage.php">Quay lại trang chủ</a>

</body>
</html>
