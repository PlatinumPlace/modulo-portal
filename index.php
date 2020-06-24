<?php

include "config/config.php";
include "api/vendor/autoload.php";
include "core/models/api.php";
include "core/controllers/usuarios.php";
include "core/controllers/cotizaciones.php";
include "core/controllers/auto.php";

use zcrmsdk\oauth\ZohoOAuth;
use zcrmsdk\crm\setup\restclient\ZCRMRestClient;

function verificar_token()
{
    $token = "api/zcrm_oauthtokens.txt";
    if (!file_exists($token) or filesize($token) == 0) {

        if ($_POST) {

            $api = new api;
            ZCRMRestClient::initialize($api->configuration);

            $oAuthClient = ZohoOAuth::getClientInstance();
            $grantToken = $_POST['grant_token'];
            $oAuthTokens = $oAuthClient->generateAccessToken($grantToken);
        }

        require_once("core/views/layout/header_login.php");
        require_once("core/views/token.php");
        require_once("core/views/layout/footer_login.php");

        exit();
    }
}

function verificar_sesion()
{
    $usuarios = new usuarios;

    if (!isset($_SESSION["usuario"])) {
        $usuarios->iniciar_sesion();
        exit;
    } else {
        if (time() -  $_SESSION["usuario"]["tiempo_activo"] > 3600) {
            $usuarios->cerrar_sesion();
        }
    }
    $_SESSION["usuario"]["tiempo_activo"] = time();
}

function buscar_controlador()
{
    $cotizaciones = new cotizaciones;

    if (isset($_GET['url'])) {

        $url = rtrim($_GET['url'], "/");
        $url = explode('/', $url);

        if (isset($url[0]) and isset($url[1])) {

            $ruta = "core/controllers/" . $url[0] . ".php";
            if (!file_exists($ruta)) {
                $cotizaciones->error();
                exit;
            }

            $controlador = new $url[0];
            if (method_exists($controlador, $url[1])) {
                if (isset($url[2])) {
                    $controlador->{$url[1]}($url[2]);
                } else {
                    $controlador->{$url[1]}();
                }
            }
        } else {
            $cotizaciones->error();
        }
    } else {
        $cotizaciones->index();
    }
}

session_start();
verificar_token();
verificar_sesion();
buscar_controlador();