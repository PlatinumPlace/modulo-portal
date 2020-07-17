<?php
include 'php_sdk/vendor/autoload.php';
include 'config/config.php';
include 'config/api.php';
include 'helpers/usuarios.php';
include 'helpers/cotizaciones.php';

function obtener_url()
{
    $url = rtrim($_GET['url'], "/");
    $url =  explode('/', $url);
    $resultado = array();
    $cont = 0;
    foreach ($url as $posicion => $valor) {
        if ($posicion > 1) {
            $resultado[$cont] = $valor;
            $cont++;
        }
    }
    return $resultado;
}

if (!file_exists("php_sdk/zcrm_oauthtokens.txt") or filesize("php_sdk/zcrm_oauthtokens.txt") == 0) {
    require_once 'php_sdk/token.php';
    exit();
}

session_start();
if (!isset($_SESSION["usuario"])) {
    require_once 'pages/login/iniciar_sesion.php';
    exit();
} else {
    if (time() - $_SESSION["usuario"]["tiempo_activo"] > 3600) {
        session_destroy();
        header("Location:" . constant("url"));
        exit();
    }
}
$_SESSION["usuario"]["tiempo_activo"] = time();

if (isset($_GET['url'])) {

    $url = rtrim($_GET['url'], "/");
    $url = explode('/', $url);

    if (isset($url[0]) and isset($url[1])) {

        if ($url[1] == "cerrar_sesion") {
            session_destroy();
            header("Location:" . constant("url"));
            exit();
        }
        $pagina = "pages/" . $url[0] . "/" . $url[1] . ".php";

        if (file_exists($pagina)) {
            require_once $pagina;
        } else {
            require_once 'pages/error.php';
        }
    } else {
        require_once 'pages/error.php';
    }
} else {
    require_once 'pages/index.php';
}
