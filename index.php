<?php

include "zoho_sdk/vendor/autoload.php";
include "config/config.php";
include "config/zoho_api.php";
include "models/usuario.php";
include "models/resumen.php";
include "models/cotizacion.php";
include "controllers/home.php";
include "controllers/usuarios.php";

session_start();

if (!file_exists("zoho_sdk/zcrm_oauthtokens.txt") or filesize("zoho_sdk/zcrm_oauthtokens.txt") == 0) {
    require_once 'views/layout/header_login.php';
    require_once 'zoho_sdk/token.php';
    require_once 'views/layout/footer_login.php';
    exit();
}


if (!isset($_SESSION["usuario"])) {
    $usuarios = new usuarios();
    $usuarios->iniciar_Sesion();
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

        $controlador = 'controllers/' . $url[0] . '.php';

        if (file_exists($controlador)) {

            include $controlador;
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
        $home->error();
    }
} else {
    $home->index();
}
