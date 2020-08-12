<?php

function obtener_url()
{
    $url = rtrim($_GET['url'], "/");
    $url = explode('/', $url);

    $result = array();

    foreach ($url as $posicion => $valor) {
        if ($posicion > 1) {
            $result[] = $valor;
        }
    }

    return $result;
}

function calcular_edad($fecha)
{
    list($Y, $m, $d) = explode("-", $fecha);
    return (date("md") < $m . $d ? date("Y") - $Y - 1 : date("Y") - $Y);
}

function verificar_token()
{
    if (!file_exists("php_sdk/zcrm_oauthtokens.txt") or filesize("php_sdk/zcrm_oauthtokens.txt") == 0) {
        require_once 'php_sdk/token.php';
        exit();
    }
}

function verificar_sesion()
{
    session_start();

    if (!isset($_SESSION["usuario"])) {
        require_once "controllers/contactos.php";
        $contactos = new contactos;
        $contactos->index();
        exit();
    } else {
        if (time() - $_SESSION["usuario"]["tiempo_activo"] > 3600) {
            session_destroy();
            header("Location:" . constant("url"));
            exit();
        }
    }
    $_SESSION["usuario"]["tiempo_activo"] = time();
}

function buscar_controlador()
{
    include "controllers/cotizaciones.php";
    $cotizaciones = new cotizaciones;

    if (isset($_GET['url'])) {

        $url = rtrim($_GET['url'], "/");
        $url = explode('/', $url);

        if (isset($url[0]) and isset($url[1])) {
            $ubicacion_archivo = "controllers/" . $url[0] . ".php";
            if (file_exists($ubicacion_archivo)) {
                require_once $ubicacion_archivo;
                $controlador = new $url[0];

                if (method_exists($controlador, $url[1])) {
                    $controlador->{$url[1]}();
                } else {
                    require_once "views/error.php";
                }
            } else {
                require_once "views/error.php";
            }
        } else {
            require_once "views/error.php";
        }
    } else {
        $cotizaciones->index();
    }
}
