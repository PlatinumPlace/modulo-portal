<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">

    <title><?= $titulo ?></title>
    <link rel="icon" type="image/png" href="<?= constant("url") ?>public/icons/logo.png">
</head>

<body>
    <div class="container">

        <div class="row">
            <div class="col-4">
                <img src="<?= constant("url") ?>public/icons/logo.png" height="200" width="150">
            </div>

            <div class="col-8">
                <div class="row">
                    <div class="col-6">
                        <h4><?= $_SESSION["usuario"]['empresa_nombre'] ?></h4>
                        <br>
                        <h4><?= $titulo ?></h4>
                        <br> <b>Desde:</b> <br> <b>Hasta:</b> <br> <b>Vendedor:</b>
                    </div>
                    <div class="col-6">
                        <h4>&nbsp;</h4>
                        <br>
                        <h4>&nbsp;</h4>
                        <br>
                        <?= $_POST["desde"] ?> <br>
                        <?= $_POST["hasta"] ?> <br>
                        <?= $_SESSION["usuario"]['nombre'] ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12">&nbsp;</div>

        <div class="col-12">
            <table class="table table-sm">
                <thead class="thead-dark">
                    <tr>
                        <?php if ($_POST["tipo_cotizacion"] == "Auto") : ?>
                            <th scope="col">Emision</th>
                            <th scope="col">Deudor</th>
                            <th scope="col">Marca</th>
                            <th scope="col">Modelo</th>
                            <th scope="col">Tipo</th>
                            <th scope="col">Año</th>
                            <th scope="col">Valor</th>
                            <th scope="col">Prima</th>
                            <?php if ($_POST["estado_cotizacion"] == "pendientes") : ?>
                                <th scope="col">Aseguradora</th>
                            <?php elseif ($_POST["estado_cotizacion"] == "emitidas") : ?>
                                <th scope="col">Comisión</th>
                                <th scope="col">Aseguradora</th>
                            <?php endif ?>
                        <?php endif ?>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    $result["prima_sumatoria"] = 0;
                    $result["valor_sumatoria"] = 0;
                    $result["comision_sumatoria"] = 0;
                    $num_pag = 1;
                    do {
                        $criterio = "Contact_Name:equals:" . $_SESSION["usuario"]["id"];
                        $cotizaciones = $api->searchRecordsByCriteria("Quotes", $criterio, $num_pag);
                        if (!empty($cotizaciones)) {
                            $num_pag++;
                            foreach ($cotizaciones as $cotizacion) {
                                switch ($_POST["estado_cotizacion"]) {
                                    case 'pendientes':
                                        $planes = $cotizacion->getLineItems();
                                        foreach ($planes as $plan) {
                                            if (date("Y-m-d", strtotime($cotizacion->getFieldValue("Fecha_emisi_n"))) >= $_POST["desde"] and date("Y-m-d", strtotime($cotizacion->getFieldValue("Fecha_emisi_n"))) <= $_POST["hasta"] and $cotizacion->getFieldValue("Tipo") == $_POST["tipo_cotizacion"] and $cotizacion->getFieldValue('Deal_Name') == null and $plan->getNetTotal() > 0 and (empty($_POST["aseguradora"]) or $_POST["aseguradora"] == $plan->getDescription())) {
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
                                        break;

                                    case 'emitidas':
                                        $planes = $cotizacion->getLineItems();
                                        foreach ($planes as $plan) {
                                            if (date("Y-m-d", strtotime($cotizacion->getFieldValue("Fecha_emisi_n"))) >= $_POST["desde"] and date("Y-m-d", strtotime($cotizacion->getFieldValue("Fecha_emisi_n"))) <= $_POST["hasta"] and $cotizacion->getFieldValue("Tipo") == $_POST["tipo_cotizacion"] and $cotizacion->getFieldValue('Deal_Name') != null and $plan->getNetTotal() > 0 and (empty($_POST["aseguradora"]) or $_POST["aseguradora"] == $plan->getDescription())) {
                                                switch ($_POST["tipo_cotizacion"]) {
                                                    case 'Auto':
                                                        $trato = $api->getRecord("Deals", $cotizacion->getFieldValue('Deal_Name')->getEntityId());
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
                                        break;
                                }
                            }
                        } else {
                            $num_pag = 0;
                        }
                    } while ($num_pag > 0);

                    if (empty($valor_sumatoria)) {
                        header("Location:" . constant("url") . "reportes/No existen resultados.");
                        exit();
                    }
                    ?>
                </tbody>
            </table>

            <div class="col-12">&nbsp;</div>

            <div class="row col-6">
                <div class="col">
                    <?php
                    echo "<b>Total Primas:</b> <br> <b>Total Valores:</b>";
                    if ($_POST["estado_cotizacion"] == "emitidas") {
                        echo "<br> <b>Total Comisiones:</b>";
                    }
                    ?>
                </div>

                <div class="col">
                    <?php
                    echo "RD$" . number_format($result["prima_sumatoria"], 2);
                    echo "<br>";
                    echo "RD$" . number_format($result["valor_sumatoria"], 2);
                    if ($_POST["estado_cotizacion"] == "emitidas") {
                        echo "<br>";
                        echo "RD$" . number_format($result["comision_sumatoria"], 2);
                    }
                    ?>
                </div>
            </div>

        </div>

    </div>

    <script>
        var time = 500;
        var url = "<?= constant("url") ?>";
        setTimeout(function() {
            window.print();
            window.location = url + "reportes";
        }, time);
    </script>
</body>

</html>