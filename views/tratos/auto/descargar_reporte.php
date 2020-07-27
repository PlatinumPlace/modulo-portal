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
                        <th scope="col">Emision</th>
                        <th scope="col">RNC/Cédula</th>
                        <th scope="col">Marca</th>
                        <th scope="col">Modelo</th>
                        <th scope="col">Tipo</th>
                        <th scope="col">Valor</th>
                        <th scope="col">Prima</th>
                        <?php if (!empty($_POST["comision"])) : ?>
                            <th scope="col">Comisión</th>
                        <?php endif ?>
                        <th scope="col">Aseguradora</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    $criterio = "Contact_Name:equals:" . $_SESSION["usuario"]["id"];
                    $num_pagina = 1;

                    do {
                        $tratos = $api->buscar_criterio("Deals", $criterio, $num_pagina, 200);

                        if (!empty($tratos)) {
                            $num_pagina++;

                            foreach ($tratos as $trato) {
                                if (
                                    date("Y-m-d", strtotime($trato->getFieldValue("Fecha_de_emisi_n")))  >= $_POST["desde"]
                                    and
                                    date("Y-m-d", strtotime($trato->getFieldValue("Fecha_de_emisi_n")))  <= $_POST["hasta"]
                                    and
                                    $trato->getFieldValue("Type") == "Auto"
                                ) {

                                    $bien = $api->detalles_registro("Bienes", $trato->getFieldValue('Bien')->getEntityId());

                                    $cliente = $api->detalles_registro("Clientes", $trato->getFieldValue('Cliente')->getEntityId());

                                    if (empty($_POST["aseguradora_id"])) {
                                        $prima_sumatoria += $trato->getFieldValue('Prima_Total');
                                        $valor_sumatoria += $trato->getFieldValue('Valor_Asegurado');
                                        $comision_sumatoria += $trato->getFieldValue('Comisi_n_Socio');

                                        echo "<tr>";
                                        echo '<th scope="col">' . date("Y-m-d", strtotime($trato->getFieldValue("Fecha_de_emisi_n"))) . "</th>";
                                        echo "<td>" . $cliente->getFieldValue('Name') . "</th>";
                                        echo "<td>" . $bien->getFieldValue('Marca') . "</th>";
                                        echo "<td>" . $bien->getFieldValue('Modelo') . "</th>";
                                        echo "<td>" . $bien->getFieldValue('Tipo_de_veh_culo') . "</th>";
                                        echo "<td>" . number_format($trato->getFieldValue('Valor_Asegurado'), 2) . "</th>";
                                        echo "<td>" . number_format($trato->getFieldValue('Prima_Total'), 2) . "</th>";
                                        if (!empty($_POST["comision"])) {
                                            echo "<td>" . number_format($trato->getFieldValue('Comisi_n_Socio'), 2) . "</th>";
                                        }
                                        echo "<td>" . $trato->getFieldValue('Aseguradora')->getLookupLabel() . "</th>";
                                        echo "</tr>";
                                    } elseif ($_POST["aseguradora_id"] == $trato->getFieldValue('Aseguradora')->getEntityId()) {
                                        $prima_sumatoria += $trato->getFieldValue('Prima_Total');
                                        $valor_sumatoria += $trato->getFieldValue('Valor_Asegurado');

                                        echo "<tr>";
                                        echo '<th scope="col">' . date("Y-m-d", strtotime($trato->getFieldValue("Fecha_de_emisi_n"))) . "</th>";
                                        echo "<td>" . $cliente->getFieldValue('Name') . "</th>";
                                        echo "<td>" . $bien->getFieldValue('Marca') . "</th>";
                                        echo "<td>" . $bien->getFieldValue('Modelo') . "</th>";
                                        echo "<td>" . $bien->getFieldValue('Tipo_de_veh_culo') . "</th>";
                                        echo "<td>" . number_format($trato->getFieldValue('Valor_Asegurado'), 2) . "</th>";
                                        echo "<td>" . number_format($trato->getFieldValue('Prima_Total'), 2) . "</th>";
                                        if (!empty($_POST["comision"])) {
                                            echo "<td>" . number_format($trato->getFieldValue('Comisi_n_Socio'), 2) . "</th>";
                                        }
                                        echo "<td>" . $trato->getFieldValue('Aseguradora')->getLookupLabel() . "</th>";
                                        echo "</tr>";
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
                    <?php if (!empty($_POST["comision"])) : ?>
                        <br>
                        <b>Total Comisiones:</b>
                    <?php endif ?>
                </div>
                <div class="col">
                    <?php
                    if (!empty($valor_sumatoria)) {
                        echo "RD$" . number_format($prima_sumatoria, 2);
                        echo "<br>";
                        echo "RD$" . number_format($valor_sumatoria, 2);
                        if (!empty($_POST["comision"])) {
                            echo "<br>";
                            echo "RD$" . number_format($comision_sumatoria, 2);
                        }
                    } else {
                        header("Location:" . constant("url") . "tratos/reporte/No se encontraton resultados.");
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
                    window.location = url + "tratos/reporte";
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