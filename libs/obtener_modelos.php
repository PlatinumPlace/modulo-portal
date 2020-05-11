<?php
include dirname(__FILE__, 2) . '/api/vendor/autoload.php';
include dirname(__FILE__, 2) . '/libs/api.php';

use zcrmsdk\crm\setup\restclient\ZCRMRestClient;

$api = new api;
$api->config["token_persistence_path"] = dirname(__FILE__, 2) . "/api";
ZCRMRestClient::initialize($api->config);
$criterio = "Marca:equals:" . $_POST["marcas_id"];
$modelos = $api->buscar_registro_por_criterio("Modelos", $criterio);
sort($modelos);
foreach ($modelos as $modelo) {
    echo '<option value="' . $modelo->getEntityId() . '">' . strtoupper($modelo->getFieldValue("Name")) . '</option>';
}
