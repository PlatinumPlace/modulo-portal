<?php

$cotizaciones = new cotizaciones;

$url = $cotizaciones->obtener_url();
$alerta  = (isset($url[0])) ? $url[0] : "";
$contrato = $cotizaciones->lista_aseguradoras();
$emitida = array("Emitido", "En trámite");

if (isset($_POST["pdf"])) {

    $post = array(
        "contrato_id" => $_POST["contrato_id"],
        "tipo_cotizacion" => $_POST["tipo_cotizacion"],
        "tipo_reporte" => $_POST["tipo_reporte"],
        "desde" => $_POST["desde"],
        "hasta" => $_POST["hasta"]
    );

    header("Location:" . constant("url") . "cotizaciones/descargar/" . json_encode($post));
    exit();
}
if (isset($_POST["csv"])) {

    $contrato =  $cotizaciones->detalles_contrato($_POST["contrato_id"]);
    $lista = $cotizaciones->buscar_cotizaciones("Type", ucfirst($_POST["tipo_cotizacion"]));

    if (!empty($lista)) {

        // verificar csv
        if (!is_dir("files")) {
            mkdir("files", 0755, true);
        }
        $fp = fopen("files/reporte.csv", 'w');

        // encabezado
        $titulo = "Reporte " . ucfirst($_POST["tipo_reporte"]) . " " . ucfirst($_POST["tipo_cotizacion"]);
        $encabezado = array(
            array($contrato->getFieldValue("Socio")->getLookupLabel()),
            array($titulo),
            array("Aseguradora:", $contrato->getFieldValue("Aseguradora")->getLookupLabel()),
            array("Poliza:", $contrato->getFieldValue('No_P_liza')),
            array("Desde:", $_POST["desde"], "Hasta:", $_POST["hasta"]),
            array("Vendedor:", $_SESSION["usuario"]['nombre']),
            array("")
        );
        foreach ($encabezado as $campos) {
            fputcsv($fp, $campos);
        }

        // encabezado tabla
        if ($_POST["tipo_cotizacion"] == "auto") {
            $tabla_encabezado = array(
                array(
                    "Fecha Emision",
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
                    "Prima Neta",
                    "ISC",
                    "Prima Total"
                )
            );
            if ($_POST["tipo_reporte"] == "comisiones") {
                $tabla_encabezado[0][] = "Comision";
            }
        }
        foreach ($tabla_encabezado as $campos) {
            fputcsv($fp, $campos);
        }

        // cuerpo tabla
        $prima_neta_sumatoria = 0;
        $isc_sumatoria = 0;
        $prima_total_sumatoria = 0;
        $valor_asegurado_sumatoria = 0;
        $comision_sumatoria = 0;
        foreach ($lista as $resumen) {
            if (
                date("Y-m-d", strtotime($resumen->getFieldValue("Fecha_de_emisi_n")))  >= $_POST["desde"]
                and
                date("Y-m-d", strtotime($resumen->getFieldValue("Fecha_de_emisi_n"))) <= $_POST["hasta"]
                and
                $resumen->getFieldValue("Contact_Name")->getEntityId() == $_SESSION["usuario"]["id"]
            ) {

                $detalles = $cotizaciones->detalles_cotizaciones($resumen->getEntityId());

                // planes
                foreach ($detalles as $info) {
                    if (
                        $info->getFieldValue("Aseguradora")->getEntityId() == $contrato->getFieldValue("Aseguradora")->getEntityId()
                        and
                        $info->getFieldValue('Grand_Total') > 0
                    ) {
                        // detalles sobre los costos de los planes
                        $planes = $info->getLineItems();
                        foreach ($planes as $plan) {
                            $prima_neta = $plan->getTotalAfterDiscount();
                            $isc = $plan->getTaxAmount();
                            $prima_total = $plan->getNetTotal();
                        }
                        $comision = $info->getFieldValue('Comisi_n_Socio');

                        if ($_POST["tipo_reporte"] == "cotizaciones") {
                            $estado[] = "Cotizando";
                        } elseif ($_POST["tipo_reporte"] == "emisiones" or $_POST["tipo_reporte"] == "comisiones") {
                            $estado = array("En trámite", "Emitido");
                        }

                        //contenido
                        if (in_array($resumen->getFieldValue("Stage"), $estado)) {

                            $prima_neta_tabla = "RD$" .  number_format($prima_neta, 2);
                            $isc_tabla = "RD$" . number_format($isc, 2);
                            $prima_total_tabla = "RD$" . number_format($prima_total, 2);
                            $comision_tabla = "RD$" . number_format($comision, 2);
                            $valor_asegurado_tabla = "RD$" . number_format($resumen->getFieldValue('Valor_Asegurado'), 2);

                            if ($_POST["tipo_cotizacion"] == "auto") {
                                $tabla_contenido = array(
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
                                        $valor_asegurado_tabla,
                                        $resumen->getFieldValue('Plan'),
                                        $prima_neta_tabla,
                                        $isc_tabla,
                                        $prima_total_tabla
                                    )
                                );

                                $valor_asegurado_sumatoria += $resumen->getFieldValue('Valor_Asegurado');
                                $prima_neta_sumatoria += $prima_neta;
                                $isc_sumatoria += $isc;
                                $prima_total_sumatoria += $prima_total;

                                if ($_POST["tipo_reporte"] == "comisiones") {
                                    $tabla_contenido[0][] = $comision_tabla;

                                    $comision_sumatoria += $comision;
                                }
                            }
                            foreach ($tabla_contenido as $campos) {
                                fputcsv($fp, $campos);
                            }
                        }
                    }
                }
            }
        }

        if (!isset($tabla_contenido)) {
            fclose($fp);

            $alerta = "No existen resultados para la aseguradora seleccionada.";
        } else {

            $prima_neta_sumatoria = "RD$" . number_format($prima_neta_sumatoria, 2);
            $isc_sumatoria = "RD$" . number_format($isc_sumatoria, 2);
            $prima_total_sumatoria = "RD$" . number_format($prima_total_sumatoria, 2);
            $valor_asegurado_sumatoria = "RD$" . number_format($valor_asegurado_sumatoria, 2);
            $comision_sumatoria = "RD$" . number_format($comision_sumatoria, 2);

            if ($_POST["tipo_cotizacion"] == "auto") {
                $pie_pagina = array(
                    array(""),
                    array("Total Primas Netas:", $prima_neta_sumatoria),
                    array("Total ISC:", $isc_sumatoria),
                    array("Total Primas Totales:", $prima_total_sumatoria),
                    array("Total Valores Asegurados:", $valor_asegurado_sumatoria)
                );
                if ($_POST["tipo_reporte"] == "comisiones") {
                    $pie_pagina[5] = array("Total Comisiones:", $comision_sumatoria);
                }
            }
            foreach ($pie_pagina as $campos) {
                fputcsv($fp, $campos);
            }

            fclose($fp);

            $alerta = 'Reporte generado correctamente,<a download="' . $titulo . '.csv" href="' . constant("url") . 'files/reporte.csv" class="btn btn-link">descargar</a>';
        }
    } else {
        $alerta = "Ha ocurrido un error,vuelva a intentarlo";
    }
}

?>
<h2 class="text-uppercase text-center">
    Reporte de cotizaciones
</h2>

<div class="card">
    <div class="card-body">

        <?php if (!empty($alerta)) : ?>
            <div class="alert alert-primary" role="alert">
                <?= $alerta ?>
            </div>
        <?php endif ?>

        <form method="POST" action="<?= constant("url") ?>cotizaciones/exportar">

            <h5>Reporte</h5>
            <hr>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label class="font-weight-bold">Tipo</label>
                    <select name="tipo_reporte" class="form-control">
                        <option value="emisiones">Emisiones</option>
                        <option value="comisiones">Comisiones</option>
                        <option value="cotizaciones" selected>Cotizaciones</option>
                    </select>
                </div>

                <div class="form-group col-md-6">
                    <label class="font-weight-bold">Tipo de Cotización</label>
                    <select name="tipo_cotizacion" class="form-control">
                        <option value="auto" selected>Auto</option>
                    </select>
                </div>
            </div>

            <br>

            <h5>Aseguradora</h5>
            <hr>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label class="font-weight-bold">Nombre</label>
                    <select name="contrato_id" class="form-control" required>
                        <option value="" selected disabled>Selecciona una Aseguradora</option>
                        <?php
                        if (!empty($contrato)) {
                            foreach ($contrato as $id => $nombre_aseguradora) {
                                echo '<option value="' . $id . '">' . $nombre_aseguradora . '</option>';
                            }
                        }
                        ?>
                    </select>
                </div>
            </div>

            <br>

            <h5>Fecha</h5>
            <hr>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label class="font-weight-bold">Desde</label>
                    <input type="date" class="form-control" name="desde" required>
                </div>

                <div class="form-group col-md-6">
                    <label class="font-weight-bold">Hasta</label>
                    <input type="date" class="form-control" name="hasta" required>
                </div>
            </div>

            <br>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <button type="submit" name="csv" class="btn btn-primary">Exportar a CSV</button>
                    |
                    <button type="submit" name="pdf" class="btn btn-success">Exportar a PDF</button>
                </div>
            </div>

        </form>
    </div>
</div>