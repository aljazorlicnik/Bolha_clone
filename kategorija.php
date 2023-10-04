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
       <!-- select all oglas from oglasi where kategorija_id = get[id, if there is none display 0 -->
         <?php
            $id_kategorije = $_GET['id'];
            $sql = "SELECT * FROM oglasi WHERE kategorija_id = $id_kategorije";
            $result = mysqli_query($link, $sql);
            $st_oglasov = mysqli_num_rows($result);
            if($st_oglasov == 0){
                echo "<p class='k-naslov'>V tej kategoriji ni oglasov.</p>";
            }
            else{
                $sql_ka = "SELECT * FROM kategorije WHERE id = $id_kategorije";
                $result_ka = mysqli_query($link, $sql_ka);
                $row_ka = mysqli_fetch_assoc($result_ka);
                $kategorija = $row_ka['kategorija'];
                echo "<p class='k-naslov'>Oglasi v kategoriji $kategorija:</p><br>";
                echo "<div class='oglasi'>";
                while($row = mysqli_fetch_assoc($result)){
                    $id_oglasa = $row['id'];
                    $sql2 = "SELECT * FROM slike WHERE oglas_id = $id_oglasa";
                    $result2 = mysqli_query($link, $sql2);
                    $row2 = mysqli_fetch_assoc($result2);
                    $naslov = $row['naslov'];
                    $cena = $row['cena'];
                    $slika = $row2['slika'];
                    $id_kategorije = $row['kategorija_id'];
                    $sql = "SELECT * FROM kategorije WHERE id = $id_kategorije";
                    $result2 = mysqli_query($link, $sql);
                    $row2 = mysqli_fetch_assoc($result2);
                    $kategorija = $row2['kategorija'];
                    echo "<div class='oglas'>";
                    echo "<img src='$slika' max-width='250px' max-height='250px' alt='slika'>";
                    echo "<div class='oglas-content'>";
                    echo "<p class='naslov'>$naslov</p>";
                    echo "<div class='kategorije-cena'>$cena €</div>";
                    echo "<a href='oglas.php?id=$id_oglasa'><div class='pogovor-btn'>Več</div></a>";
                    echo "</div>";
                    echo "</div>";
                }
                echo "</div>";
            }
            ?>
    </div>
</body>
</html>