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

$oglas_id = $_GET['id'];

$sql = "SELECT * FROM oglasi WHERE id = '$oglas_id'";
$result = mysqli_query($link, $sql);
$row = mysqli_fetch_assoc($result);
$naslov = $row['naslov'];
$opis = $row['opis'];
$cena = $row['cena'];
$kraj_id = $row['kraj_id'];
$kategorija_id = $row['kategorija_id'];
$uporanbik_id = $row['uporabnik_id'];

$sql = "SELECT * FROM kraji";
$result = mysqli_query($link, $sql);
$sql2 = "SELECT * FROM kategorije";
$result2 = mysqli_query($link, $sql2);
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
    <div class="content">
        <!-- display from oglasi -->
        <div class="oglas-prikaz">
            <div class="oglas-img">
                <?php
                $sql = "SELECT * FROM slike WHERE oglas_id = '$oglas_id'";
                $result = mysqli_query($link, $sql);
                $row = mysqli_fetch_assoc($result);
                $slika = $row['slika'];
                echo "<img src='$slika' alt='slika'>";
                ?>
            </div>
            <div class="oglas-infor">
                <div class="oglas-naslov">
                    <?php
                    echo "<span class='naslov'>" . $naslov . " </span>" ;
                    ?>
                </div>
                <div class="oglas-opis">
                    <?php
                    echo "<span class='bold'>Opis: </span>" . $opis;
                    ?>
                </div>
                <div class="oglas-cena">
                    <?php
                    echo "<span class='bold'>Cena: </span>" . $cena . "€";
                    ?>
                </div>
                <div class="oglas-kraj">
                    <?php
                    $sql = "SELECT * FROM kraji WHERE id = '$kraj_id'";
                    $result = mysqli_query($link, $sql);
                    $row = mysqli_fetch_assoc($result);
                    $kraj = $row['kraj'];
                    echo "<span class='bold'>Kraj: </span>" . $kraj;
                    ?>
                </div>
                <div class="oglas-kategorija">
                    <?php
                    $sql = "SELECT * FROM kategorije WHERE id = '$kategorija_id'";
                    $result = mysqli_query($link, $sql);
                    $row = mysqli_fetch_assoc($result);
                    $kategorija = $row['kategorija'];
                    $kategorija_id = $row['id'];
                    echo "<span class='bold'>Kategorija: <a href=kategorija.php?id=$kategorija_id></span>" . $kategorija ."</a>";
                    ?>
                </div>
                <div class="oglas-avtor">
                    <?php
                    $sql = "SELECT * FROM uporabniki WHERE id = '$uporanbik_id'";
                    $result = mysqli_query($link, $sql);
                    $row = mysqli_fetch_assoc($result);
                    $avtor_ime = $row['ime'];
                    $avtor_priimek = $row['priimek'];
                    echo "<span class='bold'>Avtor: </span>" . $avtor_ime . " " . $avtor_priimek;
                    ?>
                </div>
                <div>
                    <?php
                    echo "<a href='pogovor.php?id=$oglas_id'><div class='pogovor-btn'>Začni pogovor</div></a>";
                    ?>
                </div>
            </div>
    </div>
</body>
</html>