<?php
$api = new api();
$url = obtener_url();
$alerta = (isset($url[1])) ? $url[1] : null;

if (isset($_POST["csv"])) {
    $titulo = "Reporte " . ucfirst($_POST["estado_cotizacion"]) . " " . $_POST["tipo_cotizacion"];
    $contenido_csv = array(
        array(
            $_SESSION["usuario"]['empresa_nombre']
        ),
        array(
            $titulo
        ),
        array(
            "Desde:",
            $_POST["desde"],
            "Hasta:",
            $_POST["hasta"]
        ),
        array(
            "Vendedor:",
            $_SESSION["usuario"]['nombre']
        ),
        array(
            ""
        )
    );

    switch ($_POST["tipo_cotizacion"]) {
        case 'Auto':
            switch ($_POST["estado_cotizacion"]) {
                case 'pendientes':
                    $contenido_csv[] = array(
                        "Emision",
                        "Vigencia",
                        "Deudor",
                        "RNC/Cédula",
                        "Marca",
                        "Modelo",
                        "Tipo",
                        "Año",
                        "Valor Aseguradora",
                        "Prima",
                        "Aseguradora"
                    );
                    break;

                case 'emitidas':
                    $contenido_csv[] = array(
                        "Emision",
                        "Vigencia",
                        "Póliza",
                        "Deudor",
                        "RNC/Cédula",
                        "Marca",
                        "Modelo",
                        "Tipo",
                        "Año",
                        "Chasis",
                        "Valor Aseguradora",
                        "Prima",
                        "Comisión",
                        "Aseguradora"
                    );
                    break;
            }
            break;
    }

    $prima_sumatoria = 0;
    $valor_sumatoria = 0;
    $comision_sumatoria = 0;
    $num_pag = 1;

    do {
        $criterio = "Contact_Name:equals:" . $_SESSION["usuario"]["id"];
        $cotizaciones = $api->searchRecordsByCriteria("Quotes", $criterio, $num_pag);
        if (!empty($cotizaciones)) {
            $num_pag++;
            foreach ($cotizaciones as $cotizacion) {
                switch ($_POST["estado_cotizacion"]) {
                    case 'pendientes':
                        if (date("Y-m-d", strtotime($cotizacion->getFieldValue("Fecha_emisi_n"))) >= $_POST["desde"] and date("Y-m-d", strtotime($cotizacion->getFieldValue("Fecha_emisi_n"))) <= $_POST["hasta"] and $cotizacion->getFieldValue("Tipo") == $_POST["tipo_cotizacion"] and $cotizacion->getFieldValue('Deal_Name') == null) {
                            $planes = $cotizacion->getLineItems();
                            foreach ($planes as $plan) {
                                if ($plan->getNetTotal() > 0 and (empty($_POST["aseguradora"]) or $_POST["aseguradora"] == $plan->getDescription())) {
                                    switch ($_POST["tipo_cotizacion"]) {
                                        case 'Auto':
                                            $prima_sumatoria += $plan->getNetTotal();
                                            $valor_sumatoria += $cotizacion->getFieldValue('Valor_Asegurado');

                                            $contenido_csv[] = array(
                                                date("Y-m-d", strtotime($cotizacion->getFieldValue("Fecha_emisi_n"))),
                                                date("Y-m-d", strtotime($cotizacion->getFieldValue("Valid_Till"))),
                                                $cotizacion->getFieldValue('Nombre') . " " . $cotizacion->getFieldValue('Apellido'),
                                                $cotizacion->getFieldValue('RNC_C_dula'),
                                                $cotizacion->getFieldValue('Marca')->getLookupLabel(),
                                                $cotizacion->getFieldValue('Modelo')->getLookupLabel(),
                                                $cotizacion->getFieldValue('Tipo_Veh_culo'),
                                                $cotizacion->getFieldValue('A_o_Fabricaci_n'),
                                                number_format($cotizacion->getFieldValue('Valor_Asegurado'), 2),
                                                number_format($plan->getNetTotal(), 2),
                                                $plan->getDescription()
                                            );
                                            break;
                                    }
                                }
                            }
                        }
                        break;

                    case 'emitidas':
                        if (date("Y-m-d", strtotime($cotizacion->getFieldValue("Fecha_emisi_n"))) >= $_POST["desde"] and date("Y-m-d", strtotime($cotizacion->getFieldValue("Fecha_emisi_n"))) <= $_POST["hasta"] and $cotizacion->getFieldValue("Tipo") == $_POST["tipo_cotizacion"] and $cotizacion->getFieldValue('Deal_Name') != null) {
                            $planes = $cotizacion->getLineItems();
                            foreach ($planes as $plan) {
                                if ($plan->getNetTotal() > 0 and (empty($_POST["aseguradora"]) or $_POST["aseguradora"] == $plan->getDescription())) {
                                    switch ($_POST["tipo_cotizacion"]) {
                                        case 'Auto':
                                            $trato = $api->getRecord("Deals", $cotizacion->getFieldValue('Deal_Name')->getEntityId());
                                            $prima_sumatoria += $plan->getNetTotal();
                                            $valor_sumatoria += $cotizacion->getFieldValue('Valor_Asegurado');
                                            $comision_sumatoria += $trato->getFieldValue('Comisi_n_Socio');

                                            $contenido_csv[] = array(
                                                date("Y-m-d", strtotime($cotizacion->getFieldValue("Fecha_emisi_n"))),
                                                date("Y-m-d", strtotime($cotizacion->getFieldValue("Valid_Till"))),
                                                $trato->getFieldValue('P_liza')->getLookupLabel(),
                                                $trato->getFieldValue('Contact_Name')->getLookupLabel(),
                                                $cotizacion->getFieldValue('RNC_C_dula'),
                                                $cotizacion->getFieldValue('Marca')->getLookupLabel(),
                                                $cotizacion->getFieldValue('Modelo')->getLookupLabel(),
                                                $cotizacion->getFieldValue('Tipo_Veh_culo'),
                                                $cotizacion->getFieldValue('A_o_Fabricaci_n'),
                                                $trato->getFieldValue('Bien')->getLookupLabel(),
                                                number_format($cotizacion->getFieldValue('Valor_Asegurado'), 2),
                                                number_format($plan->getNetTotal(), 2),
                                                number_format($trato->getFieldValue('Comisi_n_Socio'), 2),
                                                $plan->getDescription()
                                            );
                                            break;
                                    }
                                }
                            }
                        }
                        break;
                }
            }
        } else {
            $num_pag = 0;
        }
    } while ($num_pag > 0);

    $contenido_csv[] = array(
        ""
    );
    $contenido_csv[] = array(
        "Total Primas:",
        number_format($prima_sumatoria, 2)
    );
    $contenido_csv[] = array(
        "Total Valores:",
        number_format($valor_sumatoria, 2)
    );
    if ($_POST["estado_cotizacion"] == "emitidas") {
        $contenido_csv[] = array(
            "Total Comisiones:",
            number_format($comision_sumatoria, 2)
        );
    }

    if ($valor_sumatoria > 0) {
        if (!is_dir("public/path")) {
            mkdir("public/path", 0755, true);
        }

        $ruta_csv = "public/path/" . $titulo . ".csv";
        $fp = fopen($ruta_csv, 'w');
        foreach ($contenido_csv as $campos) {
            fputcsv($fp, $campos);
        }
        fclose($fp);

        $fileName = basename($ruta_csv);
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . $fileName . '"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: ');
        header('Content-Length: ' . filesize($ruta_csv));
        readfile($ruta_csv);
        unlink($ruta_csv);
        exit();
    } else {
        $alerta = 'No se encontraton resultados';
    }
}

if (isset($_POST["pdf"])) {
    $titulo = "Reporte Pendientes " . $_POST["tipo_cotizacion"];
    require_once "views/descargar/reporte.php";
    exit();
}

require_once 'views/layout/header.php';
?>
<h1 class="mt-4 text-uppercase text-center">reporte de cotizaciones</h1>

<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item"><a href="<?= constant("url") ?>">Panel de Control</a></li>
    <li class="breadcrumb-item active"><a href="<?= constant("url") ?>reportes">Reportes</a></li>
</ol>

<div class="row justify-content-center">
    <div class="col-lg-10">

        <?php if (!empty($alerta)) : ?>
            <div class="alert alert-primary" role="alert">
                <?= $alerta ?>
            </div>
        <?php endif ?>

        <div class="card mb-4">
            <div class="card-body">
                <form method="POST" action="<?= constant("url") ?>reportes">

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label font-weight-bold">Tipo de cotización</label>
                        <div class="col-sm-9">
                            <select name="tipo_cotizacion" class="form-control">
                                <option value="Auto" selected>Auto</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label font-weight-bold">Estado de la cotización</label>
                        <div class="col-sm-9">
                            <select name="estado_cotizacion" class="form-control">
                                <option value="pendientes" selected>Pendientes</option>
                                <option value="emitidas">Emitidos</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label font-weight-bold">Desde</label>
                        <div class="col-sm-9">
                            <input type="date" class="form-control" name="desde" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label font-weight-bold">Hasta</label>
                        <div class="col-sm-9">
                            <input type="date" class="form-control" name="hasta" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label font-weight-bold">Aseguradora</label>
                        <div class="col-sm-9">
                            <select name="aseguradora" class="form-control">
                                <option value="" selected>Todas</option>
                                <?php
                                $criterio = "Socio:equals:" . $_SESSION["usuario"]["empresa_id"];
                                $contratos = $$api->searchRecordsByCriteria("Contratos", $criterio);
                                $aseguradoras = array();
                                foreach ($contratos as $contrato) {
                                    $plan = $$api->getRecord("Products", $contrato->getFieldValue('Plan')->getEntityId());
                                    $aseguradoras[] = $plan->getFieldValue('Vendor_Name')->getLookupLabel();
                                }
                                $aseguradoras = array_unique($aseguradoras);
                                foreach ($aseguradoras as $indice => $valor) {
                                    echo '<option value="' . $valor . '">' . $valor . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                    <br>
                    <button type="submit" name="csv" class="btn btn-primary">Exportar a CSV</button>
                    |
                    <button type="submit" name="pdf" class="btn btn-success">Exportar a PDF</button>

                </form>
            </div>
        </div>
    </div>
</div>

<?php require_once 'views/layout/footer.php'; ?>