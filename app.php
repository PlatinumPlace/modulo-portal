<?php

class app
{
    public function validar_api()
    {
        $token = "api/zcrm_oauthtokens.txt";
        if (filesize($token) == 0) {
            header("Location:" . constant("url") . "install.php");
            exit();
        }
    }
    public function validar_sesion()
    {
        session_start();
        $_SESSION["usuario_id"] = (isset($_COOKIE["usuario_id"])) ? $_COOKIE["usuario_id"] : "";
        if (empty($_SESSION["usuario_id"])) {
            include "controllers/LoginController.php";
            $login = new LoginController;
            $login->iniciar_sesion();
            exit();
        } else {
            if (time() - $_SESSION['tiempo'] > 3600) {
                include "controllers/LoginController.php";
                $login = new LoginController;
                $login->cerrar_sesion();
            } else {
                $_SESSION['tiempo'] = time();
            }
        }
    }
    public function buscar_url()
    {
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
    }
}
