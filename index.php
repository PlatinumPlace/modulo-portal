<?php

require "sdk/vendor/autoload.php";
include 'api.php';
include 'helpers/libs.php';
include 'controllers/portal.php';
include 'controllers/cotizaciones.php';
include 'controllers/emisiones.php';

session_start();
define("url", "http://localhost/it/");

$api = new api;
$portal = new portal;

if (!isset($_SESSION["usuario"])) {
    $portal->ingresar();
    exit();
}

if (!empty($_GET["path"])) {
    $url = explode("/", $_GET["path"]);

    if (class_exists($url[0])) {
        $controlador = new $url[0];
        if (method_exists($controlador, $url[1])) {
            $controlador->{$url[1]}();
        } else {
            $portal->error();
        }
    } else {
        $portal->error();
    }
} else {
    $portal->inicio();
}
