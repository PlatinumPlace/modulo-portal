<?php

$api = new api;
$portal = new portal;

$url = $portal->obtener_url();
$oferta_id = $url[0];
$alerta  = (isset($url[1])) ? $url[1] : "";

$oferta = $api->getRecord("Deals", $oferta_id);
$criterio = "Deal_Name:equals:$oferta_id";
$cotizaciones =  $api->searchRecordsByCriteria("Quotes", $criterio, 1, 200);

$emitida = array("Emitido", "En trámite");
$ruta = "public/img";

if (
    $oferta->getFieldValue('Email') == null
    or
    empty($oferta)
    or
    empty($cotizaciones)
    or
    $oferta->getFieldValue('Stage') == "Abandonado"
) {
    header("Location:" . constant("url") . "portal/error");
    exit();
}

if (in_array($oferta->getFieldValue("Stage"), $emitida)) {

    foreach ($cotizaciones  as $cotizacion) {
        $poliza = $cotizacion->getFieldValue('P_liza')->getLookupLabel();
        $coberturas = $api->getRecord("Contratos", $cotizacion->getFieldValue('Contrato')->getEntityId());
    }

    if (!is_dir($ruta)) {
        mkdir($ruta, 0755, true);
    }

    $imagen_aseguradora =  $api->downloadPhoto("Vendors", $oferta->getFieldValue("Aseguradora")->getEntityId(), "$ruta/");
}

require_once("pages/auto/descargar_vista.php");
