<?php
require_once 'baza.php';
require_once 'cookie.php';

$e = $_POST['email'];
$p = $_POST['geslo'];
$kp = password_hash($p, PASSWORD_DEFAULT);

$query = "SELECT * FROM uporabniki WHERE `email` = '$e';";
$result = mysqli_query($link, $query);
$row = mysqli_fetch_array($result);
$hash = $row['geslo'];

if (password_verify($p, $hash))
{
    $query_ime = "SELECT * FROM uporabniki WHERE email='$e';";
    $result_ime = mysqli_query($link, $query_ime);
    $row_ime = mysqli_fetch_array($result_ime);
    $_SESSION['ime'] = $row_ime['ime'];
    $_SESSION['priimek'] = $row_ime['priimek'];
    $_SESSION['id'] = $row_ime['id'];
    header("Refresh:0;url=index.php");
}
else {
    echo '<script>alert("Napačen email in/ali geslo")</script>';
    header("Refresh:0;url=prijava.php");
}


?>