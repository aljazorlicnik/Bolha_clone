<!-- chat -->
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

$id_oglasa = $_GET['id'];
$sql_oglas = "SELECT * FROM oglasi o INNER JOIN uporabniki u ON o.uporabnik_id = u.id WHERE o.id = $id_oglasa";
$result_oglas = mysqli_query($link, $sql_oglas);
$row_oglas = mysqli_fetch_assoc($result_oglas);

$reciever_id = $row_oglas['uporabnik_id'];

$sender_id = $_SESSION['id'];

$sql = "SELECT * FROM sporocila WHERE (sender_id = $sender_id AND reciever_id = $reciever_id) OR (sender_id = $reciever_id AND reciever_id = $sender_id)";
$result = mysqli_query($link, $sql);

$sql_ime = "SELECT * FROM uporabniki WHERE id = $reciever_id";
$result_ime = mysqli_query($link, $sql_ime);
$row_ime = mysqli_fetch_assoc($result_ime);
$reciever_ime = $row_ime['ime'] . " " . $row_ime['priimek'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Chat</title>
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
        <div class="chat">
            <div class="chat-header">
                <p><?php echo $reciever_ime; ?></p>
            </div>
            <div class="chat-body">
                <?php
                while($row = mysqli_fetch_assoc($result)){
                    $sender_id = $row['sender_id'];
                    $sql_sender = "SELECT * FROM uporabniki WHERE id = $sender_id";
                    $result_sender = mysqli_query($link, $sql_sender);
                    $row_sender = mysqli_fetch_assoc($result_sender);
                    $sender_ime = $row_sender['ime'] . " " . $row_sender['priimek'];
                    $sporocilo = $row['sporocilo'];
                    echo "<div class='sporocilo'>";
                    echo "<p class='sender'>$sender_ime</p>";
                    echo "<p class='sporocilo'>$sporocilo</p>";
                    echo "</div>";
                }
                ?>
            </div>
            <div class="chat-footer">
                <form action="chat_in.php?id=<?php echo $id_oglasa; ?>" method="post">
                    <input type="text" name="sporocilo" placeholder="Sporočilo">
                    <button class="btn" type="submit">Pošlji</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
