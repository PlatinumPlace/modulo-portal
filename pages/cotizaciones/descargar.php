<?php

$api = new api;
$usuario = json_decode($_COOKIE["usuario"], true);

$url = rtrim($_GET['url'], "/");
$url = explode('/', $url);
$post = $url[2];
$post = json_decode($post, true);

$emitida = array("Emitido", "En trámite");
$contrato =  $api->getRecord("Contratos", $post["contrato_id"]);
$criterio = "((Contact_Name:equals:" .  $usuario['id'] . ") and (Type:equals:" . ucfirst($post["tipo_cotizacion"]) . "))";
$cotizaciones = $api->searchRecordsByCriteria("Deals", $criterio);

if (empty($cotizaciones)) {
    $alerta = "No existen registros.";

    header("Location:" . constant("url") . "cotizaciones/exportar/$alerta");
    exit;
} else {
    $titulo = "Reporte " . ucfirst($post["tipo_reporte"]) . " " . ucfirst($post["tipo_cotizacion"]);
}

?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Bootstrap core CSS -->
    <link href="<?= constant("url") ?>vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="<?= constant("url") ?>css/blog-post.css" rel="stylesheet">

    <!--Import Google Icon Font-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <title><?= $titulo ?></title>
    <link rel="icon" type="image/png" href="<?= constant("url") ?>img/logo.png">

</head>

<body>

    <div class="container">

        <div class="row">

            <div class="col-4">
                <img src="<?= constant("url") ?>img/logo.png" height="200" width="150">
            </div>

            <div class="col-8">
                <div class="row">

                    <div class="col-6">
                        <b><?= $contrato->getFieldValue("Socio")->getLookupLabel() ?></b> <br>
                        <b><?= $titulo ?></b> <br>
                        <b>Aseguradora:</b> <br>
                        <b>Póliza:</b> <br>
                        <b>Desde:</b> <br>
                        <b>Hasta:</b> <br>
                        <b>Vendedor:</b>
                    </div>

                    <div class="col-6">
                        &nbsp; <br>
                        &nbsp; <br>
                        <?= $contrato->getFieldValue("Aseguradora")->getLookupLabel() ?> <br>
                        <?= $contrato->getFieldValue('No_P_liza') ?> <br>
                        <?= $post["desde"] ?> <br>
                        <?= $post["hasta"] ?> <br>
                        <?= $usuario['nombre'] ?>
                    </div>

                </div>

            </div>

            <br>

            <?php

            $prima_neta_sumatoria = 0;
            $isc_sumatoria = 0;
            $prima_total_sumatoria = 0;
            $valor_asegurado_sumatoria = 0;
            $comision_sumatoria = 0;

            ?>

            <table class="table">
                <thead>
                    <tr class="bg-primary text-white">
                        <?php if ($post["tipo_cotizacion"] == "auto") : ?>

                            <th scope="col">Fecha Emision</th>
                            <th scope="col">Nombre Asegurado</th>
                            <th scope="col">Cedula</th>
                            <th scope="col">Marca</th>
                            <th scope="col">Modelo</th>
                            <th scope="col">Año</th>
                            <th scope="col">Color</th>
                            <th scope="col">Chasis</th>
                            <th scope="col">Placa</th>
                            <th scope="col">Valor Asegurado</th>
                            <th scope="col">Plan</th>
                            <th scope="col">Prima Neta</th>
                            <th scope="col">ISC</th>
                            <th scope="col">Prima Total</th>

                            <?php if ($post["tipo_reporte"] == "comisiones") : ?>
                                <th scope="col">Comisión</th>
                            <?php endif ?>

                        <?php endif ?>
                    </tr>
                </thead>
                <tbody>
                    <?php

                    foreach ($cotizaciones as $resumen) {
                        if (
                            date("Y-m-d", strtotime($resumen->getFieldValue("Fecha_de_emisi_n")))  >= $post["desde"]
                            and
                            date("Y-m-d", strtotime($resumen->getFieldValue("Fecha_de_emisi_n"))) <= $post["hasta"]
                            and
                            $resumen->getFieldValue("Contact_Name")->getEntityId() == $usuario["id"]
                        ) {

                            $criterio = "Deal_Name:equals:" . $resumen->getEntityId();
                            $detalles = $api->searchRecordsByCriteria("Quotes", $criterio);

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


                                    if ($post["tipo_reporte"] == "cotizaciones") {
                                        $estado[] = "Cotizando";
                                    } elseif ($post["tipo_reporte"] == "emisiones" or $post["tipo_reporte"] == "comisiones") {
                                        $estado = array("En trámite", "Emitido");
                                    }

                                    //contenido
                                    if (in_array($resumen->getFieldValue("Stage"), $estado)) {

                                        echo "<tr>";


                                        if ($post["tipo_cotizacion"] == "auto") {

                                            echo '<th scope="row">' . date("Y-m-d", strtotime($resumen->getFieldValue("Fecha_de_emisi_n"))) . '</th>';
                                            echo "<td>" . $resumen->getFieldValue("Nombre") . " " . $resumen->getFieldValue("Apellido") . "</td>";
                                            echo "<td>" . $resumen->getFieldValue("RNC_Cedula") . "</td>";
                                            echo "<td>" . $resumen->getFieldValue('Marca')->getLookupLabel() . "</td>";
                                            echo "<td>" . $resumen->getFieldValue('Modelo')->getLookupLabel() . "</td>";
                                            echo "<td>" . $resumen->getFieldValue('A_o_de_Fabricacion') . "</td>";
                                            echo "<td>" . $resumen->getFieldValue('Color') . "</td>";
                                            echo "<td>" . $resumen->getFieldValue('Chasis') . "</td>";
                                            echo "<td>" . $resumen->getFieldValue('Placa') . "</td>";
                                            echo "<td>RD$" . number_format($resumen->getFieldValue('Valor_Asegurado'), 2) . "</td>";
                                            echo "<td>" . $resumen->getFieldValue('Plan') . "</td>";
                                            echo "<td>RD$" . number_format($prima_neta, 2) . "</td>";
                                            echo "<td>RD$" . number_format($isc, 2) . "</td>";
                                            echo "<td>RD$" . number_format($prima_total, 2) . "</td>";

                                            $valor_asegurado_sumatoria += $resumen->getFieldValue('Valor_Asegurado');
                                            $prima_neta_sumatoria += $prima_neta;
                                            $isc_sumatoria += $isc;
                                            $prima_total_sumatoria += $prima_total;

                                            if ($post["tipo_reporte"] == "comisiones") {
                                                echo "<td>RD$" . number_format($comision, 2) . "</td>";

                                                $comision_sumatoria += $comision;
                                            }
                                        }

                                        echo "</tr>";
                                    }
                                }
                            }
                        }
                    }

                    ?>
                </tbody>
            </table>

            <br>

            <div class="row col-6">

                <div class="col">
                    <b>Total Primas Netas:</b> <br>
                    <b>Total ISC:</b> <br>
                    <b>Total Primas Totales:</b> <br>
                    <b>Total Valores Asegurados:</b> <br>
                    <?php if ($post["tipo_reporte"] == "comisiones") : ?>
                        <b>Total Comisiones:</b> <br>
                    <?php endif ?>
                </div>

                <div class="col">
                    RD$<?= number_format($prima_neta_sumatoria, 2) ?> <br>
                    RD$<?= number_format($isc_sumatoria, 2) ?> <br>
                    RD$<?= number_format($prima_total_sumatoria, 2) ?> <br>
                    RD$<?= number_format($valor_asegurado_sumatoria, 2) ?> <br>
                    <?php if ($post["tipo_reporte"] == "comisiones") : ?>
                        RD$<?= number_format($comision_sumatoria, 2) ?>
                    <?php endif ?>
                </div>

            </div>
        </div>

    </div>
    <?php

    if ($valor_asegurado_sumatoria == 0) {
        $alerta = "No existen resultados para la aseguradora seleccionada.";

        header("Location:" . constant("url") . "cotizaciones/exportar/$alerta");
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

    <!-- Bootstrap core JavaScript -->
    <script src="<?= constant("url") ?>vendor/jquery/jquery-2.1.1.min.js"></script>
    <script src="<?= constant("url") ?>vendor/jquery/jquery.min.js"></script>
    <script src="<?= constant("url") ?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

</body>

</html>