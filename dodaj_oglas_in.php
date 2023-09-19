<!-- insert into database -->
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

$naslov = $_POST['naslov'];
$opis = $_POST['opis'];
$cena = $_POST['cena'];
$kraj = $_POST['kraj'];
$kategorija = $_POST['kategorija'];

// image upload
$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["slika"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

// check if image is actual image or fake image
if(isset($_POST["submit"])){
    $check = getimagesize($_FILES["slika"]["tmp_name"]);
    if($check !== false){
        $uploadOk = 1;
    }
    else{
        echo "<script>alert('Dovoljene so samo slike.')</script>";
        $uploadOk = 0;
    }
}

// check if file already exists
if(file_exists($target_file)){
    echo "<script>alert('Datoteka že obstaja.')</script>";
    $uploadOk = 0;
}

// check file size
if($_FILES["slika"]["size"] > 500000){
    echo "<script>alert('Datoteka je prevelika.')</script>";
    $uploadOk = 0;
}

// allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"){
    echo "Dovoljeni so samo formati: JPG, JPEG, PNG.";
    $uploadOk = 0;
}

// check if $uploadOk is set to 0 by an error
if($uploadOk == 0){
    echo "<script>alert('Datoteka ni bila naložena.')</script>";
}
// if everything is ok, try to upload file
else{
    if(move_uploaded_file($_FILES["slika"]["tmp_name"], $target_file)){
        
    }
    else{
        echo "<script>alert('Prišlo je do napake pri nalaganju datoteke.')</script>";
    }
}



$sql = "INSERT INTO oglasi (naslov, opis, cena, kraj_id, kategorija_id, uporabnik_id) VALUES ('$naslov', '$opis', '$cena', '$kraj', '$kategorija', '$id')";
$result = mysqli_query($link, $sql);

// insert slika into database
$sql = "SELECT * FROM oglasi WHERE naslov = '$naslov'";
$result = mysqli_query($link, $sql);
$row = mysqli_fetch_assoc($result);
$id_oglasa = $row['id'];
$sql = "INSERT INTO slike (slika, oglas_id) VALUES ('$target_file', '$id_oglasa')";
$result = mysqli_query($link, $sql);

if($result){
    header("Location: oglasi.php");
    exit;
}
else{
    echo "Napaka pri dodajanju oglasa.";
}

?>

