<?php

use zcrmsdk\crm\setup\restclient\ZCRMRestClient;

class api {

    public $configuration = array(
        "client_id" => "",
        "client_secret" => "",
        "currentUserEmail" => "",
        "redirect_uri" => "install.php",
        "token_persistence_path" => "sdk"
    );

    public function __construct() {
        ZCRMRestClient::initialize($this->configuration);
    }

}
