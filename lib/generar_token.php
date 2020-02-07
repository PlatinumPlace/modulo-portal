<?php

include "../api/vendor/autoload.php";
include "../models/api_model.php";

use zcrmsdk\oauth\ZohoOAuth;
use zcrmsdk\crm\setup\restclient\ZCRMRestClient;

function generar_token($grant_token)
{
    $api = new api_model;
    ZCRMRestClient::initialize($api->configuration);
    $oAuthClient = ZohoOAuth::getClientInstance();
    $grantToken = $grant_token;
    $oAuthTokens = $oAuthClient->generateAccessToken($grantToken);
}