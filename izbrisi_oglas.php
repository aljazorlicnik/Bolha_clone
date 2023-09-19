<!-- delete from slike where oglas_id = GET[id] -->
<!-- delete from oglasi where id = GET[id] -->
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

$id_oglasa = $_GET['id'];

$sql = "DELETE FROM slike WHERE oglas_id = $id_oglasa";
$result = mysqli_query($link, $sql);
$sql = "DELETE FROM oglasi WHERE id = $id_oglasa";
$result = mysqli_query($link, $sql);

if($result){
    header("Location: oglasi.php");
    exit;
}
else{
    echo "<script>alert('Prišlo je do napake.')</script>";
}
?>