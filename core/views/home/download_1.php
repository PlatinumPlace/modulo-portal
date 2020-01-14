<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0" />
    <title>Cotización</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

</head>

<body>

    <main>
        <div class='container'>

            <div class="row">
                <div class="col s3">

                </div>
                <div class="col s7">
                    <h5>
                        COTIZACIÓN PARA <br>
                        SEGURO VEHICULO DE MOTOR <br>
                        PLAN <?= strtoupper($oferta->getFieldValue('Plan')) ?> <?= strtoupper($oferta->getFieldValue('Tipo_de_poliza')) ?>
                    </h5>
                </div>
                <div class="col s2">
                    <?php foreach ($cotizaciones as $cotizacion) : ?>
                        <p>Cotización <?= $cotizacion->getFieldValue('Quote_Number') ?></p>
                        <p>Fecha <?= date('d/m/Y') ?></p>
                        <?php break ?>
                    <?php endforeach ?>
                </div>
            </div>

            <br>


                <center>
                    <h6>
                        DATOS DEL CLIENTE
                    </h6>
                </center>
            <div class="row">

                <div class="col">
                    <div class="col">
                        <P>
                            <b>Cliente: </b>
                            <br>
                            <b>Cedula/RNC: </b>
                            <br>
                            <b>Direccion: </b>
                            <br>
                            <b>Email: </b>
                        </P>
                    </div>
                    <div class="col">
                        <P>
                            <?= $oferta->getFieldValue('Nombre_del_asegurado') . " " . $oferta->getFieldValue('Apellido_del_asegurado') ?>
                            <br>
                            <?= $oferta->getFieldValue('RNC_Cedula_del_asegurado') ?>
                            <br>
                            <?= $oferta->getFieldValue('Direcci_n_del_asegurado') ?>
                            <br>
                            <?= $oferta->getFieldValue('Email_del_asegurado') ?>
                        </P>
                    </div>
                </div>

                <div class="col">
                    <div class="col">
                        <P>
                            <P>
                                <b>Tel. Residencia: </b>
                                <br>
                                <b>Tel. Celular: </b>
                                <br>
                                <b>Tel. Trabajo: </b>
                                <br>
                                <b>Otro: </b>
                            </P>
                        </P>
                    </div>
                    <div class="col ">
                        <P>
                            <?= $oferta->getFieldValue('Telefono_del_asegurado') ?>
                        </P>
                    </div>
                </div>
            </div>

            
            <div class="row">
                <div class="col s12 center">
                    <h6>
                        DATOS DEL VEHICULO
                    </h6>
                </div>
            </div>
            <div class="row">
                <div class="col s6">
                    <div class="col s6">
                        <P>
                            <b>Tipo: </b>
                            <br>
                            <b>Marca: </b>
                            <br>
                            <b>Modelo: </b>
                            <br>
                            <b>Año: </b>
                            <br>
                            <b>Suma Asegurado: </b>
                        </P>
                    </div>
                    <div class="col s6">
                        <P>
                            <?= $oferta->getFieldValue('Tipo_de_vehiculo') ?>
                            <br>
                            <?= $oferta->getFieldValue('Marca') ?>
                            <br>
                            <?= $oferta->getFieldValue('Modelo') ?>
                            <br>
                            <?= $oferta->getFieldValue('A_o_de_Fabricacion') ?>
                            <br>
                            RD$<?= number_format($oferta->getFieldValue('Valor_Asegurado'), 2) ?>
                        </P>
                    </div>
                </div>

                <div class="col s6">
                    <div class="col s6">
                        <P>
                            <b>Chasis: </b>
                            <br>
                            <b>Placa: </b>
                            <br>
                            <b>Color: </b>
                            <br>
                            <b>Condiciones: </b>
                        </P>
                    </div>
                    <div class="col s6">
                        <P>
                            <?= $oferta->getFieldValue('Chasis') ?>
                            <br>
                            <?= $oferta->getFieldValue('Placa') ?>
                            <br>
                            <?= $oferta->getFieldValue('Color') ?>
                            <br>
                            <?= $retVal = ($oferta->getFieldValue('Es_nuevo') == 1) ? "Nuevo" : "Usado"; ?>
                        </P>
                    </div>
                </div>
            </div>

            <br>

            <table class="table">

                <div class="center">
                    <h6>
                        COBERTURAS
                    </h6>
                </div>

                <thead>
                    <tr>
                        <th scope="col">&nbsp;</th>
                        <?php foreach ($cotizaciones as $cotizacion) : ?>
                            <?php $planes = $cotizacion->getLineItems() ?>
                            <?php foreach ($planes as $plan) : ?>
                                <?php $plan_detalles = $this->api->getRecord("Products", $plan->getProduct()->getEntityId()) ?>
                                <th scope="col"><?= $plan_detalles->getFieldValue('Vendor_Name')->getLookupLabel() ?></th>
                            <?php endforeach ?>
                            <?php break ?>
                        <?php endforeach ?>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <p><b>DAÑOS PROPIOS</b></p>
                            <p>Riesgos comprensivos</p>
                            <p>Riesgos comprensivos (Deducible)</p>
                            <p>Rotura de Cristales (Deducible)</p>
                            <p>Colisión y vuelco</p>
                            <p>Incendio y robo</p>
                        </td>
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
                                        <td>
                                            <p>&nbsp;</p>
                                            <p><?= $cobertura->getFieldValue('Riesgos_comprensivos') ?>%</p>
                                            <p><?= $cobertura->getFieldValue('Riesgos_comprensivos_Deducible') ?>%</p>
                                            <p><?= $cobertura->getFieldValue('Rotura_de_Cristales_Deducible') ?>%</p>
                                            <p><?= $cobertura->getFieldValue('Colisi_n_y_vuelco') ?>%</p>
                                            <p><?= $cobertura->getFieldValue('Incendio_y_robo') ?>%</p>
                                        </td>
                                    <?php endif ?>
                                    <?php break ?>
                                <?php endforeach ?>
                            <?php endforeach ?>
                            <?php break ?>
                        <?php endforeach ?>
                    </tr>
                    <tr>
                        <td>
                            <p><b>RESPONSABILIDAD CIVIL</b></p>
                            <p>Daños Propiedad ajena</p>
                            <p>Lesiones/Muerte 1 Pers</p>
                            <p>Lesiones/Muerte más de 1 Pers</p>
                            <p>Lesiones/Muerte 1 pasajero</p>
                            <p>Lesiones/Muerte más de 1 pasajero</p>
                        </td>
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
                                        <td>
                                            <p>&nbsp;</p>
                                            <p>RD$<?= number_format($cobertura->getFieldValue('Da_os_Propiedad_ajena'), 2) ?></p>
                                            <p>RD$<?= number_format($cobertura->getFieldValue('Lesiones_Muerte_1_Pers'), 2) ?></p>
                                            <p>RD$<?= number_format($cobertura->getFieldValue('Lesiones_Muerte_m_s_de_1_Pers'), 2) ?></p>
                                            <p>RD$<?= number_format($cobertura->getFieldValue('Lesiones_Muerte_1_pasajero'), 2) ?></p>
                                            <p>RD$<?= number_format($cobertura->getFieldValue('Lesiones_Muerte_m_s_de_1_pasajero'), 2) ?></p>
                                        </td>
                                    <?php endif ?>
                                    <?php break ?>
                                <?php endforeach ?>
                            <?php endforeach ?>
                            <?php break ?>
                        <?php endforeach ?>
                    </tr>
                    <tr>
                        <td>
                            <p><b>RIESGOS CONDUCTOR</b></p>
                        </td>
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
                                        <td>
                                            <p>RD$<?= number_format($cobertura->getFieldValue('Riesgos_conductor'), 2) ?></p>
                                        </td>
                                    <?php endif ?>
                                    <?php break ?>
                                <?php endforeach ?>
                            <?php endforeach ?>
                            <?php break ?>
                        <?php endforeach ?>
                    </tr>
                    <tr>
                        <td>
                            <p><b>FIANZA JUDICIAL</b> </p>
                        </td>
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
                                        <td>
                                            <p>RD$<?= number_format($cobertura->getFieldValue('Fianza_judicial'), 2) ?></p>
                                        </td>
                                    <?php endif ?>
                                    <?php break ?>
                                <?php endforeach ?>
                            <?php endforeach ?>
                            <?php break ?>
                        <?php endforeach ?>
                    </tr>
                    <tr>
                        <td>
                            <p><b>COBERTURAS ADICIONALES</b> </p>
                            <p>Asistencia vial</p>
                            <p>Renta Vehículo</p>
                            <p>Casa del conductor</p>
                        </td>
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
                                        <td>

                                            <p>&nbsp;</p>
                                            <p><?= $retVal = ($cobertura->getFieldValue('Asistencia_vial') == 1) ? "Aplica" : "No Aplica"; ?></p>
                                            <p><?= $retVal = ($cobertura->getFieldValue('Asistencia_vial') == 1) ? "Aplica" : "No Aplica"; ?></p>
                                            <p><?= $retVal = ($cobertura->getFieldValue('Casa_del_Conductor') == 1) ? "Aplica" : "No Aplica"; ?></p>
                                        </td>
                                    <?php endif ?>
                                    <?php break ?>
                                <?php endforeach ?>
                            <?php endforeach ?>
                            <?php break ?>
                        <?php endforeach ?>
                    </tr>
                    <tr>
                        <td>
                            <p><b>Prima Neta</b></p>
                        </td>
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
                                        <td>
                                            <p>RD$<?= number_format($plan->getListPrice(), 2) ?></p>
                                        </td>
                                    <?php endif ?>
                                    <?php break ?>
                                <?php endforeach ?>
                            <?php endforeach ?>
                            <?php break ?>
                        <?php endforeach ?>
                    </tr>
                    <tr>
                        <td>
                            <p><b>ISC</b></p>
                        </td>
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
                                        <td>
                                            <p>RD$<?= number_format($plan->getTaxAmount(), 2) ?></p>
                                        </td>
                                    <?php endif ?>
                                    <?php break ?>
                                <?php endforeach ?>
                            <?php endforeach ?>
                            <?php break ?>
                        <?php endforeach ?>
                    </tr>
                    <tr>
                        <td>
                            <p><b>Prima Total</b></p>
                        </td>
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
                                        <td>
                                            <p>RD$<?= number_format($plan->getNetTotal(), 2) ?></p>
                                        </td>
                                    <?php endif ?>
                                    <?php break ?>
                                <?php endforeach ?>
                            <?php endforeach ?>
                            <?php break ?>
                        <?php endforeach ?>
                    </tr>
                </tbody>
            </table>

            <br>

            <div class="row">
                <div class="col s4">
                    <p>
                        _______________________________
                        <br>
                        Firma Cliente
                    </p>
                </div>
                <div class="col s4">
                    <p>
                        _______________________________
                        <br>
                        Aseguradora Elegida
                    </p>
                </div>
                <div class="col s4">
                    <p>
                        _______________________________
                        <br>
                        Fecha
                    </p>
                </div>
            </div>
    </main>

    <!--  Scripts-->
    <script>
        var time = 500;
        setTimeout(function() {
            window.print();
            window.location = "?page=details&id=" + $_GET['id'];
        }, time);
    </script>
</body>

</html>