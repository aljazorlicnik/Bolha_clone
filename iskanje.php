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

// Process the search input
$input = isset($_POST['iskanje']) ? $_POST['iskanje'] : '';
$stmt = $pdo->prepare("SELECT * FROM oglasi WHERE naslov LIKE :input OR opis LIKE :input");
$stmt->execute(['input' => '%' . $input . '%']);
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
            $st_oglasov = count($results);
            if($st_oglasov == 0){
                echo "<p class='k-naslov'>Najden ni bil noben oglas.</p>";
            }
            else{
                echo "<p class='k-naslov'>Moji oglasi:</p><br>";
                echo "<div class='oglasi'>";
                foreach($results as $row){
                    $id_oglasa = $row['id'];
                    $stmt2 = $pdo->prepare("SELECT * FROM slike WHERE  oglas_id = :id_oglasa");
                    $stmt2->execute(['id_oglasa' => $id_oglasa]);
                    $row2 = $stmt2->fetch(PDO::FETCH_ASSOC);
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
