<?php
require "zcrm_php_sdk/vendor/autoload.php";
require "config/api.php";
include "config/config.php";
include "core/models/usuario.php";
include "core/models/cotizacion.php";
include "core/models/trato.php";
include "core/controllers/usuarios.php";
include "core/controllers/cotizaciones.php";
include "core/controllers/polizas.php";
include "core/controllers/auto.php";

$usuarios = new usuarios;
$cotizaciones = new cotizaciones;

if (!isset($_SESSION["usuario"])) {
    $usuarios->ingresar();
    exit();
} else {
    if (time() - $_SESSION["usuario"]["tiempo_activo"] > 3600) {
        $usuarios->salir();
    }
}
$_SESSION["usuario"]["tiempo_activo"] = time();

if (isset($_GET["url"])) {
    $url = explode("/", $_GET["url"]);
    if (class_exists($url[0])) {
        $controlador = new $url[0];
        if (method_exists($controlador, $url[1])) {
            $controlador->{$url[1]}();
        } else {
            require_once "error.php";
        }
    } else {
        require_once "error.php";
    }
} else {
    $cotizaciones->inicio();
}
