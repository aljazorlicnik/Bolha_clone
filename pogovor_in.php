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

$sporocilo = $_POST['sporocilo'];
$sender_id = $_POST['sender_id'];
$receiver_id = $_POST['receiver_id'];
$oglas_id = $_POST['oglas_id'];

$sql = "INSERT INTO sporocila (sporocilo, sender_id, receiver_id, oglas_id) VALUES ('$sporocilo', '$sender_id', '$receiver_id', '$oglas_id')";

if(mysqli_query($link, $sql)){
    header("Location: pogovor.php?id=$oglas_id");
    exit;
}
else{
    echo "Napaka: " . mysqli_error($link);
}

?>