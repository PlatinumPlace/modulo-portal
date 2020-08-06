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

        <?php if ($cotizacion->getFieldValue("Deal_Name") == null) : ?>

            <div class="row">

                <div class="col-2">
                    <img src="<?= constant("url") ?>public/img/logo.png" width="100" height="100">
                </div>

                <div class="col-8">
                    <h4 class="text-uppercase text-center">
                        cotización coberturas

                        <?php
                        switch ($cotizacion->getFieldValue("Tipo")) {
                            case 'Auto':
                                echo "<br> seguro vehículo de motor";
                                break;
                        }
                        ?>

                        <br>
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
                            <?= $cotizacion->getFieldValue('Nombre') . " " . $cotizacion->getFieldValue('Apellido') ?><br>
                            <?= $cotizacion->getFieldValue('RNC_C_dula') ?><br>
                            <?= $cotizacion->getFieldValue('Correo') ?><br>
                            <?= $cotizacion->getFieldValue('Direcci_n') ?>
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
                            <?= $cotizacion->getFieldValue('Tel_Residencial') ?><br>
                            <?= $cotizacion->getFieldValue('Tel_Celular') ?><br>
                            <?= $cotizacion->getFieldValue('Tel_Trabajo') ?>
                        </div>
                    </div>
                </div>

                <?php if ($cotizacion->getFieldValue("Tipo") == "Auto") : ?>
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
                                <?= ($cotizacion->getFieldValue('Estado_Veh_culo') == 1) ? "Nuevo" : "Usado"; ?><br>
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
                <?php elseif (
                    $cotizacion->getFieldValue("Tipo") == "Vida"
                    or
                    $cotizacion->getFieldValue("Tipo") == "Desempleo"
                    or
                    $cotizacion->getFieldValue("Tipo") == "Incendio"
                ) : ?>
                    <div class="col-12 d-flex justify-content-center bg-primary text-white">
                        <h6>COBERTURAS</h6>
                    </div>

                    <div class="col-12 border">
                        <div class="row">

                            <div class="col-4">
                                <div class="card border-0">
                                    <div class="card-body">

                                        <h3 class="card-title">
                                            Suma Asegurada:<br>
                                            RD$<?= number_format($cotizacion->getFieldValue('Valor_Asegurado'), 2) ?>
                                        </h3>

                                        <hr>

                                        <p class="card-text">
                                            Prima Neta<br>
                                            ISC<br>
                                            Prima Mensual
                                        </p>
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
                                        <div class="card border-0">
                                            <div class="card-body">

                                                <div class="card-title">
                                                    <img height="65" width="125" src="<?= constant("url") . $imagen_aseguradora ?>">
                                                </div>

                                                <hr>

                                                <p class="card-text">
                                                    RD$<?= number_format($plan->getListPrice(), 2) ?><br>
                                                    RD$<?= number_format($plan->getTaxAmount(), 2) ?><br>
                                                    RD$<?= number_format($plan->getNetTotal(), 2) ?>
                                                </p>

                                            </div>
                                        </div>
                                    </div>
                                <?php endif ?>
                            <?php endforeach ?>
                        </div>
                    </div>
                <?php endif ?>

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
        <?php else : ?>

            <div class="row">

                <div class="col-2">
                    <img src="<?= constant("url") . $imagen_aseguradora ?>" width="150" height="100">
                </div>

                <div class="col-8">
                    <h4 class="text-uppercase text-center">
                        resumen coberturas <br>

                        <?php
                        switch ($cotizacion->getFieldValue("Tipo")) {
                            case 'Auto':
                                echo "seguro vehículo de motor";
                                break;
                        }
                        ?>

                        <br>
                        <?= $trato->getFieldValue('Deal_Name') ?>
                    </h4>
                </div>

                <div class="col-2">
                    <b>Fecha</b> <br> <?= $trato->getFieldValue('Fecha_de_emisi_n') ?> <br>
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
                            <?= $cliente->getFieldValue('First_Name') . " " . $cliente->getFieldValue('Last_Name') ?><br>
                            <?= $cliente->getFieldValue('RNC_C_dula') ?><br>
                            <?= $cliente->getFieldValue('Email') ?><br>
                            <?= $cliente->getFieldValue('Mailing_Street') ?>
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
                            <?= $cliente->getFieldValue('Mobile') ?><br>
                            <?= $cliente->getFieldValue('Phone') ?><br>
                            <?= $cliente->getFieldValue('Tel_Trabajo') ?>
                        </div>
                    </div>
                </div>

                <?php if ($cotizacion->getFieldValue("Tipo") == "Auto") : ?>
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
                                <?= strtoupper($bien->getFieldValue('Marca')) ?><br>
                                <?= strtoupper($bien->getFieldValue('Modelo')) ?><br>
                                <?= $bien->getFieldValue('A_o') ?><br>
                                <?= $bien->getFieldValue('Tipo_de_veh_culo') ?><br>
                                RD$<?= number_format($trato->getFieldValue('Valor_Asegurado'), 2) ?>
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
                                <?= $bien->getFieldValue('Name') ?><br>
                                <?= $bien->getFieldValue('Placa') ?><br>
                                <?= $bien->getFieldValue('Color') ?><br>
                                <?php $bien->getFieldValue('Uso') ?><br>
                                <?php $bien->getFieldValue('Condicion') ?><br>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 d-flex justify-content-center bg-primary text-white">
                        <h6>COBERTURAS</h6>
                    </div>

                    <div class="col-12 border">
                        <div class="row">
                            <div class="col-10">
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

                            <div class="col-2">
                                &nbsp;<br>
                                <div class="card border-0">
                                    <div class="card-body">
                                        <p class="card-text">
                                            <small>
                                                <?php
                                                $resultado = $trato->getFieldValue('Valor_Asegurado') * ($coberturas->getFieldValue('Riesgos_comprensivos') / 100);
                                                ?>
                                                RD$<?= number_format($resultado) ?> <br>
                                                <?= $coberturas->getFieldValue('Riesgos_Comprensivos_Deducible') ?><br>
                                                <?= $coberturas->getFieldValue('Rotura_de_cristales_Deducible') ?><br>
                                                <?php
                                                $resultado = $trato->getFieldValue('Valor_Asegurado') * ($coberturas->getFieldValue('Colisi_n_y_vuelco') / 100);
                                                ?>
                                                RD$<?= number_format($resultado) ?> <br>
                                                <?php
                                                $resultado = $trato->getFieldValue('Valor_Asegurado') * ($coberturas->getFieldValue('Incendio_y_robo') / 100);
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
                                        <h6 class="card-title"><small>RD$<?= number_format($trato->getFieldValue('Prima_Neta'), 2) ?></small></h6>
                                        <h6 class="card-title"><small>RD$<?= number_format($trato->getFieldValue('ISC'), 2) ?></small></h6>
                                        <h6 class="card-title"><small>RD$<?= number_format($trato->getFieldValue('Prima_Total'), 2) ?></small></h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                <?php endif ?>

            </div>

            <?php if ($cotizacion->getFieldValue("Tipo") == "Auto") : ?>
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
                                    </div>

                                    <div class="col-8">
                                        <?= strtoupper($bien->getFieldValue('Marca')) ?><br>
                                        <?= $bien->getFieldValue('Placa') ?><br>
                                        <?= $bien->getFieldValue('A_o') ?><br>
                                    </div>

                                </div>
                            </div>

                            <div class="col-7">
                                <div class="row">

                                    <div class="col-3">
                                        <b>Modelo:</b><br>
                                        <b>Chasis:</b><br>
                                        <b>Desde:</b><br>
                                        <b>Hasta:</b>
                                    </div>

                                    <div class="col-9">
                                        <?= strtoupper($bien->getFieldValue('Modelo')) ?><br>
                                        <?= $bien->getFieldValue('Name') ?><br>
                                        <?= $trato->getFieldValue('Fecha_de_emisi_n') ?><br>
                                        <?= $trato->getFieldValue('Closing_Date') ?><br>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-6 border">
                        <small> <b>EN CASO DE ACCIDENTE</b> <br>
                            Realiza el levantamiento del acta policial y obtén la siguente cotizacionrmación:
                            <li>Nombre,dirección y teléfonos del conductor,los lesionados,del propietario y de los testigos.</li>
                            <li>Número de placa y póliza del vehículo involucrado, y nombre de la aseguradora</li>
                            <b>EN CASO DE ROBO: </b>Notifica de inmediato a la Policía y a la Aseguradora.
                            <br>
                            <div class="text-center"><b>RESERVE SU DERECHO</b></div>
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

        <?php endif ?>

    </div>

    <script>
        var time = 500;
        var url = "<?= constant("url") ?>";
        var id = "<?= $id ?>";
        setTimeout(function() {
            window.print();
            window.location = url + "cotizaciones/detalles/" + id;
        }, time);
    </script>

</body>

</html>