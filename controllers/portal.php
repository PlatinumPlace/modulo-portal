<?php

class portal
{

    public function error()
    {
        require_once 'views/error.php';
    }

    public function ingresar()
    {
        if ($_POST) {
            require_once 'views/ingresar.php';
        } else {
            require_once 'views/ingresar.php';
        }
    }

    public function salir()
    {
        session_destroy();
        header("Location:?pagina=ingresar");
        exit();
    }

    public function inicio()
    {
        require_once 'views/layout/header.php';
        require_once 'views/inicio.php';
        require_once 'views/layout/footer.php';
    }

    function buscar()
    {
        if ($_POST) {
            require_once "views/buscar.php";
        } else {
            require_once "views/layout/header.php";
            require_once "views/buscar.php";
            require_once "views/layout/footer.php";
        }
    }

    public function crear()
    {
        require_once "views/layout/header.php";
        require_once "views/crear.php";
        require_once "views/layout/footer.php";
    }

    public function adjuntar()
    {
        if ($_FILES) {
            require_once "views/adjuntar.php";
        } else {
            require_once "views/layout/header.php";
            require_once "views/adjuntar.php";
            require_once "views/layout/footer.php";
        }
    }

    public function reportes()
    {
        if ($_POST) {
            require_once "views/reportes.php";
        } else {
            require_once "views/layout/header.php";
            require_once "views/reportes.php";
            require_once "views/layout/footer.php";
        }
    }

    public function crearAuto()
    {
        if ($_POST) {
            require_once "views/auto/crear.php";
        } else {
            require_once "views/layout/header.php";
            require_once "views/auto/crear.php";
            require_once "views/layout/footer.php";
        }
    }

    public function detallesAuto()
    {
        if (isset($_GET["contratoid"]) and isset($_GET["adjuntoid"])) {
            $api = new api;
            $documento = $api->downloadAttachment("Contratos", $_GET["contratoid"], $_GET["adjuntoid"]);
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

        require_once "views/layout/header.php";
        require_once "views/auto/detalles.php";
        require_once "views/layout/footer.php";
    }

    public function cotizacionAuto()
    {
        require_once "views/auto/cotizacion.php";
    }

    public function emisionAuto()
    {
        require_once "views/auto/emision.php";
    }

    public function emitirAuto()
    {
        if ($_POST) {
            require_once "views/auto/emitir.php";
        } else {
            require_once "views/layout/header.php";
            require_once "views/auto/emitir.php";
            require_once "views/layout/footer.php";
        }
    }

    public function crearVida()
    {
        if ($_POST) {
            require_once "views/vida/crear.php";
        } else {
            require_once "views/layout/header.php";
            require_once "views/vida/crear.php";
            require_once "views/layout/footer.php";
        }
    }

    public function detallesVida()
    {
        if (isset($_GET["contratoid"]) and isset($_GET["adjuntoid"])) {
            $api = new api;
            $documento = $api->downloadAttachment("Contratos", $_GET["contratoid"], $_GET["adjuntoid"]);
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

        require_once "views/layout/header.php";
        require_once "views/vida/detalles.php";
        require_once "views/layout/footer.php";
    }

    public function cotizacionVida()
    {
        require_once "views/vida/descargar_1.php";
    }

    public function emisionVida()
    {
        require_once "views/vida/emision.php";
    }

    public function emitirVida()
    {
        if ($_POST) {
            require_once "views/vida/emitir.php";
        } else {
            require_once "views/layout/header.php";
            require_once "views/vida/emitir.php";
            require_once "views/layout/footer.php";
        }
    }
}
