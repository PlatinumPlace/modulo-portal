<?php

class CotizacionesController
{
    public $cotizacion;

    function __construct()
    {
        $this->cotizacion = new cotizacion;
    }

    public function buscar()
    {
        if (isset($_POST['submit'])) {
            $cotizaciones = $this->cotizacion->buscar($_POST['parametro'], $_POST['busqueda']);
        } else {
            $cotizaciones = $this->cotizacion->lista();
        }

        require_once("core/views/template/header.php");
        require_once("core/views/cotizaciones/buscar.php");
        require_once("core/views/template/footer.php");
    }

    public function pendientes()
    {
        $cotizaciones = $this->cotizacion->lista();

        require_once("core/views/template/header.php");
        require_once("core/views/cotizaciones/pendientes.php");
        require_once("core/views/template/footer.php");
    }

    public function vencimientos_mensuales()
    {
        $cotizaciones = $this->cotizacion->lista();
        $emitida = array("Emitido", "En trámite");

        require_once("core/views/template/header.php");
        require_once("core/views/cotizaciones/vencimientos_mensuales.php");
        require_once("core/views/template/footer.php");
    }

    public function emisiones_mensuales()
    {
        $cotizaciones = $this->cotizacion->lista();
        $emitida = array("Emitido", "En trámite");

        require_once("core/views/template/header.php");
        require_once("core/views/cotizaciones/emisiones_mensuales.php");
        require_once("core/views/template/footer.php");
    }

    public function crear()
    {
        $marcas = $this->cotizacion->lista_marcas();
        sort($marcas);

        if (isset($_POST['crear_auto'])) {
            $this->crear_auto();
        }

        require_once("core/views/template/header.php");
        require_once("core/views/cotizaciones/crear.php");
        require_once("core/views/template/footer.php");
    }

    public function exportar()
    {
        $contratos = $this->cotizacion->lista_aseguradoras();

        if (isset($_POST["csv"])) {

            if ($_POST['tipo_reporte'] == "emisiones") {
                $resultado = $this->cotizacion->exportar_emisiones_csv($_POST["tipo_cotizacion"], $_POST["contrato_id"], $_POST["desde"], $_POST["hasta"]);
            } elseif ($_POST['tipo_reporte'] == "cotizaciones") {
                $resultado = $this->cotizacion->exportar_cotizaciones_csv($_POST["tipo_cotizacion"], $_POST["contrato_id"], $_POST["desde"], $_POST["hasta"]);
            }


            if (!empty($resultado)) {
                $alerta = 'Reporte generado correctamente,<a download="' . $resultado . '.csv" href="public/file/reporte.csv" class="btn btn-link">descargar</a>';
            } else {
                $alerta = "Ha ocurrido un error,vuelva a intentarlo";
            }
        }

        require_once("core/views/template/header.php");
        require_once("core/views/cotizaciones/exportar.php");
        require_once("core/views/template/footer.php");
    }

    public function crear_auto()
    {
        $usuario = json_decode($_COOKIE["usuario"], true);

        $nueva_cotizacion["Stage"] = "Cotizando";
        $nueva_cotizacion["Type"] = "Auto";
        $nueva_cotizacion["Lead_Source"] = "Portal GNB";
        $nueva_cotizacion["Deal_Name"] = "Cotización";
        $nueva_cotizacion["Contact_Name"] =  $usuario['id'];
        $nueva_cotizacion["Tipo_de_poliza"] = $_POST["Tipo_de_poliza"];
        $nueva_cotizacion["Plan"] = $_POST["Plan"];
        $nueva_cotizacion["Marca"] = $_POST["Marca"];
        $nueva_cotizacion["Modelo"] = $_POST["Modelo"];

        $modelo = $this->cotizacion->detalles_modelo($_POST['Modelo']);

        $nueva_cotizacion["Tipo_de_veh_culo"] = $modelo->getFieldValue('Tipo');
        $nueva_cotizacion["Valor_Asegurado"] = $_POST["Valor_Asegurado"];

        $nueva_cotizacion["A_o_de_Fabricacion"] = $_POST["A_o_de_Fabricacion"];
        $nueva_cotizacion["Chasis"] = (isset($_POST["Chasis"])) ? $_POST["Chasis"] : null;
        $nueva_cotizacion["Color"] = (isset($_POST["Color"])) ? $_POST["Color"] : null;
        $nueva_cotizacion["Uso"] = (isset($_POST["Uso"])) ? $_POST["Uso"] : null;
        $nueva_cotizacion["Placa"] = (isset($_POST["Placa"])) ? $_POST["Placa"] : null;
        $nueva_cotizacion["Es_nuevo"] = (isset($_POST["Es_nuevo"])) ? true : false;

        $id = $this->cotizacion->crear($nueva_cotizacion);

        header("Location:?url=home/redirect/auto-detalles-$id");
        exit;
    }
}
