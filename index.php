<?php

include "includes.php";

session_start();
define("url", "http://localhost/portal/");

$api = new api;

verificar_sesion();
buscar_pagina();
