<?php

use zcrmsdk\crm\setup\restclient\ZCRMRestClient;

class zoho_api
{

    public $configuration = array(
        "client_id" => "",
        "client_secret" => "",
        "currentUserEmail" => "",
        "redirect_uri" => "index.php",
        "token_persistence_path" => "zoho_sdk"
    );

    public function __construct()
    {
        ZCRMRestClient::initialize($this->configuration);
    }
}
