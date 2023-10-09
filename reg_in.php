<?php
require_once('baza.php');

$i = $_POST['ime'];
$pri = $_POST['priimek'];
$e = $_POST['e-mail'];
$p = $_POST['geslo'];

// Use password_hash
$kp = password_hash($p, PASSWORD_DEFAULT);

try {
    // Establish a database connection using credentials from baza.php
    $conn = new mysqli($host, $user, $password, $db);

    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $prev = "SELECT * FROM uporabniki WHERE `email` = '$e';";
    $result = $conn->query($prev);

    if ($result->num_rows === 1) {
        header("Refresh:0;url=registracija.php");
        echo '<script>alert("Uporabnik s tem e-poštnim naslovom že obstaja.")</script>';
    } else {
        $query = "INSERT INTO uporabniki (ime, priimek, email, geslo) VALUES ('$i', '$pri', '$e', '$kp');";
        if ($conn->query($query) === TRUE) {
            header("Refresh:0;url=prijava.php");
        } else {
            header("Refresh:0;url=registracija.php");
            echo '<script>alert("Registracija ni uspela.")</script>';
        }
    }

    // Close the database connection
    $conn->close();
} catch (Exception $e) {
    die("Error: " . $e->getMessage());
}
?>
