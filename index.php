<?php

include "config/config.php";
include "api/vendor/autoload.php";
include "libs/api.php";
include "app.php";

$app = new app;
$app->verificar_zoho_api();
$app->verificar_sesion();
$app->buscar_pagina();