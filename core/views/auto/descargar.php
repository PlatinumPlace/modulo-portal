<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js" crossorigin="anonymous"></script>

    <title>Cotización No. <?= $detalles->getFieldValue('Quote_Number') ?></title>

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
                <img src="<?= constant("url") ?>public/icons/logo.png" width="100" height="100">
            </div>

            <div class="col-8">
                <h4 class="text-uppercase text-center">
                    cotización <br> seguro vehí­culo de motor <br> <?= $detalles->getFieldValue('Subject') ?>
                </h4>
            </div>

            <div class="col-2">
                <b>Fecha</b> <br> <?= date("d-m-Y") ?> <br>
                <b>Cotización No.</b> <br> <?= $detalles->getFieldValue('Quote_Number') ?> <br>
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
                        echo $detalles->getFieldValue('Nombre');
                        echo "<br>";
                        echo $detalles->getFieldValue('RNC_C_dula');
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
                        &nbsp;
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
                        echo strtoupper($detalles->getFieldValue('Marca')->getLookupLabel());
                        echo "<br>";
                        echo strtoupper($detalles->getFieldValue('Modelo')->getLookupLabel());
                        echo "<br>";
                        echo $detalles->getFieldValue('A_o_Fabricaci_n');
                        echo "<br>";
                        echo $detalles->getFieldValue('Tipo_Veh_culo');
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
                        &nbsp;
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
                                        Casa del conductor / <br> Centro del Automovilista
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

                    <?php $planes = $detalles->getLineItems() ?>
                    <?php foreach ($planes as $plan) : ?>
                        <?php if ($plan->getNetTotal() > 0) : ?>
                            <div class="col-2">
                                <?php
                                $imagen_aseguradora = $cotizacion->imagenAseguradora($plan->getProduct()->getEntityId());
                                $coberturas = $cotizacion->coberturas($plan->getProduct()->getEntityId());
                                ?>
                                <img height="31" width="90" src="<?= constant("url") . $imagen_aseguradora ?>">

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

                                        <br>

                                        <h6 class="card-title">
                                            <small>RD$<?= number_format($plan->getListPrice(), 2) ?></small>
                                        </h6>
                                        <h6 class="card-title">
                                            <small>RD$<?= number_format($plan->getTaxAmount(), 2) ?></small>
                                        </h6>
                                        <h6 class="card-title">
                                            <small>RD$<?= number_format($plan->getNetTotal(), 2) ?></small>
                                        </h6>

                                    </div>
                                </div>
                            </div>
                        <?php endif ?>
                    <?php endforeach ?>
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


    </div>

    <script>
        var time = 500;
        var url = "<?= constant("url") ?>";
        var id = "<?= $_GET["id"] ?>";
        setTimeout(function() {
            window.print();
            window.location = url + "auto/detalles?id=" + id;
        }, time);
    </script>

</body>

</html>