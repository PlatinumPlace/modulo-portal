<?php
include "api/vendor/autoload.php";
include "models/api_model.php";
include "models/deals_model.php";
include "models/quotes_model.php";
include "models/products_model.php";
include "models/marcas_model.php";
include "controllers/portal_controller.php";


//Instalador de la api
header("Location: api.php");


//Autenticacion
session_start();
if (isset($_SESSION["usuario"])) {
    header("Location: login.php");
}


//Navegacion del portal
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
        unset($_SESSION['usuario']);
        header("Location: index.php");
        break;
}