<?php
include "api/vendor/autoload.php";
include "core/models/api.php";


//Instalador de la api
//header("Location: api/install.php");


//Autenticacion
session_start();
if (!isset($_SESSION["usuario"])) {
    require_once("core/views/login/entrar.php");
} else {
    
    include "core/models/tratos.php";
    include "core/controllers/portal.php";

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
}
