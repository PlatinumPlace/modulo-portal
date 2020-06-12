<?php

$api = new api;
$portal = new portal;

$url = $portal->obtener_url();
$alerta  = (isset($url[0])) ? $url[0] : "";
$emitida = array("Emitido", "En trámite");

$criterio = "Socio:equals:" .  $_SESSION["usuario"]['empresa_id'];
$contratos = $api->searchRecordsByCriteria("Contratos", $criterio, 1, 200);
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

    if (!is_dir("public/files")) {
        mkdir("public/files", 0755, true);
    }

    if ($_POST["tipo_cotizacion"] == "auto") {

        $fp = fopen("public/files/reporte.csv", 'w');

        $titulo = "Reporte " . ucfirst($_POST["tipo_reporte"]) . " " . ucfirst($_POST["tipo_cotizacion"]);

        $encabezado = array(
            array($_SESSION["usuario"]['empresa_nombre']),
            array($titulo),
            array("Desde:", $_POST["desde"], "Hasta:", $_POST["hasta"]),
            array("Vendedor:", $_SESSION["usuario"]['nombre']),
            array("")
        );
        foreach ($encabezado as $campos) {
            fputcsv($fp, $campos);
        }

        $encabezado_tabla = array(
            array(
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
            )
        );
        if ($_POST["tipo_reporte"] == "comisiones") {
            $encabezado_tabla[0][] = "Comision";
        }
        foreach ($encabezado_tabla as $campos) {
            fputcsv($fp, $campos);
        }

        $pagina = 1;
        $criterio = "Contact_Name:equals:" .  $_SESSION["usuario"]['id'];

        do {

            $cotizaciones = $this->searchRecordsByCriteria("Quotes", $criterio, $pagina, 200);
            if (!empty($cotizaciones)) {

                $pagina++;
                $prima_sumatoria = 0;
                $valor_sumatoria = 0;
                $comision_sumatoria = 0;
                $emitida = array("Emitido", "En trámite");

                if ($_POST["tipo_reporte"] == "cotizaciones") {

                    if (empty($_POST["aseguradora_id"])) {
                        foreach ($cotizaciones as $cotizacion) {

                            $oferta =  $this->getRecord("Deals", $cotizacion->getFieldValue("Deal_Name")->getEntityId());

                            if (
                                date("Y-m-d", strtotime($oferta->getFieldValue("Fecha_de_emisi_n")))  >= $_POST["desde"]
                                and
                                date("Y-m-d", strtotime($oferta->getFieldValue("Fecha_de_emisi_n"))) <= $_POST["hasta"]
                                and
                                $oferta->getFieldValue("Stage") == "Cotizando"
                                and
                                $cotizacion->getFieldValue('Grand_Total') > 0
                            ) {

                                $prima_sumatoria += $oferta->getFieldValue('Valor_Asegurado');
                                $valor_sumatoria += $cotizacion->getFieldValue('Grand_Total');

                                $contenido = array(
                                    array(
                                        date("Y-m-d", strtotime($oferta->getFieldValue("Fecha_de_emisi_n"))),
                                        date("Y-m-d", strtotime($oferta->getFieldValue("Closing_Date"))),
                                        $oferta->getFieldValue("Nombre") . " " . $oferta->getFieldValue("Apellido"),
                                        $oferta->getFieldValue("RNC_Cedula"),
                                        $oferta->getFieldValue('Marca')->getLookupLabel(),
                                        $oferta->getFieldValue('Modelo')->getLookupLabel(),
                                        $oferta->getFieldValue('Tipo_de_veh_culo'),
                                        $oferta->getFieldValue('A_o_de_Fabricacion'),
                                        $oferta->getFieldValue('Color'),
                                        $oferta->getFieldValue('Chasis'),
                                        $oferta->getFieldValue('Placa'),
                                        number_format($oferta->getFieldValue('Valor_Asegurado'), 2),
                                        number_format($cotizacion->getFieldValue('Grand_Total'), 2),
                                        $cotizacion->getFieldValue('Aseguradora')->getLookupLabel()
                                    )
                                );
                                foreach ($contenido as $campos) {
                                    fputcsv($fp, $campos);
                                }
                            }
                        }
                    } else {
                        foreach ($cotizaciones as $cotizacion) {

                            $oferta =  $this->getRecord("Deals", $cotizacion->getFieldValue("Deal_Name")->getEntityId());

                            if (
                                date("Y-m-d", strtotime($oferta->getFieldValue("Fecha_de_emisi_n")))  >= $_POST["desde"]
                                and
                                date("Y-m-d", strtotime($oferta->getFieldValue("Fecha_de_emisi_n"))) <= $_POST["hasta"]
                                and
                                $oferta->getFieldValue("Stage") == "Cotizando"
                                and
                                $cotizacion->getFieldValue('Grand_Total') > 0
                                and
                                $cotizacion->getFieldValue("Aseguradora")->getEntityId() == $_POST["aseguradora_id"]
                            ) {

                                $prima_sumatoria += $oferta->getFieldValue('Valor_Asegurado');
                                $valor_sumatoria += $cotizacion->getFieldValue('Grand_Total');

                                $contenido = array(
                                    array(
                                        date("Y-m-d", strtotime($oferta->getFieldValue("Fecha_de_emisi_n"))),
                                        date("Y-m-d", strtotime($oferta->getFieldValue("Closing_Date"))),
                                        $oferta->getFieldValue("Nombre") . " " . $oferta->getFieldValue("Apellido"),
                                        $oferta->getFieldValue("RNC_Cedula"),
                                        $oferta->getFieldValue('Marca')->getLookupLabel(),
                                        $oferta->getFieldValue('Modelo')->getLookupLabel(),
                                        $oferta->getFieldValue('Tipo_de_veh_culo'),
                                        $oferta->getFieldValue('A_o_de_Fabricacion'),
                                        $oferta->getFieldValue('Color'),
                                        $oferta->getFieldValue('Chasis'),
                                        $oferta->getFieldValue('Placa'),
                                        number_format($oferta->getFieldValue('Valor_Asegurado'), 2),
                                        number_format($cotizacion->getFieldValue('Grand_Total'), 2),
                                        $cotizacion->getFieldValue('Aseguradora')->getLookupLabel()
                                    )
                                );
                                foreach ($contenido as $campos) {
                                    fputcsv($fp, $campos);
                                }
                            }
                        }
                    }
                } elseif ($_POST["tipo_reporte"] == "emisiones" or $_POST["tipo_reporte"] == "comisiones") {
                    if (empty($_POST["aseguradora_id"])) {
                        foreach ($cotizaciones as $cotizacion) {

                            $oferta =  $this->getRecord("Deals", $cotizacion->getFieldValue("Deal_Name")->getEntityId());

                            if (
                                date("Y-m-d", strtotime($oferta->getFieldValue("Fecha_de_emisi_n")))  >= $_POST["desde"]
                                and
                                date("Y-m-d", strtotime($oferta->getFieldValue("Fecha_de_emisi_n"))) <= $_POST["hasta"]
                                and
                                in_array($oferta->getFieldValue("Stage"), $emitida)
                                and
                                $cotizacion->getFieldValue('Grand_Total') > 0
                            ) {

                                $prima_sumatoria += $oferta->getFieldValue('Valor_Asegurado');
                                $valor_sumatoria += $cotizacion->getFieldValue('Grand_Total');
                                $comision_sumatoria += $cotizacion->getFieldValue('Comisi_n_Socio');

                                $contenido = array(
                                    array(
                                        date("Y-m-d", strtotime($oferta->getFieldValue("Fecha_de_emisi_n"))),
                                        date("Y-m-d", strtotime($oferta->getFieldValue("Closing_Date"))),
                                        $oferta->getFieldValue("Nombre") . " " . $oferta->getFieldValue("Apellido"),
                                        $oferta->getFieldValue("RNC_Cedula"),
                                        $oferta->getFieldValue('Marca')->getLookupLabel(),
                                        $oferta->getFieldValue('Modelo')->getLookupLabel(),
                                        $oferta->getFieldValue('Tipo_de_veh_culo'),
                                        $oferta->getFieldValue('A_o_de_Fabricacion'),
                                        $oferta->getFieldValue('Color'),
                                        $oferta->getFieldValue('Chasis'),
                                        $oferta->getFieldValue('Placa'),
                                        number_format($oferta->getFieldValue('Valor_Asegurado'), 2),
                                        number_format($cotizacion->getFieldValue('Grand_Total'), 2),
                                        $cotizacion->getFieldValue('Aseguradora')->getLookupLabel()
                                    )
                                );
                                if ($_POST["tipo_reporte"] == "comisiones") {
                                    $contenido[0][] = number_format($cotizacion->getFieldValue('Comisi_n_Socio'), 2);
                                }
                                foreach ($contenido as $campos) {
                                    fputcsv($fp, $campos);
                                }
                            }
                        }
                    } else {
                        foreach ($cotizaciones as $cotizacion) {

                            $oferta =  $this->getRecord("Deals", $cotizacion->getFieldValue("Deal_Name")->getEntityId());

                            if (
                                date("Y-m-d", strtotime($oferta->getFieldValue("Fecha_de_emisi_n")))  >= $_POST["desde"]
                                and
                                date("Y-m-d", strtotime($oferta->getFieldValue("Fecha_de_emisi_n"))) <= $_POST["hasta"]
                                and
                                in_array($oferta->getFieldValue("Stage"), $emitida)
                                and
                                $cotizacion->getFieldValue('Grand_Total') > 0
                                and
                                $cotizacion->getFieldValue("Aseguradora")->getEntityId() == $_POST["aseguradora_id"]
                            ) {

                                $prima_sumatoria += $oferta->getFieldValue('Valor_Asegurado');
                                $valor_sumatoria += $cotizacion->getFieldValue('Grand_Total');
                                $comision_sumatoria += $cotizacion->getFieldValue('Comisi_n_Socio');

                                $contenido = array(
                                    array(
                                        date("Y-m-d", strtotime($oferta->getFieldValue("Fecha_de_emisi_n"))),
                                        date("Y-m-d", strtotime($oferta->getFieldValue("Closing_Date"))),
                                        $oferta->getFieldValue("Nombre") . " " . $oferta->getFieldValue("Apellido"),
                                        $oferta->getFieldValue("RNC_Cedula"),
                                        $oferta->getFieldValue('Marca')->getLookupLabel(),
                                        $oferta->getFieldValue('Modelo')->getLookupLabel(),
                                        $oferta->getFieldValue('Tipo_de_veh_culo'),
                                        $oferta->getFieldValue('A_o_de_Fabricacion'),
                                        $oferta->getFieldValue('Color'),
                                        $oferta->getFieldValue('Chasis'),
                                        $oferta->getFieldValue('Placa'),
                                        number_format($oferta->getFieldValue('Valor_Asegurado'), 2),
                                        number_format($cotizacion->getFieldValue('Grand_Total'), 2),
                                        $cotizacion->getFieldValue('Aseguradora')->getLookupLabel()
                                    )
                                );
                                if ($_POST["tipo_reporte"] == "comisiones") {
                                    $contenido[0][] = number_format($cotizacion->getFieldValue('Comisi_n_Socio'), 2);
                                }
                                foreach ($contenido as $campos) {
                                    fputcsv($fp, $campos);
                                }
                            }
                        }
                    }
                }

                $pie_pagina = array(
                    array(""),
                    array("Total Primas:", number_format($prima_sumatoria, 2)),
                    array("Total Valores:", number_format($valor_sumatoria, 2))
                );
                if ($_POST["tipo_reporte"] == "comisiones") {
                    $pie_pagina[3] = array("Total Comisiones:", number_format($comision_sumatoria, 2));
                }
                foreach ($pie_pagina as $campos) {
                    fputcsv($fp, $campos);
                }
            } else {
                $pagina = 0;
            }
        } while ($pagina > 0);


        fclose($fp);
    }

    if (empty($contenido)) {
        $alerta = "No se encontraron registros.";
    } else {
        $alerta = 'Reporte generado correctamente,<a download="' . $titulo . '.csv" href="' . constant("url") . 'public/files/reporte.csv" class="btn btn-link">descargar</a>';
    }
}


require_once("pages/cotizaciones/exportar_vista.php");
