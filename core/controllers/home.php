<?php

use zcrmsdk\oauth\ZohoOAuth;
use zcrmsdk\crm\setup\restclient\ZCRMRestClient;

class home extends api
{
    function __construct()
    {
        parent::__construct();
    }

    public function generar_token()
    {
        if ($_POST) {

            ZCRMRestClient::initialize($this->configuration);

            $oAuthClient = ZohoOAuth::getClientInstance();
            $grantToken = $_POST['grant_token'];
            $oAuthTokens = $oAuthClient->generateAccessToken($grantToken);
        }

        require_once("core/views/layout/header_login.php");
        require_once("core/views/home/token.php");
        require_once("core/views/layout/footer_login.php");
    }

    public function error()
    {
        require_once("core/views/home/error.php");
    }

    public function redirigir($url)
    {
        require_once("core/views/layout/header_main.php");
        require_once("core/views/home/redirigir.php");
        require_once("core/views/layout/footer_main.php");
    }
}
