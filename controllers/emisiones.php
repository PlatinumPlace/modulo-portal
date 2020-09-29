<?php

class emisiones
{

    function lista()
    {
        require_once 'views/layout/header.php';
        require_once 'views/emisiones/lista.php';
        require_once 'views/layout/footer.php';
    }

    public function detalles()
    {
        if (isset($_GET["tipo"])) {
            require_once 'views/layout/header.php';
            require_once 'views/emisiones/' . $_GET["tipo"] . '/detalles.php';
            require_once 'views/layout/footer.php';
        } else {
            require_once "views/portal/error.php";
            exit();
        }
    }

    public function descargar()
    {
        if (isset($_GET["tipo"])) {
            require_once 'views/emisiones/' . $_GET["tipo"] . '/descargar.php';
        } else {
            require_once "views/portal/error.php";
            exit();
        }
    }

    function adjuntar()
    {
        if ($_FILES) {
            require_once 'views/emisiones/adjuntar.php';
        } else {
            require_once 'views/layout/header.php';
            require_once 'views/emisiones/adjuntar.php';
            require_once 'views/layout/footer.php';
        }
    }
}
