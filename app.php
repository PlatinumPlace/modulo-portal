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
        if (!isset($_COOKIE["usuario"])) {
            $this->buscar_pagina("usuarios/iniciar_sesion");
            exit;
        } else {
            require_once("pages/usuarios/continuar_sesion.php");
        }
    }

    public function buscar_pagina($pagina = null)
    {
        if (isset($_GET['url'])) {

            $url = rtrim($_GET['url'], "/");
            $url = explode('/', $url);

            $header = "pages/template/header.php";
            $pagina = "pages/" . $url[0] . "/" . $url[1] . ".php";
            $footer = "pages/template/footer.php";
            $error = "pages/error.php";

            if ($url[1] == "descargar") {
                require_once($pagina);
            }else {
                require_once($header);
                if (file_exists($pagina)) {
                    require_once($pagina);
                } else {
                    require_once($error);
                }
                require_once($footer);
            }
        } else {

            if ($pagina == null) {

                require_once("pages/template/header.php");
                require_once("pages/cotizaciones/pagina_principal.php");
                require_once("pages/template/footer.php");
            } else {

                $url = rtrim($pagina, "/");
                $url = explode('/', $url);

                $pagina = "pages/" . $url[0] . "/" . $url[1] . ".php";
                if (file_exists($pagina)) {
                    require_once($pagina);
                }
            }
        }
    }
}
