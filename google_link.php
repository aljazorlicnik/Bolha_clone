<?php
require_once 'baza.php';
require_once 'cookie.php';
$email = $_POST['email'];
$password = $_POST['geslo'];

$sql = "SELECT * FROM uporabniki WHERE email = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$email]); // Pass parameters as an array
$result = $stmt->fetch(PDO::FETCH_ASSOC);

if ($result !== false) {
    $hash = $result['geslo'];
    if (password_verify($password, $hash)) {
        $sql = "UPDATE uporabniki SET google_id = ? WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$_SESSION['google_id'], $result['id']]);

        $_SESSION['id'] = $result['id'];
        header('Location: index.php');
    } else {
        header('Location: google_addmail.php');
        exit();
    }
} else {
    header('Location: google_addmail.php');
    exit();
}
?>
