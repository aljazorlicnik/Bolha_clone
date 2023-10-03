<?php
//server
$host="localhost";
$user="orlieu_root";
$password="7#5pg9}6)nl?";
$db="orlieu_bolha";

//local
// $host = "localhost";
// $user = "root";
// $password = "";
// $db = "bolha";

$link = mysqli_connect($host, $user, $password, $db);

// Check connection
if (!$link) {
  die("Povezava ni uspela: " . mysqli_connect_error());
}
mysqli_set_charset($link, "utf8")
?>