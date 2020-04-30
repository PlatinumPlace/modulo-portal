<?php
include "api/vendor/autoload.php";
include "config/config.php";
include "models/api.php";
include "app.php";

$app = new app;
$app->validar_api();
$app->validar_sesion();
$app->buscar_url();