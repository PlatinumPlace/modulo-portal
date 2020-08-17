<?php

function obtener_url() {
    $url = rtrim($_GET['url'], "/");
    return explode('/', $url);
}

function calcular_edad($fecha) {
    list($Y, $m, $d) = explode("-", $fecha);
    return (date("md") < $m . $d ? date("Y") - $Y - 1 : date("Y") - $Y);
}
