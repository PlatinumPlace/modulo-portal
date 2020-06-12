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

if (empty($oferta)) {
    header("Location:" . constant("url") . "portal/error");
    exit();
}

if (in_array($oferta->getFieldValue("Stage"), $emitida)) {
    $documentos_adjuntos = $api->getAttachments("Deals", $oferta_id);
}

if ($oferta->getFieldValue("Stage") == "Abandonada") {
    $alerta = 'Cotización Abandonada';
}

require_once("pages/template/header_auto.php");
require_once("pages/auto/detalles_vista.php");
