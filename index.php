<?php

include "core/controllers/HomeController.php";
include "core/models/API.php";
include "core/models/Deals.php";
include "core/models/Coberturas.php";
include "core/models/Products.php";
include "core/models/Quotes.php";



$nombre_fichero = "api/config.php";
if (!file_exists($nombre_fichero)) {
    header("Location: api/install.php");
}


$controller = new HomeController;
$page  = (isset($_GET['page'])) ? $_GET['page'] : null;

switch ($page) {
    case 'create':
        $controller->crear_cotizacion();
        break;
    case 'loading':
        $controller->pantalla_de_carga();
        break;
    case 'details':
        $controller->detalles_cotizacion();
        break;
    case 'list':
        $controller->cotizaciones_lista();
        break;
    case 'complete':
        $controller->completar_cotizacion();
        break;

    default:
        $controller->pagina_principal();
        break;
}
