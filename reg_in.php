<?php
require_once('baza.php');
require_once('cookie.php');

// Check if all required fields are set
if(isset($_POST['ime'], $_POST['priimek'], $_POST['e-mail'], $_POST['geslo'])) {
    $i = $_POST['ime'];
    $pri = $_POST['priimek'];
    $e = $_POST['e-mail'];
    $p = $_POST['geslo'];

    // Use password_hash
    $kp = password_hash($p, PASSWORD_DEFAULT);

    $google_id = isset($_SESSION['google_id']) ? $_SESSION['google_id'] : null;

    // Use prepared statements to avoid SQL injection
    $stmt = $pdo->prepare("SELECT * FROM uporabniki WHERE email = ?");
    $stmt->execute([$e]);

    if ($stmt->rowCount() === 1) {
        header("Refresh:0;url=registracija.php");
        echo '<script>alert("Uporabnik s tem e-poštnim naslovom že obstaja.")</script>';
    } else {
        if ($google_id !== null) {
            $query = "INSERT INTO uporabniki (ime, priimek, email, geslo, google_id) VALUES (?, ?, ?, ?, ?)";
            $params = [$i, $pri, $e, $kp, $google_id];
        } else {
            $query = "INSERT INTO uporabniki (ime, priimek, email, geslo) VALUES (?, ?, ?, ?)";
            $params = [$i, $pri, $e, $kp];
        }

        $stmt = $pdo->prepare($query);
        if ($stmt->execute($params)) {
            header("Refresh:0;url=prijava.php");
        } else {
            header("Refresh:0;url=registracija.php");
            echo '<script>alert("Registracija ni uspela.")</script>';
        }
    }
} else {
    echo "Missing required fields.";
}
?>
