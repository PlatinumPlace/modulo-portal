<?php

class usuarios {

    function ingresar() {
        require_once 'core/views/usuarios/index.php';
    }

    function salir() {
        session_destroy();
        header("Location:" . constant("url"));
        exit();
    }

}
