<?php

use zcrmsdk\crm\setup\restclient\ZCRMRestClient;
use zcrmsdk\oauth\ZohoOAuth;

require 'api.php';

if ($_POST) {
    $api = new api();
    ZCRMRestClient::initialize($api->configuration);
    $oAuthClient = ZohoOAuth::getClientInstance();
    $oAuthClient->generateAccessToken($_POST['grant_token']);
}
?>
<!doctype html>
<html lang="en">

    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">

        <title>Generar token</title>
    </head>

    <body>

        <div class="container">

            <br> <br> <br>
            <div class="row justify-content-center">

                <div class="col-lg-7">

                    <h3>Generar token</h3>

                    <form class="form-inline">

                        <div class="form-group mb-2">
                            <input type="text" readonly class="form-control-plaintext" value="Clave cliente propio">
                        </div>

                        <div class="form-group mx-sm-3 mb-2">
                            <input type="text" name="grant_token" class="form-control" placeholder="Grant token">
                        </div>

                        <button type="submit" class="btn btn-primary mb-2">Confirmar</button>
                    </form>

                    <br> <br> <br> <br>

                    <h4>
                        Referencias <a class="small mb-3 text-muted" href="https://www.zoho.com/es-xl/crm/developer/docs/server-side-sdks/php.html#Initialization" target="_blank">Ver</a>
                    </h4>

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

                    <?php if ($_POST) : ?>
                        <div class="alert alert-success" role="alert">
                            Token Creardo.
                        </div>
                    <?php endif ?>

                </div>
            </div>
        </div>

    </body>

</html>