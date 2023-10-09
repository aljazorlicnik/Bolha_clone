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
?>

<!-- HTML -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
        <!-- form: dodaj oglas naslov, opis, cena, select kraj, select kategorija-->
        <?php
            try {
                // Fetch kraji and kategorije for the dropdowns
                $stmt = $pdo->query("SELECT * FROM kraji");
                $stmt2 = $pdo->query("SELECT * FROM kategorije");
            } catch (PDOException $e) {
                die("Error: " . $e->getMessage());
            }
        ?>
        <form class="dodaj-form" action="dodaj_oglas_in.php" method="post" enctype="multipart/form-data">
            <div class="input">
                <h1 class="naslov">Dodaj oglas</h1>
            </div>
            <div class="input">
                <input type="text" name="naslov" placeholder="Naslov" required/> <br>
            </div>
            <div class="input">
                <textarea name="opis" placeholder="Opis" required></textarea><br>
            </div>
            <div class="input">
                <input type="number" name="cena" placeholder="Cena" required/><br>
            </div>
            <div class="input">
                <select name="kraj" required>
                    <option value="" disabled selected>Izberi kraj</option>
                    <?php
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            $id_kraja = $row['id'];
                            $ime_kraja = $row['kraj'];
                            echo "<option value='$id_kraja'>$ime_kraja</option>";
                        }
                    ?>
                </select>
            </div>
            <div class="input">
                <select name="kategorija" required>
                    <option value="" disabled selected>Izberi kategorijo</option>
                    <?php
                        while ($row = $stmt2->fetch(PDO::FETCH_ASSOC)) {
                            $id_kategorije = $row['id'];
                            $ime_kategorije = $row['kategorija'];
                            echo "<option value='$id_kategorije'>$ime_kategorije</option>";
                        }
                    ?>
                </select>
            </div>
            <div class="input">
                <input type="file" name="slika" accept=".png, .jpg" required/>
            </div>
            <div class="input">
                <button class="btn" type="submit">Dodaj oglas</button>
            </div>
        </form>
    </div>
</body>
</html>
