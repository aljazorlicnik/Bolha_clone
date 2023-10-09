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

$sender_id = $id;

$oglas_id = $_GET['id'];

// Try GET[receiver_id], else get receiver_id from oglas_id
if (isset($_GET['receiver_id'])) {
    $receiver_id = $_GET['receiver_id'];
} else {
    try {
        // Establish a PDO connection (use your own connection details)
        $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Fetch the receiver_id based on oglas_id using a prepared statement
        $stmt = $pdo->prepare("SELECT o.uporabnik_id as receiver_id 
                               FROM oglasi o
                               INNER JOIN uporabniki u ON o.uporabnik_id = u.id 
                               WHERE o.id = :oglas_id");
        $stmt->bindParam(':oglas_id', $oglas_id, PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $receiver_id = $row['receiver_id'];
    } catch (PDOException $e) {
        die("Error: " . $e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1" />
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
        <div class="sporocilo-content">
            <!-- form for sporocilo -->
            <form action="pogovor_in.php" method="post">
                <div class="input">
                    <h1 class="naslov">Pošlji sporočilo</h1>
                </div>
                <div class="input">
                    <textarea class="sporocilo" name="sporocilo" placeholder="Sporočilo" rows="5" required></textarea><br>
                </div>
                <div class="input">
                    <input type="hidden" name="sender_id" value="<?php echo $sender_id; ?>">
                    <input type="hidden" name="receiver_id" value="<?php echo $receiver_id; ?>">
                    <input type="hidden" name="oglas_id" value="<?php echo $oglas_id; ?>">
                    <button class="sporocilo-btn" type="submit" name="submit">Pošlji</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
