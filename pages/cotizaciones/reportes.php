<?php
$cotizaciones = new cotizaciones;

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
    $ruta_csv = "public/tmp/" . $titulo . ".csv";

    $prima_sumatoria = 0;
    $valor_sumatoria = 0;
    $comision_sumatoria = 0;

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
    }

    $prima_sumatoria = 0;
    $valor_sumatoria = 0;
    $comision_sumatoria = 0;


    $num_pagina = 1;
    do {
        $lista_cotizaciones = $cotizaciones->lista_cotizaciones($num_pagina);
        if (!empty($lista_cotizaciones)) {
            $num_pagina++;
            foreach ($lista_cotizaciones as $cotizacion) {
                if (
                    $cotizacion->getFieldValue('Grand_Total') > 0
                    and
                    date("Y-m-d", strtotime($cotizacion->getFieldValue("Fecha_de_emisi_n")))  >= $_POST["desde"]
                    and
                    date("Y-m-d", strtotime($cotizacion->getFieldValue("Fecha_de_emisi_n")))  <= $_POST["hasta"]
                ) {
                    if ($_POST["tipo_reporte"] == "cotizaciones" and $cotizacion->getFieldValue("Quote_Stage") == "En espera") {
                        $detalles_resumen = $cotizaciones->detalles_resumen($cotizacion->getFieldValue("Deal_Name")->getEntityId());
                        if ($_POST["tipo_cotizacion"] == "auto" and $detalles_resumen->getFieldValue('Type') == "Auto") {
                            if (empty($_POST["aseguradora_id"])) {
                                $prima_sumatoria += $cotizacion->getFieldValue('Grand_Total');
                                $valor_sumatoria += $detalles_resumen->getFieldValue('Valor_Asegurado');

                                $contenido_csv[] = array(
                                    date("Y-m-d", strtotime($cotizacion->getFieldValue("Fecha_de_emisi_n"))),
                                    date("Y-m-d", strtotime($cotizacion->getFieldValue("Valid_Till"))),
                                    $detalles_resumen->getFieldValue("Nombre") . " " . $detalles_resumen->getFieldValue("Apellidos"),
                                    $detalles_resumen->getFieldValue("RNC_Cedula"),
                                    $detalles_resumen->getFieldValue('Marca')->getLookupLabel(),
                                    $detalles_resumen->getFieldValue('Modelo')->getLookupLabel(),
                                    $detalles_resumen->getFieldValue('Tipo_de_Veh_culo'),
                                    $detalles_resumen->getFieldValue('A_o_de_Fabricacion'),
                                    $detalles_resumen->getFieldValue('Color'),
                                    $detalles_resumen->getFieldValue('Chasis'),
                                    $detalles_resumen->getFieldValue('Placa'),
                                    number_format($detalles_resumen->getFieldValue('Valor_Asegurado'), 2),
                                    number_format($cotizacion->getFieldValue('Grand_Total'), 2),
                                    $cotizacion->getFieldValue('Aseguradora')->getLookupLabel()
                                );
                            } elseif($_POST["aseguradora_id"] == $cotizacion->getFieldValue('Aseguradora')->getEntityId()) {
                                $prima_sumatoria += $cotizacion->getFieldValue('Grand_Total');
                                $valor_sumatoria += $detalles_resumen->getFieldValue('Valor_Asegurado');

                                $contenido_csv[] = array(
                                    date("Y-m-d", strtotime($cotizacion->getFieldValue("Fecha_de_emisi_n"))),
                                    date("Y-m-d", strtotime($cotizacion->getFieldValue("Valid_Till"))),
                                    $detalles_resumen->getFieldValue("Nombre") . " " . $detalles_resumen->getFieldValue("Apellidos"),
                                    $detalles_resumen->getFieldValue("RNC_Cedula"),
                                    $detalles_resumen->getFieldValue('Marca')->getLookupLabel(),
                                    $detalles_resumen->getFieldValue('Modelo')->getLookupLabel(),
                                    $detalles_resumen->getFieldValue('Tipo_de_Veh_culo'),
                                    $detalles_resumen->getFieldValue('A_o_de_Fabricacion'),
                                    $detalles_resumen->getFieldValue('Color'),
                                    $detalles_resumen->getFieldValue('Chasis'),
                                    $detalles_resumen->getFieldValue('Placa'),
                                    number_format($detalles_resumen->getFieldValue('Valor_Asegurado'), 2),
                                    number_format($cotizacion->getFieldValue('Grand_Total'), 2),
                                    $cotizacion->getFieldValue('Aseguradora')->getLookupLabel()
                                );
                            }
                        }
                    } elseif ($_POST["tipo_reporte"] == "emisiones" and $cotizacion->getFieldValue("Quote_Stage") == "Confirmada") {
                        $detalles_resumen = $cotizaciones->detalles_resumen($cotizacion->getFieldValue("Deal_Name")->getEntityId());
                        if ($_POST["tipo_cotizacion"] == "auto" and $detalles_resumen->getFieldValue('Type') == "Auto") {
                            if (empty($_POST["aseguradora_id"])) {
                                $prima_sumatoria += $cotizacion->getFieldValue('Grand_Total');
                                $valor_sumatoria += $detalles_resumen->getFieldValue('Valor_Asegurado');

                                $contenido_csv[] = array(
                                    date("Y-m-d", strtotime($cotizacion->getFieldValue("Fecha_de_emisi_n"))),
                                    date("Y-m-d", strtotime($cotizacion->getFieldValue("Valid_Till"))),
                                    $detalles_resumen->getFieldValue("Nombre") . " " . $detalles_resumen->getFieldValue("Apellidos"),
                                    $detalles_resumen->getFieldValue("RNC_Cedula"),
                                    $detalles_resumen->getFieldValue('Marca')->getLookupLabel(),
                                    $detalles_resumen->getFieldValue('Modelo')->getLookupLabel(),
                                    $detalles_resumen->getFieldValue('Tipo_de_Veh_culo'),
                                    $detalles_resumen->getFieldValue('A_o_de_Fabricacion'),
                                    $detalles_resumen->getFieldValue('Color'),
                                    $detalles_resumen->getFieldValue('Chasis'),
                                    $detalles_resumen->getFieldValue('Placa'),
                                    number_format($detalles_resumen->getFieldValue('Valor_Asegurado'), 2),
                                    number_format($cotizacion->getFieldValue('Grand_Total'), 2),
                                    $cotizacion->getFieldValue('Aseguradora')->getLookupLabel()
                                );
                            } elseif($_POST["aseguradora_id"] == $cotizacion->getFieldValue('Aseguradora')->getEntityId()) {
                                $prima_sumatoria += $cotizacion->getFieldValue('Grand_Total');
                                $valor_sumatoria += $detalles_resumen->getFieldValue('Valor_Asegurado');

                                $contenido_csv[] = array(
                                    date("Y-m-d", strtotime($cotizacion->getFieldValue("Fecha_de_emisi_n"))),
                                    date("Y-m-d", strtotime($cotizacion->getFieldValue("Valid_Till"))),
                                    $detalles_resumen->getFieldValue("Nombre") . " " . $detalles_resumen->getFieldValue("Apellidos"),
                                    $detalles_resumen->getFieldValue("RNC_Cedula"),
                                    $detalles_resumen->getFieldValue('Marca')->getLookupLabel(),
                                    $detalles_resumen->getFieldValue('Modelo')->getLookupLabel(),
                                    $detalles_resumen->getFieldValue('Tipo_de_Veh_culo'),
                                    $detalles_resumen->getFieldValue('A_o_de_Fabricacion'),
                                    $detalles_resumen->getFieldValue('Color'),
                                    $detalles_resumen->getFieldValue('Chasis'),
                                    $detalles_resumen->getFieldValue('Placa'),
                                    number_format($detalles_resumen->getFieldValue('Valor_Asegurado'), 2),
                                    number_format($cotizacion->getFieldValue('Grand_Total'), 2),
                                    $cotizacion->getFieldValue('Aseguradora')->getLookupLabel()
                                );
                            }
                        }
                    }
                }
            }
        } else {
            $num_pagina = 0;
        }
    } while ($num_pagina > 0);

    $contenido_csv[] = array("");
    $contenido_csv[] = array("Total Primas:", number_format($prima_sumatoria, 2, ".", " "));
    $contenido_csv[] = array("Total Valores:", number_format($valor_sumatoria, 2, ".", " "));


    if ($_POST["tipo_reporte"] == "emisiones") {
        $contenido_csv[] = array("Total Comisiones:", number_format($comision_sumatoria, 2, ".", " "));
    }

    if ($valor_sumatoria > 0) {
        if (!is_dir("public/tmp")) {
            mkdir("public/tmp", 0755, true);
        }

        $fp = fopen($ruta_csv, 'w');
        foreach ($contenido_csv as $campos) {
            fputcsv($fp, $campos);
        }
        fclose($fp);
    }

    $fileName = basename($ruta_csv);
    if (!empty($fileName) and file_exists($ruta_csv)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . $fileName . '"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($ruta_csv));
        readfile($ruta_csv);
        unlink($ruta_csv);
        exit;
    } else {
        $alerta = 'Exportación fallida, no se encontraron cotizaciones.';
    }
}
require_once 'pages/layout/header_main.php';
?>
<h1 class="mt-4 text-uppercase">exportar cotizaciones</h1>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item"><a href="<?= constant("url") ?>cotizaciones/buscar">Cotizaciones</a></li>
    <li class="breadcrumb-item active">Reportes</li>
</ol>
<form class="row justify-content-center" method="POST" action="<?= constant("url") ?>cotizaciones/reportes">
    <div class="col-lg-10">
        <?php if (!empty($alerta)) : ?>
            <div class="alert alert-primary" role="alert">
                <?= $alerta ?>
            </div>
        <?php endif ?>
        <div class="card mb-4">
            <div class="card-body">
                <div class="form-row">
                    <div class="col-md-6">
                        <div class="form-groups">
                            <label class="small mb-1">Tipo de reporte</label>
                            <select name="tipo_reporte" class="form-control">
                                <option value="cotizaciones" selected>Cotizaciones</option>
                                <option value="emisiones">Emisiones</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-groups">
                            <label class="small mb-1">Tipo de cotización</label>
                            <select name="tipo_cotizacion" class="form-control">
                                <option value="auto" selected>Auto</option>
                            </select>
                        </div>
                    </div>
                </div>

                <br>

                <div class="form-row">
                    <div class="col-md-6">
                        <div class="form-groups">
                            <label class="small mb-1">Desde</label>
                            <input type="date" class="form-control" name="desde" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-groups">
                            <label class="small mb-1">Hasta</label>
                            <input type="date" class="form-control" name="hasta" required>
                        </div>
                    </div>
                </div>

                <br>

                <div class="form-row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="small mb-1">Aseguradora</label>
                            <select name="aseguradora_id" class="form-control">
                                <option value="" selected>Todas</option>
                                <?php
                                $lista_contratos = $cotizaciones->lista_contratos();
                                foreach ($lista_contratos as $contrato) {
                                    echo '<option value="' . $contrato->getFieldValue('Aseguradora')->getEntityId() . '">' . $contrato->getFieldValue('Aseguradora')->getLookupLabel() . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>

                <br>

                <div class="form-row">
                    <div class="col-md-6">
                        <button type="submit" name="csv" class="btn btn-primary">Exportar a CSV</button>
                        |
                        <button type="submit" name="pdf" class="btn btn-success">Exportar a PDF</button>
                    </div>
                </div>
            </div>
        </div>
</form>
<?php require_once 'pages/layout/footer_main.php'; ?>