<!-- uredi oglas where id = get id -->
<!-- form: uredi oglas naslov, opis, cena, select kraj, select kategorija-->

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

$sql = "SELECT * FROM oglasi WHERE id = $id_oglasa";
$result = mysqli_query($link, $sql);
$row = mysqli_fetch_assoc($result);
$naslov = $row['naslov'];
$opis = $row['opis'];
$cena = $row['cena'];
$kraj_id = $row['kraj_id'];
$kategorija_id = $row['kategorija_id'];

$sql = "SELECT * FROM kraji";
$result = mysqli_query($link, $sql);
$sql2 = "SELECT * FROM kategorije";
$result2 = mysqli_query($link, $sql2);
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
        <!-- form: dodaj oglas naslov, opis, cena, select kraj, select kategorija-->
        <form class="dodaj-form" action="uredi_oglas_in.php?id=<?php echo $id_oglasa ?>" method="post" enctype="multipart/form-data">
            <div class="input">
                <h1 class="naslov">Uredi oglas</h1>
            </div>
            <div class="input">
                <input type="text" name="naslov" placeholder="Naslov" value="<?php echo $naslov; ?>" required/> <br>
            </div>
            <div class="input">
                <textarea name="opis" placeholder="Opis" required><?php echo $opis; ?></textarea><br>
            </div>
            <div class="input">
                <input type="number" name="cena" placeholder="Cena" value="<?php echo $cena; ?>" required/><br>
            </div>
            <div class="input">
                <select name="kraj" required>
                    <?php
                    while($row = mysqli_fetch_assoc($result)){
                        $id_kraja = $row['id'];
                        $ime_kraja = $row['kraj'];
                        if($id_kraja == $kraj_id){
                            echo "<option value='$id_kraja' selected>$ime_kraja</option>";
                        }
                        else{
                            echo "<option value='$id_kraja'>$ime_kraja</option>";
                        }
                    }
                    ?>
                </select><br>
            </div>
            <div class="input">
                <select name="kategorija" required>
                    <?php
                    while($row2 = mysqli_fetch_assoc($result2)){
                        $id_kategorije = $row2['id'];
                        $ime_kategorije = $row2['kategorija'];
                        if($id_kategorije == $kategorija_id){
                            echo "<option value='$id_kategorije' selected>$ime_kategorije</option>";
                        }
                        else{
                            echo "<option value='$id_kategorije'>$ime_kategorije</option>";
                        }
                    }
                    ?>
                </select><br>
            </div>
            <div class="input">
                <button class="btn" type="submit">Uredi oglas</button>
            </div>
        </form>
    </div>
</body>
</html>

