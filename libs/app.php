<?php
require_once "controllers/error.php";
require_once "controllers/login.php";
class App
{
    function __construct()
    {
        $url = (isset($_GET['url'])) ? $_GET['url'] : null;
        $url = rtrim($url, '/');
        $url = explode('/', $url);
        session_start();
        $sesion = new Login;
        if (isset($_SESSION['tiempo'])) {
            $sesion->validar_tiempo();
        }
        if (!isset($_SESSION['usuario'])) {
            $sesion->iniciar_sesion();
            return false;
        }
        if (empty($url[0])) {
            require_once "controllers/home.php";
            $controlador = new Home;
            return false;
        }
        $peticion = 'controllers/' . $url[0] . '.php';
        if (file_exists($peticion)) {
            require_once $peticion;
            $controlador = new $url[0];
            if (isset($url[1]) and method_exists($url[0], $url[1])) {
                if (isset($url[2])) {
                    $controlador->{$url[1]}($url[2]);
                } else {
                    $controlador->{$url[1]}();
                }
            }
        } else {
            $controlador = new Desvio;
        }
    }
}
