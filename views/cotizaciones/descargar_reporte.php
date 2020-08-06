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
                        <h4><?= $_SESSION["usuario"]['empresa_nombre'] ?></h4> <br>
                        <h4><?= $titulo ?></h4> <br>
                        <b>Desde:</b> <br>
                        <b>Hasta:</b> <br>
                        <b>Vendedor:</b>
                    </div>
                    <div class="col-6">
                        <h4>&nbsp;</h4> <br>
                        <h4>&nbsp;</h4> <br>
                        <?= $_POST["desde"] ?> <br>
                        <?= $_POST["hasta"] ?> <br>
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
                <thead class="thead-dark">
                    <tr>
                        <?php if ($_POST["estado_cotizacion"] == "pendientes" and $_POST["tipo_cotizacion"] == "Auto") : ?>
                            <th scope="col">Emision</th>
                            <th scope="col">Deudor</th>
                            <th scope="col">Marca</th>
                            <th scope="col">Modelo</th>
                            <th scope="col">Tipo</th>
                            <th scope="col">Año</th>
                            <th scope="col">Valor</th>
                            <th scope="col">Prima</th>
                            <th scope="col">Aseguradora</th>

                        <?php elseif ($_POST["estado_cotizacion"] == "emitidos" and $_POST["tipo_cotizacion"] == "Auto") : ?>
                            <th scope="col">Emision</th>
                            <th scope="col">Deudor</th>
                            <th scope="col">Marca</th>
                            <th scope="col">Modelo</th>
                            <th scope="col">Tipo</th>
                            <th scope="col">Año</th>
                            <th scope="col">Valor</th>
                            <th scope="col">Prima</th>
                            <th scope="col">Comisión</th>
                            <th scope="col">Aseguradora</th>
                        <?php endif ?>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    if (!empty($cotizaciones)) {
                        foreach ($cotizaciones as $cotizacion) {
                            if (
                                date("Y-m-d", strtotime($cotizacion->getFieldValue("Fecha_emisi_n")))  >= $_POST["desde"]
                                and
                                date("Y-m-d", strtotime($cotizacion->getFieldValue("Fecha_emisi_n")))  <= $_POST["hasta"]
                                and
                                $cotizacion->getFieldValue("Tipo") == $_POST["tipo_cotizacion"]
                            ) {
                                if ($_POST["estado_cotizacion"] == "emitidos" and    $cotizacion->getFieldValue('Deal_Name') != null) {
                                    $planes = $cotizacion->getLineItems();
                                    foreach ($planes as $plan) {
                                        if (
                                            $plan->getNetTotal() > 0
                                            and
                                            (empty($_POST["aseguradora"])
                                                or
                                                $_POST["aseguradora"] == $plan->getDescription())
                                        ) {
                                            $trato = $api->detalles_registro("Deals", $cotizacion->getFieldValue('Deal_Name')->getEntityId());

                                            switch ($_POST["tipo_cotizacion"]) {
                                                case 'Auto':
                                                    $prima_sumatoria += $plan->getNetTotal();
                                                    $valor_sumatoria += $cotizacion->getFieldValue('Valor_Asegurado');
                                                    $comision_sumatoria += $trato->getFieldValue('Comisi_n_Socio');

                                                    echo "<tr>";
                                                    echo '<th scope="col">' . date("Y-m-d", strtotime($cotizacion->getFieldValue("Fecha_emisi_n"))) . "</th>";
                                                    echo "<td>" . $trato->getFieldValue('Contact_Name')->getLookupLabel() . "</th>";
                                                    echo "<td>" . $cotizacion->getFieldValue('Marca')->getLookupLabel() . "</th>";
                                                    echo "<td>" . $cotizacion->getFieldValue('Modelo')->getLookupLabel() . "</th>";
                                                    echo "<td>" . $cotizacion->getFieldValue('Tipo_Veh_culo') . "</th>";
                                                    echo "<td>" . $cotizacion->getFieldValue('A_o_Fabricaci_n') . "</th>";
                                                    echo "<td>" . number_format($cotizacion->getFieldValue('Valor_Asegurado'), 2) . "</th>";
                                                    echo "<td>" . number_format($plan->getNetTotal(), 2) . "</th>";
                                                    echo "<td>" . number_format($trato->getFieldValue('Comisi_n_Socio'), 2) . "</th>";
                                                    echo "<td>" . $plan->getDescription() . "</th>";
                                                    echo "</tr>";
                                                    break;
                                            }
                                        }
                                    }
                                } elseif ($_POST["estado_cotizacion"] == "pendientes" and    $cotizacion->getFieldValue('Deal_Name') == null) {
                                    $planes = $cotizacion->getLineItems();
                                    foreach ($planes as $plan) {
                                        if (
                                            $plan->getNetTotal() > 0
                                            and
                                            (empty($_POST["aseguradora"])
                                                or
                                                $_POST["aseguradora"] == $plan->getDescription())
                                        ) {
                                            switch ($_POST["tipo_cotizacion"]) {
                                                case 'Auto':
                                                    $prima_sumatoria += $plan->getNetTotal();
                                                    $valor_sumatoria += $cotizacion->getFieldValue('Valor_Asegurado');

                                                    echo "<tr>";
                                                    echo '<th scope="col">' . date("Y-m-d", strtotime($cotizacion->getFieldValue("Fecha_emisi_n"))) . "</th>";
                                                    echo "<td>" . $cotizacion->getFieldValue('Nombre') . " " . $cotizacion->getFieldValue('Apellido') . "</th>";
                                                    echo "<td>" . $cotizacion->getFieldValue('Marca')->getLookupLabel() . "</th>";
                                                    echo "<td>" . $cotizacion->getFieldValue('Modelo')->getLookupLabel() . "</th>";
                                                    echo "<td>" . $cotizacion->getFieldValue('Tipo_Veh_culo') . "</th>";
                                                    echo "<td>" . $cotizacion->getFieldValue('A_o_Fabricaci_n') . "</th>";
                                                    echo "<td>" . number_format($cotizacion->getFieldValue('Valor_Asegurado'), 2) . "</th>";
                                                    echo "<td>" . number_format($plan->getNetTotal(), 2) . "</th>";
                                                    echo "<td>" . $plan->getDescription() . "</th>";
                                                    echo "</tr>";
                                                    break;
                                            }
                                        }
                                    }
                                }
                            }
                        }
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
                    <b>Total Valores:</b>
                    <b>Total Comisiones:</b>
                </div>
                <div class="col">
                    <?php
                    if (!empty($valor_sumatoria)) {
                        echo "RD$" . number_format($prima_sumatoria, 2);
                        echo "<br>";
                        echo "RD$" . number_format($valor_sumatoria, 2);
                        echo "<br>";
                        echo "RD$" . number_format($comision_sumatoria, 2);
                    } else {
                        header("Location:" . constant("url") . "cotizaciones/reporte/No existen resultados.");
                        exit;
                    }
                    ?>
                </div>
            </div>

            <script>
                var time = 500;
                var url = "<?= constant("url") ?>";
                setTimeout(function() {
                    window.print();
                    window.location = url + "cotizaciones/reporte";
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