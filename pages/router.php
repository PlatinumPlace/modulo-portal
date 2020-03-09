<?php
$pagina  = (isset($_GET['page'])) ? $_GET['page'] : null;
switch ($pagina) {
    default:
        require_once("pages/pagina_principal.php");
        break;
    case 'logout':
        session_destroy();
        header("Location: index.php");
        break;
    case 'search':
        require_once("pages/buscar_cotizaciones.php");
        break;
    case 'add':
        require_once("pages/crear_cotizacion.php");
        break;
    case 'list':
        require_once("pages/lista_cotizaciones.php");
        break;
    case 'details':
        require_once("pages/detalles_cotizacion.php");
        break;
    case 'edit':
        require_once("pages/editar_cotizacion.php");
        break;
    case 'emit':
        require_once("pages/emitir_cotizacion.php");
        break;
}
