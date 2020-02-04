<?php

class portal
{
    public $cotizacion;

    function __construct()
    {
        $this->cotizaciones = new cotizaciones;
    }

    public function pagina_principal()
    {
        $cotizaciones = $this->cotizaciones->resumen();
        require("template/header.php");
        require("pages/portal/pagina_principal.php");
        require("template/footer.php");
    }


    public function crear_cotizacion()
    {
        if ($_POST) {
            $resultado = $this->cotizaciones->crear();
            if (!empty($resultado)) {
                $mensaje = "Cotización realizada exitosamente";
            } else {
                $mensaje = "Ha ocurrido un error,intentelo mas tarde";
            }
        }
        require("template/header.php");
        require("pages/portal/crear_cotizacion.php");
        require("template/footer.php");
        if ($_POST) {
            echo '
            <script>
            $(document).ready(function(){
                $("#modal").modal();
                $("#modal").modal("open"); 
             });
            </script>
            ';
        }
    }

    public function buscar_cotizacion()
    {
        if ($_POST) {
            $resultados = $this->cotizaciones->buscar();
        } else {
            $resultados = $this->cotizaciones->lista();
        }
        require("template/header.php");
        require("pages/portal/buscar_cotizacion.php");
        require("template/footer.php");
    }

    public function lista_cotizaciones()
    {
        $filtro = (isset($_GET['filtro'])) ? $_GET['filtro'] : "";
        $resultados = $this->cotizaciones->lista();
        require("template/header.php");
        require("pages/portal/lista_cotizaciones.php");
        require("template/footer.php");
    }

    public function ver_cotizacion()
    {
        $resultado = $this->cotizaciones->detalles();
        require("template/header.php");
        require("pages/portal/ver_cotizacion.php");
        require("template/footer.php");
    }

    public function descargar_cotizacion()
    {
        $resultado = $this->cotizaciones->detalles();
        require("pages/portal/descargar_cotizacion.php");
    }

    public function editar_cotizacion()
    {
        $resultado = $this->cotizaciones->detalles();
        if ($_POST) {
            $mensaje = $this->cotizaciones->editar();
        }
        require("template/header.php");
        require("pages/portal/editar_cotizacion.php");
        require("template/footer.php");
        if ($_POST) {
            echo '
            <script>
            $(document).ready(function(){
                $("#modal").modal();
                $("#modal").modal("open"); 
             });
            </script>
            ';
        }
    }

    public function eliminar_cotizacion()
    {
        $resultado = $this->cotizaciones->eliminar();
        $this->buscar_cotizacion();
    }

    public function emitir_cotizacion()
    {
        $resultado = $this->cotizaciones->detalles();
        if ($_POST) {
            $mensaje = $this->cotizaciones->emitir();
        }
        require("template/header.php");
        require("pages/portal/emitir_cotizacion.php");
        require("template/footer.php");
        if ($_POST) {
            echo '
            <script>
            $(document).ready(function(){
                $("#modal").modal();
                $("#modal").modal("open"); 
             });
            </script>
            ';
        }
    }
}