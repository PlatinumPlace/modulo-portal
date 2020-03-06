<?php
include "api/vendor/autoload.php";
include "helpers/api.php";
include "helpers/tratos.php";
include 'helpers/verificar_usuario.php';
//header("Location: api/install.php");
session_start();
if (!$_SESSION["usuario"]) {
    require_once("pages/login.php");
} else {
    if (isset($_GET['page']) and $_GET['page'] == "download") {
        require_once("pages/portal/descargar_cotizacion.php");
    } else {
        require_once("pages/template.php");
    }
}