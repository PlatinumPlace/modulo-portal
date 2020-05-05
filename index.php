<?php
include "config/config.php";
include "zoho_api/vendor/autoload.php";
include "models/zoho_api.php";
include "models/usuario.php";
include "models/cotizacion.php";
include "models/reporte.php";
include "controllers/LoginController.php";
include "controllers/HomeController.php";

$usuario = new LoginController;
$home = new HomeController;

$zoho_api = "zoho_api/zcrm_oauthtokens.txt";
if (filesize($zoho_api) == 0) {
    header("Location:" . constant("url") . "install.php");
    exit();
}

session_start();
$_SESSION["usuario_id"] = (isset($_COOKIE["usuario_id"])) ? $_COOKIE["usuario_id"] : "";
if (empty($_SESSION["usuario_id"])) {
    $usuario->iniciar_sesion();
    exit();
} else {
    if (time() - $_SESSION['tiempo'] > 3600) {
        $usuario->cerrar_sesion();
    } else {
        $_SESSION['tiempo'] = time();
    }
}

if (isset($_GET['url'])) {
    $url  = $_GET['url'];
    $url = explode('/', rtrim($url, '/'));
    $peticion = 'controllers/' . ucfirst($url[0]) . 'Controller.php';
    if (file_exists($peticion)) {
        require_once $peticion;
        $controlador = ucfirst($url[0]) . "Controller";
        $portal = new $controlador;
        if (isset($url[1]) and method_exists($controlador, $url[1])) {
            if (!empty($url[2])) {
                $portal->{$url[1]}($url[2]);
            } else {
                $portal->{$url[1]}();
            }
        } else {
            $home->error();
        }
    } else {
        $home->error();
    }
} else {
    $home->pagina_principal();
}
