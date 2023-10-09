<?php
require_once 'baza.php';
require_once 'cookie.php';

// Assuming the session is already started
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

// Process the category ID from GET parameter
$id_kategorije = isset($_GET['id']) ? $_GET['id'] : 0;

try {
    // Fetch category information
    $stmt_ka = $pdo->prepare("SELECT * FROM kategorije WHERE id = :id_kategorije");
    $stmt_ka->execute(['id_kategorije' => $id_kategorije]);
    $row_ka = $stmt_ka->fetch(PDO::FETCH_ASSOC);
    $kategorija = $row_ka['kategorija'];

    // Fetch ads in the selected category
    $stmt = $pdo->prepare("SELECT o.*, s.slika, k.kategorija 
                          FROM oglasi o 
                          LEFT JOIN slike s ON o.id = s.oglas_id 
                          LEFT JOIN kategorije k ON o.kategorija_id = k.id 
                          WHERE o.kategorija_id = :id_kategorije");
    $stmt->execute(['id_kategorije' => $id_kategorije]);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $st_oglasov = count($results);
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
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
        <?php
            if ($st_oglasov == 0) {
                echo "<p class='k-naslov'>V tej kategoriji ni oglasov.</p>";
            } else {
                echo "<p class='k-naslov'>Oglasi v kategoriji $kategorija:</p><br>";
                echo "<div class='oglasi'>";
                foreach ($results as $row) {
                    $id_oglasa = $row['id'];
                    $naslov = $row['naslov'];
                    $cena = $row['cena'];
                    $slika = $row['slika'];

                    echo "<div class='oglas'>";
                    echo "<div class='oglas-img'>";
                    echo "<img src='$slika' max-width='90%' height='250px' alt='slika'>";
                    echo "</div>";
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
