<?php

include "core/controllers/HomeController.php";
include "core/models/API.php";
include "core/models/Deals.php";
//include "core/models/Products.php";
//include "core/models/Quotes.php";

$controller = new HomeController;
$page  = (isset($_GET['page'])) ? $_GET['page'] : null;

switch ($page) {
    case 'create':
        $controller->crear_cotizacion();
        break;

    default:
        $controller->pagina_principal();
        break;
}
