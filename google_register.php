<!DOCTYPE html>
<html lang="sl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel = "stylesheet" href = "styles/style_prijava.css">
    <title>Registracija</title>
</head>
<body>
  <?php
  require_once 'cookie.php';
  if(isset($_SESSION['id'])){
    header('Location: index.php');
    exit();
  }
  $_SESSION['googleregister'] = 1;
  ?>
  <div class='content-below-navbar'>
   
  <div class = "container">
    <h1>Registracija</h1>
    <p>Potrebno je še izpolniti dodatna polja:</p>
 <form action="reg_in.php" method="post">
  <label for="ime">Ime:</label>
  <input type="text" id="ime" name="ime" value = "<?php echo $_SESSION['ime'] ?>" required>  
  <label for="priimek">Priimek:</label>
  <input type="text" id="priimek" name="priimek" required  value = "<?php echo $_SESSION['priimek'] ?>">  
  <label for="email">Mail:</label>
  <input type="text" id="email" name="e-mail" required value = "<?php echo $_SESSION['email'] ?>" readonly>  
  <label for="geslo">Geslo:</label>
  <input type="password" id="geslo" name="geslo" required>  
</datalist>
  <input type="submit" value="Registracija">
</form>
<p>Ste že registrirani? <a href = "prijava.php">Pojdite na prijavo</a>
  </div>
</body>
</html>
