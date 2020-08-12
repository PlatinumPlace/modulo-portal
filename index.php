<?php

include 'php_sdk/vendor/autoload.php';
include 'config/config.php';
include 'config/api.php';
include "helpers/libreria.php";

verificar_token();

$api = new api;
verificar_sesion();
buscar_controlador();