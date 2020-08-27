<?php

use zcrmsdk\crm\setup\restclient\ZCRMRestClient;

require 'vendor/autoload.php';

class api {

    public $configuration = array(
        "client_id" => "",
        "client_secret" => "",
        "currentUserEmail" => "",
        "redirect_uri" => "index.php",
        "token_persistence_path" => "zcrm_php_sdk"
    );

    public function __construct() {
        ZCRMRestClient::initialize($this->configuration);
    }

}
