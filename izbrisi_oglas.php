<?php
require_once 'baza.php';
require_once 'cookie.php';

if (!isset($_SESSION['ime'])) {
    header("Location: prijava.php");
    exit;
}
else {
    $ime = $_SESSION['ime'];
    $priimek = $_SESSION['priimek'];
    $id = $_SESSION['id'];
}

try {
    // Establish a PDO connection using credentials from baza.php
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}

$id_oglasa = $_GET['id'];

try {
    // Delete from 'slike' table where oglas_id matches
    $stmt = $pdo->prepare("DELETE FROM slike WHERE oglas_id = :id_oglasa");
    $stmt->bindParam(':id_oglasa', $id_oglasa, PDO::PARAM_INT);
    $stmt->execute();

    // Delete from 'oglasi' table where id matches
    $stmt = $pdo->prepare("DELETE FROM oglasi WHERE id = :id_oglasa");
    $stmt->bindParam(':id_oglasa', $id_oglasa, PDO::PARAM_INT);
    $stmt->execute();

    header("Location: oglasi.php");
    exit;
} catch (PDOException $e) {
    echo "Napaka pri brisanju oglasa: " . $e->getMessage();
}
?>
