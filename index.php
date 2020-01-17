<?php

include "core/controllers/HomeController.php";
include "core/models/API.php";

$nombre_fichero = "api/config.php";
if (!file_exists($nombre_fichero)) {
    header("Location: api/install.php");
}


$controller = new HomeController;
$pagina  = (isset($_GET['pagina'])) ? $_GET['pagina'] : null;

switch ($pagina) {
    default:
        $controller->pagina_principal();
        break;
    case 'lista':
        $controller->lista();
        break;
    case 'crear_cotizacion':
        $controller->crear_cotizacion();
        break;
    case 'detalles_cotizacion':
        $controller->detalles_cotizacion();
        break;
    case 'complete':
        $controller->completar_cotizacion();
        break;
    case 'download_1':
        $controller->descargar_cotizacion();
        break;
    case 'download_2':
        $controller->descargar_poliza();
        break;
}
