<?php

// incluye las clases del api
// teniendo en cuenta que,cuando se haga refencia con ajax,
// tomara este .php en la pocision donde esta en el porta
// asi que, para hacer refencia, se busca las clases con dos ubicaciones atras 
// en la ruta donde estamos ahora
include dirname(__FILE__, 2) . '/api/vendor/autoload.php';
include dirname(__FILE__, 2) . '/libs/api.php';

use zcrmsdk\crm\setup\restclient\ZCRMRestClient;

$api = new api;
// al inicializar la api, require la ubicacion del token que,como acedemos a el
// desde otra ubicacion, lo volvemos a indicar
$api->configuration["token_persistence_path"] = dirname(__FILE__, 2) . "/api";
ZCRMRestClient::initialize($api->configuration);
// buscamos en los registros del modulo segun el id
$criterio = "Marca:equals:" . $_POST["marcas_id"];
$modelos = $api->searchRecordsByCriteria("Modelos", $criterio);
// imprimimos en bucle elementos de un select html
foreach ($modelos as $modelo) {
    echo '<option value="' . $modelo->getEntityId() . '">' . $modelo->getFieldValue("Name") . '</option>';
}
