<?php

require_once "read-file.php";

// Kết nối CSDL
$conn = new mysqli("localhost", "root", "", "qlbanhang");

if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

$conn->set_charset("utf8mb4");

if (isset($_POST['submit'])) {

    if (!isset($_FILES['fileUpload']) ||
        $_FILES['fileUpload']['error'] != UPLOAD_ERR_OK) {
        die("Có lỗi khi upload file!");
    }

    $fileName = $_FILES['fileUpload']['name'];
    $tmpName = $_FILES['fileUpload']['tmp_name'];

    $fileType = strtolower(
        pathinfo($fileName, PATHINFO_EXTENSION)
    );

    if ($fileType != "csv") {
        die("Chỉ chấp nhận file CSV!");
    }

    if (!is_dir("uploads")) {
        mkdir("uploads", 0755, true);
    }

    $targetFile = "uploads/" . uniqid("csv_", true) . ".csv";

    if (move_uploaded_file($tmpName, $targetFile)) {

        echo "Upload thành công!<br>";

        // Gọi hàm đọc CSV và INSERT dữ liệu
        importCSV($targetFile, $conn);

    } else {
        echo "Upload thất bại!";
    }
}

$conn->close();
?>