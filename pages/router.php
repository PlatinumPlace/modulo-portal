<?php
include "api/vendor/autoload.php";
include "helpers/api.php";

//header("Location: api/install.php");

if (!isset($_SESSION["usuario"])) {
    require_once("pages/login/entrar.php");
} else {
    include "helpers/tratos.php";
    $pagina  = (isset($_GET['page'])) ? $_GET['page'] : null;
    switch ($pagina) {
        default:
            require_once("pages/portal/pagina_principal.php");
            break;
        case 'logout':
            unset($_SESSION['usuario']);
            header("Location: index.php");
            break;
        case 'search':
            require_once("pages/cotizaciones/buscar.php");
            break;
        case 'add':
            require_once("pages/cotizaciones/crear.php");
            break;
        case 'list':
            require_once("pages/cotizaciones/lista.php");
            break;
        case 'details':
            require_once("pages/cotizaciones/detalles.php");
            break;
        case 'edit':
            require_once("pages/cotizaciones/editar.php");
            break;
        case 'emit':
            require_once("pages/cotizaciones/emitir.php");
            break;
        case 'download':
            require_once("pages/cotizaciones/descargar.php");
            break;
    }
}
