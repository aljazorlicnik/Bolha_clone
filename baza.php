<?php
/* 
povezava na strežnik
 */
$host="localhost";
$user="root";
$password="";
$db="bolha";

$link = mysqli_connect($host, $user, $password, $db);

// Check connection
if (!$link) {
  die("Povezava ni uspela: " . mysqli_connect_error());
}
?>