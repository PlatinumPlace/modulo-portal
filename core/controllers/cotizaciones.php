<?php

class cotizaciones
{
    public $cotizacion;

    function __construct()
    {
        $this->cotizacion = new cotizacion;
    }

    public function pagina_principal()
    {

        $usuario = json_decode($_COOKIE["usuario"], true);
        $api = new api;

        $criterio = "Contact_Name:equals:" . $usuario['id'];
        $cotizaciones = $api->searchRecordsByCriteria("Deals", $criterio);

        $resultado["total"] = 0;
        $resultado["pendientes"] = 0;
        $resultado["emisiones"] = 0;
        $resultado["vencimientos"] = 0;
        $emitida = array("Emitido", "En trámite");

        if ($cotizaciones) {
            foreach ($cotizaciones as $cotizacion) {

                if ($cotizacion->getFieldValue("Stage") != "Abandonado") {
                    $resultado["total"] += 1;
                }

                if ($cotizacion->getFieldValue("Stage") == "Cotizando") {
                    $resultado["pendientes"] += 1;
                }

                if (in_array($cotizacion->getFieldValue("Stage"), $emitida)) {

                    if (date("Y-m", strtotime($cotizacion->getFieldValue("Fecha_de_emisi_n"))) == date('Y-m')) {
                        $resultado["emisiones"] += 1;
                        $resultado["aseguradoras"][] = $cotizacion->getFieldValue('Aseguradora')->getLookupLabel();
                    }

                    if (date("Y-m", strtotime($cotizacion->getFieldValue("Closing_Date"))) == date('Y-m')) {
                        $resultado["vencimientos"] += 1;
                    }
                }
            }
        }

        $aseguradoras =  array_count_values($resultado["aseguradoras"]);

        require_once("core/views/template/header.php");
        require_once("core/views/cotizaciones/index.php");
        require_once("core/views/template/footer.php");
    }

    public function error()
    {
        require_once("core/views/template/header.php");
        require_once("core/views/cotizaciones/error.php");
        require_once("core/views/template/footer.php");
    }

    public function redirigir($peticion = null)
    {
        if (empty($peticion)) {
            $this->error();
            exit;
        } else {
            $url = explode('-', $peticion);
            $controlador = $url[0];
            $funcion = $url[1];
            $datos = $url[2];
        }

        require_once("core/views/template/header.php");
        require_once("core/views/cotizaciones/redirigir.php");
        require_once("core/views/template/footer.php");
    }

    public function buscar()
    {
        if ($_POST) {
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
                $alerta = 'Reporte generado correctamente,<a download="' . $resultado . '.csv" href="' . constant("url") . 'public/file/reporte.csv" class="btn btn-link">descargar</a>';
            } else {
                $alerta = "Ha ocurrido un error,vuelva a intentarlo";
            }
        } elseif (isset($_POST["pdf"])) {



            require_once("core/views/cotizaciones/exportar_pdf.php");
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

        header("Location:" . constant("url") . "cotizaciones/redirigir/auto-detalles-$id");
        exit;
    }
}
