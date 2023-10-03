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

$query = "SELECT * FROM uporabniki WHERE id = '$id'";
$result = mysqli_query($link, $query);
$row = mysqli_fetch_assoc($result);
$ime = $row['ime'];
$priimek = $row['priimek'];
$email = $row['email'];
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
    
    <div class="content">
        <!-- edit user info (ime, priimek, email, geslo) -->
        <div class="edit">
            <form action="profil_in.php" method="post">
                <label for="ime">Ime:</label><br>
                <input type="text" name="ime" id="ime" value="<?php echo $ime; ?>"><br>
                <label for="priimek">Priimek:</label><br>
                <input type="text" name="priimek" id="priimek" value="<?php echo $priimek; ?>"><br>
                <label for="email">Email:</label><br>
                <input type="email" name="email" id="email" value="<?php echo $email; ?>"><br>
                <label for="geslo">Geslo:</label><br>
                <input type="password" name="geslo" id="geslo"><br>
                <label for="geslo2">Ponovi geslo:</label><br>
                <input type="password" name="geslo2" id="geslo2"><br>
                <button class="btn" type="submit">Shrani</button>
            </form>
    </div>
</body>
</html>