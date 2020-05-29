<?php

class app
{
    public $api = "api/zcrm_oauthtokens.txt";
    public $home_path = "core/controllers/cotizaciones.php";
    public $home_controller = "cotizaciones";
    public $login_path = "core/controllers/usuarios.php";
    public $login_controller = "usuarios";

    public function verificar_zoho_api()
    {
        if (!file_exists($this->api) or filesize($this->api) == 0) {
            require_once("api/install.php");
            exit();
        }
    }

    public function verificar_sesion()
    {
        require_once $this->login_path;
        $login = new $this->login_controller;

        if (!isset($_COOKIE["usuario"])) {
            $login->iniciar_sesion();
            exit;
        } else {
            $login->continuar_sesion();
        }
    }

    public function buscar_controlador()
    {
        require_once $this->home_path;
        $home = new $this->home_controller;

        if (isset($_GET['url'])) {

            $url = rtrim($_GET['url'],"/");
            $url = explode('/', $url);

            $ubicacion_controlador = "core/controllers/".$url[0].".php";

            if (file_exists($ubicacion_controlador)) {

                require_once $ubicacion_controlador;
                $controlador = new $url[0];
                
                if (isset($url[1]) and method_exists($controlador, $url[1])) {

                    if (isset($url[2])) {
                        $controlador->{$url[1]}($url[2]);
                    } else {
                        $controlador->{$url[1]}();
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
    }
}
