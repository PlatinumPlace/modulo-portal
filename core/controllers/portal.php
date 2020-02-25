<?php

class portal_controller
{
    public $tratos;

    function __construct()
    {
        $this->tratos = new tratos;
    }

    public function pagina_principal()
    {
        $tratos = $this->tratos->resumen($_SESSION['usuario']['id']);
        require("core/views/portal/template/header.php");
        require("core/views/portal/pagina_principal.php");
        require("core/views/portal/template/footer.php");
    }

    public function buscar_cotizacion($mensaje = null)
    {
        if ($_POST) {
            $tratos = $this->tratos->buscar($_SESSION['usuario']['id'], $_POST['busqueda'], $_POST['parametro']);
        } else {
            $tratos = $this->tratos->lista($_SESSION['usuario']['id']);
        }
        require("core/views/portal/template/header.php");
        require("core/views/portal/cotizaciones/buscar.php");
        require("core/views/portal/template/footer.php");
    }

    public function crear_cotizacion()
    {
        if ($_POST) {
            $resultado = $this->tratos->crear();
            $mensaje = "Cotización creada";
        }
        require("core/views/portal/template/header.php");
        require("core/views/portal/cotizaciones/crear.php");
        require("core/views/portal/template/footer.php");
        echo '<script>
                function obtener_modelos(val) {
                    {
                        $.ajax({
                            url: "core/helpers/obtener_modelos.php",
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
            echo '<script>$("#crear").modal("show")</script>';
        }
    }

    public function ver_cotizacion()
    {
        $trato = $this->tratos->detalles($_GET['id']);
        $cotizaciones = $trato->getFieldValue('Aseguradoras_Disponibles');
        require("core/views/portal/template/header.php");
        require("core/views/portal/cotizaciones/detalles.php");
        require("core/views/portal/template/footer.php");
    }

    public function editar_cotizacion()
    {
        $trato = $this->tratos->detalles($_GET['id']);
        if ($_POST) {
            $this->tratos->editar($_GET['id']);
            $mensaje = "Cambios Aplicados";
        }
        require("core/views/portal/template/header.php");
        require("core/views/portal/cotizaciones/editar.php");
        require("core/views/portal/template/footer.php");
        echo '<script>
                function obtener_modelos(val) {
                    {
                        $.ajax({
                            url: "core/helpers/obtener_modelos.php",
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
            echo '<script>$("#editar").modal("show")</script>';
        }
    }

    public function lista_cotizaciones()
    {
        $filtro = $_GET['filtro'];
        $tratos = $this->tratos->lista($_SESSION['usuario']['id']);
        require("core/views/portal/template/header.php");
        require("core/views/portal/cotizaciones/lista.php");
        require("core/views/portal/template/footer.php");
    }

    public function descargar_cotizacion()
    {
        $trato = $this->tratos->detalles($_GET['id']);
        $cotizaciones = $trato->getFieldValue('Aseguradoras_Disponibles');
        require("core/views/portal/cotizaciones/descargar.php");
    }

    public function eliminar_cotizacion()
    {
        $trato = $this->tratos->detalles($_GET['id']);
        $mensaje = "Cotización No. " . $trato->getFieldValue('No_de_cotizaci_n') . " ha sido Abandonado";
        $this->tratos->eliminar($_GET['id']);
        $this->buscar_cotizacion($mensaje);
    }

    public function emitir_cotizacion()
    {
        $trato = $this->tratos->detalles($_GET['id']);
        $cotizaciones = $trato->getFieldValue('Aseguradoras_Disponibles');
        if ($_POST or $_FILES) {
            $mensaje = $this->tratos->emitir($_GET['id']);
        }
        require("core/views/portal/template/header.php");
        require("core/views/portal/cotizaciones/emitir.php");
        require("core/views/portal/template/footer.php");
        if ($_POST) {
            echo '<script>$("#emitir").modal("show")</script>';
        }
    }
}
