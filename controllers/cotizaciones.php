<?php

class cotizaciones {

    function buscar() {
        if ($_POST) {
            require_once 'views/cotizaciones/buscar.php';
        } else {
            require_once 'views/layout/header.php';
            require_once 'views/cotizaciones/buscar.php';
            require_once 'views/layout/footer.php';
        }
    }

    public function crear() {
        require_once 'views/layout/header.php';
        require_once 'views/cotizaciones/crear.php';
        require_once 'views/layout/footer.php';
    }

    public function crearAuto() {
        if ($_POST) {
            require_once 'views/cotizaciones/auto/crear.php';
        } else {
            require_once 'views/layout/header.php';
            require_once 'views/cotizaciones/auto/crear.php';
            require_once 'views/layout/footer.php';
        }
    }

    public function detallesAuto() {
        $url = explode("/", $_GET["url"]);

        if (isset($url[3]) and isset($url[4])) {
            $documento = descargarAdjunto("Contratos", $url[3], $url[4]);
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

        require_once 'views/layout/header.php';
        require_once 'views/cotizaciones/auto/detalles.php';
        require_once 'views/layout/footer.php';
    }

    public function descargarAuto() {
        require_once 'views/cotizaciones/auto/descargar.php';
    }

    public function emitirAuto() {
        if ($_POST) {
            require_once 'views/cotizaciones/auto/emitir.php';
        } else {
            require_once 'views/layout/header.php';
            require_once 'views/cotizaciones/auto/emitir.php';
            require_once 'views/layout/footer.php';
        }
    }

    public function crearVida() {
        if ($_POST) {
            require_once 'views/cotizaciones/vida/crear.php';
        } else {
            require_once 'views/layout/header.php';
            require_once 'views/cotizaciones/vida/crear.php';
            require_once 'views/layout/footer.php';
        }
    }

    public function detallesVida() {
        $url = explode("/", $_GET["url"]);

        if (isset($url[3]) and isset($url[4])) {
            $documento = descargarAdjunto("Contratos", $url[3], $url[4]);
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

        require_once 'views/layout/header.php';
        require_once 'views/cotizaciones/vida/detalles.php';
        require_once 'views/layout/footer.php';
    }

    public function descargarVida() {
        require_once 'views/cotizaciones/vida/descargar.php';
    }

    public function emitirVida() {
        if ($_POST) {
            require_once 'views/cotizaciones/vida/emitir.php';
        } else {
            require_once 'views/layout/header.php';
            require_once 'views/cotizaciones/vida/emitir.php';
            require_once 'views/layout/footer.php';
        }
    }

}
