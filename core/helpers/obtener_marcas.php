<?php

$api = new api;
$marcas = $api->getRecords("Marcas");
foreach ($marcas as $marca) {
    echo '<option value="' . $marca->getEntityId() . '">' . $marca->getFieldValue("Name") . '</option>';
}