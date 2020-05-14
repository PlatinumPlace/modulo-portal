<?php

class app
{
    public $home = "controllers/HomeController.php";
    public $login = "controllers/UsuariosController.php";

    public function verificar_zoho_api()
    {
        if (filesize("zoho_api/zcrm_oauthtokens.txt") == 0) {

            require_once("zoho_api/install.php");
            exit();
        }
    }

    public function verificar_sesion()
    {
        require_once $this->login;
        $login = new UsuariosController;

        session_start();
        $_SESSION["usuario_id"] = (isset($_COOKIE["usuario_id"])) ? $_COOKIE["usuario_id"] : "";
        $_SESSION["tiempo"] = (isset($_COOKIE["tiempo"])) ? $_COOKIE["tiempo"] : "";

        if (empty($_SESSION["usuario_id"])) {
            $login->index();
            exit;
        } else {
            if (time() -   $_SESSION['tiempo'] > 3600) {
                $login->cerrar_sesion();
                exit;
            } else {
                $_SESSION['tiempo'] = time();
            }
        }
    }

    public function buscar_controlador()
    {
        require_once $this->home;
        $home = new HomeController;

        if (!empty($_GET['url'])) {

            $url = explode('/', rtrim($_GET['url'], '/'));

            $peticion = "controllers/" . ucfirst($url[0]) . "Controller.php";

            if (file_exists($peticion)) {

                require_once $peticion;
                $claseControlador = ucfirst($url[0]) . "Controller";
                $controlador =  new $claseControlador;
                $funcion = (isset($url[1])) ? $url[1] : "";
                $valor = (isset($url[2])) ? $url[2] : "";

                if (method_exists($controlador, $funcion)) {

                    if (!empty($valor)) {
                        $controlador->{$funcion}($valor);
                    } else {
                        $controlador->{$funcion}();
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
    }
}
