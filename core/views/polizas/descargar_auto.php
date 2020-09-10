<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js" crossorigin="anonymous"></script>

    <title>Resumen No. <?= $detalles->getFieldValue('No_orden') ?></title>

    <link rel="icon" type="image/png" href="<?= constant("url") ?>public/icons/logo.png">

</head>

<div class="container">
    <div class="row">

        <div class="col-2">
            <img src="<?= constant("url") . $imagen_aseguradora ?>" width="160" height="90">
        </div>

        <div class="col-8">
            <h4 class="text-uppercase text-center">
                resumen coberturas <br> seguro vehí­culo de motor <br> <?= $detalles->getFieldValue('Deal_Name') ?>
            </h4>
        </div>

        <div class="col-2">
            <b>Fecha</b> <br> <?= date("d-m-Y") ?> <br>
            <b>No.</b> <br> <?= $detalles->getFieldValue('No_orden') ?> <br>
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
                    <?php
                    echo $cliente->getFieldValue('First_Name') . " " . $cliente->getFieldValue('Last_Name');
                    echo "<br>";
                    echo $cliente->getFieldValue('RNC_C_dula');
                    echo "<br>";
                    echo $cliente->getFieldValue('Email');
                    echo "<br>";
                    echo $cliente->getFieldValue('Mailing_Street');
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
                    echo $cliente->getFieldValue('Phone');
                    echo "<br>";
                    echo $cliente->getFieldValue('Mobile');
                    echo "<br>";
                    echo $cliente->getFieldValue('Tel_Trabajo');
                    ?>
                </div>

            </div>
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
                    echo $bien->getFieldValue('Marca');
                    echo "<br>";
                    echo $bien->getFieldValue('Modelo');
                    echo "<br>";
                    echo $bien->getFieldValue('A_o');
                    echo "<br>";
                    echo $bien->getFieldValue('Tipo_de_veh_culo');
                    echo "<br>";
                    echo "RD$" . number_format($detalles->getFieldValue('Valor_Asegurado'), 2);
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
                    echo $bien->getFieldValue('Name');
                    echo "<br>";
                    echo $bien->getFieldValue('Placa');
                    echo "<br>";
                    echo $bien->getFieldValue('Color');
                    echo "<br>";
                    echo $bien->getFieldValue('Uso');
                    echo "<br>";
                    echo $bien->getFieldValue('Condicion');
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

                            <h6 class="card-title"><small><b>DAñOS PROPIOS</b></small></h6>
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
                                    Renta Vehí­culo<br>
                                    <?= $coberturas->getFieldValue('En_caso_de_accidente') ?>
                                </small>
                            </p>

                            <h6 class="card-title">
                                <small><b>Prima Neta</b></small>
                            </h6>
                            <h6 class="card-title">
                                <small><b>ISC</b></small>
                            </h6>
                            <h6 class="card-title">
                                <small><b>Prima Total</b></small>
                            </h6>

                        </div>
                    </div>

                </div>

                <div class="col-2">
                    &nbsp;
                </div>

                <div class="col-2">

                    <br>

                    <div class="card border-0">
                        <div class="card-body">

                            <p class="card-text">
                                <small>
                                    <?php
                                    $resultado = $detalles->getFieldValue('Valor_Asegurado') * ($coberturas->getFieldValue('Riesgos_comprensivos') / 100);
                                    ?>
                                    RD$<?= number_format($resultado) ?> <br>
                                    <?= $coberturas->getFieldValue('Riesgos_comprensivos_deducible') ?><br>
                                    <?= $coberturas->getFieldValue('Rotura_de_cristales_deducible') ?><br>
                                    <?php
                                    $resultado = $detalles->getFieldValue('Valor_Asegurado') * ($coberturas->getFieldValue('Colisi_n_y_vuelco') / 100);
                                    ?>
                                    RD$<?= number_format($resultado) ?> <br>
                                    <?php
                                    $resultado = $detalles->getFieldValue('Valor_Asegurado') * ($coberturas->getFieldValue('Incendio_y_robo') / 100);
                                    ?>
                                    RD$<?= number_format($resultado) ?> <br>
                                </small>
                            </p>

                            <h6 class="card-title">&nbsp;</h6>
                            <p class="card-text">
                                <small>
                                    RD$<?= number_format($coberturas->getFieldValue('Da_os_propiedad_ajena')) ?> <br>
                                    RD$<?= number_format($coberturas->getFieldValue('Lesiones_muerte_1_pas')) ?> <br>
                                    RD$<?= number_format($coberturas->getFieldValue('Lesiones_muerte_m_s_pas')) ?> <br>
                                    RD$<?= number_format($coberturas->getFieldValue('Lesiones_muerte_1_pers')) ?> <br>
                                    RD$<?= number_format($coberturas->getFieldValue('Lesiones_muerte_m_s_pers')) ?>
                                </small>
                            </p>

                            <h6 class="card-title">
                                <small>RD$ <?= number_format($coberturas->getFieldValue('Riesgos_conductor')) ?></small>
                            </h6>

                            <h6 class="card-title">
                                <small>RD$ <?= number_format($coberturas->getFieldValue('Fianza_judicial')) ?></small>
                            </h6>

                            <h6 class="card-title">&nbsp;</h6>
                            <p class="card-text">
                                <small>
                                    <?= ($coberturas->getFieldValue('Asistencia_vial') == 1) ? "Aplica" : "No Aplica" ?><br>
                                    <?= ($coberturas->getFieldValue('Renta_veh_culo') == 1) ? "Aplica" : "No Aplica" ?> <br>
                                    <?= ($coberturas->getFieldValue('En_caso_de_accidente') != null) ? "Aplica" : "No Aplica" ?> <br>
                                </small>
                            </p>

                            <h6 class="card-title">
                                <small>RD$<?= number_format($detalles->getFieldValue('Prima_Neta'), 2) ?></small>
                            </h6>
                            <h6 class="card-title">
                                <small>RD$<?= number_format($detalles->getFieldValue('ISC'), 2) ?></small>
                            </h6>
                            <h6 class="card-title">
                                <small>RD$<?= number_format($detalles->getFieldValue('Prima_Total'), 2) ?></small>
                            </h6>

                        </div>
                    </div>

                </div>

            </div>
        </div>

    </div>

    <div class="col-12">
        &nbsp;
    </div>

    <div class="row small">

        <div class="col-6 border">

            <br>
            <img height="60" width="150" src="<?= constant("url") . $imagen_aseguradora ?>">
            <br><br>

            <div class="row">

                <div class="col-md-4">
                    <p>
                        <b>Póliza:</b><br>
                        <b>Marca:</b> <br>
                        <b>Modelo:</b> <br>
                        <b>Chasis:</b> <br>
                        <b>Placa:</b> <br>
                        <b>Año:</b> <br>
                        <b>Desde:</b> <br>
                        <b>Hasta:</b>
                    </p>
                </div>

                <div class="col-md-8">
                    <p>
                        <?= $detalles->getFieldValue('P_liza')->getLookupLabel() ?> <br>
                        <?= strtoupper($bien->getFieldValue('Marca')) ?> <br>
                        <?= strtoupper($bien->getFieldValue('Modelo')) ?> <br>
                        <?= $bien->getFieldValue('Name') ?> <br>
                        <?= $bien->getFieldValue('Placa') ?> <br>
                        <?= $bien->getFieldValue('A_o') ?> <br>
                        <?= $detalles->getFieldValue('Fecha_de_emisi_n') ?> <br>
                        <?= $detalles->getFieldValue('Closing_Date') ?>
                    </p>
                </div>

            </div>

        </div>

        <div class="col-6 border">

            <div class="text-center font-weight-bold">EN CASO DE ACCIDENTE</div>
            <p>
                Realiza el levantamiento del acta policial y obténga la siguente cotizacionrmación:

                <ul>
                    <li>Nombre,dirección y teléfonos del conductor,los lesionados,del propietario y de los testigos.</li>
                    <li>Número de placa y póliza del vehí­culo involucrado, y nombre de la aseguradora</li>
                </ul>

                <b>EN CASO DE ROBO:</b>Notifica de inmediato a la Policía y a la Aseguradora. <br>

                <div class="text-center"><b>RESERVE SU DERECHO</b></div>
            </p>

            <p>
                <b>Aseguradora:</b> Tel. <?= $aseguradora->getFieldValue('Phone') ?>
            </p>

            <div class="row">

                <div class="col-md-8">
                    <?php if ($coberturas->getFieldValue('En_caso_de_accidente') != null) : ?>
                        <p>
                            <b><?= $coberturas->getFieldValue('En_caso_de_accidente') ?></b> <br>
                            Tel. Sto. Dgo <?= $coberturas->getFieldValue('Tel_accidente_Sto_Dgo') ?> <br>
                            Tel. Santiago <?= $coberturas->getFieldValue('Tel_accidente_Santiago') ?>
                        </p>
                    <?php endif ?>
                </div>

                <div class="col-md-4">
                    <?php if ($coberturas->getFieldValue('Asistencia_vial') == 1) : ?>
                        <p>
                            <b>Asistencia vial 24 horas</b> <br>
                            Tel. <?= $coberturas->getFieldValue('Tel_asistencia_vial') ?>
                        </p>
                    <?php endif ?>
                </div>

            </div>

        </div>

    </div>

</div>

<script>
        var time = 500;
        var url = "<?= constant("url") ?>";
        var id = "<?= $_GET["id"] ?>";
        setTimeout(function() {
            window.print();
            window.location = url + "polizas/detalles?id=" + id;
        }, time);
    </script>

</body>

</html>