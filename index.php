<?php
include "api/vendor/autoload.php";
include "helpers/api.php";


//header("Location: api/install.php");
session_start();
if (!isset($_SESSION["usuario"])) {
    require_once("pages/login.php");
} else {
    if (isset($_GET['page']) and $_GET['page'] == "download") {
        require_once("pages/descargar_cotizacion.php");
    } else {
        require_once("pages/template.php");
    }
}