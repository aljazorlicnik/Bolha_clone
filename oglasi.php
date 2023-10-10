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
    // Establish a PDO connection (use your own connection details)
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $password);

    // Set PDO to throw exceptions on error
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Start the HTML output
    echo '
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <title>Domov - Muha</title>
        <link rel="stylesheet" href="./styles/style_index.css">
    </head>
    <body>
        <nav>
            <div class="nav">
                <a href="index.php">Muha</a>
                <a href="oglasi.php">Moji oglasi</a>
                <a href="sporocila.php">Sporočila</a>
                <div class="profil">
                    <a href="profil.php?id=' . $id . '">' . $ime . ' ' . $priimek . '</a>
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
    ';

    // Display all oglasi where uporabnik_id = session[id]
    $sql = "SELECT * FROM oglasi WHERE uporabnik_id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $st_oglasov = $stmt->rowCount();

    if ($st_oglasov == 0) {
        echo "<p class='k-naslov'>Nimate nobenega oglasa.</p>";
    } else {
        echo "<p class='k-naslov'>Moji oglasi:</p><br>";
        echo "<div class='oglasi'>";
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $id_oglasa = $row['id'];
            $sql2 = "SELECT * FROM slike WHERE oglas_id = :id_oglasa";
            $stmt2 = $pdo->prepare($sql2);
            $stmt2->bindParam(':id_oglasa', $id_oglasa, PDO::PARAM_INT);
            $stmt2->execute();
            $row2 = $stmt2->fetch(PDO::FETCH_ASSOC);
            $naslov = $row['naslov'];
            $cena = $row['cena'];
            $opis = $row['opis'];
            $slika = $row2['slika'];
            echo "<div class='oglas'>";
            echo "<img src='$slika' alt='slika' max-width='90%' height='200px'>";
            echo "<p>$naslov</p>";
            echo "<p class='opis'>$opis</p>";
            echo "<p>$cena €</p>";
            echo "<a href='uredi_oglas.php?id=$id_oglasa'><div class=uredi-btn>Uredi</div></a>";
            echo "<a  href='izbrisi_oglas.php?id=$id_oglasa'><div class=izbrisi-btn>Izbriši</div></a>";
            echo "</div>";
        }
    }

    // Add a button to create a new oglas
    echo '
    </div>
    <div class="dodaj">
        <a href="dodaj_oglas.php">Dodaj oglas</a>
    </div>
    ';

    // Close the HTML
    echo '
    </body>
    </html>
    ';
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}
?>
