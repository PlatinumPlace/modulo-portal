<?php
include 'php_sdk/vendor/autoload.php';
include 'config/config.php';
include 'config/config_api.php';
include "core/models/api.php";
include "core/controllers/home.php";

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

if (!file_exists("php_sdk/zcrm_oauthtokens.txt") or filesize("php_sdk/zcrm_oauthtokens.txt") == 0) {
    require_once 'php_sdk/token.php';
    exit();
}

session_start();
if (!isset($_SESSION["usuario"])) {
    require_once "core/controllers/contactos.php";
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

$home = new home;
if (isset($_GET['url'])) {

    $url = rtrim($_GET['url'], "/");
    $url = explode('/', $url);

    if (isset($url[0]) and isset($url[1])) {
        $ubicacion_archivo = "core/controllers/" . $url[0] . ".php";
        if (file_exists($ubicacion_archivo)) {
            require_once $ubicacion_archivo;
            $controlador = new $url[0];

            if (method_exists($controlador, $url[1])) {
                $controlador->{$url[1]}();
            } else {
                $home->error();
                exit();
            }
        } else {
            $home->error();
            exit();
        }
    } else {
        $home->error();
        exit();
    }
} else {
    $home->index();
    exit();
}
