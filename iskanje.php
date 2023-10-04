<!-- search -->
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

$sql = "SELECT * FROM kraji";
$result = mysqli_query($link, $sql);
$sql2 = "SELECT * FROM kategorije";
$result2 = mysqli_query($link, $sql2);

$input = $_POST['iskanje'];
// select from oglasi where naslov like input or opis like input
$sql = "SELECT * FROM oglasi WHERE naslov LIKE '%$input%' OR opis LIKE '%$input%'";
$result = mysqli_query($link, $sql);
?>

<!-- HTML -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Domov - Muha</title>
    <link rel="stylesheet" href="./styles/style_index.css">
</head>

<body>
    <!-- make a nav with domov, moji oglasi, profil and search -->
    <nav>
        <div class="nav">
            <a href="index.php">Muha</a>
            <a href="oglasi.php">Moji oglasi</a>
            <a href="sporocila.php">Sporočila</a>
            <div class="profil">
                <a href="profil.php?id=<?php echo $id; ?>"><?php echo $ime . " " . $priimek; ?></a>
                <a class="odjava" href="odjava.php">Odjava</a>
            </div>
        </div>
    </nav>
    <div class="search">
        <form action="iskanje.php" method="post">
                    <input type="text" name="iskanje" placeholder="Išči po oglasih">
                    <button class="btn" type="submit">Išči</button>
        </form>
    </div>
    <div class="content">
        <!-- display all oglasi where uporabnik_id = session[id] -->
        <?php
            $st_oglasov = mysqli_num_rows($result);
            if($st_oglasov == 0){
                echo "<p class='k-naslov'>Najden ni bil noben oglas.</p>";
            }
            else{
                echo "<p class='k-naslov'>Moji oglasi:</p><br>";
                echo "<div class='oglasi'>";
                while($row = mysqli_fetch_assoc($result)){
                    $id_oglasa = $row['id'];
                    $sql2 = "SELECT * FROM slike WHERE  oglas_id = $id_oglasa";
                    $result2 = mysqli_query($link, $sql2);
                    $row2 = mysqli_fetch_assoc($result2);
                    $slika = $row2['slika'];
                    $naslov = $row['naslov'];
                    $opis = $row['opis'];
                    $cena = $row['cena'];
                    $kraj_id = $row['kraj_id'];
                    $kategorija_id = $row['kategorija_id'];

                    echo "<div class='oglas'>";
                    echo "<div class='oglas-img'>";
                    echo "<img src='$slika' alt='slika' max-width='90%' height='200px'>";
                    echo "</div>";
                    echo "<div class='oglas-info'>";
                    echo "<a href='oglas.php?id=$id_oglasa'><p>$naslov</p></a>";
                    echo "<p>$opis</p>";
                    echo "<p>$cena €</p>";
                    echo "<a href='oglas.php?id=$id_oglasa'><div class='pogovor-btn'>Več</div></a>";
                    echo "</div>";
                    echo "</div>";
                }
            }
        ?>
