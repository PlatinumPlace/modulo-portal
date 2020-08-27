<?php

function obtener_url()
{
    $url = array();
    if (isset($_GET['url'])) {
        $url = rtrim($_GET['url'], "/");
        $url = explode('/', $url);
    }
    return $url;
}

function calcular_edad($fecha)
{
    list($Y, $m, $d) = explode("-", $fecha);
    return (date("md") < $m . $d ? date("Y") - $Y - 1 : date("Y") - $Y);
}

function verificar_sesion()
{
    $portal = new portal;

    if (!isset($_SESSION["usuario"])) {
        $portal->iniciar_sesion();
        exit();
    } else {
        if (time() - $_SESSION["usuario"]["tiempo_activo"] > 3600) {
            $portal->cerrar_sesion();
        }
    }
    $_SESSION["usuario"]["tiempo_activo"] = time();
}

function buscar_pagina()
{
    $portal = new portal;

    if (isset($_GET['url'])) {
        $url = obtener_url();
        $funcion = (isset($url[0])) ? $url[0] : null;

        if (method_exists($portal, $funcion)) {
            $portal->{$url[0]}();
        } else {
            $portal->error();
        }
    } else {
        $portal->inicio();
    }
}
