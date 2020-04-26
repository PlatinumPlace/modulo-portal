<?php
include "api/vendor/autoload.php";
include "config/config.php";
include "libs/api.php";
include "controllers/LoginController.php";

$login = new LoginController;
$login->validar();

if (isset($_GET['url'])) {
    $url  = $_GET['url'];
    $url = explode('/', rtrim($url, '/'));
    if ($url[1] == "cerrar_sesion") {
        $login->salir();
    }
    $peticion = 'controllers/' . strtolower(ucfirst($url[0])) . 'Controller.php';
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
    include "controllers/HomeController.php";
    $home = new HomeController;
    $home->pagina_principal();
}
