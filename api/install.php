<?php

use zcrmsdk\oauth\ZohoOAuth;
use zcrmsdk\crm\setup\restclient\ZCRMRestClient;

if (isset($_POST["submit"])) {
    $api = new api;
    ZCRMRestClient::initialize($api->configuration);
    $oAuthClient = ZohoOAuth::getClientInstance();
    $grantToken = $_POST['grant_token'];
    $oAuthTokens = $oAuthClient->generateAccessToken($grantToken);
}

?>
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <title>Instalar ZOHO API</title>
</head>

<body>
    <div class="container">

        <h2>Generar token:</h2>

        <p class="font-italic"><a href="https://www.zoho.com/es-xl/crm/developer/docs/server-side-sdks/php.html#Initialization" target="_blank">Referencias</a></p>
        
        <ol>
            <li>Seguir instrucciones para "Generar tokens" y crear "cliente propio" <a href="https://accounts.zoho.com/developerconsole" target="_blank">aqui</a>.</li>
            <li>Completar configuracion en libs/api.php.</li>
            <li>Generar una clave de cliente propio y ingresarla en el formulario. <b>Ambito:</b> <br> ZohoCRM.modules.ALL,ZohoCRM.settings.ALL,aaaserver.profile.READ</li>
        </ol>
        
        <form action="index.php" method="post">

            <div class="form-group">
                <label>Clave cliente propio</label>
                <input type="text" name="grant_token" class="form-control">
            </div>

            <button type="submit" name="submit" class="btn btn-primary">Generar token</button>
        </form>

        <br>
        
        <?php if (isset($_POST["submit"])) : ?>
            <div class="alert alert-primary" role="alert">
                Token generado. <a href="index.php">Ir a index</a>
            </div>
        <?php endif ?>

    </div>


</body>

</html>