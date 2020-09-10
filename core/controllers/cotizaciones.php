<?php

class cotizaciones
{
    public function inicio()
    {
        $cotizacion = new cotizacion;
        $trato = new trato;
        $cotizaciones_totales = $cotizacion->total();
        $resumen_mensual = $trato->resumenMensual();

        require_once "core/views/layout/header.php";
        require_once "core/views/cotizaciones/index.php";
        require_once "core/views/layout/footer.php";
    }

    public function buscar()
    {
        $cotizacion = new cotizacion;
        $num_pag = (isset($_GET["page"])) ? $_GET["page"] : 1;

        if ($_POST) {
            $lista = $cotizacion->buscar($num_pag, 10, $_POST['parametro'], $_POST['busqueda']);
        } else {
            $lista = $cotizacion->lista($num_pag, 10);
        }

        require_once "core/views/layout/header.php";
        require_once "core/views/cotizaciones/buscar.php";
        require_once "core/views/layout/footer.php";
    }

    public function crear()
    {
        $cotizacion = new cotizacion;
        $contrato = $cotizacion->contratosDisponiblesCrear();

        require_once "core/views/layout/header.php";
        require_once "core/views/cotizaciones/crear.php";
        require_once "core/views/layout/footer.php";
    }
}
