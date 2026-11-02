<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "qlsv";


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$id = $_POST['id'];
$name = $_POST['name_major'];


$sql = "UPDATE major SET name_major = '" . $name . "'";
$sql = $sql . " WHERE id = '" . $id . "'";

if ($conn->query($sql) == TRUE) {
    header('Location: major_index.php');
    exit;
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}


$conn->close();
?>