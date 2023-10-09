<!DOCTYPE html>
<html lang="sl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./styles/style_prijava.css">
    <title>Registracija</title>
</head>
<body>
  <?php
  require_once 'cookie.php';
  if(isset($_SESSION['id'])){
    header('Location: index.php');
    exit();
  }
  ?>
  <div>
  <div class = "container">
    <h1>Google povezava</h1>
    <p>Poveži svoj trenutni račun, z svojim google računom za lažjo prijavo:</p>
 <form action="googlelink.php" method="post">
 <label for="email">Mail:</label>
  <input type="text" id="email" name="email" required readonly value = "<?php echo $_SESSION['email'] ?>">
  <label for="geslo">Geslo:</label>
  <input type="password" id="geslo" name="geslo" required>  
  <input type="submit" value="Pošlji">
</form>
<p>Nočeš povezati računa?<a href = "prijava.php"> Pojdi na prijavo</a>
  </div>
</div>
</body>
</html>
