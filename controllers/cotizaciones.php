<?php

class cotizaciones
{

    function buscar()
    {
        if ($_POST) {
            require_once 'views/cotizaciones/buscar.php';
        } else {
            require_once 'views/layout/header.php';
            require_once 'views/cotizaciones/buscar.php';
            require_once 'views/layout/footer.php';
        }
    }

    public function crear()
    {
        if (!isset($_GET["tipo"])) {
            require_once 'views/layout/header.php';
            require_once 'views/cotizaciones/crear.php';
            require_once 'views/layout/footer.php';
        } else {
            if ($_POST) {
                require_once 'views/cotizaciones/' . $_GET["tipo"] . '/crear.php';
            } else {
                require_once 'views/layout/header.php';
                require_once 'views/cotizaciones/' . $_GET["tipo"] . '/crear.php';
                require_once 'views/layout/footer.php';
            }
        }
    }

    public function detalles()
    {
        if (isset($_GET["contratoid"]) and isset($_GET["adjuntoid"])) {
            $documento = descargarAdjunto("Contratos", $_GET["contratoid"], $_GET["adjuntoid"]);
            $fileName = basename($documento);
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="' . $fileName . '"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: ');
            header('Content-Length: ' . filesize($documento));
            readfile($documento);
            unlink($documento);
            exit();
        }

        if (isset($_GET["tipo"])) {
            require_once 'views/layout/header.php';
            require_once 'views/cotizaciones/' . $_GET["tipo"] . '/detalles.php';
            require_once 'views/layout/footer.php';
        } else {
            require_once "views/portal/error.php";
            exit();
        }
    }

    public function descargar()
    {
        if (isset($_GET["tipo"])) {
            require_once 'views/cotizaciones/' . $_GET["tipo"] . '/descargar.php';
        } else {
            require_once "views/portal/error.php";
            exit();
        }
    }

    public function emitir()
    {
        if (isset($_GET["tipo"])) {
            if ($_POST) {
                require_once 'views/cotizaciones/' . $_GET["tipo"] . '/emitir.php';
            } else {
                require_once 'views/layout/header.php';
                require_once 'views/cotizaciones/' . $_GET["tipo"] . '/emitir.php';
                require_once 'views/layout/footer.php';
            }
        } else {
            require_once "views/portal/error.php";
            exit();
        }
    }
}
