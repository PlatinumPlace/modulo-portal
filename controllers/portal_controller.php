<?php

class portal_controller
{
    public $tratos;
    public $marcas;


    function __construct()
    {
        $this->cotizaciones = new cotizacion_model;
        $this->marcas = new marcas_model;
    }

    public function pagina_principal()
    {
        $cotizaciones = $this->cotizaciones->resumen();
        require("views/template/header.php");
        require("views/portal/pagina_principal.php");
        require("views/template/footer.php");
    }

    public function crear_cotizacion()
    {
        $marcas = $this->marcas->obtener_marcas();
        if ($_POST) {
            $resultado = $this->cotizaciones->crear();
            if (!empty($resultado)) {
                $mensaje = "Cotización realizada exitosamente";
            } else {
                $mensaje = "Ha ocurrido un error,intentelo mas tarde";
            }
        }
        require("views/template/header.php");
        require("views/portal/crear_cotizacion.php");
        require("views/template/footer.php");
        echo '<script>
            function obtener_modelos(val) {
                {
                    $.ajax({
                        url: "lib/obtener_modelos.php",
                        type: "POST",
                        data: {
                            marcas_id: val.value
                        },
                        success: function(response) {
                            document.getElementById("modelo").innerHTML = response;
                        }
                    });
                }
            }    
        </script>';
        if ($_POST) {
            echo '<script>$("#modal").modal("show")</script>';
        }
    }

    public function ver_cotizacion()
    {
        $resultado = $this->cotizaciones->detalles();
        require("views/template/header.php");
        require("views/portal/ver_cotizacion.php");
        require("views/template/footer.php");
    }

    public function buscar_cotizacion()
    {
        if ($_POST) {
            $resultados = $this->cotizaciones->buscar();
        } else {
            $resultados = $this->cotizaciones->lista();
        }
        require("views/template/header.php");
        require("views/portal/buscar_cotizacion.php");
        require("views/template/footer.php");
    }

    public function lista_cotizaciones()
    {
        $filtro = (isset($_GET['filtro'])) ? $_GET['filtro'] : "";
        $resultados = $this->cotizaciones->lista();
        require("views/template/header.php");
        require("views/portal/buscar_cotizacion.php");
        require("views/template/footer.php");
    }

    public function descargar_cotizacion()
    {
        $resultado = $this->cotizaciones->detalles();
        require("views/portal/descargar_cotizacion.php");
    }

    public function editar_cotizacion()
    {
        $resultado = $this->cotizaciones->detalles();
        if ($_POST) {
            $mensaje = $this->cotizaciones->editar();
        }
        require("views/template/header.php");
        require("views/portal/editar_cotizacion.php");
        require("views/template/footer.php");
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
        require("views/template/header.php");
        require("views/portal/emitir_cotizacion.php");
        require("views/template/footer.php");
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
