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
        require_once 'views/tratos/inicio.php';
        require_once 'views/layout/footer.php';
    }

    function buscar()
    {
        if ($_POST) {
            require_once "views/tratos/buscar.php";
        } else {
            require_once "views/layout/header.php";
            require_once "views/tratos/buscar.php";
            require_once "views/layout/footer.php";
        }
    }

    public function crear()
    {
        require_once "views/layout/header.php";
        require_once "views/tratos/crear.php";
        require_once "views/layout/footer.php";
    }

    public function adjuntar()
    {
        if ($_POST) {
            require_once "views/tratos/adjuntar.php";
        } else {
            require_once "views/layout/header.php";
            require_once "views/tratos/adjuntar.php";
            require_once "views/layout/footer.php";
        }
    }

    public function reportes()
    {
        if ($_POST) {
            require_once "views/tratos/reportes.php";
        } else {
            require_once "views/layout/header.php";
            require_once "views/tratos/reportes.php";
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
            $auto = new auto;
            $auto->descargarAdjunto();
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
            $vida = new vida;
            $vida->descargarAdjunto();
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
