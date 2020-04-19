<?php

include "api/vendor/autoload.php";
include "config/config.php";
include "libs/api.php";
include "app.php";

$app = new app;
// reanuda o inicia las sesiones dentro del portal
// verifica no existe un usuario,
// si no existe,redirige al controlador login para iniciar sesion y se detiene la ejecucion
// si existe,continua
session_start();
if (!isset($_SESSION['usuario'])) {
    $app->iniciar_sesion();
}else {
    $app->validar_sesion();
    $app->portal();
}
