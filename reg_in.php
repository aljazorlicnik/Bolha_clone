<?php
require_once('baza.php');
require_once('cookie.php');

$i = $_POST['ime'];
$pri = $_POST['priimek'];
$e = $_POST['e-mail'];
$p = $_POST['geslo'];

// Use password_hash
$kp = password_hash($p, PASSWORD_DEFAULT);

$google_id = isset($_SESSION['google_id']) ? $_SESSION['google_id'] : null;

// Prepare a statement for checking if the email exists
$prevQuery = "SELECT * FROM uporabniki WHERE email = :email";
$prevStatement = $pdo->prepare($prevQuery);
$prevStatement->bindParam(':email', $e);
$prevStatement->execute();

if ($prevStatement->rowCount() === 1) {
    header("Refresh:0;url=registracija.php");
    echo '<script>alert("Uporabnik s tem e-poštnim naslovom že obstaja.")</script>';
} else {
    if ($google_id !== null) {
        $query = "INSERT INTO uporabniki (ime, priimek, email, geslo, google_id) VALUES (:ime, :priimek, :email, :geslo, :google_id)";
    } else {
        $query = "INSERT INTO uporabniki (ime, priimek, email, geslo) VALUES (:ime, :priimek, :email, :geslo)";
    }

    $insertStatement = $pdo->prepare($query);
    $insertStatement->bindParam(':ime', $i);
    $insertStatement->bindParam(':priimek', $pri);
    $insertStatement->bindParam(':email', $e);
    $insertStatement->bindParam(':geslo', $kp);

    if ($google_id !== null) {
        $insertStatement->bindParam(':google_id', $google_id);
    }

    if ($insertStatement->execute()) {
        header("Refresh:0;url=prijava.php");
    } else {
        header("Refresh:0;url=registracija.php");
        echo '<script>alert("Registracija ni uspela.")</script>';
    }
}
?>
