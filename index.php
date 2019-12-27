<?php

include "core/controllers/HomeController.php";
include "core/controllers/CotizacionController.php";
include "core/models/ZohoAPI.php";
include "core/models/Deals.php";
include "core/models/Products.php";
include "core/models/Quotes.php";

if (isset($_GET['page'])) {
    switch ($_GET['page']) {
        case 'cotizacion_auto':
            $controller = new CotizacionController;
            call_user_func(array($controller, "crear_auto"));
            break;
        case 'cotizacion_lista':
            $controller = new CotizacionController;
            call_user_func(array($controller, "lista"));
            break;
        case 'cotizacion_detalles':
            $controller = new CotizacionController;
            call_user_func(array($controller, "detalles"));
            break;
        case 'cotizacion_emitir_poliza':
            $controller = new CotizacionController;
            call_user_func(array($controller, "emitir_poliza"));
            break;
            case 'alerta':
                $controller = new HomeController;
                call_user_func(array($controller, "alerta"));
                break;
    }
} else {
    $controller = new HomeController;
    call_user_func(array($controller, "pagina_principal"));
}