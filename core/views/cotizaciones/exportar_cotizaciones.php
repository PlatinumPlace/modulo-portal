<?php


/*
    public function reporte_csv($titulo_reporte, $reporte_tipo, $tipo, $inicio, $fin)
    {
        $fp = fopen('public/tmp/reporte.csv', 'w');

        foreach ($titulo_reporte as $campos) {
            fputcsv($fp, $campos);
        }

        $cotizaciones = $this->buscar("Type", $tipo);

        if (!empty($cotizaciones)) {

            switch ($reporte_tipo) {
                case 'polizas':
                    $filas = array(
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
                            "Prima Neta"
                        )
                    );
                    break;
                case 'comisiones':
                    $filas = array(
                        array(
                            "Fecha de emision",
                            "Nombre Asegurado",
                            "Cedula",
                            "Bien Asegurado",
                            "Valor Asegurado",
                            "Plan",
                            "Prima Total",
                            "Comision"
                        )
                    );
                    break;
                case 'cotizaciones':
                    $filas = array(
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
                            "Plan"
                        )
                    );
                    break;
            }

            foreach ($filas as $campos) {
                fputcsv($fp, $campos);
            }

            $total_valor_asegurado = 0;
            $total_prima = 0;
            $total_comision = 0;
            $emitida = array("Emitido", "En trámite");
            foreach ($cotizaciones as $cotizacion) {

                if (
                    date("Y-m-d", strtotime($cotizacion->getFieldValue("Fecha_de_emisi_n")))  > $_POST['inicio']
                    and
                    date("Y-m-d", strtotime($cotizacion->getFieldValue("Fecha_de_emisi_n"))) < $_POST['fin']
                ) {

                    switch ($reporte_tipo) {

                        case 'polizas':

                            if (in_array($cotizacion->getFieldValue("Stage"), $emitida)) {

                                $total_valor_asegurado += $cotizacion->getFieldValue('Valor_Asegurado');
                                $total_prima += $cotizacion->getFieldValue('Prima_Neta');

                                $filas = array(
                                    array(
                                        date("Y-m-d", strtotime($cotizacion->getFieldValue("Fecha_de_emisi_n"))),
                                        $cotizacion->getFieldValue("Nombre") . " " . $cotizacion->getFieldValue("Apellido"),
                                        $cotizacion->getFieldValue("RNC_Cedula"),
                                        $cotizacion->getFieldValue('Marca')->getLookupLabel(),
                                        $cotizacion->getFieldValue('Modelo')->getLookupLabel(),
                                        $cotizacion->getFieldValue('A_o_de_Fabricacion'),
                                        $cotizacion->getFieldValue('Color'),
                                        $cotizacion->getFieldValue('Chasis'),
                                        $cotizacion->getFieldValue('Placa'),
                                        round($cotizacion->getFieldValue('Valor_Asegurado'), 2),
                                        $cotizacion->getFieldValue('Plan'),
                                        $cotizacion->getFieldValue('Prima_Neta')
                                    )
                                );
                            }

                            break;

                        case 'comisiones':

                            if (in_array($cotizacion->getFieldValue("Stage"), $emitida)) {


                                $total_valor_asegurado += $cotizacion->getFieldValue('Valor_Asegurado');
                                $total_prima += $cotizacion->getFieldValue('Prima_Total');
                                $total_comision += $cotizacion->getFieldValue('Comisi_n_Socio');

                                $filas = array(
                                    array(
                                        date("Y-m-d", strtotime($cotizacion->getFieldValue("Fecha_de_emisi_n"))),
                                        $cotizacion->getFieldValue("Nombre") . " " . $cotizacion->getFieldValue("Apellido"),
                                        $cotizacion->getFieldValue("RNC_Cedula"),
                                        $cotizacion->getFieldValue("Type"),
                                        round($cotizacion->getFieldValue('Valor_Asegurado'), 2),
                                        $cotizacion->getFieldValue('Plan'),
                                        $cotizacion->getFieldValue('Prima_Total'),
                                        $cotizacion->getFieldValue('Comisi_n_Socio')
                                    )
                                );
                            }

                            break;

                        case 'cotizaciones':

                            if (!in_array($cotizacion->getFieldValue("Stage"), $emitida)) {

                                $total_valor_asegurado += $cotizacion->getFieldValue('Valor_Asegurado');

                                $filas = array(
                                    array(
                                        date("Y-m-d", strtotime($cotizacion->getFieldValue("Fecha_de_emisi_n"))),
                                        $cotizacion->getFieldValue("Nombre") . " " . $cotizacion->getFieldValue("Apellido"),
                                        $cotizacion->getFieldValue("RNC_Cedula"),
                                        $cotizacion->getFieldValue('Marca')->getLookupLabel(),
                                        $cotizacion->getFieldValue('Modelo')->getLookupLabel(),
                                        $cotizacion->getFieldValue('A_o_de_Fabricacion'),
                                        $cotizacion->getFieldValue('Color'),
                                        $cotizacion->getFieldValue('Chasis'),
                                        $cotizacion->getFieldValue('Placa'),
                                        round($cotizacion->getFieldValue('Valor_Asegurado'), 2),
                                        $cotizacion->getFieldValue('Plan')
                                    )
                                );
                            }

                            break;
                    }

                    foreach ($filas as $campos) {
                        fputcsv($fp, $campos);
                    }
                }
            }

            switch ($reporte_tipo) {
                case 'polizas':
                    $filas = array(
                        array(""),
                        array("Total Valor Asegurado:", $total_valor_asegurado),
                        array("Total Prima Neta:", $total_prima),
                    );
                    break;
                case 'comisiones':
                    $filas = array(
                        array(""),
                        array("Total Valor Asegurado:", $total_valor_asegurado),
                        array("Total Prima:", $total_prima),
                    );
                    break;
                case 'cotizaciones':
                    $filas = array(
                        array(""),
                        array("Total Valor Asegurado:", $total_valor_asegurado)
                    );
                    break;
            }

            foreach ($filas as $campos) {
                fputcsv($fp, $campos);
            }


            fclose($fp);

            return $titulo_reporte[1][0];
        } else {
            fclose($fp);
        }
    }

    public function exportar_excel_poliza($contrato_id)
    {
        $contrato = $this->getRecord("Contratos", $contrato_id);
        $resultados = $this->buscar_cotizaciones("Aseguradora", $contrato->getFieldValue("Aseguradora")->getEntityId());
        if (!empty($resultados)) {
        }
    }
    public function exportar_excel()
    {
        $contrato = $this->getRecord("Contratos", $contrato_id);
        $resultados = $this->buscar_cotizaciones("Aseguradora", $contrato->getFieldValue("Aseguradora")->getEntityId());
        if (!empty($resultados)) {
            $fp = fopen('public/tmp/reporte.xlsx', 'w');
            $titulo = "Reporte " . ucfirst($_POST['reporte_tipo']) . " de " . $_POST['tipo'];
            fputs($fp, $contrato->getFieldValue("Socio")->getLookupLabel() . "\n");
            fputs($fp, $titulo . "\n");
            fputs($fp, "Aseguradora:" . "\t");
            fputs($fp, $contrato->getFieldValue("Aseguradora")->getLookupLabel() . "\n");
            fputs($fp, "Poliza:" . "\t");
            fputs($fp, $contrato->getFieldValue('No_P_liza') . "\n");
            fputs($fp, "Desde:" . "\t");
            fputs($fp, $_POST['inicio'] . "\n");
            fputs($fp, "Hasta" . "\t");
            fputs($fp, $_POST['fin'] . "\n");
            fputs($fp, "Vendedor" . "\t");
            fputs($fp, $_SESSION['usuario_nombre'] . "\n");
            fputs($fp, "Formato de moneda:" . "\t");
            fputs($fp, "RD$" . "\n");
            fputs($fp, "\n");
            switch ($_POST['reporte_tipo']) {
                case 'polizas':
                    $filas = array("Fecha de emision", "Nombre Asegurado", "Cedula", "Marca", "Modelo", "Ano", "Chasis", "Valor Aseg.", "Prima Neta", "Plan");
                    break;
                case 'comisiones':
                    $filas = array("Fecha de emision", "Nombre Asegurado", "Cedula", "Valor Aseg.", " Prima Total ", "Plan", "Comision");
                    break;
                case 'cotizaciones':
                    $filas = array("Fecha de emision", "Nombre Asegurado", "Cedula", "Marca", "Modelo", "Ano", "Chasis", "Valor Aseg.", "Plan");
                    break;
            }
            foreach ($filas as $campo => $valor) {
                fputs($fp, $valor . "\t");
            }
            fputs($fp, "\n");
            $total_prima = 0;
            $total_comision = 0;
            foreach ($resultados as $resumen) {
                if (
                    $resumen->getFieldValue("Type") == $_POST['tipo']
                    and
                    date("Y-m-d", strtotime($resumen->getFieldValue("Fecha_de_emisi_n")))  > $_POST['inicio']
                    and
                    date("Y-m-d", strtotime($resumen->getFieldValue("Fecha_de_emisi_n"))) < $_POST['fin']
                ) {
                    $cotizacion = $this->cotizacion_detalles($resumen->getEntityId());
                    $prima_total = round($cotizacion->getFieldValue("Grand_Total"), 2);
                    $planes = $cotizacion->getLineItems();
                    foreach ($planes as $plan) {
                        $prima_neta = round($plan->getTotalAfterDiscount(), 2);
                    }
                    $comision = $cotizacion->getFieldValue("Importe_Socio");
                    switch ($_POST['reporte_tipo']) {
                        case 'polizas':
                            fputs($fp, date("Y-m-d", strtotime($resumen->getFieldValue("Fecha_de_emisi_n"))) . "\t");
                            fputs($fp, $resumen->getFieldValue("Nombre") . " " . $resumen->getFieldValue("Apellido") . "\t");
                            fputs($fp, $resumen->getFieldValue("RNC_Cedula") . "\t");
                            fputs($fp, $resumen->getFieldValue('Marca')->getLookupLabel() . "\t");
                            fputs($fp, $resumen->getFieldValue('Modelo')->getLookupLabel() . "\t");
                            fputs($fp, $resumen->getFieldValue('A_o_de_Fabricacion') . "\t");
                            fputs($fp, $resumen->getFieldValue('Chasis') . "\t");
                            fputs($fp, round($resumen->getFieldValue('Valor_Asegurado'), 2) . "\t");
                            fputs($fp, $prima_total . "\t");
                            fputs($fp, $resumen->getFieldValue('Plan') . "\t");
                            break;
                    }
                    fputs($fp, "\n");
                }
            }
            switch ($_POST['reporte_tipo']) {
                case 'polizas':
                    break;
            }
            fclose($fp);
            return $titulo . ".xlsx";
        }
        /*
          if ($_POST['reporte_tipo'] == "polizas") {
                        $total_prima += $prima_ci;
                        fputcsv(
                            $csv,
                            array(
                                date("Y-m-d", strtotime($oferta->getFieldValue("Fecha_de_emisi_n"))),
                                $oferta->getFieldValue("Nombre") . " " . $oferta->getFieldValue("Apellido"),
                                $oferta->getFieldValue("RNC_Cedula"),
                                $oferta->getFieldValue('Marca')->getLookupLabel(),
                                $oferta->getFieldValue('Modelo')->getLookupLabel(),
                                $oferta->getFieldValue('A_o_de_Fabricacion'),
                                $oferta->getFieldValue('Chasis'),
                                round($oferta->getFieldValue('Valor_Asegurado'), 2),
                                $prima_ci,
                                $oferta->getFieldValue('Plan')
                            ),
                            ","
                        );
                    } elseif ($_POST['reporte_tipo'] == "comisiones") {
                        $total_prima += $prima_si;
                        $total_comision += $comision;
                        fputcsv(
                            $csv,
                            array(
                                date("Y-m-d", strtotime($oferta->getFieldValue("Fecha_de_emisi_n"))),
                                $oferta->getFieldValue("Nombre") . " " . $oferta->getFieldValue("Apellido"),
                                $oferta->getFieldValue("RNC_Cedula"),
                                round($oferta->getFieldValue('Valor_Asegurado'), 2),
                                $prima_si,
                                $oferta->getFieldValue('Plan'),
                                $comision
                            ),
                            ","
                        );
                    }
            
            if ($_POST['reporte_tipo'] == "polizas") {
                fputcsv($csv,  array("", "", "", "", "", "", "", "Total", $total_prima), ",");
            } elseif ($_POST['reporte_tipo'] == "comisiones") {
                fputcsv($csv,  array("", "", "", "Total", $total_prima, "Total", $total_comision), ",");
            }
            fclose($csv);
            $nombre_csv = "Reporte de  " . $_POST['reporte_tipo'] . " de " . $_POST['tipo'] . " de " . $contrato->getFieldValue("Aseguradora")->getLookupLabel();        } else {
            $alerta =  "El reporte esta vacio.";
        }
        

*/
/*
$aseguradoras = $this->contrato->aseguradoras();

        if (isset($_POST["csv"])) {

            switch ($_POST['reporte_tipo']) {

                case 'polizas':
                    $titulo_reporte = $this->contrato->titular_reporte_csv($_POST['contrato_id'], $_POST['reporte_tipo'], $_POST['tipo'], $_POST['inicio'], $_POST['fin']);
                    $nombre_reporte = $this->cotizacion->reporte_csv($titulo_reporte, $_POST['reporte_tipo'], $_POST['tipo'], $_POST['inicio'], $_POST['fin']);
                    break;
            }
        }

        if (!empty($nombre_reporte)) {

            $alerta = "Reporte generado exitosamente. "
                .
                '<a href="' . constant("url") . 'public/tmp/reporte.csv" download="' . $nombre_reporte . '.csv" class="btn btn-link">Descargar</a>';
        } else {

            $alerta = "El reporte no se genero.";
        }
*/
?>

<form enctype="multipart/form-data" method="POST" action="<?= constant('url') ?>cotizaciones/exportar_csv">


    <?php if ($_POST) : ?>
        <div class="alert alert-primary" role="alert">
            <?= $alerta ?>
        </div>
    <?php endif ?>


    <div class="card">
        <div class="card-body">
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Tipo de reporte</label>
                <div class="col-sm-4">
                    <select name="tipo_reporte" class="form-control">
                        <option value="emisiones" selected>Pólizas emitidas</option>
                        <option value="cotizaciones">Cotizaciones</option>
                        <option value="comisiones">Comisiones</option>
                    </select>
                </div>
                <label class="col-sm-2 col-form-label">Tipo de cotización</label>
                <div class="col-sm-4">
                    <select name="tipo_cotizacion" class="form-control">
                        <option value="Auto" selected>Auto</option>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Aseguradora</label>
                <div class="col-sm-4">
                    <select name="contrato_id" class="form-control" required>
                        <option value="" selected disabled>Selecciona una Aseguradora</option>
                        <?php

                        foreach ($contratos as $id => $nombre_aseguradora) {
                            echo '<option value="' . $id . '">' . $nombre_aseguradora . '</option>';
                        }

                        ?>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Desde</label>
                <div class="col-sm-4">
                    <input type="date" class="form-control" name="desde" required>
                </div>
                <label class="col-sm-2 col-form-label">Hasta</label>
                <div class="col-sm-4">
                    <input type="date" class="form-control" name="hasta" required>
                </div>
            </div>
        </div>
    </div>

    <br>

    <div class="row">

        <div class="col-md-7">
            &nbsp;
        </div>

        <div class="col-md-5">
            <div class="card">
                <h5 class="card-header">Opciones</h5>
                <div class="card-body">
                    <button type="submit" name="csv" class="btn btn-primary">Exportar a CSV</button>
                    |
                    <button type="submit" name="pdf" class="btn btn-success">Exportar a PDF</button>
                </div>
            </div>
        </div>

    </div>

</form>