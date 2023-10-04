<!-- check if user is logged in -->
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
        <p class="k-naslov">Kategorije:</p><br>
        <div class="kategorije">
            <!-- select kategorije and display them in divs -->
            <?php
            $sql = "SELECT * FROM kategorije";
            $result = mysqli_query($link, $sql);
            while($row = mysqli_fetch_assoc($result)){
                $id_kategorije = $row['id'];
                $ime_kategorije = $row['kategorija'];
                echo "<div class='kategorija'>";
                echo "<a href='kategorija.php?id=$id_kategorije'><div>$ime_kategorije</div></a>";
                echo "</div>";
            }
            ?>
        </div>
        <!-- display 4 random oglasi -->
        <p class="k-naslov">Naključni oglasi:</p><br>
        <div class="oglasi">
            <?php
            $sql = "SELECT * FROM oglasi ORDER BY RAND() LIMIT 3";
            $result = mysqli_query($link, $sql);
            while($row = mysqli_fetch_assoc($result)){
                $id_oglasa = $row['id'];
                $naslov = $row['naslov'];
                $opis = $row['opis'];
                $cena = $row['cena'];
                $uporabnik_id = $row['uporabnik_id'];
                $sql2 = "SELECT * FROM slike WHERE oglas_id = '$id_oglasa'";
                $result2 = mysqli_query($link, $sql2);
                $row2 = mysqli_fetch_assoc($result2);
                $slika = $row2['slika'];
                echo "<div class='oglas'>";
                echo "<img src='$slika' alt='slika' max-width='90%' height='200px'></a>";
                echo "<div class='naslov'>$naslov</div></a>";
                echo "<div class='opis'>$opis</div>";
                echo "<div class='cena'>$cena €</div>";
                echo "<a href='oglas.php?id=$id_oglasa'><div class='pogovor-btn'>Več</div></a>";
                echo "</div>";
            }
            ?>
    </div>
</body>
</html>