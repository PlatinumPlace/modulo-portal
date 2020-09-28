<?php
$url = explode("/", $_GET["url"]);
$id = (isset($url[2])) ? $url[2] : null;
$trato = detalles("Deals", $id);

if (empty($trato)) {
    require_once "views/portal/error.php";
    exit();
}
?>
<!doctype html>
<html lang="en">

    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js" crossorigin="anonymous"></script>

        <title>Cotizacion</title>

        <link rel="icon" type="image/png" href="<?= constant("url") ?>public/img/logo.png">

        <style>
            @media print {
                .pie_pagina {
                    position: fixed;
                    margin: auto;
                    height: 100px;
                    width: 100%;
                    right: 0;
                    bottom: 0;
                    left: 0;
                    z-index: 1030;
                }
            }
        </style>
    </head>

    <body>

        <div class="container">
            <div class="row">

                <div class="col-2">
                    <img src="<?= constant("url") ?>public/img/logo.png" alt="60" width="100" height="100">
                </div>

                <div class="col-8">
                    <h4 class="text-uppercase text-center">
                        cotización <br> seguro vehí­culo de motor <br> Plan <?= $trato->getFieldValue('Plan') ?>
                    </h4>
                </div>

                <div class="col-2">
                    <b>Fecha</b> <br> <?= date("d-m-Y") ?> <br>
                    <b>No.</b> <br> <?= $trato->getFieldValue('No') ?> <br>
                </div>

                <div class="col-12">
                    &nbsp;
                </div>

                <div class="col-12 d-flex justify-content-center bg-primary text-white">
                    <h6>CLIENTE</h6>
                </div>

                <div class="col-6 border">
                    <div class="row">

                        <div class="col-4">
                            <b>Nombre:</b><br>
                            <b>RNC/Cédula:</b><br>
                            <b>Email:</b><br>
                            <b>Dirección:</b>
                        </div>

                        <div class="col-8">
                            <?= $trato->getFieldValue('Nombre') ?>
                        </div>

                    </div>
                </div>

                <div class="col-6 border">
                    <div class="row">

                        <div class="col-4">
                            <b>Tel. Residencia:</b><br>
                            <b>Tel. Celular:</b><br>
                            <b>Tel. Trabajo:</b>
                        </div>

                        <div class="col-8">
                            &nbsp;
                        </div>

                    </div>
                </div>

                <div class="col-12">
                    &nbsp;
                </div>

                <div class="col-12 d-flex justify-content-center bg-primary text-white">
                    <h6>VEHÍCULO</h6>
                </div>

                <div class="col-6 border">
                    <div class="row">

                        <div class="col-4">
                            <b>Marca:</b><br>
                            <b>Modelo:</b><br>
                            <b>Año:</b><br>
                            <b>Tipo:</b><br>
                            <b>Suma Asegurada</b>
                        </div>

                        <div class="col-8">
                            <?php
                            echo $trato->getFieldValue('Marca');
                            echo "<br>";
                            echo $trato->getFieldValue('Modelo');
                            echo "<br>";
                            echo $trato->getFieldValue('A_o_veh_culo');
                            echo "<br>";
                            echo $trato->getFieldValue('Tipo_veh_culo');
                            echo "<br>";
                            echo "RD$" . number_format($trato->getFieldValue('Suma_asegurada'), 2);
                            ?>
                        </div>

                    </div>
                </div>

                <div class="col-6 border">
                    <div class="row">

                        <div class="col-4">
                            <b>Chasis:</b><br>
                            <b>Placa:</b><br>
                            <b>Color:</b><br>
                            <b>Uso:</b><br>
                            <b>Condicion:</b>
                        </div>

                        <div class="col-8">
                            &nbsp;
                        </div>

                    </div>
                </div>

                <div class="col-12">
                    &nbsp;
                </div>

                <div class="col-12 d-flex justify-content-center bg-primary text-white">
                    <h6>COBERTURAS</h6>
                </div>

                <div class="col-12 border">
                    <div class="row">

                        <div class="col-4">
                            <div class="card border-0">

                                <br>

                                <div class="card-body small">

                                    <p>
                                        <b>DAÑOS PROPIOS</b><br>
                                        Riesgos comprensivos<br>
                                        Riesgos comprensivos (Deducible)<br>
                                        Rotura de Cristales (Deducible)<br>
                                        Colisión y vuelco<br>
                                        Incendio y robo
                                    </p>

                                    <p>
                                        <b>RESPONSABILIDAD CIVIL</b><br>
                                        Daños Propiedad ajena<br>
                                        Lesiones/Muerte 1 Pers<br>
                                        Lesiones/Muerte más de 1 Pers<br>
                                        Lesiones/Muerte 1 pasajero<br>
                                        Lesiones/Muerte más de 1 pasajero<br>
                                    </p>

                                    <p>
                                        <b>RIESGOS CONDUCTOR</b> <br>
                                        <b>FIANZA JUDICIAL</b>
                                    </p>

                                    <p>
                                        <b>COBERTURAS ADICIONALES</b><br>
                                        Asistencia vial<br>
                                        Renta Vehí­culo<br>
                                        Casa del conductor / <br> Centro del Automovilista
                                    </p>

                                    <br>

                                    <p>
                                        <b>PRIMA NETA</b> <br>
                                        <b>ISC</b> <br>
                                        <b>PRIMA TOTAL</b> <br>
                                    </p>

                                </div>
                            </div>
                        </div>
                        <?php
                        $criteria = "Deal_Name:equals:" . $trato->getEntityId();
                        $cotizaciones = listaPorCriterio("Quotes", $criteria);
                        foreach ($cotizaciones as $cotizacion) {
                            if ($cotizacion->getFieldValue('Grand_Total') > 0) {

                                echo '<div class="col-2">';
                                echo '<div class="card border-0">';

                                $imagen = descargarFoto("Vendors", $cotizacion->getFieldValue('Aseguradora')->getEntityId());
                                echo '<img src="' . constant('url') . $imagen . '" height="43" width="90" class="card-img-top">';
                                echo '<div class="card-body small">';

                                $coberturas = detalles("Coberturas", $cotizacion->getFieldValue('Coberturas')->getEntityId());

                                $riesgo_compresivo = $trato->getFieldValue('Suma_asegurada') * ($coberturas->getFieldValue('Riesgos_comprensivos') / 100);
                                $colision = $trato->getFieldValue('Suma_asegurada') * ($coberturas->getFieldValue('Colisi_n_y_vuelco') / 100);
                                $incendio = $trato->getFieldValue('Suma_asegurada') * ($coberturas->getFieldValue('Incendio_y_robo') / 100);

                                echo '<p>';
                                echo "RD$" . number_format($riesgo_compresivo) . "<br>";
                                echo $coberturas->getFieldValue('Riesgos_comprensivos_deducible') . "<br>";
                                echo $coberturas->getFieldValue('Rotura_de_cristales_deducible') . "<br>";
                                echo "RD$" . number_format($colision) . "<br>";
                                echo "RD$" . number_format($incendio) . "<br>";
                                echo '</p>';

                                echo '<p>';
                                echo "<br>";
                                echo "RD$" . number_format($coberturas->getFieldValue('Da_os_propiedad_ajena')) . "<br>";
                                echo "RD$" . number_format($coberturas->getFieldValue('Lesiones_muerte_1_pas')) . "<br>";
                                echo "RD$" . number_format($coberturas->getFieldValue('Lesiones_muerte_m_s_pas')) . "<br>";
                                echo "RD$" . number_format($coberturas->getFieldValue('Lesiones_muerte_1_pers')) . "<br>";
                                echo "RD$" . number_format($coberturas->getFieldValue('Lesiones_muerte_m_s_pers')) . "<br>";
                                echo '</p>';

                                echo '<p>';
                                echo "RD$" . number_format($coberturas->getFieldValue('Riesgos_conductor')) . "<br>";
                                echo "RD$" . number_format($coberturas->getFieldValue('Fianza_judicial')) . "<br>";
                                echo '</p>';

                                echo '<p>';
                                echo "<br>";
                                echo ($coberturas->getFieldValue('Asistencia_vial') == 1) ? "Aplica <br>" : "No Aplica <br>";
                                echo ($coberturas->getFieldValue('Renta_veh_culo') == 1) ? "Aplica <br>" : "No Aplica <br>";
                                echo ($coberturas->getFieldValue('En_caso_de_accidente') != null) ? "Aplica" : "No Aplica";
                                echo '</p>';

                                echo "<br>";
                                echo "<br>";

                                $planes = $cotizacion->getLineItems();
                                foreach ($planes as $plan) {
                                    echo '<p>';
                                    echo "RD$" . number_format($plan->getListPrice(), 2) . "<br>";
                                    echo "RD$" . number_format($plan->getTaxAmount(), 2) . "<br>";
                                    echo "RD$" . number_format($plan->getNetTotal(), 2) . "<br>";
                                    echo '</p>';
                                }

                                echo '</div>';
                                echo '</div>';
                                echo '</div>';
                            }
                        }
                        ?>

                    </div>
                </div>

            </div>
        </div>

        <div class="row pie_pagina">

            <div class="col-3">
                <p class="text-center">
                    _______________________________ <br> Firma Cliente
                </p>
            </div>

            <div class="col-6">
                <p class="text-center">
                    _______________________________ <br> Aseguradora Elegida
                </p>
            </div>

            <div class="col-3">
                <p class="text-center">
                    _______________________________ <br> Fecha
                </p>
            </div>

        </div>

        <script>
            var time = 500;
            var id = "<?= $id ?>";
            var url = "<?= constant("url") ?>";
            setTimeout(function () {
                window.print();
                window.location = url + "cotizaciones/detallesAuto/" + id;
            }, time);
        </script>

    </body>

</html>