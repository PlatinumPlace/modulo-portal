<?php
use zcrmsdk\crm\setup\restclient\ZCRMRestClient;

class config_api
{
    public $configuration = array(
        "client_id" => " ",
        "client_secret" => " ",
        "currentUserEmail" => " ",
        "redirect_uri" => "index.php",
        "token_persistence_path" => "php_sdk"
    );

    public function __construct()
    {
        ZCRMRestClient::initialize($this->configuration);
    }
}
