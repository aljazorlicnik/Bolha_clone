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

$oglas_id = $_GET['id'];

try {
    // Establish a PDO connection using credentials from baza.php
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Fetch oglas data
    $stmt = $pdo->prepare("SELECT * FROM oglasi WHERE id = :oglas_id");
    $stmt->bindParam(':oglas_id', $oglas_id, PDO::PARAM_INT);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    $naslov = $row['naslov'];
    $opis = $row['opis'];
    $cena = $row['cena'];
    $kraj_id = $row['kraj_id'];
    $kategorija_id = $row['kategorija_id'];
    $uporabnik_id = $row['uporabnik_id'];

    // Fetch kraj
    $stmt = $pdo->prepare("SELECT * FROM kraji WHERE id = :kraj_id");
    $stmt->bindParam(':kraj_id', $kraj_id, PDO::PARAM_INT);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $kraj = $row['kraj'];

    // Fetch kategorija
    $stmt = $pdo->prepare("SELECT * FROM kategorije WHERE id = :kategorija_id");
    $stmt->bindParam(':kategorija_id', $kategorija_id, PDO::PARAM_INT);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $kategorija = $row['kategorija'];

    // Fetch avtor
    $stmt = $pdo->prepare("SELECT * FROM uporabniki WHERE id = :uporabnik_id");
    $stmt->bindParam(':uporabnik_id', $uporabnik_id, PDO::PARAM_INT);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $avtor_ime = $row['ime'];
    $avtor_priimek = $row['priimek'];
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
                try {
                    // Fetch slika for the oglas
                    $stmt = $pdo->prepare("SELECT * FROM slike WHERE oglas_id = :oglas_id");
                    $stmt->bindParam(':oglas_id', $oglas_id, PDO::PARAM_INT);
                    $stmt->execute();
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);
                    $slika = $row['slika'];
                    echo "<img src='$slika' alt='slika'>";
                } catch (PDOException $e) {
                    echo "Error fetching image: " . $e->getMessage();
                }
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
                    echo "<span class='bold'>Kraj: </span>" . $kraj;
                    ?>
                </div>
                <div class="oglas-kategorija">
                    <?php
                    echo "<span class='bold'>Kategorija: <a href=kategorija.php?id=$kategorija_id></span>" . $kategorija ."</a>";
                    ?>
                </div>
                <div class="oglas-avtor">
                    <?php
                    echo "<span class='bold'>Avtor: </span>" . $avtor_ime . " " . $avtor_priimek;
                    ?>
                </div>
                <div>
                    <?php
                    echo "<a href='pogovor.php?id=$oglas_id'><div class='pogovor-btn'>Začni pogovor</div></a>";
                    ?>
                </div>
                <!-- if admin == 1, izbrisi button -->
                <?php
                if ($_SESSION['admin'] == 1) {
                    echo "<a href='izbrisi_oglas.php?id=$oglas_id'><div class='izbrisi-btn'>Izbriši oglas</div></a>";
                }
                ?>
            </div>
        </div>
    </div>
</body>
</html>
