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

try {
    // Establish a PDO connection using credentials from baza.php
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql_id = $pdo->quote($id);
    $sql = "UPDATE oglasi SET naslov = ?, opis = ?, cena = ?, kraj_id = ?, kategorija_id = ? WHERE id = $sql_id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$naslov, $opis, $cena, $kraj, $kategorija]);

    header("Location: oglasi.php");
    exit;
} catch (PDOException $e) {
    echo "<script>alert('Prišlo je do napake: " . $e->getMessage() . "')</script>";
}
?>
