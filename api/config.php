<?php 
    use zcrmsdk\crm\setup\restclient\ZCRMRestClient;
    require "vendor/autoload.php";
    $configuration = array(
        "client_id" => "1000.ITUMBO9C16Y86Z8TUB3AAJ19LG42EH",
        "client_secret" => "cc764977b6d217d892d526a5825489cd106a363c09",
        "redirect_uri" => "http://localhost/portal/api/install.php",
        "currentUserEmail" => "tecnologia@gruponobe.com",
        "token_persistence_path" =>dirname(__FILE__). "/token"
    );
    ZCRMRestClient::initialize($configuration);
    ?>