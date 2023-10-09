<?php
require_once('baza.php');
require_once('cookie.php');

$i = $_POST['ime'];
$pri = $_POST['priimek'];
$e = $_POST['e-mail'];
$p = $_POST['geslo'];

// Use password_hash
$kp = password_hash($p, PASSWORD_DEFAULT);



    $prev = "SELECT * FROM uporabniki WHERE `email` = '$e';";
    $result = $pdo->query($prev);

    if ($result->num_rows === 1) {
        header("Refresh:0;url=registracija.php");
        echo '<script>alert("Uporabnik s tem e-poštnim naslovom že obstaja.")</script>';
    }
    else {
        if(isset($_SESSION['google_id'])
           {
               $query = "INSERT INTO uporabniki (ime, priimek, email, geslo, google_id) VALUES ('$i', '$pri', '$e', '$kp', '$_SESSION['google_id']');";
           }
        $query = "INSERT INTO uporabniki (ime, priimek, email, geslo) VALUES ('$i', '$pri', '$e', '$kp');";
        if ($pdo->query($query) === TRUE) {
            header("Refresh:0;url=prijava.php");
        } else {
            header("Refresh:0;url=registracija.php");
            echo '<script>alert("Registracija ni uspela.")</script>';
        }
    }
?>
