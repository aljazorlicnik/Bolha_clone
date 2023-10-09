<?php
require_once 'cookie.php';
if(isset($_SESSION['id'])){
    header('Location: index.php');
    exit();
  }
include_once 'libraries/vendor/autoload.php';
require_once 'baza.php';

$google_client = new Google_Client();
$google_client->setClientId('568109484828-nfildh5cd6p21kn75bmkcdkc5mln257j.apps.googleusercontent.com');

$google_client->setClientSecret('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');

$google_client->SetRedirectUri('http://bolha.aljazorli.eu/google_login.php');
$google_client->addScope('email');
$google_client->addScope('profile');

if (isset($_GET["code"])) {
    $token = $google_client->fetchAccessTokenWithAuthCode($_GET["code"]);

    if (!isset($token["error"])) {
        $google_client->setAccessToken($token['access_token']);
        $_SESSION['access_token'] = $token['access_token'];

        $google_service = new Google_Service_Oauth2($google_client);

        $data = $google_service->userinfo->get();

        $ime = $data->givenName; // Use object properties to access data
        $priimek = $data->familyName;
        $mail = $data->email;
        //get id from google account
        $id = $data->id;

        
        $sql = "SELECT * FROM uporabniki WHERE email = :mail";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':mail', $mail, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($stmt->rowCount() == 0) {
            $_SESSION['ime'] = $ime;
            $_SESSION['priimek'] = $priimek;
            $_SESSION['email'] = $mail;
            $_SESSION['google_id'] = $id;
            header("Location: google_register.php");
        } 
        else {
            if($result['google_id'] == NULL){
                $_SESSION['google_id'] = $id;
                $_SESSION['email'] = $mail;
                header("Location: google_addmail.php");
            }
                else{
                    $_SESSION['ime'] = $result['ime'];
                    $_SESSION['priimek'] = $result['priimek'];
                    $_SESSION['id'] = $result['id'];
                    header("Refresh:0;url=index.php");
                }
        }
    }
} else {
    // Handle the case where the 'code' parameter is not set.
    // You might want to redirect or display an error message.
    echo "Error: Unable to authenticate with Google.";
}
?>
