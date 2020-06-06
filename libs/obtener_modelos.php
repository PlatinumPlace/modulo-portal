<?php
include dirname(__FILE__, 2) . '/api/vendor/autoload.php';
include dirname(__FILE__, 2) . '/libs/api.php';

use zcrmsdk\crm\setup\restclient\ZCRMRestClient;

$api = new api;
$api->configuration["token_persistence_path"] = dirname(__FILE__, 2) . "/api";
ZCRMRestClient::initialize($api->configuration);

$criterio = "Marca:equals:" . $_POST["marcas_id"];
$modelos = $api->searchRecordsByCriteria("Modelos", $criterio, 1);
sort($modelos);
$limite =0;
foreach ($modelos as $modelo) {
    $limite++;
    echo '<option value="' . $modelo->getEntityId() . '">' . strtoupper($modelo->getFieldValue("Name")) . '</option>';
}

if ($limite == 200) {

    $pagina = 2;

    do {
       
        $modelos = $api->searchRecordsByCriteria("Modelos", $criterio, $pagina);
        if (!empty($modelos)) {
            $pagina++;
            
            sort($modelos);
            foreach ($modelos as $modelo) {
                echo '<option value="' . $modelo->getEntityId() . '">' . strtoupper($modelo->getFieldValue("Name")) . '</option>';
            }
        }else {
            $pagina = 0;
        }
        
    } while ($pagina > 0);
}
