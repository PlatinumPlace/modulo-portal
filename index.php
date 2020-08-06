<?php

include 'php_sdk/vendor/autoload.php';
include 'config/config.php';
include 'config/config_api.php';
include "models/api.php";
include "helpers/libreria.php";

verificar_token();
verificar_sesion();
buscar_controlador();