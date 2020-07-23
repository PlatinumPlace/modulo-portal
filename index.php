<?php

include 'php_sdk/vendor/autoload.php';
include 'config/config.php';
include 'config/config_api.php';
include "models/api.php";
include "controllers/home.php";

session_start();

$home = new home;

$home->verificar_token();
$home->verificar_sesion();
$home->buscar_pagina();
