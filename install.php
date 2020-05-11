<?php
include "api/vendor/autoload.php";
include "models/api.php";

use zcrmsdk\oauth\ZohoOAuth;
use zcrmsdk\crm\setup\restclient\ZCRMRestClient;

if (isset($_POST["submit"])) {
    $zoho_api = new zoho_api;
    ZCRMRestClient::initialize($zoho_api->configuration);
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
        <h1>Como instalar:</h1>
        <h5>Referencias: <a href="https://www.zoho.com/es-xl/crm/developer/docs/server-side-sdks/php.html" target="_blank">aqui</a></h5>
        <ol>
            <li>Registrar la aplicacion en zoho <a href="https://accounts.zoho.com/developerconsole" target="_blank">aqui</a>.</li>
            <li>Completar models/api.php.</li>
            <li>Generar una clave de cliente propio y ingresarla en el formulario. <b>Ambito:</b> <br> ZohoCRM.modules.ALL,ZohoCRM.settings.ALL,aaaserver.profile.READ</li>
        </ol>
        <form action="install.php" method="post">
            <div class="form-group">
                <label>Clave cliente propio</label>
                <input type="text" name="grant_token" class="form-control">
            </div>
            <button type="submit" class="btn btn-primary">Generar token</button>
        </form>
        <?php if (isset($_POST["submit"])) : ?>
            <div class="alert alert-primary" role="alert">
                Token generado en api/zcrm_oauthtokens.txt
                <br>
                <a href="index.php" class="btn btn-link">Ir a index</a>
            </div>
        <?php endif ?>
    </div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>

</html>