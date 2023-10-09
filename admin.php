<!-- display all oglasi -->
<?php
require_once 'baza.php';
require_once 'cookie.php';

if (!isset($_SESSION['ime']) && $_SESSION['admin'] != 1) {
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

    // Fetch all oglasi
    $stmt = $pdo->prepare("SELECT * FROM oglasi");
    $stmt->execute();
    $oglasi = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin - Muha</title>
    <link rel="stylesheet" href="./styles/style_index.css">
</head>
<!-- display all oglasi -->
<body>
    <div class="content">
        <h1>Oglasi</h1>
        <table>
            <tr>
                <th>ID</th>
                <th>Naslov</th>
                <th>Opis</th>
                <th>Cena</th>
                <th>Kraj</th>
                <th>Kategorija</th>
                <th>Avtor</th>
                <th>Izbriši</th>
            </tr>
            <?php foreach ($oglasi as $oglas): ?>
                <tr>
                    <td><?php echo $oglas['id']; ?></td>
                    <td><?php echo $oglas['naslov']; ?></td>
                    <td><?php echo $oglas['opis']; ?></td>
                    <td><?php echo $oglas['cena']; ?></td>
                    <td><?php echo $oglas['kraj_id']; ?></td>
                    <td><?php echo $oglas['kategorija_id']; ?></td>
                    <td><?php echo $oglas['uporabnik_id']; ?></td>
                    <td><a href="izbrisi_oglas.php?id=<?php echo $oglas['id']; ?>">Izbriši</a></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
