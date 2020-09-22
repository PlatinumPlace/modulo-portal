<?php

class controller
{
    public function error()
    {
        require_once 'pages/error.php';
    }

    public function ingresar()
    {
        require_once 'pages/iniciar_sesion.php';
    }

    public function salir()
    {
        session_destroy();
        header("Location:index.php");
        exit();
    }

    public function inicio()
    {
        require_once 'pages/layout/header.php';
        require_once 'pages/inicio.php';
        require_once 'pages/layout/footer.php';
    }

    public function buscar()
    {
        require_once 'pages/layout/header.php';
        require_once 'pages/buscar.php';
        require_once 'pages/layout/footer.php';
    }

    public function crear()
    {
        require_once 'pages/layout/header.php';
        require_once 'pages/crear.php';
        require_once 'pages/layout/footer.php';
    }

    public function crearAuto()
    {
        if ($_POST) {
            require_once 'pages/auto/crear.php';
        } else {
            require_once 'pages/layout/header.php';
            require_once 'pages/auto/crear.php';
            require_once 'pages/layout/footer.php';
        }
    }

    public function detallesAuto()
    {
        if (isset($_GET["attachment_id"])) {
            $api = new api;
            $documento = $api->descargarAdjunto("Contratos", $_GET["contrato_id"], $_GET["attachment_id"]);
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

        require_once 'pages/layout/header.php';
        require_once 'pages/auto/detalles.php';
        require_once 'pages/layout/footer.php';
    }

    public function descargarCotizacionAuto()
    {
        require_once 'pages/auto/cotizacion.php';
    }

    public function emitirAuto()
    {
        if ($_POST) {
            require_once 'pages/auto/emitir.php';
        } else {
            require_once 'pages/layout/header.php';
            require_once 'pages/auto/emitir.php';
            require_once 'pages/layout/footer.php';
        }
    }

    public function descargarEmisionAuto()
    {
        require_once 'pages/auto/emision.php';
    }

    public function adjuntar()
    {
        if ($_POST) {
            require_once 'pages/adjuntar.php';
        } else {
            require_once 'pages/layout/header.php';
            require_once 'pages/adjuntar.php';
            require_once 'pages/layout/footer.php';
        }
    }

    public function crearVida()
    {
        if ($_POST) {
            require_once 'pages/vida/crear.php';
        } else {
            require_once 'pages/layout/header.php';
            require_once 'pages/vida/crear.php';
            require_once 'pages/layout/footer.php';
        }
    }

    public function detallesVida()
    {
        if (isset($_GET["attachment_id"])) {
            $api = new api;
            $documento = $api->descargarAdjunto("Contratos", $_GET["contrato_id"], $_GET["attachment_id"]);
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

        require_once 'pages/layout/header.php';
        require_once 'pages/vida/detalles.php';
        require_once 'pages/layout/footer.php';
    }

    public function descargarCotizacionVida()
    {
        require_once 'pages/vida/cotizacion.php';
    }

    public function emitirVida()
    {
        if ($_POST) {
            require_once 'pages/vida/emitir.php';
        } else {
            require_once 'pages/layout/header.php';
            require_once 'pages/vida/emitir.php';
            require_once 'pages/layout/footer.php';
        }
    }

    public function descargarEmisionVida()
    {
        require_once 'pages/vida/emision.php';
    }
}
