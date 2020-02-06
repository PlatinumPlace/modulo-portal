<?php
include "api/vendor/autoload.php";
include "models/api_model.php";

use zcrmsdk\oauth\ZohoOAuth;
use zcrmsdk\crm\setup\restclient\ZCRMRestClient;

$mensaje = "";
if ($_POST) {
    $api = new api_model;
    if (!is_dir("api/token")) {
        mkdir("api/token", 0755, true);
    }
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
    <p>Ambito: ZohoCRM.modules.ALL,ZohoCRM.settings.ALL,aaaserver.profile.READ</p>
    <form action="instalador_api.php" method="post">
        <label>Codigo</label>
        <input type="text" name="grant_token">
        <br>
        <button type="submit">Generar token</button>
    </form>
    <?= $mensaje ?>
</body>

</html>