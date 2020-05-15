<?php

include "config/urls.php";
include "api/vendor/autoload.php";
include "libs/api.php";
include "core/models/usuario.php";
include "core/models/cotizacion.php";
include "core/models/bien.php";
include "core/models/cliente.php";
include "core/models/aseguradora.php";
include "core/models/contrato.php";
include "app.php";

$app = new app;
$app->verificar_zoho_api();
$app->verificar_sesion();
$app->buscar_controlador();