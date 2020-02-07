<?php

class portal_controller
{
    public $tratos;
    public $cotizaciones;
    public $marcas;
    public $planes;

    function __construct()
    {
        $this->tratos = new deals_model;
        $this->cotizaciones = new quotes_model;
        $this->marcas = new marcas_model;
        $this->planes = new products_model;
    }

    public function pagina_principal()
    {
        $tratos = $this->tratos->resumen($_SESSION['usuario']['id']);
        require("views/template/header.php");
        require("views/portal/pagina_principal.php");
        require("views/template/footer.php");
    }

    public function crear_cotizacion()
    {
        $marcas = $this->marcas->lista();
        if ($_POST) {
            $resultado = $this->tratos->crear();
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
        $trato = $this->tratos->detalles($_GET['id']);
        $cotizacion = $this->cotizaciones->detalles($trato->getFieldValue('Cotizaci_n')->getEntityId());
        require("views/template/header.php");
        require("views/portal/ver_cotizacion.php");
        require("views/template/footer.php");
    }

    public function buscar_cotizacion()
    {
        if ($_POST) {
            $tratos = $this->tratos->buscar($_SESSION['usuario']['id'], $_POST['busqueda'], $_POST['parametro']);
        } else {
            $tratos = $this->tratos->lista($_SESSION['usuario']['id']);
        }
        require("views/template/header.php");
        require("views/portal/buscar_cotizacion.php");
        require("views/template/footer.php");
    }

    public function lista_cotizaciones()
    {
        $filtro = (isset($_GET['filtro'])) ? $_GET['filtro'] : "";
        $tratos = $this->tratos->lista($_SESSION['usuario']['id']);
        require("views/template/header.php");
        require("views/portal/buscar_cotizacion.php");
        require("views/template/footer.php");
    }

    public function descargar_cotizacion()
    {
        $trato = $this->tratos->detalles($_GET['id']);
        $cotizacion = $this->cotizaciones->detalles($trato->getFieldValue('Cotizaci_n')->getEntityId());
        require("views/portal/descargar_cotizacion.php");
    }

    public function editar_cotizacion()
    {
        $trato = $this->tratos->detalles($_GET['id']);
        if ($_POST) {
            $resultado = $this->tratos->editar($_GET['id']);
            if (!empty($resultado)) {
                $mensaje = "Cambios realizados exitosamente";
            } else {
                $mensaje = "Ha ocurrido un error,intentelo mas tarde";
            }
        }
        require("views/template/header.php");
        require("views/portal/editar_cotizacion.php");
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

    public function eliminar_cotizacion()
    {
        $trato = $this->tratos->detalles($_GET['id']);
        $mensaje = "Cotización No. " . $trato->getFieldValue('No_de_cotizaci_n') . " ha sido cancelada";
        $this->tratos->eliminar($_GET['id']);
        $this->buscar_cotizacion();
    }

    public function emitir_cotizacion()
    {
        $trato = $this->tratos->detalles($_GET['id']);
        $cotizacion = $this->cotizaciones->detalles($trato->getFieldValue('Cotizaci_n')->getEntityId());
        if ($_POST) {
            $resultado = $this->tratos->emitir($_GET['id']);
            if (!empty($resultado)) {
                $mensaje = "Póliza emitida,descarga la cotización para obtener el carnet provisional";
            }else {
                $mensaje = "Ha ocurrido un error,intentelo mas tarde";
            }
        }
        require("views/template/header.php");
        require("views/portal/emitir_cotizacion.php");
        require("views/template/footer.php");
        if ($_POST) {
            echo '<script>$("#modal").modal("show")</script>';
        }
    }
}
