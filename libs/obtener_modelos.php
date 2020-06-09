<?php
include dirname(__FILE__, 2) . '/api/vendor/autoload.php';
include dirname(__FILE__, 2) . '/libs/api.php';

use zcrmsdk\crm\setup\restclient\ZCRMRestClient;

$api = new api;
$api->configuration["token_persistence_path"] = dirname(__FILE__, 2) . "/api";
ZCRMRestClient::initialize($api->configuration);
$pagina = 1;
$criterio = "Marca:equals:" . $_POST["marcas_id"];
do {
    $modelos = $api->searchRecordsByCriteria("Modelos", $criterio, $pagina, 200);
    if ($modelos) {
        $pagina++;
        sort($modelos);
        foreach ($modelos as $modelo) {
            echo '<option value="' . $modelo->getEntityId() . '">' . strtoupper($modelo->getFieldValue("Name")) . '</option>';
        }
    } else {
        $pagina = 0;
    }
} while ($pagina > 0);