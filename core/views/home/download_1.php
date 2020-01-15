<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0" />
    <title>Cotización</title>

    <!-- CSS  -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

</head>

<body>

    <main>
        <div class='container'>

            <div class="row row-cols-3">

                <div class="col mx-auto" style="width: 200px;">
                    <h5>
                        COTIZACIÓN<br>
                        SEGURO VEHICULO DE MOTOR<br>
                        PLAN <?= strtoupper($oferta->getFieldValue('Plan')) ?> <?= strtoupper($oferta->getFieldValue('Tipo_de_poliza')) ?>
                    </h5>
                </div>

                <div class="col">
                    <?php foreach ($cotizaciones as $cotizacion) : ?>
                        <p>
                            Cotización <?= $cotizacion->getFieldValue('Quote_Number') ?><br>
                            Fecha <?= date('d/m/Y') ?>
                        </p>
                        <?php break ?>
                    <?php endforeach ?>
                </div>

            </div>

            <br>

            <div class="mx-auto" style="width: 200px;">
                <h6>
                    DATOS DEL CLIENTE
                </h6>
            </div>

            <div class="row row-cols-2">
                <div class="col">
                    <div class="row row-cols-2">
                        <div class="col">
                            <P>
                                <b>Cliente: </b><br>
                                <b>Cedula/RNC: </b><br>
                                <b>Direccion: </b><br>
                                <b>Email: </b>
                            </P>
                        </div>
                        <div class="col">
                            <P>
                                <?= $oferta->getFieldValue('Nombre_del_asegurado') . " " . $oferta->getFieldValue('Apellido_del_asegurado') ?><br>
                                <?= $oferta->getFieldValue('RNC_Cedula_del_asegurado') ?><br>
                                <?= $oferta->getFieldValue('Direcci_n_del_asegurado') ?><br>
                                <?= $oferta->getFieldValue('Email_del_asegurado') ?>
                            </P>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="row row-cols-2">
                        <div class="col">
                            <P>
                                <b>Tel. Residencia: </b><br>
                                <b>Tel. Celular: </b><br>
                                <b>Tel. Trabajo: </b><br>
                                <b>Otro: </b>
                            </P>
                        </div>
                        <div class="col">
                            <P>
                                <?= $oferta->getFieldValue('Telefono_del_asegurado') ?>
                            </P>
                        </div>
                    </div>
                </div>

            </div>


            <div class="mx-auto" style="width: 200px;">
                <h6>
                    DATOS DEL VEHICULO
                </h6>
            </div>

            <div class="row row-cols-2">

                <div class="col">
                    <div class="row row-cols-2">
                        <div class="col">
                            <P>
                                <b>Tipo: </b><br>
                                <b>Marca: </b><br>
                                <b>Modelo: </b><br>
                                <b>Año: </b><br>
                                <b>Suma Asegurado: </b>
                            </P>
                        </div>
                        <div class="col">
                            <P>
                                <?= $oferta->getFieldValue('Tipo_de_vehiculo') ?><br>
                                <?= $oferta->getFieldValue('Marca') ?><br>
                                <?= $oferta->getFieldValue('Modelo') ?><br>
                                <?= $oferta->getFieldValue('A_o_de_Fabricacion') ?><br>
                                RD$<?= number_format($oferta->getFieldValue('Valor_Asegurado'), 2) ?>
                            </P>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="row row-cols-2">
                        <div class="col">
                            <P>
                                <b>Chasis: </b><br>
                                <b>Placa: </b><br>
                                <b>Color: </b><br>
                                <b>Condiciones: </b>
                            </P>
                        </div>
                        <div class="col">
                            <P>
                                <?= $oferta->getFieldValue('Chasis') ?><br>
                                <?= $oferta->getFieldValue('Placa') ?><br>
                                <?= $oferta->getFieldValue('Color') ?><br>
                                <?= $retVal = ($oferta->getFieldValue('Es_nuevo') == 1) ? "Nuevo" : "Usado"; ?>
                            </P>
                        </div>
                    </div>
                </div>

            </div>

            <br>

            <div class="mx-auto" style="width: 200px;">
                <h6>
                    COBERTURAS
                </h6>
            </div>

            <div class="row">

                <div class="col-sm-4">
                    &nbsp;
                </div>
                <?php foreach ($cotizaciones as $cotizacion) : ?>
                    <?php $planes = $cotizacion->getLineItems() ?>
                    <?php foreach ($planes as $plan) : ?>
                        <?php $plan_detalles = $this->api->getRecord("Products", $plan->getProduct()->getEntityId()) ?>
                        <div class="col">
                            <h7><?= $plan_detalles->getFieldValue('Vendor_Name')->getLookupLabel() ?></h7>
                        </div>
                    <?php endforeach ?>
                    <?php break ?>
                <?php endforeach ?>

            </div>

            <div class="row">

                <div class="col-sm-4">
                    <p>
                        <b>DAÑOS PROPIOS</b><br>
                        Riesgos comprensivos<br>
                        Riesgos comprensivos (Deducible)<br>
                        Rotura de Cristales (Deducible)<br>
                        Colisión y vuelco<br>
                        Incendio y robo<br><br>
                        <b>RESPONSABILIDAD CIVIL</b><br>
                        Daños Propiedad ajena<br>
                        Lesiones/Muerte 1 Pers<br>
                        Lesiones/Muerte más de 1 Pers<br>
                        Lesiones/Muerte 1 pasajero<br>
                        Lesiones/Muerte más de 1 pasajero<br><br>
                        <b>RIESGOS CONDUCTOR</b><br><br>
                        <b>FIANZA JUDICIAL</b><br><br>
                        <b>COBERTURAS ADICIONALES</b><br>
                        Asistencia vial<br>
                        Renta Vehículo<br>
                        Casa del conductor<br><br>
                        <b>Prima Neta</b><br>
                        <b>ISC</b><br>
                        <b>Prima Total</b>
                    </p>
                </div>

                <?php foreach ($cotizaciones as $cotizacion) : ?>
                    <?php $planes = $cotizacion->getLineItems() ?>
                    <?php foreach ($planes as $plan) : ?>
                        <?php $plan_detalles = $this->api->getRecord("Products", $plan->getProduct()->getEntityId()) ?>
                        <?php
                        $criterio = "Aseguradora:equals:" . $plan_detalles->getFieldValue('Vendor_Name')->getEntityId();
                        $coberturas = $this->api->searchRecordsByCriteria("Coberturas", $criterio);
                        ?>
                        <?php foreach ($coberturas as $cobertura) : ?>
                            <?php if (
                                $cobertura->getFieldValue('Aseguradora')->getEntityId() == $plan_detalles->getFieldValue('Vendor_Name')->getEntityId()
                                and
                                $cobertura->getFieldValue('Socio_IT')->getEntityId() == $oferta->getFieldValue('Account_Name')->getEntityId()
                            ) : ?>
                                <div class="col">
                                    <p>
                                        <br>
                                        <?= $cobertura->getFieldValue('Riesgos_comprensivos') ?>%<br>
                                        <?= $cobertura->getFieldValue('Riesgos_comprensivos_Deducible') ?>%<br>
                                        <?= $cobertura->getFieldValue('Rotura_de_Cristales_Deducible') ?>%<br>
                                        <?= $cobertura->getFieldValue('Colisi_n_y_vuelco') ?>%<br>
                                        <?= $cobertura->getFieldValue('Incendio_y_robo') ?>% <br><br>
                                        <br>
                                        RD$<?= number_format($cobertura->getFieldValue('Da_os_Propiedad_ajena'), 2) ?><br>
                                        RD$<?= number_format($cobertura->getFieldValue('Lesiones_Muerte_1_Pers'), 2) ?><br>
                                        RD$<?= number_format($cobertura->getFieldValue('Lesiones_Muerte_m_s_de_1_Pers'), 2) ?><br>
                                        RD$<?= number_format($cobertura->getFieldValue('Lesiones_Muerte_1_pasajero'), 2) ?><br>
                                        RD$<?= number_format($cobertura->getFieldValue('Lesiones_Muerte_m_s_de_1_pasajero'), 2) ?><br><br>
                                        RD$<?= number_format($cobertura->getFieldValue('Riesgos_conductor'), 2) ?><br><br>
                                        RD$<?= number_format($cobertura->getFieldValue('Fianza_judicial'), 2) ?><br><br>
                                        <br>
                                        <?= $retVal = ($cobertura->getFieldValue('Asistencia_vial') == 1) ? "Aplica" : "No Aplica"; ?><br>
                                        <?= $retVal = ($cobertura->getFieldValue('Renta_Veh_culo') == 1) ? "Aplica" : "No Aplica"; ?><br>
                                        <?= $retVal = ($cobertura->getFieldValue('Casa_del_Conductor') == 1) ? "Aplica" : "No Aplica"; ?><br><br>
                                        RD$<?= number_format($plan->getListPrice(), 2) ?><br>
                                        RD$<?= number_format($plan->getTaxAmount(), 2) ?><br>
                                        RD$<?= number_format($plan->getNetTotal(), 2) ?>
                                    </p>
                                </div>
                            <?php endif ?>
                            <?php break ?>
                        <?php endforeach ?>
                    <?php endforeach ?>
                    <?php break ?>
                <?php endforeach ?>

            </div>

            <br>

            <div class="row row-cols-3">
                <div class="col">
                    <p>
                        _______________________________
                        <br>
                        Firma Cliente
                    </p>
                </div>
                <div class="col">
                    <p>
                        _______________________________
                        <br>
                        Aseguradora Elegida
                    </p>
                </div>
                <div class="col">
                    <p>
                        _______________________________
                        <br>
                        Fecha
                    </p>
                </div>
            </div>








        </div>
    </main>



    <input type="text" value="<?= $_GET['id'] ?>" id="id" hidden>

    <!--  Scripts-->
    <script>
        var time = 500;
        var id = document.getElementById('id').value;
        setTimeout(function() {
            window.print();
            window.location = "?page=details&id=" + id;
        }, time);
    </script>
</body>

</html>