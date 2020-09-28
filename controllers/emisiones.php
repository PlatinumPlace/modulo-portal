<?php

class emisiones {

    function lista() {
        require_once 'views/layout/header.php';
        require_once 'views/emisiones/lista.php';
        require_once 'views/layout/footer.php';
    }

    public function detallesAuto() {
        require_once 'views/layout/header.php';
        require_once 'views/emisiones/auto/detalles.php';
        require_once 'views/layout/footer.php';
    }

    public function descargarAuto() {
        require_once 'views/emisiones/auto/descargar.php';
    }

    public function detallesVida() {
        require_once 'views/layout/header.php';
        require_once 'views/emisiones/vida/detalles.php';
        require_once 'views/layout/footer.php';
    }

    public function descargarVida() {
        require_once 'views/emisiones/vida/descargar.php';
    }

    function adjuntar() {
        if ($_FILES) {
            require_once 'views/emisiones/adjuntar.php';
        } else {
            require_once 'views/layout/header.php';
            require_once 'views/emisiones/adjuntar.php';
            require_once 'views/layout/footer.php';
        }
    }

}
