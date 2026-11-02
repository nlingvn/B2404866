<!-- <!DOCTYPE HTML>
<html>  
<body>

<form action="luu.php" method="post">
Name: <input type="text" name="name"><br>
E-mail: <input type="text" name="email"><br>
Birthday: <input type="date" name="birth"><br>

<input type="submit">
</form>

</body>
</html> -->
<!DOCTYPE HTML>
<html>  
<body>


<?php
include 'connect.php';

$result_major = $conn->query("SELECT * FROM major");
?>
<form action="luu.php" method="post">
Name: <input type="text" name="name"><br>
E-mail: <input type="text" name="email"><br>
Birthday: <input type="date" name="birth"><br>


Major:
<select name="major_id">
    <?php
    while ($major = $result_major->fetch_assoc()) {
        echo '<option value="' . $major['id'] . '">'
            . $major['name_major'] . '</option>';
    }
    ?>
<input type="submit">
</form>


</body>
</html>
