<?php
require_once 'baza.php';
require_once 'cookie.php';

if (!isset($_SESSION['ime'])) {
    header("Location: prijava.php");
    exit;
} else {
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

if ($geslo == $geslo2) {
    try {
        // Establish a PDO connection using the database connection variables from baza.php
        $pdo = new PDO("mysql:host=localhost;dbname=$db", $user, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Use a prepared statement for the update query
        $stmt = $pdo->prepare("UPDATE uporabniki SET ime = :ime, priimek = :priimek, email = :email, geslo = :geslo WHERE id = :id");
        $stmt->bindParam(':ime', $ime, PDO::PARAM_STR);
        $stmt->bindParam(':priimek', $priimek, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':geslo', $geslo3, PDO::PARAM_STR);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        echo "<script>alert('Uspešno ste spremenili podatke.');</script>";
        // back
        header("Refresh:0;url=profil.php?id=$id");
        exit;
    } catch (PDOException $e) {
        echo "<script>alert('Napaka pri shranjevanju: " . $e->getMessage() . "');</script>";
    }
} else {
    echo "<script>alert('Gesli se ne ujemata.');</script>";
}
?>
