<?php
use zcrmsdk\crm\setup\restclient\ZCRMRestClient;

class config_api
{
    public $configuration = array(
        "client_id" => "1000.7FJQ4A2KDH9S2IJWDYL13HATQFMA2H",
        "client_secret" => "c3f1d0589803f294a7c5b27e3968ae1658927da9d7",
        "currentUserEmail" => "tecnologia@gruponobe.com",
        "redirect_uri" => "index.php",
        "token_persistence_path" => "php_sdk"
    );

    public function __construct()
    {
        ZCRMRestClient::initialize($this->configuration);
    }
}
