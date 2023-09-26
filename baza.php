<?php
/* 
povezava na strežnik
 */
$host="localhost";
$user="orlieu_root";
$password="7#5pg9}6)nl?";
$db="orlieu_bolha";

$link = mysqli_connect($host, $user, $password, $db);
mysql_set_charset("UTF8", $conn);

// Check connection
if (!$link) {
  die("Povezava ni uspela: " . mysqli_connect_error());
}
?>