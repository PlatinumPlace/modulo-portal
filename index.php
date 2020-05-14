<?php

include "config/config.php";
include "zoho_api/vendor/autoload.php";
include "libs/zoho_api.php";
include "models/usuario.php";
include "models/cotizacion.php";
include "models/auto.php";
include "models/cliente.php";
include "models/aseguradora.php";
include "models/contrato.php";
include "app.php";

$app = new app;
$app->verificar_zoho_api();
$app->verificar_sesion();
$app->buscar_controlador();