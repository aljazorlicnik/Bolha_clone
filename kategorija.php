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
                    echo "<p class='k-naslov'>Oglasi v kategoriji $kategorija:</p><br>";
                    echo "<div class='oglas'>";
                    echo "<div class='oglas-img'><img src='$slika' width='250px' alt='slika'></div>";
                    echo "<div class='oglas-content'>";
                    echo "<p class='naslov'>$naslov</p>";
                    echo "<p class='cena'>$cena €</p>";
                    echo "<p class='kategorija'>Kategorija: $kategorija</p>";
                    echo "<a class='btn' href='oglas.php?id=$id_oglasa'>Več</a>";
                    echo "</div>";
                    echo "</div>";
                }
            }
            ?>
    </div>
</body>
</html>