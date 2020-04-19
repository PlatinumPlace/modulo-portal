<?php
include "api/vendor/autoload.php";
include "libs/api.php";

use zcrmsdk\oauth\ZohoOAuth;
use zcrmsdk\crm\setup\restclient\ZCRMRestClient;

$mensaje = "";
if ($_POST) {
    $api = new api;
    ZCRMRestClient::initialize($api->configuration);
    $oAuthClient = ZohoOAuth::getClientInstance();
    $grantToken = $_POST['grant_token'];
    $oAuthTokens = $oAuthClient->generateAccessToken($grantToken);
    $mensaje = "Token generado.";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ZOHO API</title>
</head>

<body>
    <h1>
        Generar token con clave de <a href="https://accounts.zoho.com/developerconsole" target="_blank">client propio</a>.
    </h1>
    <p>Ambito: <br> ZohoCRM.modules.ALL,ZohoCRM.settings.ALL,aaaserver.profile.READ</p>
    <form action="install.php" method="post">
        <label>Codigo</label>
        <input type="text" name="grant_token">
        <br>
        <button type="submit">Generar token</button>
    </form>
    <?= $mensaje ?>
</body>

</html>