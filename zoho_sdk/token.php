<?php

use zcrmsdk\oauth\ZohoOAuth;
use zcrmsdk\crm\setup\restclient\ZCRMRestClient;

if ($_POST) {
    $zoho_api = new zoho_api();
    ZCRMRestClient::initialize($zoho_api->configuration);
    $oAuthClient = ZohoOAuth::getClientInstance();
    $grantToken = $_POST['grant_token'];
    $oAuthTokens = $oAuthClient->generateAccessToken($grantToken);
    header("Location:" . constant("url"));
    exit();
}
?>
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