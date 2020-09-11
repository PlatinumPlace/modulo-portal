<?php

require "zcrm_php_sdk/vendor/autoload.php";
include 'config/api.php';
include 'core/models/usuario.php';
include 'core/models/cotizacion.php';
include 'core/models/poliza.php';
include 'core/controllers/home.php';
include 'core/controllers/usuarios.php';
include 'core/controllers/cotizaciones.php';
include 'core/controllers/polizas.php';

session_start();
define("url", "http://localhost/portal/");

if (!isset($_SESSION["usuario"])) {
    $usuario = new usuarios();
    $usuario->ingresar();
    exit();
}

$home = new home();

if (isset($_GET["url"])) {
    $url = explode("/", $_GET["url"]);
    
    if (class_exists($url[0])) {
        $controlador = new $url[0];

        if (method_exists($controlador, $url[1])) {
            $controlador->{$url[1]}();
        } else {
            $home->error();
        }
    } else {
        $home->error();
    }
} else {
    $home->inicio();
}