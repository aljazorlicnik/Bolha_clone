<?php
/* 
povezava na strežnik
 */
$host="aljazorli.eu";
$user="root";
$password="7#5pg9}6)nl?";
$db="bolha";

$link = mysqli_connect($host, $user, $password, $db);

// Check connection
if (!$link) {
  die("Povezava ni uspela: " . mysqli_connect_error());
}
?>