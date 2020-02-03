<?php

include "api/config.php";
include "obj/portal.php";
include "obj/iniciar_sesion.php";
include "lib/api.php";
include "lib/autenticar.php";
include "lib/cotizaciones.php";

$config_api = "api/config.php";
if (!file_exists($config_api)) {
    header("Location: api/install.php");
}

session_start();

if (isset($_SESSION["usuario"])) {

    $portal = new portal;
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
            $iniciar_sesion = new iniciar_sesion;
            $iniciar_sesion->cerrar_sesion();
            break;
    }
} else {
    $iniciar_sesion = new iniciar_sesion;
    $iniciar_sesion->verificar_usuario();
}
