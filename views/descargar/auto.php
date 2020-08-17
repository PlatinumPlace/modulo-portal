<?php
if ($cotizacion->getFieldValue("Deal_Name") != null) {
    $trato = $api->getRecord("Deals", $cotizacion->getFieldValue("Deal_Name")->getEntityId());
    $coberturas = $api->getRecord("Contratos", $trato->getFieldValue("Contrato")->getEntityId());
    $bien = $api->getRecord("Bienes", $trato->getFieldValue("Bien")->getEntityId());
    $aseguradora = $api->getRecord("Vendors", $coberturas->getFieldValue("Aseguradora")->getEntityId());
    $imagen_aseguradora = $api->downloadPhoto("Vendors", $aseguradora->getEntityId());
}
?>
<!DOCTYPE html>
<html lang="en">

    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

        <title>Cotización No. <?= $cotizacion->getFieldValue('Quote_Number') ?></title>
        <link rel="icon" type="image/png" href="<?= constant("url") ?>public/icons/logo.png">

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
                    <?php if ($cotizacion->getFieldValue("Deal_Name") != null) : ?>
                        <img src="<?= constant("url") . $imagen_aseguradora ?>" width="130" height="100">
                    <?php else : ?>
                        <img src="<?= constant("url") ?>public/icons/logo.png" width="100" height="100">
                    <?php endif ?>
                </div>

                <div class="col-8">
                    <h4 class="text-uppercase text-center">
                        <?php
                        if ($cotizacion->getFieldValue("Deal_Name") == null) {
                            echo " cotización <br>";
                        } else {
                            echo "resumen coberturas <br>";
                        }
                        ?>
                        seguro vehículo de motor <br>
                        <?= $cotizacion->getFieldValue('Subject') ?>
                    </h4>
                </div>

                <div class="col-2">
                    <b>Fecha</b> <br> <?= $cotizacion->getFieldValue('Fecha_emisi_n') ?> <br>
                    <b>Cotización No.</b> <br> <?= $cotizacion->getFieldValue('Quote_Number') ?> <br>
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
                            <b>Direccion:</b>
                        </div>

                        <div class="col-8">
                            <?php
                            echo $cotizacion->getFieldValue('Nombre') . " " . $cotizacion->getFieldValue('Apellido');
                            echo "<br>";
                            echo $cotizacion->getFieldValue('RNC_C_dula');
                            echo "<br>";
                            echo $cotizacion->getFieldValue('Correo');
                            echo "<br>";
                            echo $cotizacion->getFieldValue('Direcci_n');
                            ?>
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
                            <?php
                            echo $cotizacion->getFieldValue('Tel_Residencial');
                            echo "<br>";
                            echo $cotizacion->getFieldValue('Tel_Celular');
                            echo "<br>";
                            echo $cotizacion->getFieldValue('Tel_Trabajo');
                            ?>
                        </div>

                    </div>
                </div>

                <div class="col-12 d-flex justify-content-center bg-primary text-white">
                    <h6>VEHICULO</h6>
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
                            echo strtoupper($cotizacion->getFieldValue('Marca')->getLookupLabel());
                            echo "<br>";
                            echo strtoupper($cotizacion->getFieldValue('Modelo')->getLookupLabel());
                            echo "<br>";
                            echo $cotizacion->getFieldValue('A_o_Fabricaci_n');
                            echo "<br>";
                            echo $cotizacion->getFieldValue('Tipo_Veh_culo');
                            echo "<br>";
                            echo "RD$" . number_format($cotizacion->getFieldValue('Valor_Asegurado'), 2);
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
                            <?php
                            if (!empty($bien)) {
                                echo $bien->getFieldValue('Name');
                                echo "<br>";
                                echo $bien->getFieldValue('Placa');
                                echo "<br>";
                                echo $bien->getFieldValue('Color');
                                echo "<br>";
                                echo $bien->getFieldValue('Uso');
                                echo "<br>";
                                echo $bien->getFieldValue('Condicion');
                            }
                            ?>
                        </div>

                    </div>
                </div>

                <div class="col-12 d-flex justify-content-center bg-primary text-white">
                    <h6>COBERTURAS</h6>
                </div>

                <div class="col-12 border">
                    <div class="row">

                        <div class="col-4">
                            <div class="card border-0">
                                <div class="card-body">
                                    <h6 class="card-title"><small><b>DAÑOS PROPIOS</b></small></h6>
                                    <p class="card-text">
                                        <small>
                                            Riesgos comprensivos<br>
                                            Riesgos comprensivos (Deducible)<br>
                                            Rotura de Cristales (Deducible)<br>
                                            Colisión y vuelco<br>
                                            Incendio y robo
                                        </small>
                                    </p>
                                    <h6 class="card-title"><small><b>RESPONSABILIDAD CIVIL</b></small></h6>
                                    <p class="card-text">
                                        <small>
                                            Daños Propiedad ajena<br>
                                            Lesiones/Muerte 1 Pers<br>
                                            Lesiones/Muerte más de 1 Pers<br>
                                            Lesiones/Muerte 1 pasajero<br>
                                            Lesiones/Muerte más de 1 pasajero<br>
                                        </small>
                                    </p>
                                    <h6 class="card-title"><small><b>RIESGOS CONDUCTOR</b></small></h6>
                                    <h6 class="card-title"><small><b>FIANZA JUDICIAL</b></small></h6>
                                    <h6 class="card-title"><small><b>COBERTURAS ADICIONALES</b></small></h6>
                                    <p class="card-text">
                                        <small>
                                            Asistencia vial<br>
                                            Renta Vehículo<br>
                                            Casa del conductor/<br>
                                            Centro del Automovilista
                                        </small>
                                    </p>
                                    <h6 class="card-title"><small><b>Prima Neta</b></small></h6>
                                    <h6 class="card-title"><small><b>ISC</b></small></h6>
                                    <h6 class="card-title"><small><b>Prima Total</b></small></h6>
                                </div>
                            </div>
                        </div>

                        <?php $planes = $cotizacion->getLineItems() ?>
                        <?php foreach ($planes as $plan) : ?>
                            <?php if ($plan->getNetTotal() > 0) : ?>
                                <?php
                                $criterio = "((Socio:equals:" . $_SESSION["usuario"]["empresa_id"] . ") and (Plan:equals:" . $plan->getProduct()->getEntityId() . "))";
                                $contratos = $api->searchRecordsByCriteria("Contratos", $criterio);
                                foreach ($contratos as $contrato) {
                                    $coberturas = $contrato;
                                }
                                if ($cotizacion->getFieldValue("Deal_Name") == null) {
                                    $imagen_aseguradora = $api->downloadPhoto("Vendors", $coberturas->getFieldValue("Aseguradora")->getEntityId());
                                }
                                ?>
                                <div class="col-2">
                                    <?php if ($cotizacion->getFieldValue("Deal_Name") == null) : ?>
                                        <img height="31" width="90" src="<?= constant("url") . $imagen_aseguradora ?>">
                                    <?php else : ?>
                                        &nbsp;
                                    <?php endif ?>
                                    <div class="card border-0">
                                        <div class="card-body">
                                            <p class="card-text">
                                                <small>
                                                    <?php
                                                    $resultado = $cotizacion->getFieldValue('Valor_Asegurado') * ($coberturas->getFieldValue('Riesgos_comprensivos') / 100);
                                                    ?>
                                                    RD$<?= number_format($resultado) ?> <br>
                                                    <?= $coberturas->getFieldValue('Riesgos_Comprensivos_Deducible') ?><br>
                                                    <?= $coberturas->getFieldValue('Rotura_de_cristales_Deducible') ?><br>
                                                    <?php
                                                    $resultado = $cotizacion->getFieldValue('Valor_Asegurado') * ($coberturas->getFieldValue('Colisi_n_y_vuelco') / 100);
                                                    ?>
                                                    RD$<?= number_format($resultado) ?> <br>
                                                    <?php
                                                    $resultado = $cotizacion->getFieldValue('Valor_Asegurado') * ($coberturas->getFieldValue('Incendio_y_robo') / 100);
                                                    ?>
                                                    RD$<?= number_format($resultado) ?> <br>
                                                </small>
                                            </p>
                                            <h6 class="card-title">&nbsp;</h6>
                                            <p class="card-text">
                                                <small>
                                                    RD$<?= number_format($coberturas->getFieldValue('Da_os_Propiedad_ajena')) ?> <br>
                                                    RD$<?= number_format($coberturas->getFieldValue('Lesiones_Muerte_1_Pers')) ?> <br>
                                                    RD$<?= number_format($coberturas->getFieldValue('Lesiones_Muerte_m_s_de_1_Pers')) ?> <br>
                                                    RD$<?= number_format($coberturas->getFieldValue('Lesiones_Muerte_1_pasajero')) ?> <br>
                                                    RD$<?= number_format($coberturas->getFieldValue('Lesiones_Muerte_m_s_de_1_pasajero')) ?>
                                                </small>
                                            </p>
                                            <h6 class="card-title">
                                                <small>RD$
                                                    <?= number_format($coberturas->getFieldValue('Riesgos_conductor')) ?></small>
                                            </h6>
                                            <h6 class="card-title">
                                                <small>RD$
                                                    <?= number_format($coberturas->getFieldValue('Fianza_judicial')) ?></small>
                                            </h6>
                                            <h6 class="card-title">&nbsp;</h6>
                                            <p class="card-text">
                                                <small>
                                                    <?= ($coberturas->getFieldValue('Asistencia_vial') == 1) ? "Aplica" : "No Aplica" ?><br>
                                                    <?= ($coberturas->getFieldValue('Renta_Veh_culo') == 1) ? "Aplica" : "No Aplica" ?> <br>
                                                    <?= ($coberturas->getFieldValue('Asistencia_Accidente') != null) ? "Aplica" : "No Aplica" ?> <br><br>
                                                </small>
                                            </p>
                                            <h6 class="card-title"><small>RD$<?= number_format($plan->getListPrice(), 2) ?></small></h6>
                                            <h6 class="card-title"><small>RD$<?= number_format($plan->getTaxAmount(), 2) ?></small></h6>
                                            <h6 class="card-title"><small>RD$<?= number_format($plan->getNetTotal(), 2) ?></small></h6>
                                        </div>
                                    </div>
                                </div>
                            <?php endif ?>
                        <?php endforeach ?>
                    </div>
                </div>

            </div>

            <?php if ($cotizacion->getFieldValue("Deal_Name") == null) : ?>
                <div class="row pie_pagina">
                    <div class="col-3">
                        <p class="text-center">
                            _______________________________
                            <br>
                            Firma Cliente
                        </p>
                    </div>
                    <div class="col-6">
                        <p class="text-center">
                            _______________________________
                            <br>
                            Aseguradora Elegida
                        </p>
                    </div>
                    <div class="col-3">
                        <p class="text-center">
                            _______________________________
                            <br>
                            Fecha
                        </p>
                    </div>
                </div>
            <?php else : ?>
                <div class="col-12">
                    &nbsp;
                </div>

                <div class="row">

                    <div class="col-6 border">
                        <br>
                        <img height="50" width="150" src="<?= constant("url") . $imagen_aseguradora ?>">
                        <br> <br>

                        <b>Póliza: </b> <?= $trato->getFieldValue('P_liza')->getLookupLabel() ?> <br>

                        <div class="row">
                            <div class="col-5">

                                <div class="row">
                                    <div class="col-4">
                                        <b>Marca:</b><br>
                                        <b>Placa:</b> <br>
                                        <b>Año:</b><br>
                                        <b>Desde:</b>
                                    </div>

                                    <div class="col-8">
                                        <?php
                                        echo strtoupper($bien->getFieldValue('Marca'));
                                        echo "<br>";
                                        echo $bien->getFieldValue('Placa');
                                        echo "<br>";
                                        echo $bien->getFieldValue('A_o');
                                        echo "<br>";
                                        echo $trato->getFieldValue('Fecha_de_emisi_n');
                                        ?>
                                    </div>

                                </div>
                            </div>

                            <div class="col-7">
                                <div class="row">

                                    <div class="col-3">
                                        <b>Modelo:</b><br>
                                        <b>Chasis:</b><br>
                                        <b>Hasta:</b>
                                    </div>

                                    <div class="col-9">
                                        <?php
                                        echo strtoupper($bien->getFieldValue('Modelo'));
                                        echo "<br>";
                                        echo $bien->getFieldValue('Name');
                                        echo "<br>";
                                        echo $trato->getFieldValue('Closing_Date');
                                        ?>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-6 border">

                        <small>
                            <div class="text-center font-weight-bold">EN CASO DE ACCIDENTE</div>
                            <p>Realiza el levantamiento del acta policial y obtén la siguente cotizacionrmación:</p>

                            <ul>
                                <li>Nombre,dirección y teléfonos del conductor,los lesionados,del propietario y de los testigos.</li>
                                <li>Número de placa y póliza del vehículo involucrado, y nombre de la aseguradora</li>
                            </ul>

                            <b>EN CASO DE ROBO: </b>Notifica de inmediato a la Policía y a la Aseguradora.

                            <br>
                            <div class="text-center"><b>RESERVE SU DERECHO</b></div>
                            <br>

                            <div class="row">
                                <div class="col-12">
                                    <b>Aseguradora</b> Tel. <?= $aseguradora->getFieldValue('Phone') ?>
                                </div>
                                <?php if ($coberturas->getFieldValue('Asistencia_Accidente') != null) : ?>
                                    <div class="col-6">
                                        <b><?= $coberturas->getFieldValue('Asistencia_Accidente') ?></b><br>
                                        Tel. Sto. Dgo <?= $coberturas->getFieldValue('Tel_fono_Accidente') ?> <br>
                                        Tel. Santiago<?= $coberturas->getFieldValue('Tel_fono_Accidente_Santiago') ?>
                                    </div>
                                <?php endif ?>
                                <?php if ($coberturas->getFieldValue('Asistencia_vial') == 1) : ?>
                                    <div class="col-6">
                                        <b>Asistencia vial 24 horas</b><br>
                                        Tel. <?= $coberturas->getFieldValue('Tel_fono_Asistencia_vial') ?>
                                    </div>
                                <?php endif ?>
                            </div>
                        </small>

                    </div>
                </div>
            <?php endif ?>

        </div>

        <script>
            var time = 500;
            var url = "<?= constant("url") ?>";
            var id = "<?= $cotizacion->getEntityId() ?>";
            setTimeout(function () {
                window.print();
                window.location = url + "detalles/" + id;
            }, time);
        </script>

    </body>

</html>