<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./styles/style_prijava.css">
    <title>Registracija</title>
</head>
<body>
<?php
  include_once 'libraries/vendor/autoload.php';
  session_start();

  $google_client = new Google_Client();

$google_client->setClientId('568109484828-nfildh5cd6p21kn75bmkcdkc5mln257j.apps.googleusercontent.com');

$google_client->setClientSecret('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');

$google_client->SetRedirectUri('http://bolha.aljazorli.eu/googlelogin.php');

$google_client->addScope('email');

$google_client->addScope('profile');
  ?>
    <div id="bg"></div>
        <form form action="reg_in.php" method="post">
            <div class="input">
                <h1 class="naslov">Registracija</h1>
            </div>
            <div class="input">
                <input type="text" name="ime" placeholder="Ime" required/> <br>
            </div>
            <div class="input">
                <input type="text" name="priimek" placeholder="Priimek" required/><br>
            </div>
        
            <div class="input">
                <input type="email" name="e-mail" placeholder="E-mail" required/>
            </div>

            <div class="input">
                <input type="password" name="geslo" placeholder="Geslo" required/>
            </div>
            <div class="input">
                <button class="btn" type="submit">Registriraj se</button>
            </div>
            <div class="input">
            <p>Lahko se tudi registriraš z Google računom: <a href = "<?php echo $google_client->createAuthUrl()?>">Registriraj se z Google računom</a>
            <a class="prijava" href="prijava.php">Ste že registrirani? Prijavite se.</a>
            </div>
        </form>
    </div>
</body>
</html>

<?php
?>