<?php

class app
{
    public function verificar_zoho_api()
    {
        $token = "api/zcrm_oauthtokens.txt";
        if (!file_exists($token) or filesize($token) == 0) {
            require_once("api/install.php");
            exit();
        }
    }

    public function verificar_sesion()
    {
        $pagina_login = "pages/usuarios/iniciar_sesion.php";
        if (!isset($_SESSION["usuario"])) {
            require_once($pagina_login);
            exit;
        } else {
            if (time() -  $_SESSION["usuario"]["tiempo_activo"] > 3600) {
                unset($_SESSION["usuario"]);
                require_once($pagina_login);
                exit;
            }
        }
        $_SESSION["usuario"]["tiempo_activo"] = time();
    }

    public function buscar_pagina()
    {
        $header = "pages/template/header.php";
        $footer = "pages/template/footer.php";
        $error = "pages/portal/error.php";
        $pagina_principal = "pages/portal/pagina_principal.php";

        if (isset($_GET['url'])) {

            $url = rtrim($_GET['url'], "/");
            $url = explode('/', $url);

            if (isset($url[0]) and isset($url[1])) {

                $pagina = "pages/" . $url[0] . "/" . $url[1] . ".php";

                if (isset($url[1]) and $url[1] == "descargar") {
                    require_once($pagina);
                    exit();
                }

                if (isset($url[1]) and $url[1] == "cerrar_sesion") {
                    unset($_SESSION["usuario"]);
                    $this->verificar_sesion();
                    exit();
                }

                require_once($header);
                if (file_exists($pagina)) {
                    require_once($pagina);
                } else {
                    require_once($error);
                }
                require_once($footer);
            } else {
                require_once($error);
            }
        } else {
            require_once($header);
            require_once($pagina_principal);
            require_once($footer);
        }
    }
}
