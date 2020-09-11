<?php

class cotizaciones {

    function buscar() {        
        require_once 'core/views/layout/header.php';
        require_once 'core/views/cotizaciones/buscar.php';
        require_once 'core/views/layout/footer.php';
    }

    function crear() {
        require_once 'core/views/layout/header.php';
        require_once 'core/views/cotizaciones/crear.php';
        require_once 'core/views/layout/footer.php';
    }

    function crearAuto() {
        require_once 'core/views/layout/header.php';
        require_once 'core/views/cotizaciones/auto/crear.php';
        require_once 'core/views/layout/footer.php';
    }

    function detallesAuto() {
        require_once 'core/views/layout/header.php';
        require_once 'core/views/cotizaciones/auto/detalles.php';
        require_once 'core/views/layout/footer.php';
    }

    function descargarAuto() {
        require_once 'core/views/cotizaciones/auto/descargar.php';
    }

    function emitirAuto() {
        require_once 'core/views/layout/header.php';
        require_once 'core/views/cotizaciones/auto/emitir.php';
        require_once 'core/views/layout/footer.php';
    }

}
