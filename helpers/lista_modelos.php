<?php
include dirname(__FILE__, 2) . '/php_sdk/vendor/autoload.php';
include dirname(__FILE__, 2) . '/config/config_api.php';

use zcrmsdk\crm\setup\restclient\ZCRMRestClient;
use zcrmsdk\crm\exception\ZCRMException;

$api = new config_api();
$api->configuration["token_persistence_path"] = dirname(__FILE__, 2) . "/php_sdk";
ZCRMRestClient::initialize($api->configuration);

$page = 1;
$criteria = "Marca:equals:" . $_POST["marcas_id"];
$moduleIns = ZCRMRestClient::getInstance()->getModuleInstance("Modelos");
do {
    $param_map = array("page" => $page, "per_page" => 200);
    try {
        $response = $moduleIns->searchRecordsByCriteria($criteria, $param_map);
        $records = $response->getData();
        $page++;
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

        $page = 0;
    }
} while ($page > 1);