

<!DOCTYPE html>
<html>
<body>


<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "qlsv";


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['id'])) {
    $id = $_POST['id'];
} else {
    echo "Không tìm thấy ID!";
    exit();
}
// $id = $_POST['id'];


$sql = "SELECT * FROM major WHERE id='" . $id . "'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
?>


<form action="major_edit_save.php" method="post">
    ID:
    <input type="text" name="id"
           value="<?php echo $row['id']; ?>" readonly>
    <br>


    Ten chuyen nganh:
    <input type="text" name="name_major"
           value="<?php echo $row['name_major']; ?>">
    <br>


    <input type="submit" value="Luu">
</form>


</body>
</html>


