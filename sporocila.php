<!-- display all sporocila where sender_id = id -->

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

$sql = "SELECT * FROM sporocila WHERE sender_id = '$id' OR receiver_id = '$id'";
$result = mysqli_query($link, $sql);

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
    <div class="content">        <?php
        while ($row = mysqli_fetch_assoc($result)) {
            $sporocilo_id = $row['id'];
            $oglas_id = $row['oglas_id'];
            $sql_oglas = "SELECT * FROM oglasi WHERE id = '$oglas_id'";
            $result_oglas = mysqli_query($link, $sql_oglas);
            $row_oglas = mysqli_fetch_assoc($result_oglas);
            $naslov_oglasa = $row_oglas['naslov'];
            $vsebina = $row['sporocilo'];
            $sender_id = $row['sender_id'];
            $sql_sender = "SELECT * FROM uporabniki WHERE id = '$sender_id'";
            $result_sender = mysqli_query($link, $sql_sender);
            $row_sender = mysqli_fetch_assoc($result_sender);
            $sender_ime = $row_sender['ime'];
            $sender_priimek = $row_sender['priimek'];
            $cas_posiljanja = $row['cas'];
            // convert cas_posiljanja to how much time ago
            $cas_posiljanja = strtotime($cas_posiljanja);
            $cas_posiljanja = time() - $cas_posiljanja;
            $cas_posiljanja = round($cas_posiljanja / 60);
            if ($cas_posiljanja < 60) {
                $cas_posiljanja = $cas_posiljanja . " minut";
            }
            else if ($cas_posiljanja < 1440) {
                $cas_posiljanja = round($cas_posiljanja / 60);
                $cas_posiljanja = $cas_posiljanja . " ur";
            }
            else {
                $cas_posiljanja = round($cas_posiljanja / 1440);
                $cas_posiljanja = $cas_posiljanja . " dni";
            }
            $receiver_id = $sender_id;
        ?>
        <a class="sporocila-a" href="pogovor.php?id=<?php echo $oglas_id; ?>&receiver_id=<?php echo $receiver_id; ?>">
            <div class="sporocila">
                <div class="naslov">
                    <span class="bold"></span> <?php echo $naslov_oglasa; ?>
                </div>
                <div class="ime">
                    <span class="bold">Pošiljatelj:</span> <?php echo $sender_ime . " " . $sender_priimek; ?>
                </div>
                <div>
                    <span class="bold">Sporočilo:</span> <?php echo $vsebina; ?>
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
