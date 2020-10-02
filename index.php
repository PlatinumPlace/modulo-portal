<?php

require "zcrm-php-sdk/vendor/autoload.php";
require 'PhpSpreadsheet/vendor/autoload.php';
include 'api.php';
include 'models/vida.php';
include 'models/auto.php';
include 'controllers/portal.php';

session_start();

$portal = new portal;

if (!isset($_SESSION["usuario"])) {
    $portal->ingresar();
    exit();
}

if (!empty($_GET["pagina"])) {
    if (method_exists($portal, $_GET["pagina"])) {
        $portal->{$_GET["pagina"]}();
    } else {
        $portal->error();
    }
} else {
    $portal->inicio();
}
