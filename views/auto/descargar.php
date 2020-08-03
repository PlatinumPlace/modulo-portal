<?php

if ($cotizacion->getFieldValue("Deal_Name") == null) {
    require_once "views/auto/descargar_cotizando.php";
}else {

    $trato = $api->detalles_registro("Deals", $cotizacion->getFieldValue('Deal_Name')->getEntityId());

    $coberturas = $api->detalles_registro("Contratos", $trato->getFieldValue('Contrato')->getEntityId());
    $poliza = $api->detalles_registro("P_lizas", $trato->getFieldValue('P_liza')->getEntityId());
    $bien = $api->detalles_registro("Bienes", $trato->getFieldValue('Bien')->getEntityId());
    $cliente = $api->detalles_registro("Contacts", $trato->getFieldValue('Contact_Name')->getEntityId());
    $aseguradora = $api->detalles_registro("Vendors", $poliza->getFieldValue('Aseguradora')->getEntityId());
    $imagen_aseguradora = $api->obtener_imagen("Vendors", $aseguradora->getEntityId(), "public/img");

    require_once "views/auto/descargar_emitido.php";
}