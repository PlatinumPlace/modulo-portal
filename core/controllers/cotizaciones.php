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

            if (isset($resultado["aseguradoras"])) {
                $aseguradoras =  array_count_values($resultado["aseguradoras"]);
            }
        }

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
            $id = $url[2];
            $alerta = (isset($url[3])) ? $url[3] : "";
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
            $alerta = $this->exportar_csv($_POST["tipo_reporte"], $_POST["tipo_cotizacion"], $_POST["contrato_id"], $_POST["desde"], $_POST["hasta"]);
        } elseif (isset($_POST["pdf"])) {
            $this->exportar_pdf($_POST["tipo_reporte"], $_POST["tipo_cotizacion"], $_POST["contrato_id"], $_POST["desde"], $_POST["hasta"]);
        }

        require_once("core/views/template/header.php");
        require_once("core/views/cotizaciones/exportar.php");
        require_once("core/views/template/footer.php");
    }

    public function exportar_csv($tipo_reporte, $tipo_cotizacion, $contrato_id, $desde, $hasta)
    {
        $usuario = json_decode($_COOKIE["usuario"], true);
        $emitida = array("Emitido", "En trámite");
        $contrato = $this->cotizacion->contrato_detalles($contrato_id);

        $cotizaciones = $this->cotizacion->buscar("Type", ucfirst($tipo_cotizacion));

        if (!empty($cotizaciones)) {

            $titulo = "Reporte Emisiones " . ucfirst($tipo_cotizacion);

            if (!is_dir("public/file")) {
                mkdir("public/file", 0755, true);
            }

            $fp = fopen('public/file/reporte.csv', 'w');

            $encabezado = array(
                array($contrato->getFieldValue("Socio")->getLookupLabel()),
                array($titulo),
                array("Aseguradora:", $contrato->getFieldValue("Aseguradora")->getLookupLabel()),
                array("Poliza:", $contrato->getFieldValue('No_P_liza')),
                array("Desde:", $desde, "Hasta:", $hasta),
                array("Vendedor:", $usuario['nombre']),
                array("Formato de moneda:", "RD$"),
                array("")
            );
            foreach ($encabezado as $campos) {
                fputcsv($fp, $campos);
            }

            switch ($tipo_cotizacion) {
                case 'auto':
                    $tabla = array(
                        array(
                            "Fecha de emision",
                            "Nombre Asegurado",
                            "Cedula",
                            "Marca",
                            "Modelo",
                            "Ano",
                            "Color",
                            "Chasis",
                            "Placa",
                            "Valor Asegurado",
                            "Plan",
                            "Prima"
                        )
                    );
                    break;
            }

            foreach ($tabla as $campos) {
                fputcsv($fp, $campos);
            }

            $total_prima = 0;
            $total_comision = 0;
            $total_valor = 0;

            foreach ($cotizaciones as $resumen) {
                if (
                    date("Y-m-d", strtotime($resumen->getFieldValue("Fecha_de_emisi_n")))  > $desde
                    and
                    date("Y-m-d", strtotime($resumen->getFieldValue("Fecha_de_emisi_n"))) < $hasta
                    and
                    $resumen->getFieldValue("Contact_Name")->getEntityId() == $usuario["id"]
                ) {
                    $resultado = $this->cotizacion->detalles($resumen->getEntityId());
                    $detalles =  $resultado["cotizaciones"];
                    foreach ($detalles as $info) {
                        if ($info->getFieldValue("Aseguradora")->getEntityId() == $contrato->getFieldValue("Aseguradora")->getEntityId()) {
                            if (
                                $resumen->getFieldValue("Stage") == "Cotizando"
                                and
                                $tipo_reporte == "cotizaciones"
                            ) {
                                switch ($tipo_cotizacion) {
                                    case 'auto':
                                        $total_valor += $resumen->getFieldValue('Valor_Asegurado');
                                        $contenido = array(
                                            array(
                                                date("Y-m-d", strtotime($resumen->getFieldValue("Fecha_de_emisi_n"))),
                                                $resumen->getFieldValue("Nombre") . " " . $resumen->getFieldValue("Apellido"),
                                                $resumen->getFieldValue("RNC_Cedula"),
                                                $resumen->getFieldValue('Marca')->getLookupLabel(),
                                                $resumen->getFieldValue('Modelo')->getLookupLabel(),
                                                $resumen->getFieldValue('A_o_de_Fabricacion'),
                                                $resumen->getFieldValue('Color'),
                                                $resumen->getFieldValue('Chasis'),
                                                $resumen->getFieldValue('Placa'),
                                                $resumen->getFieldValue('Valor_Asegurado'),
                                                $resumen->getFieldValue('Plan'),
                                                $resumen->getFieldValue('Prima_Total'),
                                            )
                                        );
                                        break;
                                }
                            } elseif (
                                in_array($resumen->getFieldValue("Stage"), $emitida)
                                and
                                $tipo_reporte == "emisiones"
                                or
                                $tipo_reporte == "comisiones"
                            ) {
                                switch ($tipo_cotizacion) {
                                    case 'auto':
                                        $total_comision += $resumen->getFieldValue('Comisi_n_Socio');
                                        $total_prima += $resumen->getFieldValue('Prima_Total');
                                        $total_valor += $resumen->getFieldValue('Valor_Asegurado');
                                        $contenido = array(
                                            array(
                                                date("Y-m-d", strtotime($resumen->getFieldValue("Fecha_de_emisi_n"))),
                                                $resumen->getFieldValue("Nombre") . " " . $resumen->getFieldValue("Apellido"),
                                                $resumen->getFieldValue("RNC_Cedula"),
                                                $resumen->getFieldValue('Marca')->getLookupLabel(),
                                                $resumen->getFieldValue('Modelo')->getLookupLabel(),
                                                $resumen->getFieldValue('A_o_de_Fabricacion'),
                                                $resumen->getFieldValue('Color'),
                                                $resumen->getFieldValue('Chasis'),
                                                $resumen->getFieldValue('Placa'),
                                                $resumen->getFieldValue('Valor_Asegurado'),
                                                $resumen->getFieldValue('Plan'),
                                                $resumen->getFieldValue('Prima_Total'),
                                            )
                                        );
                                        break;
                                }
                            }

                            foreach ($contenido as $campos) {
                                fputcsv($fp, $campos);
                            }
                        }
                    }
                }
            }


            switch ($tipo_cotizacion) {
                case 'auto':
                    if ($tipo_reporte == "emisiones") {
                        $pie_pagina = array(
                            array(""),
                            array("Total de las Primas:", $total_prima),
                            array("Total de los Valores Asegurados:", $total_valor)
                        );
                    } elseif ($tipo_reporte == "comisiones") {
                        $pie_pagina = array(
                            array(""),
                            array("Total de las Primas:", $total_prima),
                            array("Total de las Comisiones:", $total_comision),
                            array("Total de los Valores Asegurados:", $total_valor)
                        );
                    } elseif ($tipo_reporte == "cotizaciones") {
                        $pie_pagina = array(
                            array(""),
                            array("Total de los Valores Asegurados:", $total_valor)
                        );
                    }
                    break;
            }

            foreach ($pie_pagina as $campos) {
                fputcsv($fp, $campos);
            }

            fclose($fp);

            return 'Reporte generado correctamente,
            <a download="' . $titulo . '.csv" href="' . constant("url") . 'public/file/reporte.csv" class="btn btn-link">descargar</a>';
        } else {
            return "Ha ocurrido un error,vuelva a intentarlo";
        }
    }

    public function exportar_pdf($tipo_reporte, $tipo_cotizacion, $contrato_id, $desde, $hasta)
    {

        require_once("core/views/cotizaciones/exportar_pdf.php");
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
