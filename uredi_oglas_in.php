<?php
require_once 'baza.php';
require_once 'cookie.php';

if (!isset($_SESSION['ime'])) {
    header("Location: prijava.php");
    exit;
}
else{
    $ime = $_SESSION['ime'];
    $priimek = $_SESSION['priimek'];
    $id = $_SESSION['id'];
}

$id = $_GET['id'];
$naslov = $_POST['naslov'];
$opis = $_POST['opis'];
$cena = $_POST['cena'];
$kraj = $_POST['kraj'];
$kategorija = $_POST['kategorija'];

$sql_id = 
$sql = "UPDATE oglasi SET naslov = '$naslov', opis = '$opis', cena = '$cena', kraj_id = '$kraj', kategorija_id = '$kategorija' WHERE id = $id";
$result = mysqli_query($link, $sql);


if($result){
    header("Location: oglasi.php");
    exit;
}
else{
    echo "<script>alert('Prišlo je do napake.')</script>";
}
?>

