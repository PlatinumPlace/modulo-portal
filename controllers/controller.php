<?php

class controller {

    function error() {
        require_once 'views/error.php';
    }

    function iniciar_sesion() {
        require_once 'views/iniciar_sesion.php';
    }

    function cerrar_sesion() {
        session_destroy();
        header("Location:" . constant("url"));
        exit();
    }

    function inicio() {
        require_once 'views/inicio.php';
    }

    function buscar() {
        require_once 'views/buscar.php';
    }

    function reportes() {
        require_once 'views/reportes.php';
    }

    function crear() {
        $url = obtener_url();
        $url[1] = (isset($url[1])) ? $url[1] : null;
        switch ($url[1]) {
            case "auto":
                require_once 'views/crear/auto.php';
                exit();
                break;

            default:
                require_once 'views/crear.php';
                break;
        }
    }

    function detalles() {
        require_once 'views/detalles.php';
    }

    function descargar() {
        $api = new api();
        $url = obtener_url();
        $id = (isset($url[1])) ? $url[1] : null;
        $cotizacion = $api->getRecord("Quotes", $id);

        if (empty($cotizacion)) {
            require_once "views/error.php";
            exit();
        }

        if (date('Y-m-d') > date("Y-m-d", strtotime($cotizacion->getFieldValue("Valid_Till")))) {
            $alerta = "Cotización Vencida.";
        }

        switch ($cotizacion->getFieldValue("Tipo")) {
            case 'Auto':
                require_once 'views/descargar/auto.php';
                break;

            default:
                require_once "views/error.php";
                break;
        }
    }

    function emitir() {
        $api = new api;
        $url = obtener_url();
        $id = (isset($url[1])) ? $url[1] : null;
        $cotizacion = $api->getRecord("Quotes", $id);

        if (empty($cotizacion) or $cotizacion->getFieldValue("Deal_Name") != null) {
            require_once "views/error.php";
            exit();
        }

        if (date('Y-m-d') > date("Y-m-d", strtotime($cotizacion->getFieldValue("Valid_Till")))) {
            header("Location:" . constant("url") . "cotizaciones/detalles/$id");
            exit();
        }

        switch ($cotizacion->getFieldValue("Tipo")) {
            case 'Auto':
                require_once "views/emitir/auto.php";
                break;

            default:
                require_once "views/error.php";
                break;
        }
    }

    function documentos() {
        $api = new api;
        $url = obtener_url();
        $id = (isset($url[1])) ? $url[1] : null;
        $cotizacion = $api->getRecord("Quotes", $id);

        if (empty($cotizacion) or $cotizacion->getFieldValue("Deal_Name") == null) {
            require_once "pages/error.php";
            exit();
        }

        if (date('Y-m-d') > date("Y-m-d", strtotime($cotizacion->getFieldValue("Valid_Till")))) {
            header("Location:" . constant("url") . "cotizaciones/detalles/$id");
            exit();
        }

        require_once 'views/documentos.php';
    }

    function adjuntar() {
        $api = new api;
        $url = obtener_url();
        $id = (isset($url[1])) ? $url[1] : null;
        $cotizacion = $api->getRecord("Quotes", $id);

        if (empty($cotizacion) or $cotizacion->getFieldValue("Deal_Name") == null) {
            require_once "views/error.php";
            exit();
        }

        if (date('Y-m-d') > date("Y-m-d", strtotime($cotizacion->getFieldValue("Valid_Till")))) {
            header("Location:" . constant("url") . "cotizaciones/detalles/$id");
            exit();
        }

        require_once 'views/adjuntar.php';
    }

}
