<?php

$portal = new portal;
$api = new api;

$criterio = "Contact_Name:equals:" . $_SESSION["usuario"]["id"];
$lista = $api->searchRecordsByCriteria("Deals", $criterio, 1, 200);

$url = $portal->obtener_url();
$tipo = $url[0];
$emitida = array("Emitido", "En trámite");

require_once("pages/cotizaciones/lista_vista.php");
