<?php

use zcrmsdk\oauth\ZohoOAuth;
use zcrmsdk\crm\setup\restclient\ZCRMRestClient;

class instalador_api
{
    public function instalar()
    {
        if ($_POST) {
            if (!is_dir("api/token")) {
                mkdir("api/token", 0755, true);
            }
            $authTokenFile = fopen("token/zcrm_oauthtokens.txt", "w");
            fwrite($authTokenFile, '');
            fclose($authTokenFile);
            $api = new api;
            ZCRMRestClient::initialize($api->configuration);
            $oAuthClient = ZohoOAuth::getClientInstance();
            $grantToken = $_POST['grant_token'];
            $oAuthTokens = $oAuthClient->generateAccessToken($grantToken);
            $mensaje = "Token generado.";
        }
        require("pages/api/instalador.php");
    }
}
