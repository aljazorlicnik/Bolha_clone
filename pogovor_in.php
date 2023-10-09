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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sporocilo = $_POST['sporocilo'];
    $sender_id = $_POST['sender_id'];
    $receiver_id = $_POST['receiver_id'];
    $oglas_id = $_POST['oglas_id'];

    try {
        // Establish a PDO connection (use your own connection details)
        $pdo = new PDO("mysql:host=localhost;dbname=bolha", "root", "");

        // Set PDO to throw exceptions on error
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Prepare and execute the SQL statement using a prepared statement
        $stmt = $pdo->prepare("INSERT INTO sporocila (sporocilo, sender_id, receiver_id, oglas_id) VALUES (:sporocilo, :sender_id, :receiver_id, :oglas_id)");
        $stmt->bindParam(':sporocilo', $sporocilo, PDO::PARAM_STR);
        $stmt->bindParam(':sender_id', $sender_id, PDO::PARAM_INT);
        $stmt->bindParam(':receiver_id', $receiver_id, PDO::PARAM_INT);
        $stmt->bindParam(':oglas_id', $oglas_id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            header("Location: pogovor.php?id=$oglas_id");
            exit;
        } else {
            echo "Napaka pri vstavljanju sporocila.";
        }
    } catch (PDOException $e) {
        echo "Napaka: " . $e->getMessage();
    }
}
?>
