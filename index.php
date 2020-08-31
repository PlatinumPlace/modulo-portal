<?php
include 'zcrm_php_sdk/api.php';
include 'helpers/libs.php';
include 'helpers/auto.php';
include 'helpers/vida.php';
include 'pages/router.php';

session_start();
define("url", "http://localhost/portal/");

$api = new api;
$router = new router;

verificar_sesion($router);
buscar_pagina($router);