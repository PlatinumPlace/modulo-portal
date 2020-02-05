<?php
include 'vendor/autoload.php';
use zcrmsdk\crm\setup\restclient\ZCRMRestClient;
include '../lib/api.php';
$api = new api;
$api->configuration["token_persistence_path"]='token/';
ZCRMRestClient::initialize($api->configuration);
$criterio = "Marca:equals:" . $_POST["marcas_id"];
$modelos = $api->searchRecordsByCriteria("Modelos", $criterio);
foreach ($modelos as $modelo) {
    echo '<option value="'.$modelo->getEntityId().'">'.$modelo->getFieldValue("Name").'</option>';
}