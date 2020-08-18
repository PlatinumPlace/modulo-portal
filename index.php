<?php

include 'helpers/libs.php';
include 'zoho_sdk/vendor/autoload.php';
include 'models/api.php';
include 'controllers/controller.php';

session_start();
define("url", "http://localhost/portal/");


$controlador = new controller();


if (!isset($_SESSION["usuario"])) {
    $controlador->iniciar_sesion();
    exit();
} else {
    if (time() - $_SESSION["usuario"]["tiempo_activo"] > 3600) {
        $controlador->cerrar_sesion();
    }
}
$_SESSION["usuario"]["tiempo_activo"] = time();


if (isset($_GET['url'])) {
    $url = obtener_url();
    if (method_exists($controlador, $url[0])) {
        $controlador->{$url[0]}();
    } else {
        $controlador->error();
    }
} else {
    $controlador->inicio();
}
