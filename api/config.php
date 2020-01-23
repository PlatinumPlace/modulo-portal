<?php 
    use zcrmsdk\crm\setup\restclient\ZCRMRestClient;
    require "vendor/autoload.php";
    $configuration = array(
        "client_id" => "1000.OSYCO9GL00AGB3GSRROTEG9SP22RZH",
        "client_secret" => "db004e2e204017877c6f72ba5d5c7e184f893e957b",
        "redirect_uri" => "http://localhost/portal/api/install.php",
        "currentUserEmail" => "tecnologia@gruponobe.com",
        "token_persistence_path" =>dirname(__FILE__). "/token"
    );
    ZCRMRestClient::initialize($configuration);
    ?>