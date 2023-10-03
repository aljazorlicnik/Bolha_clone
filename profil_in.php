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

$ime = $_POST['ime'];
$priimek = $_POST['priimek'];
$email = $_POST['email'];
$geslo = $_POST['geslo'];
$geslo2 = $_POST['geslo2'];

$geslo3 = password_hash($geslo, PASSWORD_DEFAULT);

if($geslo == $geslo2){
    $query = "UPDATE uporabniki SET ime = '$ime', priimek = '$priimek', email = '$email', geslo = '$geslo3' WHERE id = '$id'";
    $result = mysqli_query($link, $query);
    if($result){
        echo "<script>alert('Uspešno ste spremenili podatke.');</script>";
        // back
        header("Refresh:0;url=profil.php?id=$id");
        exit;
    }
    else{
        echo "<script>alert('Napaka pri shranjevanju.');</script>";
    }
}
else{
    echo "<script>alert('Gesli se ne ujemata.');</script>";
}