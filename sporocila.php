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
    $pdo = new PDO("mysql:host=$db_host;dbname=$db", $db_user, $db_password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Fetch sporocila using prepared statement
    $stmt = $pdo->prepare("SELECT * FROM sporocila WHERE sender_id = :id OR receiver_id = :id");
    $stmt->execute(['id' => $id]);
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
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
        <?php
        foreach ($result as $row) {
            $sporocilo_id = $row['id'];
            $oglas_id = $row['oglas_id'];
            $naslov_oglasa = "";
            $vsebina = $row['sporocilo'];
            $sender_id = $row['sender_id'];
            $receiver_id = $sender_id;
            
            // Fetch oglas info using prepared statement
            $stmt_oglas = $pdo->prepare("SELECT * FROM oglasi WHERE id = :oglas_id");
            $stmt_oglas->execute(['oglas_id' => $oglas_id]);
            $row_oglas = $stmt_oglas->fetch(PDO::FETCH_ASSOC);
            if ($row_oglas) {
                $naslov_oglasa = $row_oglas['naslov'];
            }

            // Fetch sender info using prepared statement
            $stmt_sender = $pdo->prepare("SELECT * FROM uporabniki WHERE id = :sender_id");
            $stmt_sender->execute(['sender_id' => $sender_id]);
            $row_sender = $stmt_sender->fetch(PDO::FETCH_ASSOC);
            if ($row_sender) {
                $sender_ime = $row_sender['ime'];
                $sender_priimek = $row_sender['priimek'];
            }

            // Calculate time difference
            $cas_posiljanja = strtotime($row['cas']);
            $cas_posiljanja = time() - $cas_posiljanja;
            $cas_posiljanja = round($cas_posiljanja / 60);
            if ($cas_posiljanja < 60) {
                $cas_posiljanja = $cas_posiljanja . " minut";
            } else if ($cas_posiljanja < 1440) {
                $cas_posiljanja = round($cas_posiljanja / 60);
                $cas_posiljanja = $cas_posiljanja . " ur";
            } else {
                $cas_posiljanja = round($cas_posiljanja / 1440);
                $cas_posiljanja = $cas_posiljanja . " dni";
            }
        ?>
            <a class="sporocila-a" href="pogovor.php?id=<?php echo $oglas_id; ?>&receiver_id=<?php echo $receiver_id; ?>">
                <div class="sporocila">
                    <div class="bold">
                        <span></span> <?php echo $naslov_oglasa; ?>
                    </div>
                    <div class="ime">
                        <span class="bold">Pošiljatelj:</span> <?php echo $sender_ime . " " . $sender_priimek; ?>
                    </div>
                    <div class="sporocilo-text">
                        <span>Sporočilo:</span> <?php echo $vsebina; ?>
                    </div>
                    <div class="cas">
                        <span class="bold">Poslano pred:</span> <?php echo $cas_posiljanja; ?>
                    </div>
                </div>
            </a>
        <?php
        }
        ?>
    </div>
</body>
</html>
