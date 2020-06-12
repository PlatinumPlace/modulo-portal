<?php

$api = new api;
$portal = new portal;

$url = $portal->obtener_url();
$pagina = (!empty($url[0]) and is_numeric($url[0])) ?  $url[0] : 1 ;

if ($_POST) {
    $criterio = "((Contact_Name:equals:" .  $_SESSION["usuario"]['id'] . ") and (" . $_POST['parametro'] . ":equals:" . $_POST['busqueda'] . "))";
    $lista =  $api->searchRecordsByCriteria("Deals", $criterio, $pagina, 25);
} else {
    $criterio = "Contact_Name:equals:" . $_SESSION["usuario"]["id"];
    $lista = $api->searchRecordsByCriteria("Deals", $criterio, $pagina, 25);
}

require_once("pages/cotizaciones/buscar_vista.php");
