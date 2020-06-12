<?php

$api = new api;
$portal = new portal;

$url = $portal->obtener_url();
$post = json_decode($url[0], true);

$titulo = "Reporte " . ucfirst($post["tipo_reporte"]) . " " . ucfirst($post["tipo_cotizacion"]);

$pagina = 1;
$criterio = "Contact_Name:equals:" .  $_SESSION["usuario"]['id'];

$prima_sumatoria = 0;
$valor_sumatoria = 0;
$comision_sumatoria = 0;
$emitida = array("Emitido", "En trámite");

require_once("pages/cotizaciones/descargar_vista.php");
