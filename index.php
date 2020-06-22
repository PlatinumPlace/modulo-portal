<?php

include "config/config.php";
include "api/vendor/autoload.php";
include "core/models/api.php";
include "core/controllers/home.php";
include "core/controllers/usuarios.php";
include "core/controllers/cotizaciones.php";
include "core/controllers/auto.php";

session_start();
$home = new home;
$cotizaciones = new cotizaciones;
$usuarios = new usuarios;


$token = "api/zcrm_oauthtokens.txt";
if (!file_exists($token) or filesize($token) == 0) {
    $home->generar_token();
    exit();
}


if (!isset($_SESSION["usuario"])) {
    $usuarios->iniciar_sesion();
    exit;
} else {
    if (time() -  $_SESSION["usuario"]["tiempo_activo"] > 3600) {
        $usuarios->cerrar_sesion();
    }
}
$_SESSION["usuario"]["tiempo_activo"] = time();


if (isset($_GET['url'])) {

    $url = rtrim($_GET['url'], "/");
    $url = explode('/', $url);

    if (isset($url[0]) and isset($url[1])) {

        $ruta = "core/controllers/" . $url[0] . ".php";
        if (!file_exists($ruta)) {
            $home->error();
            exit;
        }

        $controlador = new $url[0];
        if (method_exists($controlador, $url[1])) {
            if (isset($url[2])) {
                $controlador->{$url[1]}($url[2]);
            } else {
                $controlador->{$url[1]}();
            }
        }
    } else {
        $home->error();
    }
}else {
    $cotizaciones->index();
}
