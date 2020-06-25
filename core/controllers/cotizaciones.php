<?php

class cotizaciones extends api
{
    function __construct()
    {
        parent::__construct();
    }

    public function error()
    {
        require_once("core/views/cotizaciones/error.php");
    }

    public function redirigir($url)
    {
        require_once("core/views/layout/header_main.php");
        require_once("core/views/cotizaciones/redirigir.php");
        require_once("core/views/layout/footer_main.php");
    }

    public function obtener_url()
    {
        $url = rtrim($_GET['url'], "/");
        $url = explode('/', $url);

        $resultado = array();
        $cont = 0;

        foreach ($url as $posicion => $valor) {

            if ($posicion > 2) {
                $resultado[$cont] = $valor;
                $cont++;
            }
        }

        return $resultado;
    }

    public function index()
    {
        $total = 0;
        $pendientes = 0;
        $emisiones = 0;
        $vencimientos = 0;
        $emitida = array("Emitido", "En trámite");

        $pagina = 1;
        $criterio = "Contact_Name:equals:" . $_SESSION["usuario"]["id"];

        do {

            $cotizaciones = $this->searchRecordsByCriteria("Deals", $criterio, $pagina, 200);

            if ($cotizaciones) {

                $pagina++;

                foreach ($cotizaciones as $cotizacion) {

                    if ($cotizacion->getFieldValue("Stage") != "Abandonado") {
                        $total += 1;
                    }

                    if ($cotizacion->getFieldValue("Stage") == "Cotizando") {
                        $pendientes += 1;
                    }

                    if (in_array($cotizacion->getFieldValue("Stage"), $emitida)) {

                        if (date("Y-m", strtotime($cotizacion->getFieldValue("Fecha_de_emisi_n"))) == date('Y-m')) {
                            $emisiones += 1;
                            $aseguradoras[] = $cotizacion->getFieldValue('Aseguradora')->getLookupLabel();
                        }

                        if (date("Y-m", strtotime($cotizacion->getFieldValue("Closing_Date"))) == date('Y-m')) {
                            $vencimientos += 1;
                        }
                    }
                }
            } else {
                $pagina = 0;
            }
        } while ($pagina > 0);

        if (!empty($aseguradoras)) {
            $aseguradoras =  array_count_values($aseguradoras);
        }

        require_once("core/views/layout/header_main.php");
        require_once("core/views/cotizaciones/index.php");
        require_once("core/views/layout/footer_main.php");
    }

    public function buscar($num_pagina = 1)
    {
        if ($_POST) {
            $criterio = "((Contact_Name:equals:" .  $_SESSION["usuario"]['id'] . ") and (" . $_POST['parametro'] . ":equals:" . $_POST['busqueda'] . "))";
            $lista =  $this->searchRecordsByCriteria("Deals", $criterio, $num_pagina, 15);
        } else {
            $criterio = "Contact_Name:equals:" . $_SESSION["usuario"]["id"];
            $lista = $this->searchRecordsByCriteria("Deals", $criterio, $num_pagina, 15);
        }

        require_once("core/views/layout/header_main.php");
        require_once("core/views/cotizaciones/buscar.php");
        require_once("core/views/layout/footer_main.php");
    }

    public function lista($filtro = null)
    {
        $criterio = "Contact_Name:equals:" . $_SESSION["usuario"]["id"];
        $lista = $this->searchRecordsByCriteria("Deals", $criterio, 1, 200);
        $emitida = array("Emitido", "En trámite");

        require_once("core/views/layout/header_main.php");
        require_once("core/views/cotizaciones/lista.php");
        require_once("core/views/layout/footer_main.php");
    }

    public function crear()
    {
        if ($_POST) {

            $nuevo_resumen["Deal_Name"] = "Cotización";
            $nuevo_resumen["Stage"] = "Cotizando";
            $nuevo_resumen["Lead_Source"] = "Portal GNB";
            $nuevo_resumen["Tipo_de_poliza"] = $_POST["tipo_poliza"];
            $nuevo_resumen["Plan"] = $_POST["tipo_plan"];
            $nuevo_resumen["Contact_Name"] = $_SESSION["usuario"]['id'];
            $nuevo_resumen["Account_Name"] = $_SESSION["usuario"]['empresa_id'];
            $nuevo_resumen["Valor_Asegurado"] = (!empty($_POST["valor"])) ? $_POST["valor"] : null;;

            if (!empty($_POST["tipo_cotizacion"]) and $_POST['tipo_cotizacion'] == "auto") {

                $nuevo_resumen["Type"] = "Auto";
                $nuevo_resumen["Marca"] = (!empty($_POST["marca"])) ? $_POST["marca"] : null;

                if (!empty($_POST["modelo"])) {
                    $nuevo_resumen["Modelo"] = $_POST["modelo"];
                    $modelo = $this->getRecord("Modelos", $_POST['modelo']);
                    $nuevo_resumen["Tipo_de_veh_culo"] = $modelo->getFieldValue('Tipo');
                }

                $nuevo_resumen["A_o_de_Fabricacion"] = (!empty($_POST["fabricacion"])) ? $_POST["fabricacion"] : null;
                $nuevo_resumen["Uso"] = (!empty($_POST["uso"])) ? $_POST["uso"] : null;
                $cambios["Es_nuevo"] = (!empty($_POST["nuevo"])) ? true : false;
            }

            if (
                empty($nuevo_resumen["Marca"])
                or
                empty($nuevo_resumen["Modelo"])
                or
                empty($nuevo_resumen["Tipo_de_veh_culo"])
                or
                empty($nuevo_resumen["A_o_de_Fabricacion"])
                or
                empty($nuevo_resumen["Valor_Asegurado"])
            ) {
                $alerta = "Debes completar los campos: valor asegurado, marca, modelo y año de fabricación.";
            } else {
                $resultado = $this->createRecord("Deals", $nuevo_resumen);
                $nueva_url = array("auto", "detalles", $resultado['id']);
                header("Location:" . constant("url") . "cotizaciones/redirigir/" . json_encode($nueva_url));
                exit;
            }
        }

        require_once("core/views/layout/header_main.php");
        require_once("core/views/cotizaciones/crear.php");
        require_once("core/views/layout/footer_main.php");
    }

    public function exportar()
    {
        $criterio = "Socio:equals:" .  $_SESSION["usuario"]['empresa_id'];
        $contratos = $this->searchRecordsByCriteria("Contratos", $criterio, 1, 200);
        if (!empty($contratos)) {

            foreach ($contratos as $contrato) {
                $aseguradoras[$contrato->getFieldValue('Aseguradora')->getEntityId()] = $contrato->getFieldValue('Aseguradora')->getLookupLabel();
            }

            $aseguradoras = array_unique($aseguradoras);
        }

        if (isset($_POST["pdf"])) {

            $post = array(
                "aseguradora_id" => $_POST["aseguradora_id"],
                "tipo_cotizacion" => $_POST["tipo_cotizacion"],
                "tipo_reporte" => $_POST["tipo_reporte"],
                "desde" => $_POST["desde"],
                "hasta" => $_POST["hasta"]
            );

            header("Location:" . constant("url") . "cotizaciones/descargar/" . json_encode($post));
            exit();
        }
        if (isset($_POST["csv"])) {

            $titulo = "Reporte " . ucfirst($_POST["tipo_reporte"]) . " " . ucfirst($_POST["tipo_cotizacion"]);

            $csv = "public/tmp/" . $titulo . ".csv";
            if (!is_dir("public/tmp")) {
                mkdir("public/tmp", 0755, true);
            }

            $pagina = 1;
            $criterio = "Contact_Name:equals:" .  $_SESSION["usuario"]['id'];

            $prima_sumatoria = 0;
            $valor_sumatoria = 0;
            $comision_sumatoria = 0;
            $emitida = array("Emitido", "En trámite");

            $contenido_csv = array(
                array($_SESSION["usuario"]['empresa_nombre']),
                array($titulo),
                array("Desde:", $_POST["desde"], "Hasta:", $_POST["hasta"]),
                array("Vendedor:", $_SESSION["usuario"]['nombre']),
                array("")
            );

            if ($_POST["tipo_cotizacion"] == "auto") {
                $contenido_csv[] = array(
                    "Emision",
                    "Vigencia",
                    "Nombre",
                    "RNC/Cedula",
                    "Marca",
                    "Modelo",
                    "Tipo",
                    "Ano",
                    "Color",
                    "Chasis",
                    "Placa",
                    "Valor",
                    "Prima",
                    "Aseguradora"
                );

                do {
                    $cotizaciones = $this->searchRecordsByCriteria("Quotes", $criterio, $pagina, 200);
                    if (!empty($cotizaciones)) {
                        $pagina++;
                        foreach ($cotizaciones as $cotizacion) {
                            if ($cotizacion->getFieldValue('Grand_Total') > 0) {
                                $resumen =  $this->getRecord("Deals", $cotizacion->getFieldValue("Deal_Name")->getEntityId());
                                if ($_POST["tipo_reporte"] == "cotizaciones") {
                                    if (
                                        date("Y-m-d", strtotime($resumen->getFieldValue("Fecha_de_emisi_n")))  >= $_POST["desde"]
                                        and
                                        date("Y-m-d", strtotime($resumen->getFieldValue("Fecha_de_emisi_n"))) <= $_POST["hasta"]
                                        and
                                        $resumen->getFieldValue("Stage") == "Cotizando"
                                        and
                                        $resumen->getFieldValue("Type") == "Auto"
                                    ) {
                                        if (empty($_POST["aseguradora_id"])) {
                                            $prima_sumatoria += $resumen->getFieldValue('Valor_Asegurado');
                                            $valor_sumatoria += $cotizacion->getFieldValue('Grand_Total');
                                            $contenido_csv[] =  array(
                                                date("Y-m-d", strtotime($resumen->getFieldValue("Fecha_de_emisi_n"))),
                                                date("Y-m-d", strtotime($resumen->getFieldValue("Closing_Date"))),
                                                $resumen->getFieldValue("Nombre") . " " . $resumen->getFieldValue("Apellidos"),
                                                $resumen->getFieldValue("RNC_Cedula"),
                                                $resumen->getFieldValue('Marca')->getLookupLabel(),
                                                $resumen->getFieldValue('Modelo')->getLookupLabel(),
                                                $resumen->getFieldValue('Tipo_de_veh_culo'),
                                                $resumen->getFieldValue('A_o_de_Fabricacion'),
                                                $resumen->getFieldValue('Color'),
                                                $resumen->getFieldValue('Chasis'),
                                                $resumen->getFieldValue('Placa'),
                                                number_format($resumen->getFieldValue('Valor_Asegurado'), 2, ".", " "),
                                                number_format($cotizacion->getFieldValue('Grand_Total'), 2, ".", " "),
                                                $cotizacion->getFieldValue('Aseguradora')->getLookupLabel()
                                            );
                                        } elseif (!empty($_POST["aseguradora_id"]) and $cotizacion->getFieldValue("Aseguradora")->getEntityId() == $_POST["aseguradora_id"]) {
                                            $prima_sumatoria += $resumen->getFieldValue('Valor_Asegurado');
                                            $valor_sumatoria += $cotizacion->getFieldValue('Grand_Total');
                                            $contenido_csv[] =  array(
                                                date("Y-m-d", strtotime($resumen->getFieldValue("Fecha_de_emisi_n"))),
                                                date("Y-m-d", strtotime($resumen->getFieldValue("Closing_Date"))),
                                                $resumen->getFieldValue("Nombre") . " " . $resumen->getFieldValue("Apellidos"),
                                                $resumen->getFieldValue("RNC_Cedula"),
                                                $resumen->getFieldValue('Marca')->getLookupLabel(),
                                                $resumen->getFieldValue('Modelo')->getLookupLabel(),
                                                $resumen->getFieldValue('Tipo_de_veh_culo'),
                                                $resumen->getFieldValue('A_o_de_Fabricacion'),
                                                $resumen->getFieldValue('Color'),
                                                $resumen->getFieldValue('Chasis'),
                                                $resumen->getFieldValue('Placa'),
                                                number_format($resumen->getFieldValue('Valor_Asegurado'), 2, ".", " "),
                                                number_format($cotizacion->getFieldValue('Grand_Total'), 2, ".", " "),
                                                $cotizacion->getFieldValue('Aseguradora')->getLookupLabel()
                                            );
                                        }
                                    }
                                } elseif ($_POST["tipo_reporte"] == "emisiones") {
                                    if (
                                        date("Y-m-d", strtotime($resumen->getFieldValue("Fecha_de_emisi_n")))  >= $_POST["desde"]
                                        and
                                        date("Y-m-d", strtotime($resumen->getFieldValue("Fecha_de_emisi_n"))) <= $_POST["hasta"]
                                        and
                                        in_array($resumen->getFieldValue("Stage"), $emitida)
                                        and
                                        $resumen->getFieldValue("Type") == "Auto"
                                    ) {
                                        if (empty($_POST["aseguradora_id"])) {
                                            $prima_sumatoria += $resumen->getFieldValue('Valor_Asegurado');
                                            $valor_sumatoria += $cotizacion->getFieldValue('Grand_Total');
                                            $comision_sumatoria += $cotizacion->getFieldValue('Comisi_n_Socio');
                                            $contenido_csv[] =  array(
                                                date("Y-m-d", strtotime($resumen->getFieldValue("Fecha_de_emisi_n"))),
                                                date("Y-m-d", strtotime($resumen->getFieldValue("Closing_Date"))),
                                                $resumen->getFieldValue("Nombre") . " " . $resumen->getFieldValue("Apellidos"),
                                                $resumen->getFieldValue("RNC_Cedula"),
                                                $resumen->getFieldValue('Marca')->getLookupLabel(),
                                                $resumen->getFieldValue('Modelo')->getLookupLabel(),
                                                $resumen->getFieldValue('Tipo_de_veh_culo'),
                                                $resumen->getFieldValue('A_o_de_Fabricacion'),
                                                $resumen->getFieldValue('Color'),
                                                $resumen->getFieldValue('Chasis'),
                                                $resumen->getFieldValue('Placa'),
                                                number_format($resumen->getFieldValue('Valor_Asegurado'), 2, ".", " "),
                                                number_format($cotizacion->getFieldValue('Grand_Total'), 2, ".", " "),
                                                $cotizacion->getFieldValue('Aseguradora')->getLookupLabel(),
                                                number_format($cotizacion->getFieldValue('Comisi_n_Socio'),  2, ".", " ")
                                            );
                                        } elseif (!empty($_POST["aseguradora_id"]) and $cotizacion->getFieldValue("Aseguradora")->getEntityId() == $_POST["aseguradora_id"]) {
                                            $prima_sumatoria += $resumen->getFieldValue('Valor_Asegurado');
                                            $valor_sumatoria += $cotizacion->getFieldValue('Grand_Total');
                                            $comision_sumatoria += $cotizacion->getFieldValue('Comisi_n_Socio');
                                            $contenido_csv[] =  array(
                                                date("Y-m-d", strtotime($resumen->getFieldValue("Fecha_de_emisi_n"))),
                                                date("Y-m-d", strtotime($resumen->getFieldValue("Closing_Date"))),
                                                $resumen->getFieldValue("Nombre") . " " . $resumen->getFieldValue("Apellidos"),
                                                $resumen->getFieldValue("RNC_Cedula"),
                                                $resumen->getFieldValue('Marca')->getLookupLabel(),
                                                $resumen->getFieldValue('Modelo')->getLookupLabel(),
                                                $resumen->getFieldValue('Tipo_de_veh_culo'),
                                                $resumen->getFieldValue('A_o_de_Fabricacion'),
                                                $resumen->getFieldValue('Color'),
                                                $resumen->getFieldValue('Chasis'),
                                                $resumen->getFieldValue('Placa'),
                                                number_format($resumen->getFieldValue('Valor_Asegurado'), 2, ".", " "),
                                                number_format($cotizacion->getFieldValue('Grand_Total'), 2, ".", " "),
                                                $cotizacion->getFieldValue('Aseguradora')->getLookupLabel(),
                                                number_format($cotizacion->getFieldValue('Comisi_n_Socio'),  2, ".", " ")
                                            );
                                        }
                                    }
                                }
                            }
                        }
                    } else {
                        $pagina = 0;
                    }
                } while ($pagina > 1);
            }

            $contenido_csv[] = array("");
            $contenido_csv[] = array("Total Primas:", number_format($prima_sumatoria, 2, ".", " "));
            $contenido_csv[] = array("Total Valores:", number_format($valor_sumatoria, 2, ".", " "));
            if ($_POST["tipo_reporte"] == "emisiones") {
                $contenido_csv[] = array("Total Comisiones:", number_format($comision_sumatoria, 2, ".", " "));
            }

            if (!empty($valor_sumatoria)) {
                $fp = fopen($csv, 'w');
                foreach ($contenido_csv as $campos) {
                    fputcsv($fp, $campos);
                }
                fclose($fp);
            }

            $fileName = basename($csv);
            if (!empty($fileName) and file_exists($csv)) {
                header('Content-Description: File Transfer');
                header('Content-Type: application/octet-stream');
                header('Content-Disposition: attachment; filename="' . $fileName . '"');
                header('Expires: 0');
                header('Cache-Control: must-revalidate');
                header('Pragma: public');
                header('Content-Length: ' . filesize($csv));
                readfile($csv);
                unlink($csv);
                exit;
            } else {
                $alerta = 'Exportación fallida, el archivo esta vacío.';
            }
        }

        require_once("core/views/layout/header_main.php");
        require_once("core/views/cotizaciones/exportar.php");
        require_once("core/views/layout/footer_main.php");
    }

    public function descargar($post)
    {
        $post = json_decode($post, true);

        $titulo = "Reporte " . ucfirst($post["tipo_reporte"]) . " " . ucfirst($post["tipo_cotizacion"]);

        $pagina = 1;
        $criterio = "Contact_Name:equals:" .  $_SESSION["usuario"]['id'];

        $prima_sumatoria = 0;
        $valor_sumatoria = 0;
        $comision_sumatoria = 0;
        $emitida = array("Emitido", "En trámite");

        require_once("core/views/cotizaciones/descargar.php");
    }
}
