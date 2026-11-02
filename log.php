
<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "qlbanhang";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
$email = $_POST['email'] ?? '';
$pass = $_POST['pass'] ?? '';

// $sql = "select id, fullname, email from customers where email = '".$_POST["email"]."' and password = '".md5($_POST["pass"])."'";
$sql = "SELECT id, fullname, email FROM customers
        WHERE email = ? AND password = ?";

$stmt = $conn->prepare($sql);
$mk_bam = md5($pass);
$stmt->bind_param("ss", $email, $mk_bam);
$stmt->execute();

$result = $stmt->get_result();



// $result = $conn->query($sql);

if ($result->num_rows > 0) {
 session_regenerate_id(true);

  $row = $result->fetch_assoc();
  
    $_SESSION['user'] = $row['email'];
    $_SESSION['fullname'] = $row['fullname'];
    $_SESSION['id'] = $row['id'];
    $_SESSION['email'] = $row['email'];

  header('Location: homepage.php');
  exit();
} else {
  echo "Error: " . $sql . "<br>" . $conn->error;

  header('Refresh: 3;url=login.php');

}
$stmt->close();
$conn->close();
?>
