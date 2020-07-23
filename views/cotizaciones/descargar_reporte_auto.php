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
                        <h6><b><?= $_SESSION["usuario"]['empresa_nombre'] ?></b></h6> <br>
                        <h6><b><?= $titulo ?></b></h6> <br>
                        <b>Desde:</b> <br>
                        <b>Hasta:</b> <br>
                        <b>Vendedor:</b>
                    </div>
                    <div class="col-6">
                        <h6>&nbsp;</h6> <br>
                        <h6>&nbsp;</h6> <br>
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
                        <th scope="col">Emision</th>
                        <th scope="col">Vigencia</th>
                        <th scope="col">Marca</th>
                        <th scope="col">Modelo</th>
                        <th scope="col">Tipo</th>
                        <th scope="col">Año</th>
                        <th scope="col">Plan</th>
                        <th scope="col">Valor</th>
                        <th scope="col">Prima</th>
                        <th scope="col">Aseguradora</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    $criterio = "Contact_Name:equals:" . $_SESSION["usuario"]["id"];
                    $num_pagina = 1;
                    do {
                        $cotizaciones = $api->buscar_criterio("Quotes", $criterio, $num_pagina, 200);
                        if (!empty($cotizaciones)) {
                            $num_pagina++;

                            foreach ($cotizaciones as $cotizacion) {
                                if (
                                    date("Y-m-d", strtotime($cotizacion->getFieldValue("Fecha_emisi_n")))  >= $_POST["desde"]
                                    and
                                    date("Y-m-d", strtotime($cotizacion->getFieldValue("Fecha_emisi_n")))  <= $_POST["hasta"]
                                    and
                                    $cotizacion->getFieldValue("Tipo") == "Auto"
                                    and
                                    $cotizacion->getFieldValue("Deal_Name") == null
                                ) {
                                    $planes = $cotizacion->getLineItems();

                                    foreach ($planes as $plan) {
                                        if ($plan->getNetTotal() > 0) {
                                            if (empty($_POST["aseguradora"])) {
                                                $prima_sumatoria += $plan->getNetTotal();
                                                $valor_sumatoria += $cotizacion->getFieldValue('Valor_Asegurado');

                                                echo "<tr>";
                                                echo '<th scope="col">' . date("Y-m-d", strtotime($cotizacion->getFieldValue("Fecha_emisi_n"))) . "</th>";
                                                echo "<td>" . date("Y-m-d", strtotime($cotizacion->getFieldValue("Valid_Till"))) . "</th>";
                                                echo "<td>" . $cotizacion->getFieldValue('Marca')->getLookupLabel() . "</th>";
                                                echo "<td>" . $cotizacion->getFieldValue('Modelo')->getLookupLabel() . "</th>";
                                                echo "<td>" . $cotizacion->getFieldValue('Tipo_Veh_culo') . "</th>";
                                                echo "<td>" . $cotizacion->getFieldValue('A_o_Fabricaci_n') . "</th>";
                                                echo "<td>" . $cotizacion->getFieldValue('Plan') . "</th>";
                                                echo "<td>" . number_format($cotizacion->getFieldValue('Valor_Asegurado'), 2) . "</th>";
                                                echo "<td>" . number_format($plan->getNetTotal(), 2) . "</th>";
                                                echo "<td>" . $plan->getDescription() . "</th>";
                                                echo "</tr>";
                                            } elseif ($_POST["aseguradora"] == $plan->getDescription()) {
                                                $prima_sumatoria += $plan->getNetTotal();
                                                $valor_sumatoria += $cotizacion->getFieldValue('Valor_Asegurado');

                                                echo "<tr>";
                                                echo '<th scope="col">' . date("Y-m-d", strtotime($cotizacion->getFieldValue("Fecha_emisi_n"))) . "</th>";
                                                echo "<td>" . date("Y-m-d", strtotime($cotizacion->getFieldValue("Valid_Till"))) . "</th>";
                                                echo "<td>" . $cotizacion->getFieldValue('Marca')->getLookupLabel() . "</th>";
                                                echo "<td>" . $cotizacion->getFieldValue('Modelo')->getLookupLabel() . "</th>";
                                                echo "<td>" . $cotizacion->getFieldValue('Tipo_Veh_culo') . "</th>";
                                                echo "<td>" . $cotizacion->getFieldValue('A_o_Fabricaci_n') . "</th>";
                                                echo "<td>" . $cotizacion->getFieldValue('Plan') . "</th>";
                                                echo "<td>" . number_format($cotizacion->getFieldValue('Valor_Asegurado'), 2) . "</th>";
                                                echo "<td>" . number_format($plan->getNetTotal(), 2) . "</th>";
                                                echo "<td>" . $plan->getDescription() . "</th>";
                                                echo "</tr>";
                                            }
                                        }
                                    }
                                }
                            }
                        } else {
                            $num_pagina = 0;
                        }
                    } while ($num_pagina > 0);
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
                </div>
                <div class="col">
                    <?php
                    if (!empty($valor_sumatoria)) {
                        echo "RD$" . number_format($prima_sumatoria, 2);
                        echo "<br>";
                        echo "RD$" . number_format($valor_sumatoria, 2);
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