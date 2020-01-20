<?php

include "core/controllers/HomeController.php";
include "core/models/API.php";
include "api/config.php";

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
    case 'buscar_cotizaciones':
        $controller->buscar_cotizaciones();
        break;
    case 'lista_cotizaciones':
        $controller->lista_cotizaciones();
        break;
    case 'crear_cotizacion':
        $controller->crear_cotizacion();
        break;
    case 'ver_cotizacion':
        $controller->ver_cotizacion();
        break;
    case 'descargar_cotizacion':
        $controller->descargar_cotizacion();
        break;
    case 'editar_cotizacion':
        $controller->editar_cotizacion();
        break;
}
