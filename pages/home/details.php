<div class="section no-pad-bot" id="index-banner">
    <div class="container">
        <h3 class="header center orange-text">
            COTIZACIÓN<br>
            SEGURO VEHICULO DE MOTOR <br>
            PLAN <?= strtoupper($trato->getFieldValue('Plan')) ?> <?= strtoupper($trato->getFieldValue('Tipo_de_poliza')) ?>
        </h3>
        <div class="row center">
            <?php if ($trato->getFieldValue('Aseguradora') == null and !empty($cotizacion) and $cotizacion->getFieldValue('Grand_Total') > 0) : ?>
                <a href="?page=emit&id=<?= $trato_id ?>" class="btn-large waves-effect waves-light">Emitir</a>
            <?php endif ?>
            <?php if ($trato->getFieldValue('Aseguradora') == null) : ?>
                <a href="?page=edit&id=<?= $trato_id ?>" class="btn-large waves-effect waves-light yellow">Editar</a>
                <button data-target="modal" class="btn modal-trigger btn-large waves-effect waves-light red">Eliminar</button>
            <?php endif ?>
            <?php if ($cotizacion->getFieldValue('Grand_Total') > 0) : ?>
                <a href="?page=download&id=<?= $trato_id ?>" class="btn-large waves-effect waves-light green">Descargar</a>
            <?php endif ?>
        </div>

    </div>
</div>

<div class="container">
    <div class="section">

        <div class="row">

            <div class="col s12 center blue white-text">
                <h5>DATOS DEL CLIENTE</h5>
            </div>

            <div class="col s6">
                <div class="row">
                    <div class="col">
                        <P>
                            <b>Cliente:</b><br>
                            <b>Cédula/RNC:</b><br>
                            <b>Direccion:</b><br>
                            <b>Email: </b>
                        </P>
                    </div>
                    <div class="col">
                        <P>
                            <?= $trato->getFieldValue('Nombre_del_asegurado') . " " . $trato->getFieldValue('Apellido_del_asegurado') ?><br>
                            <?= $trato->getFieldValue('RNC_Cedula_del_asegurado') ?><br>
                            <?= $trato->getFieldValue('Direcci_n_del_asegurado') ?><br>
                            <?= $trato->getFieldValue('Email_del_asegurado') ?>
                        </P>
                    </div>
                </div>
            </div>

            <div class="col s6">
                <div class="row">
                    <div class="col">
                        <P>
                            <b>Tel. Residencia:</b><br>
                            <b>Tel. Celular:</b><br>
                            <b>Tel. Trabajo:</b><br>
                            <b>Otro:</b>
                        </P>
                    </div>
                    <div class="col">
                        <P>
                            <?= $trato->getFieldValue('Telefono_del_asegurado') ?>
                        </P>
                    </div>
                </div>
            </div>

        </div>

    </div>

    <div class="section">

        <div class="row">

            <div class="col s12 center blue white-text">
                <h5>DATOS DEL VEHICULO</h5>
            </div>

            <div class="col s6">
                <div class="row">
                    <div class="col">
                        <P>
                            <b>Tipo:</b><br>
                            <b>Marca:</b><br>
                            <b>Modelo:</b><br>
                            <b>Año:</b><br>
                            <b>Suma Asegurado:</b>
                        </P>
                    </div>
                    <div class="col">
                        <P>
                            <?= $trato->getFieldValue('Tipo_de_vehiculo') ?><br>
                            <?= $trato->getFieldValue('Marca') ?><br>
                            <?= $trato->getFieldValue('Modelo') ?><br>
                            <?= $trato->getFieldValue('A_o_de_Fabricacion') ?><br>
                            RD$<?= number_format($trato->getFieldValue('Valor_Asegurado'), 2) ?>
                        </P>
                    </div>
                </div>
            </div>

            <div class="col s6">
                <div class="row">
                    <div class="col">
                        <P>
                            <b>Chasis:</b><br>
                            <b>Placa:</b><br>
                            <b>Color:</b><br>
                            <b>Condiciones:</b><br>
                            &nbsp;
                        </P>
                    </div>
                    <div class="col">
                        <P>
                            <?= $trato->getFieldValue('Chasis') ?><br>
                            <?= $trato->getFieldValue('Placa') ?><br>
                            <?= $trato->getFieldValue('Color') ?><br>
                            <?= $retVal = ($trato->getFieldValue('Es_nuevo') == 1) ? "Nuevo" : "Usado"; ?>
                        </P>
                    </div>
                </div>
            </div>

        </div>

    </div>
</div>

<div class="row">

    <div class="col s12 center blue white-text">
        <h5>COBERTURAS</h5>
    </div>
    <br><br><br>
    <div class="col s12">
        <div class="row">
            <div class="col s3">
                &nbsp;
            </div>
            <?php if (!empty($cotizacion)) : ?>
                <?php $planes = $cotizacion->getLineItems() ?>
                <?php foreach ($planes as $plan) : ?>
                    <?php $plan_detalles = $this->api->getRecord("Products", $plan->getProduct()->getEntityId()) ?>
                    <?php if ($plan_detalles->getFieldValue('Vendor_Name') != null) : ?>
                        <?php
                        $ruta_imagen = $this->api->downloadRecordPhoto(
                            "Vendors",
                            $plan_detalles->getFieldValue('Vendor_Name')->getEntityId(),
                            "img/Aseguradoras/"
                        );
                        ?>
                        <div class="col s2">
                            <img height="80" width="100" src="<?= $ruta_imagen ?>" alt="<?= $plan_detalles->getFieldValue('Vendor_Name')->getLookupLabel() ?>">
                        </div>
                    <?php endif ?>
                <?php endforeach ?>
            <?php endif ?>
        </div>
    </div>
    <div class="col s12">
        <div class="row">
            <div class="col s3">
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
            <?php if (!empty($cotizacion) and $cotizacion->getFieldValue("Grand_Total") > 0) : ?>
                <?php $planes = $cotizacion->getLineItems() ?>
                <?php foreach ($planes as $plan) : ?>
                    <?php $plan_detalles = $this->api->getRecord("Products", $plan->getProduct()->getEntityId()) ?>
                    <?php
                    $criterio = "((Aseguradora:equals:" . $plan_detalles->getFieldValue('Vendor_Name')->getEntityId() . ") and (Socio_IT:equals:" . $trato->getFieldValue('Account_Name')->getEntityId() . "))";
                    $coberturas = $this->api->searchRecordsByCriteria("Coberturas", $criterio);
                    ?>
                    <?php foreach ($coberturas as $cobertura) : ?>
                        <div class="col s2">
                            <p>
                                <b>&nbsp;</b><br>
                                <?= $cobertura->getFieldValue('Riesgos_comprensivos') ?>%<br>
                                <?= $cobertura->getFieldValue('Riesgos_comprensivos_Deducible') ?>%<br>
                                <?= $cobertura->getFieldValue('Rotura_de_Cristales_Deducible') ?>%<br>
                                <?= $cobertura->getFieldValue('Colisi_n_y_vuelco') ?>%<br>
                                <?= $cobertura->getFieldValue('Incendio_y_robo') ?>% <br><br>
                                <b>&nbsp;</b><br>
                                RD$<?= number_format($cobertura->getFieldValue('Da_os_Propiedad_ajena'), 2) ?><br>
                                RD$<?= number_format($cobertura->getFieldValue('Lesiones_Muerte_1_Pers'), 2) ?><br>
                                RD$<?= number_format($cobertura->getFieldValue('Lesiones_Muerte_m_s_de_1_Pers'), 2) ?><br>
                                RD$<?= number_format($cobertura->getFieldValue('Lesiones_Muerte_1_pasajero'), 2) ?><br>
                                RD$<?= number_format($cobertura->getFieldValue('Lesiones_Muerte_m_s_de_1_pasajero'), 2) ?><br><br>
                                RD$<?= number_format($cobertura->getFieldValue('Riesgos_conductor'), 2) ?><br><br>
                                RD$<?= number_format($cobertura->getFieldValue('Fianza_judicial'), 2) ?><br><br>
                                <b>&nbsp;</b><br>
                                <?= $retVal = ($cobertura->getFieldValue('Asistencia_vial') == 1) ? "Aplica" : "No Aplica"; ?><br>
                                <?= $retVal = ($cobertura->getFieldValue('Renta_Veh_culo') == 1) ? "Aplica" : "No Aplica"; ?><br>
                                <?= $retVal = ($cobertura->getFieldValue('Casa_del_Conductor') == 1) ? "Aplica" : "No Aplica"; ?><br><br>
                                RD$<?= number_format($plan->getListPrice(), 2) ?><br>
                                RD$<?= number_format($plan->getTaxAmount(), 2) ?><br>
                                RD$<?= number_format($plan->getNetTotal(), 2) ?>
                            </p>
                        </div>
                    <?php endforeach ?>
                <?php endforeach ?>
            <?php endif ?>
        </div>
    </div>
</div>
<!-- Modal Structure -->
<div id="modal" class="modal">
    <div class="modal-content">
        <h4>¿Estas seguro?</h4>
    </div>
    <div class="modal-footer">
        <a href="#!" class="modal-close waves-effect waves-green btn-flat">No</a>
        <a href="?page=delete&id=<?= $trato_id ?>" class="modal-close waves-effect waves-green btn-flat">Si</a>
    </div>
</div>