<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

    <title><?= $titulo ?></title>
    <link rel="icon" type="image/png" href="<?= constant("url") ?>public/img/logo.png">
</head>

<body>
    <div class="container">

        <div class="row">
            <div class="col-4">
                <img src="<?= constant("url") ?>public/img/logo.png" height="200" width="150">
            </div>

            <div class="col-8">
                <div class="row">
                    <div class="col-6">
                        <b><?= $_SESSION["usuario"]['empresa_nombre'] ?></b> <br>
                        <b><?= $titulo ?></b> <br>
                        <b>Desde:</b> <br>
                        <b>Hasta:</b> <br>
                        <b>Vendedor:</b>
                    </div>

                    <div class="col-6">
                        &nbsp; <br>
                        &nbsp; <br>
                        <?= $post["desde"] ?> <br>
                        <?= $post["hasta"] ?> <br>
                        <?= $_SESSION["usuario"]['nombre'] ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12">
            &nbsp;
        </div>

        <div class="col-12">
            <table class="table table-sm">
                <thead>
                    <tr class="bg-primary text-white">
                        <?php if ($post["tipo_cotizacion"] == "auto") : ?>
                            <th scope="col">Emision</th>
                            <th scope="col">Vigencia</th>
                            <th scope="col">Marca</th>
                            <th scope="col">Modelo</th>
                            <th scope="col">Tipo</th>
                            <th scope="col">Valor</th>
                            <th scope="col">Prima</th>
                            <th scope="col">Aseguradora</th>
                            <?php if ($post["tipo_reporte"] == "comisiones") : ?>
                                <th scope="col">Comisión</th>
                            <?php endif ?>
                        <?php endif ?>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($post["tipo_cotizacion"] == "auto") {
                        do {
                            $cotizaciones = $this->searchRecordsByCriteria("Quotes", $criterio, $pagina, 200);
                            if (!empty($cotizaciones)) {
                                $pagina++;
                                foreach ($cotizaciones as $cotizacion) {
                                    if ($cotizacion->getFieldValue('Grand_Total') > 0) {
                                        $resumen =  $this->getRecord("Deals", $cotizacion->getFieldValue("Deal_Name")->getEntityId());
                                        if ($post["tipo_reporte"] == "cotizaciones") {
                                            if (
                                                date("Y-m-d", strtotime($resumen->getFieldValue("Fecha_de_emisi_n")))  >= $post["desde"]
                                                and
                                                date("Y-m-d", strtotime($resumen->getFieldValue("Fecha_de_emisi_n"))) <= $post["hasta"]
                                                and
                                                $resumen->getFieldValue("Stage") == "Cotizando"
                                                and
                                                $resumen->getFieldValue("Type") == "Auto"
                                            ) {
                                                if (empty($post["aseguradora_id"])) {
                                                    $prima_sumatoria += $resumen->getFieldValue('Valor_Asegurado');
                                                    $valor_sumatoria += $cotizacion->getFieldValue('Grand_Total');
                                                    echo "<tr>";
                                                    echo '<th scope="col">' . date("Y-m-d", strtotime($resumen->getFieldValue("Fecha_de_emisi_n"))) . "</th>";
                                                    echo "<td>" . date("Y-m-d", strtotime($resumen->getFieldValue("Closing_Date"))) . "</td>";
                                                    echo "<td>" . $resumen->getFieldValue('Marca')->getLookupLabel() . "</td>";
                                                    echo "<td>" . $resumen->getFieldValue('Modelo')->getLookupLabel() . "</td>";
                                                    echo "<td>" . $resumen->getFieldValue('Tipo_de_veh_culo') . "</td>";
                                                    echo "<td>" . number_format($resumen->getFieldValue('Valor_Asegurado'), 2) . "</td>";
                                                    echo "<td>" . number_format($cotizacion->getFieldValue('Grand_Total'), 2) . "</td>";
                                                    echo "<td>" . $cotizacion->getFieldValue('Aseguradora')->getLookupLabel() . "</td>";
                                                    echo "</tr>";
                                                } elseif (!empty($post["aseguradora_id"]) and $cotizacion->getFieldValue("Aseguradora")->getEntityId() == $post["aseguradora_id"]) {
                                                    $prima_sumatoria += $resumen->getFieldValue('Valor_Asegurado');
                                                    $valor_sumatoria += $cotizacion->getFieldValue('Grand_Total');
                                                    echo "<tr>";
                                                    echo '<th scope="col">' . date("Y-m-d", strtotime($resumen->getFieldValue("Fecha_de_emisi_n"))) . "</th>";
                                                    echo "<td>" . date("Y-m-d", strtotime($resumen->getFieldValue("Closing_Date"))) . "</td>";
                                                    echo "<td>" . $resumen->getFieldValue('Marca')->getLookupLabel() . "</td>";
                                                    echo "<td>" . $resumen->getFieldValue('Modelo')->getLookupLabel() . "</td>";
                                                    echo "<td>" . $resumen->getFieldValue('Tipo_de_veh_culo') . "</td>";
                                                    echo "<td>" . number_format($resumen->getFieldValue('Valor_Asegurado'), 2) . "</td>";
                                                    echo "<td>" . number_format($cotizacion->getFieldValue('Grand_Total'), 2) . "</td>";
                                                    echo "<td>" . $cotizacion->getFieldValue('Aseguradora')->getLookupLabel() . "</td>";
                                                    echo "</tr>";
                                                }
                                            }
                                        } elseif ($post["tipo_reporte"] == "emisiones") {
                                            if (
                                                date("Y-m-d", strtotime($resumen->getFieldValue("Fecha_de_emisi_n")))  >= $post["desde"]
                                                and
                                                date("Y-m-d", strtotime($resumen->getFieldValue("Fecha_de_emisi_n"))) <= $post["hasta"]
                                                and
                                                in_array($resumen->getFieldValue("Stage"), $emitida)
                                                and
                                                $resumen->getFieldValue("Type") == "Auto"
                                            ) {
                                                if (empty($post["aseguradora_id"])) {
                                                    $prima_sumatoria += $resumen->getFieldValue('Valor_Asegurado');
                                                    $valor_sumatoria += $cotizacion->getFieldValue('Grand_Total');
                                                    $comision_sumatoria += $cotizacion->getFieldValue('Comisi_n_Socio');
                                                    echo "<tr>";
                                                    echo '<th scope="col">' . date("Y-m-d", strtotime($resumen->getFieldValue("Fecha_de_emisi_n"))) . "</th>";
                                                    echo "<td>" . date("Y-m-d", strtotime($resumen->getFieldValue("Closing_Date"))) . "</td>";
                                                    echo "<td>" . $resumen->getFieldValue('Marca')->getLookupLabel() . "</td>";
                                                    echo "<td>" . $resumen->getFieldValue('Modelo')->getLookupLabel() . "</td>";
                                                    echo "<td>" . $resumen->getFieldValue('Tipo_de_veh_culo') . "</td>";
                                                    echo "<td>" . number_format($resumen->getFieldValue('Valor_Asegurado'), 2) . "</td>";
                                                    echo "<td>" . number_format($cotizacion->getFieldValue('Grand_Total'), 2) . "</td>";
                                                    echo "<td>" . $cotizacion->getFieldValue('Aseguradora')->getLookupLabel() . "</td>";
                                                    echo "<td>" . number_format($cotizacion->getFieldValue('Comisi_n_Socio'), 2) . "</td>";
                                                    echo "</tr>";
                                                } elseif (!empty($post["aseguradora_id"]) and $cotizacion->getFieldValue("Aseguradora")->getEntityId() == $post["aseguradora_id"]) {
                                                    $prima_sumatoria += $resumen->getFieldValue('Valor_Asegurado');
                                                    $valor_sumatoria += $cotizacion->getFieldValue('Grand_Total');
                                                    $comision_sumatoria += $cotizacion->getFieldValue('Comisi_n_Socio');
                                                    echo "<tr>";
                                                    echo '<th scope="col">' . date("Y-m-d", strtotime($resumen->getFieldValue("Fecha_de_emisi_n"))) . "</th>";
                                                    echo "<td>" . date("Y-m-d", strtotime($resumen->getFieldValue("Closing_Date"))) . "</td>";
                                                    echo "<td>" . $resumen->getFieldValue('Marca')->getLookupLabel() . "</td>";
                                                    echo "<td>" . $resumen->getFieldValue('Modelo')->getLookupLabel() . "</td>";
                                                    echo "<td>" . $resumen->getFieldValue('Tipo_de_veh_culo') . "</td>";
                                                    echo "<td>" . number_format($resumen->getFieldValue('Valor_Asegurado'), 2) . "</td>";
                                                    echo "<td>" . number_format($cotizacion->getFieldValue('Grand_Total'), 2) . "</td>";
                                                    echo "<td>" . $cotizacion->getFieldValue('Aseguradora')->getLookupLabel() . "</td>";
                                                    echo "<td>" . number_format($cotizacion->getFieldValue('Comisi_n_Socio'), 2) . "</td>";
                                                    echo "</tr>";
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
                    ?>
                </tbody>
            </table>
            <div class="col-12">
                &nbsp;
            </div>

            <div class="row col-6">
                <div class="col">
                    <b>Total Primas:</b> <br>
                    <b>Total Valores:</b> <br>
                    <?php if ($post["tipo_reporte"] == "emisiones") : ?>
                        <b>Total Comisiones:</b> <br>
                    <?php endif ?>
                </div>

                <div class="col">
                    RD$<?= number_format($prima_sumatoria, 2) ?> <br>
                    RD$<?= number_format($valor_sumatoria, 2) ?> <br>
                    <?php if ($post["tipo_reporte"] == "emisiones") : ?>
                        RD$<?= number_format($comision_sumatoria, 2) ?>
                    <?php endif ?>
                </div>
            </div>
            <?php
            if ($valor_sumatoria == 0) {
                $alerta = "No existen resultados.";
                header("Location:" . constant("url") . "cotizaciones/exportar/" . $alerta);
                exit;
            }
            ?>

            <script>
                var time = 500;
                var url = "<?= constant("url") ?>";
                setTimeout(function() {
                    window.print();
                    window.location = url + "cotizaciones/exportar";
                }, time);
            </script>

        </div>

        <!-- Optional JavaScript -->
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
</body>

</html>