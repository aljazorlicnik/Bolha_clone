<?php
require_once 'baza.php';
require_once 'cookie.php';

if (!isset($_SESSION['ime'])) {
    header("Location: prijava.php");
    exit;
} else {
    $ime = $_SESSION['ime'];
    $priimek = $_SESSION['priimek'];
    $id = $_SESSION['id'];
}

try {
    // Establish a PDO connection using credentials from baza.php
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}
?>

<!-- HTML -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Domov - Muha</title>
    <link rel="stylesheet" href="./styles/style_index.css">
</head>
<body>
    <!-- make a nav with domov, moji oglasi, profil, and search -->
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
            try {
                $sql = "SELECT * FROM kategorije";
                $stmt = $pdo->query($sql);
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $id_kategorije = $row['id'];
                    $ime_kategorije = $row['kategorija'];
                    echo "<div class='kategorija'>";
                    echo "<a href='kategorija.php?id=$id_kategorije'><div>$ime_kategorije</div></a>";
                    echo "</div>";
                }
            } catch (PDOException $e) {
                die("Error: " . $e->getMessage());
            }
            ?>
        </div>
        <!-- display 4 random oglasi -->
        <p class="k-naslov">Naključni oglasi:</p><br>
        <div class="oglasi">
            <?php
            try {
                $sql = "SELECT * FROM oglasi ORDER BY RAND() LIMIT 3";
                $stmt = $pdo->query($sql);
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $id_oglasa = $row['id'];
                    $naslov = $row['naslov'];
                    $opis = $row['opis'];
                    $cena = $row['cena'];
                    $uporabnik_id = $row['uporabnik_id'];
                    $sql2 = "SELECT * FROM slike WHERE oglas_id = :id_oglasa";
                    $stmt2 = $pdo->prepare($sql2);
                    $stmt2->bindParam(':id_oglasa', $id_oglasa, PDO::PARAM_INT);
                    $stmt2->execute();
                    $row2 = $stmt2->fetch(PDO::FETCH_ASSOC);
                    $slika = $row2['slika'];
                    echo "<div class='oglas'>";
                    echo "<img src='$slika' alt='slika' max-width='90%' height='200px'></a>";
                    echo "<div class='naslov'>$naslov</div></a>";
                    echo "<div class='opis'>$opis</div>";
                    echo "<div class='cena'>$cena €</div>";
                    echo "<a href='oglas.php?id=$id_oglasa'><div class='pogovor-btn'>Več</div></a>";
                    echo "</div>";
                }
            } catch (PDOException $e) {
                die("Error: " . $e->getMessage());
            }
            ?>
        </div>
    </div>
</body>
</html>
