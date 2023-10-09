<!-- make a login page -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="./styles/style_prijava.css">
    <title>Prijava</title>
</head>
<body>
<?php
  include_once 'libraries/vendor/autoload.php';
  session_start();

  $google_client = new Google_Client();

$google_client->setClientId('568109484828-nfildh5cd6p21kn75bmkcdkc5mln257j.apps.googleusercontent.com');

$google_client->setClientSecret('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');

$google_client->SetRedirectUri('http://bolha.aljazorli.eu/google_login.php');

$google_client->addScope('email');

$google_client->addScope('profile');
  ?>
    <div id="bg"></div>
        <form action="preveri.php" method="post">
            <div class="form-field">
                <h1 class="naslov">Prijava</h1>
            </div>
            <div class="form-field">
                <input type="email" name="email" placeholder="E-mail" required/>
            </div>
            <div class="form-field">
                <input type="password" name="geslo" placeholder="Geslo" required/>
            </div>
            <div class="form-field">
                <button class="btn" type="submit">Prijavi se</button>
            </div>
            <div class="form-field">
            <p>Lahko se tudi registriraš z Google računom: <a href = "<?php echo $google_client->createAuthUrl()?>">Registriraj se z Google računom</a><br><br>
            <a class="prijava" href="registracija.php">Še niste registrirani? Registrirajte se.</a>
        </div>
        </form>
    </div>
</body>

