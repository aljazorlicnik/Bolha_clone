<?php
//server
$host="localhost";
$user="orlieu_root";
$password="7#5pg9}6)nl?";
$db="orlieu_bolha";

// local
// $host = "localhost";
// $user = "root";
// $password = "";
// $db = "bolha";

try {
  $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $password);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
  die("Povezava ni uspela: " . $e->getMessage());
}
?>