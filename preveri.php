<?php
require_once 'baza.php';
require_once 'cookie.php';

$e = $_POST['email'];
$p = $_POST['geslo'];

try {
    // Use the database connection variables from baza.php
    $pdo = new PDO("mysql:host=localhost;dbname=$db", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Use prepared statements to prevent SQL injection
    $stmt = $pdo->prepare("SELECT * FROM uporabniki WHERE email = :email");
    $stmt->bindParam(':email', $e, PDO::PARAM_STR);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row && password_verify($p, $row['geslo'])) {
        $_SESSION['ime'] = $row['ime'];
        $_SESSION['priimek'] = $row['priimek'];
        $_SESSION['id'] = $row['id'];
        header("Refresh:0;url=index.php");
    } else {
        echo '<script>alert("Napačen email in/ali geslo")</script>';
        header("Refresh:0;url=prijava.php");
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
