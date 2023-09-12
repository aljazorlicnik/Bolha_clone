<?php
require_once('baza.php');
$i = $_POST['ime'];
$pri = $_POST['priimek'];
$e = $_POST['e-mail'];
$p = $_POST['geslo'];
// use password hash
$kp = password_hash($p, PASSWORD_DEFAULT);

$prev = "SELECT * FROM uporabniki WHERE `email` = '$e';";
$result = mysqli_query($link, $prev);

if (mysqli_num_rows($result) === 1)
{
    header("Refresh:0;url=registracija.php");
    echo '<script>alert("Uporabnik s tem e-poštnim naslovom že obstaja.")</script>';
}
else
{
    $query = "INSERT INTO uporabniki (ime,priimek,email,geslo) VALUES('$i', '$pri', '$e','$kp');";
    if(mysqli_query($link, $query))
    {
        header("Refresh:0;url=prijava.php");
    }
    else
    {
        header("Refresh:0;url=registracija.php");
        echo '<script>alert("Registracija ni uspela.")</script>';
    }
}
?>