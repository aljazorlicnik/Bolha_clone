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

$prev = "SELECT * FROM uporabniki WHERE `email` = '$e';";
$result = $pdo->query($prev);

if ($result->rowCount() === 1) {
    header("Refresh:0;url=registracija.php");
    echo '<script>alert("Uporabnik s tem e-poštnim naslovom že obstaja.")</script>';
} else {
    if ($google_id !== null) {
        $query = "INSERT INTO uporabniki (ime, priimek, email, geslo, google_id) VALUES ('$i', '$pri', '$e', '$kp', '$google_id');";
    } else {
        $query = "INSERT INTO uporabniki (ime, priimek, email, geslo) VALUES ('$i', '$pri', '$e', '$kp');";
    }

    if ($pdo->query($query)) {
        header("Refresh:0;url=prijava.php");
    } else {
        header("Refresh:0;url=registracija.php");
        echo '<script>alert("Registracija ni uspela.")</script>';
    }
}
?>
