<?php
include "api/vendor/autoload.php";
include "helpers/api.php";

//header("Location: api/install.php");
if (!isset($_COOKIE["usuario_id"])) {
    require_once("pages/login.php");
} else {
    $pagina  = (isset($_GET['page'])) ? $_GET['page'] : null;
    switch ($pagina) {
        default:
            require_once("template/header.php");
            require_once("pages/pagina_principal.php");
            require_once("template/footer.php");
            break;
        case 'load':
            require_once("template/header.php");
            require_once("pages/pagina_carga.php");
            require_once("template/footer.php");
            break;
        case 'download_auto':
            require_once("pages/descargar_cotizacion_auto.php");
            break;
        case 'logout':
            setcookie("usuario_id", "", time() - 1);
            header("Location: index.php");
            break;
        case 'search':
            require_once("template/header.php");
            require_once("pages/buscar_cotizaciones.php");
            require_once("template/footer.php");
            break;
        case 'add_auto':
            require_once("template/header.php");
            require_once("pages/crear_cotizacion_auto.php");
            require_once("template/footer.php");
            break;
        case 'list':
            require_once("template/header.php");
            require_once("pages/lista_cotizaciones.php");
            require_once("template/footer.php");
            break;
        case 'details_auto':
            require_once("template/header.php");
            require_once("pages/detalles_cotizacion_auto.php");
            require_once("template/footer.php");
            break;
        case 'complete_auto':
            require_once("template/header.php");
            require_once("pages/completar_cotizacion_auto.php");
            require_once("template/footer.php");
            break;
        case 'emit':
            require_once("template/header.php");
            require_once("pages/emitir_cotizacion.php");
            require_once("template/footer.php");
            break;
    }
}
