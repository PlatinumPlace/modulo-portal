<?php

use zcrmsdk\oauth\ZohoOAuth;
use zcrmsdk\crm\setup\restclient\ZCRMRestClient;

if ($_POST) {
    $api = new api();
    ZCRMRestClient::initialize($api->configuration);
    $oAuthClient = ZohoOAuth::getClientInstance();
    $grantToken = $_POST['grant_token'];
    $oAuthTokens = $oAuthClient->generateAccessToken($grantToken);
    header("Location:" . constant("url"));
    exit();
}
?>
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

    <title>Generar Token</title>
</head>

<body>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-7">
                <div class="card shadow-lg border-0 rounded-lg mt-5">
                    <div class="card-header">
                        <h3 class="text-center font-weight-light my-4">Generar token</h3>
                    </div>
                    <div class="card-body">
                        <div class="small mb-3 text-muted">
                            <a href="https://www.zoho.com/es-xl/crm/developer/docs/server-side-sdks/php.html#Initialization" target="_blank">Referencias</a>
                        </div>
                        <ol>
                            <li>Seguir instrucciones para "Generar tokens" y crear "cliente
                                propio" <a href="https://accounts.zoho.com/developerconsole" target="_blank">aqui</a>.
                            </li>
                            <li>Completar configuracion en core/models/api.php.</li>
                            <li>Generar una clave de cliente propio y ingresarla en el
                                formulario. <b>Ambito:</b> <br>
                                ZohoCRM.modules.ALL,ZohoCRM.settings.ALL,aaaserver.profile.READ
                            </li>
                        </ol>
                        <form action="<?= constant("url") ?>" method="post">
                            <div class="form-group">
                                <label class="small mb-1" for="clave">Clave cliente propio</label>
                                <input class="form-control py-4" id="clave" type="text" name="grant_token" />
                            </div>
                            <div class="form-group d-flex align-items-center justify-content-between mt-4 mb-0">
                                <button type="submit" class="btn btn-primary">Generar token</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
</body>

</html>