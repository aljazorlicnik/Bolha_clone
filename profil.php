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
    try {
        // Establish a PDO connection using credentials from baza.php
        $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
        // Fetch sporocila using prepared statement
        $stmt = $pdo->prepare("SELECT * FROM sporocila WHERE sender_id = :id OR receiver_id = :id");
        $stmt->execute(['id' => $id]);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die("Error: " . $e->getMessage());
    }
    $stmt = $pdo->prepare("SELECT * FROM uporabniki WHERE id = :id");
    $stmt->execute(['id' => $id]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $ime = $row['ime'];
    $priimek = $row['priimek'];
    $email = $row['email'];
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
            </form><br>
            <!-- if admin==1 add an admin button -->
            <?php
            if ($_SESSION['admin'] == 1) {
                echo "<a href='admin.php'><button class='btn'>Admin</button></a>";
            }
            ?>
        </div>
    </div>
</body>
</html>
