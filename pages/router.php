<?php
$pagina  = (isset($_GET['page'])) ? $_GET['page'] : null;
switch ($pagina) {
    default:
        require_once("pages/portal/pagina_principal.php");
        break;
    case 'logout':
        session_destroy();
        header("Location: index.php");
        break;
    case 'search':
        require_once("pages/portal/buscar_registros.php");
        break;
    case 'add':
        require_once("pages/portal/crear_cotizacion.php");
        break;
    case 'list':
        require_once("pages/portal/lista_registros.php");
        break;
    case 'details':
        require_once("pages/portal/detalles_cotizacion.php");
        break;
    case 'edit':
        require_once("pages/portal/editar_cotizacion.php");
        break;
    case 'emit':
        require_once("pages/portal/emitir_cotizacion.php");
        break;
    case 'download':
        require_once("pages/portal/descargar_cotizacion.php");
        break;
}
