<?php
include "api/vendor/autoload.php";
include "models/api_model.php";
include "models/cotizacion_model.php";
include "models/marcas_model.php";
include "controllers/portal_controller.php";
include "controllers/login_controller.php";


//header("Location: instalador_api.php");

session_start();

if (isset($_SESSION["usuario"])) {

    $portal = new portal_controller;
    $pagina  = (isset($_GET['pagina'])) ? $_GET['pagina'] : null;

    switch ($pagina) {
        default:
            $portal->pagina_principal();
            break;
        case 'buscar':
            $portal->buscar_cotizacion();
            break;
        case 'crear':
            $portal->crear_cotizacion();
            break;
        case 'lista':
            $portal->lista_cotizaciones();
            break;
        case 'detalles':
            $portal->ver_cotizacion();
            break;
        case 'descargar':
            $portal->descargar_cotizacion();
            break;
        case 'editar':
            $portal->editar_cotizacion();
            break;
        case 'eliminar':
            $portal->eliminar_cotizacion();
            break;
        case 'emitir':
            $portal->emitir_cotizacion();
            break;
        case 'cerrar_sesion':
            $iniciar_sesion = new login_controller;
            $iniciar_sesion->cerrar_sesion();
            break;
    }
} else {
    $iniciar_sesion = new login_controller;
    $iniciar_sesion->autenticacion();
}