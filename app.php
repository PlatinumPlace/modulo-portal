<?php

class app
{
    public $api = "api/zcrm_oauthtokens.txt";
    public $home = "core/controllers/HomeController.php";
    public $login = "core/controllers/LoginController.php";

    public function verificar_zoho_api()
    {
        if (!file_exists($this->api) or filesize($this->api) == 0) {
            require_once("api/install.php");
            exit();
        }
    }

    public function verificar_sesion()
    {
        require_once $this->login;
        $login = new LoginController;

        if (!isset($_COOKIE["usuario"])) {
            $login->iniciar_sesion();
            exit;
        }
        else {
            $login->continuar_sesion();
        }
    }

    public function buscar_controlador()
    {
        require_once $this->home;
        $home = new HomeController;

        if (isset($_GET['url'])) {

            $url = explode('/', $_GET['url']);

            $peticion = "core/controllers/" . ucfirst($url[0]) . "Controller.php";

            if (file_exists($peticion)) {

                require_once $peticion;

                $claseControlador = ucfirst($url[0]) . "Controller";
                $controlador =  new $claseControlador;

                if (method_exists($controlador, $url[1])) {

                    if (isset($url[2])) {
                        $controlador->{$url[1]}($url[2]);
                    }else {
                        $controlador->{$url[1]}();
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
