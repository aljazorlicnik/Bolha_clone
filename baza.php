<?php
/* 
povezava na strežnik
 */
$host="localhost";
$user="root";
$password="7#5pg9}6)nl?";
$db="orlieu_bolha";

$link = mysqli_connect($host, $user, $password, $db);

// Check connection
if (!$link) {
  die("Povezava ni uspela: " . mysqli_connect_error());
}
?>