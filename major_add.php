

<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "qlsv";


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


if (isset($_POST['submit'])) {
    $name = $_POST['name_major'];


    $sql = "INSERT INTO major (name_major)
            VALUES ('$name')";


    if ($conn->query($sql) == TRUE) {
        header('Location: major_index.php');
        exit;
    } else {
        echo "Error: " . $conn->error;
    }
}


$conn->close();
?>


<h1>Them chuyen nganh</h1>


<form method="post">
    Ten chuyen nganh:
    <input type="text" name="name_major" required>
    <input type="submit" name="submit" value="Them">
</form>
