<?php
include "api/vendor/autoload.php";
include "config/config.php";
include "libs/api.php";

session_start();
if (!isset($_SESSION["usuario_id"])) {
    require_once("controllers/login.php");
    $controlador = new LoginController;
    $controlador->iniciar_sesion();
    exit();
}
if (time() - $_SESSION['tiempo'] > 3600) {
    require_once("controllers/login.php");
    $controlador = new LoginController;
    $controlador->cerarr_sesion();
    exit();
}
$_SESSION['tiempo'] = time();
if (isset($_GET['url'])) {
    $url  = $_GET['url'];
    $url = explode('/', rtrim($url, '/'));
    if ($url[1] == "cerrar_sesion") {
        require_once("controllers/login.php");
        $controlador = new LoginController;
        $controlador->cerarr_sesion();
        exit();
    }
    $peticion = 'controllers/' . strtolower($url[0]) . '.php';
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
            require_once("views/header.php");
            require_once("views/error.php");
            require_once("views/footer.php");
            exit();
        }
    } else {
        require_once("views/header.php");
        require_once("views/error.php");
        require_once("views/footer.php");
    }
} else {
    require_once("controllers/home.php");
    $controlador = new HomeController;
    $controlador->index();
}
