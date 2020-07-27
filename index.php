<?php

include 'php_sdk/vendor/autoload.php';
include 'config/config.php';
include 'config/config_api.php';
include "models/api.php";

session_start();

if (!file_exists("php_sdk/zcrm_oauthtokens.txt") or filesize("php_sdk/zcrm_oauthtokens.txt") == 0) {
    require_once 'php_sdk/token.php';
    exit();
}

if (!isset($_SESSION["usuario"])) {
    require_once "controllers/contactos.php";
    $contactos = new contactos;
    $contactos->iniciar_sesion();
    exit();
} else {
    if (time() - $_SESSION["usuario"]["tiempo_activo"] > 3600) {
        session_destroy();
        header("Location:" . constant("url"));
        exit();
    }
}
$_SESSION["usuario"]["tiempo_activo"] = time();


function obtener_url()
{
    $url = rtrim($_GET['url'], "/");
    $url =  explode('/', $url);
    $resultado = array();
    $cont = 0;
    foreach ($url as $posicion => $valor) {
        if ($posicion > 1) {
            $resultado[$cont] = $valor;
            $cont++;
        }
    }
    return $resultado;
}

if (isset($_GET['url'])) {

    $url = rtrim($_GET['url'], "/");
    $url = explode('/', $url);

    if (isset($url[0]) and isset($url[1])) {
        $ubicacion_archivo = "controllers/" . $url[0] . ".php";
        if (file_exists($ubicacion_archivo)) {
            require_once $ubicacion_archivo;
            $controlador = new $url[0];

            if (method_exists($controlador, $url[1])) {
                $controlador->{$url[1]}();
            } else {
                require_once "views/error.php";
            }
        } else {
            require_once "views/error.php";
        }
    } else {
        require_once "views/error.php";
    }
} else {
    require_once "views/layout/header_main.php";
    require_once "views/index.php";
    require_once "views/layout/footer_main.php";
}
