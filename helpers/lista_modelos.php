<?php

include dirname(__FILE__, 2) . '/zcrm_php_sdk/vendor/autoload.php';
include dirname(__FILE__, 2) . '/config/api.php';

use zcrmsdk\crm\exception\ZCRMException;
use zcrmsdk\crm\setup\restclient\ZCRMRestClient;

$api = new api();
$api->configuration["token_persistence_path"] = dirname(__FILE__, 2) . "/zcrm_php_sdk";
ZCRMRestClient::initialize($api->configuration);

$num_pag = 1;
$criteria = "Marca:equals:" . $_POST["marcas_id"];
$moduleIns = ZCRMRestClient::getInstance()->getModuleInstance("Modelos");

do {
    $param_map = array("page" => $num_pag, "per_page" => 200);

    try {
        $response = $moduleIns->searchRecordsByCriteria($criteria, $param_map);
        $records = $response->getData();
        $num_pag++;
        sort($records);
        foreach ($records as $record) {
            echo '<option value="' . $record->getEntityId() . '">' . strtoupper($record->getFieldValue("Name")) . '</option>';
        }
    } catch (ZCRMException $ex) {
        /*
          echo $ex->getMessage();
          echo "<br>";
          echo $ex->getExceptionCode();
          echo "<br>";
          echo $ex->getFile();
          echo "<br>";
         */

        $num_pag = 0;
    }
} while ($num_pag > 1);
