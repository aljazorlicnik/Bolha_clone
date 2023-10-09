<!DOCTYPE html>
<html lang="sl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel = "stylesheet" href = "styles/style_prijava.css">
    <title>Registracija</title>
</head>
<body>
<nav class="navbar">
        <div class="navbar-left">
            <b style = "color:white; font-family:'Courier New', Courier, monospace">SteamCopy</b>
        </div>
        <div class="navbar-center">
            <button class="center-button" onclick="location.href='index.php'">Store</button>
            <button class='center-button' onclick="location.href='library.php'">Library</button>
            <button class="center-button" onclick="location.href='community.php'">Community</button>
        </div>
        <div class="navbar-right">
        </div>
    </nav>
  <?php
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
 <form action="register.php" method="post">
  <label for="ime">Ime:</label>
  <input type="text" id="ime" name="ime" value = "<?php echo $_SESSION['ime'] ?>" required>  
  <label for="priimek">Priimek:</label>
  <input type="text" id="priimek" name="priimek" required  value = "<?php echo $_SESSION['priimek'] ?>">  
  <label for="username">Username:</label>
  <input type="text" id="username" name="username"  required>  
  <label for="email">Mail:</label>
  <input type="text" id="email" name="email" required value = "<?php echo $_SESSION['email'] ?>">  
  <label for="geslo">Geslo:</label>
  <input type="password" id="geslo" name="geslo" required>  
</datalist>
  <input type="submit" value="Registracija">
</form>
<p>Ste že registrirani? <a href = "prijava.php">Pojdite na prijavo</a>
  </div>
</body>
</html>