<?php

include "config/config.php";
include "api/vendor/autoload.php";
include "libs/api.php";


$api = new api;

$header = "pages/template/header.php";
$footer = "pages/template/footer.php";
$error = "pages/home/error.php";
$pagina_principal = "pages/home/pagina_principal.php";



if (filesize("api/zcrm_oauthtokens.txt") == 0) {

    header("Location:" . constant("url") . "install.php");
    exit();
}



session_start();
$_SESSION["usuario_id"] = (isset($_COOKIE["usuario_id"])) ? $_COOKIE["usuario_id"] : "";

if (empty($_SESSION["usuario_id"])) {

    require_once("pages/login/iniciar_sesion.php");
    exit();
} else {

    if (time() -   $_SESSION['tiempo'] > 3600) {

        require_once("pages/login/cerrar_sesion.php");
        exit();
    } else {

        $_SESSION['tiempo'] = time();
    }
}



if (!empty($_GET['url'])) {

    $url = explode('/', rtrim($_GET['url'], '/'));

    $peticion = "pages/$url[0]/$url[1].php";

    $datos  = (isset($url[2])) ? $url[2] : "";

    if (file_exists($peticion)) {

        if ($url[1] == "descargar_auto") {

            require_once $peticion;
            exit;
        }

        require_once $header;
        require_once $peticion;
        require_once $footer;
    } else {
        require_once $header;
        require_once $error;
        require_once $footer;
    }
} else {
    require_once $header;
    require_once $pagina_principal;
    require_once $footer;
}
