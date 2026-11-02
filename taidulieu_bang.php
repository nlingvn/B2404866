<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "qlsv";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
//tao chuoi luu cau lenh sql
$sql = "SELECT * FROM student";
//thuc thi cau lenh sql va dua doi tuong vao $result
$result = $conn->query($sql);


if ($result->num_rows > 0) {

  
  //cach 1: show du lieu nhu bien
  //show gia tri trong mang
	// print_r ($result);
	// echo '<br>';
	// echo '<br>';
	
  //Cach 2: show theo tung dong voi for
  // while($row = $result->fetch_assoc()) {
  //   echo "id: " . $row["id"]. " - Hoten: " . $row["fullname"]. " " . $row["email"].' ngaysinh: '.$row['Birthday']. "<br>";
  // }
  // echo '<br>';
  // echo '<br>';
  //xoa ket qua cu tu o tren

  
   
  //Cach 3: trinh bay voi bang html
  //load du lieu moi len dua vao bien result
  
  // Cách 4: 

//   while (($name = $result->fetch_column(1)) !== false) {
//      echo $name . "<br>";
//   }
// } else {
//   echo "0 ket qua tra ve";
// }
//  Cách 5 fetch_array
  while ($row = $result->fetch_array()) {
    
    echo "id: " . $row["id"] . "<br>" 
       . " - Hoten: " . $row["fullname"] ."<br>" 
       . "-Email:" . $row["email"] . "<br>" 
       . " ngaysinh: " . $row["Birthday"]
       . "<br>";
}

}
$conn->close();
?>
