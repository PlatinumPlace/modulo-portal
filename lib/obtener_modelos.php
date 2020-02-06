<?php
include '../api/vendor/autoload.php';
include '../models/api_model.php';

use zcrmsdk\crm\setup\restclient\ZCRMRestClient;

$api = new api_model;
$api->configuration["token_persistence_path"] = dirname(__FILE__, 2) . '/api/token/';
ZCRMRestClient::initialize($api->configuration);
$criterio = "Marca:equals:" . $_POST["marcas_id"];
$modelos = $api->searchRecordsByCriteria("Modelos", $criterio);
foreach ($modelos as $modelo) {
    echo '<option value="' . $modelo->getEntityId() . '">' . $modelo->getFieldValue("Name") . '</option>';
}
