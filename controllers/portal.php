<?php

class portal {

    public function error() {
        require_once 'views/portal/error.php';
    }

    public function ingresar() {
        require_once 'views/portal/ingresar.php';
    }

    public function salir() {
        session_destroy();
        header("Location:" . constant("url"));
        exit();
    }

    public function inicio() {
        require_once 'views/layout/header.php';
        require_once 'views/portal/inicio.php';
        require_once 'views/layout/footer.php';
    }

}
