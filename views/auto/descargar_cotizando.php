<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

    <title>Cotización No. <?= $cotizacion->getFieldValue('Quote_Number') ?></title>
    <link rel="icon" type="image/png" href="<?= constant("url") ?>public/img/logo.png">

    <style>
        @media print {
            .saltoDePagina {
                display: block;
                page-break-before: always;
            }

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
                <img src="<?= constant("url") ?>public/img/logo.png" width="100" height="100">
            </div>

            <div class="col-8">
                <h4 class="text-uppercase text-center">
                    cotización coberturas <br> seguro vehículo de motor <br> plan <?= $cotizacion->getFieldValue('Plan') ?>
                </h4>
            </div>

            <div class="col-2">
                <b>Fecha</b> <br> <?= $cotizacion->getFieldValue('Fecha_emisi_n') ?> <br>
                <b>Cotización No.</b> <br> <?= $cotizacion->getFieldValue('Quote_Number') ?> <br>
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
                        <b>Tipo:</b>
                    </div>

                    <div class="col-8">
                        <?= strtoupper($cotizacion->getFieldValue('Marca')->getLookupLabel()) ?><br>
                        <?= strtoupper($cotizacion->getFieldValue('Modelo')->getLookupLabel()) ?><br>
                        <?= $cotizacion->getFieldValue('A_o_Fabricaci_n') ?><br>
                        <?= $cotizacion->getFieldValue('Tipo_Veh_culo') ?>
                    </div>
                </div>
            </div>

            <div class="col-6 border">
                <div class="row">
                    <div class="col-4">
                        <b>Tipo de Póliza:</b><br>
                        <b>Uso:</b><br>
                        <b>Condiciones:</b><br>
                        <b>Suma Asegurado:</b>
                    </div>

                    <div class="col-8">
                        <?= $cotizacion->getFieldValue('Tipo_P_liza') ?><br>
                        <?= $cotizacion->getFieldValue('Uso_Veh_culo') ?><br>
                        <?= ($cotizacion->getFieldValue('Veh_culo_Nuevo') == 1) ? "Nuevo" : "Usado"; ?><br>
                        RD$<?= number_format($cotizacion->getFieldValue('Valor_Asegurado'), 2) ?>
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
                            $plan_detalles = $api->detalles_registro("Products", $plan->getProduct()->getEntityId());

                            $criterio = "Socio:equals:" . $_SESSION["usuario"]["empresa_id"];
                            $contratos = $api->buscar_criterio("Contratos", $criterio, 1, 10);
                            foreach ($contratos as $contrato) {
                                if ($contrato->getFieldValue("Aseguradora")->getEntityId() == $plan_detalles->getFieldValue("Vendor_Name")->getEntityId()) {
                                    $coberturas = $contrato;
                                }
                            }

                            $imagen_aseguradora = $api->obtener_imagen("Vendors", $plan_detalles->getFieldValue("Vendor_Name")->getEntityId(), "public/img");
                            ?>
                            <div class="col-2">
                                <img height="31" width="90" src="<?= constant("url") . $imagen_aseguradora ?>">
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
    </div>

    <script>
        var time = 500;
        var url = "<?= constant("url") ?>";
        var id = "<?= $id ?>";
        setTimeout(function() {
            window.print();
            window.location = url + "auto/detalles/" + id;
        }, time);
    </script>

</body>

</html>