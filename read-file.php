<?php

function importCSV($filePath, $conn) {

    $file = fopen($filePath, "r");

    if ($file === false) {
        die("Không thể mở file CSV!");
    }

    $data = [];

    // Đọc từng dòng CSV vào mảng
    while (($row = fgetcsv($file, 0, ",")) !== false) {
        $data[] = $row;
    }

    fclose($file);

    // Bỏ dòng tiêu đề nếu CSV có tiêu đề
    if (!empty($data) && strtolower(trim($data[0][0])) === "id") {
        array_shift($data);
    }

    // Câu lệnh thêm dữ liệu vào MySQL
    $sql = "INSERT INTO customers
            (id, fullname, email, Birthday, reg_date, password)
            VALUES (?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("Lỗi SQL: " . $conn->error);
    }

    $success = 0;
    $failed = 0;

    // Duyệt từng dòng dữ liệu
    foreach ($data as $row) {

        if (count($row) < 6) {
            $failed++;
            continue;
        }

        $id = trim($row[0]);
        $fullname = trim($row[1]);
        $email = trim($row[2]);
        $birthday = trim($row[3]);
        $reg_date = trim($row[4]);
        $password = trim($row[5]);

        // Bỏ qua dòng không có ID hợp lệ
        if (!ctype_digit($id)) {
            $failed++;
            continue;
        }

        // Gán dữ liệu vào câu lệnh SQL
        $stmt->bind_param(
            "isssss",
            $id,
            $fullname,
            $email,
            $birthday,
            $reg_date,
            $password
        );

        if ($stmt->execute()) {
            $success++;
        } else {
            $failed++;
            echo "Lỗi dòng ID $id: " . $stmt->error . "<br>";
        }
    }

    $stmt->close();

    echo "Thêm thành công: $success dòng<br>";
    echo "Thêm thất bại: $failed dòng";
}
?>