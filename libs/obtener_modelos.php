<?php
include dirname(__FILE__, 2) . '/zoho_api/vendor/autoload.php';
include dirname(__FILE__, 2) . '/libs/zoho_api.php';

use zcrmsdk\crm\setup\restclient\ZCRMRestClient;

$api = new zoho_api;
$api->configuration["token_persistence_path"] = dirname(__FILE__, 2) . "/zoho_api";
ZCRMRestClient::initialize($api->configuration);

$criterio = "Marca:equals:" . $_POST["marcas_id"];
$modelos = $api->searchRecordsByCriteria("Modelos", $criterio);

sort($modelos);
foreach ($modelos as $modelo) {
    echo '<option value="' . $modelo->getEntityId() . '">' . strtoupper($modelo->getFieldValue("Name")) . '</option>';
}
