<div class="fixed-action-btn">
    <a class="btn-floating btn-large">
        <i class="large material-icons">menu</i>
    </a>
    <ul>
        <li><a href="?pagina=descargar_cotizacion&id=<?= $oferta_id ?>" data-tooltip="Descarg" class="btn-floating blue tooltipped"><i class="material-icons">file_download</i></a></li>
        <li><a href="?pagina=emitir_cotizacion&id=<?= $oferta_id ?>" data-tooltip="Emitir" class="btn-floating green tooltipped"><i class="material-icons">recent_actors</i></a></li>
        <li><a href="?pagina=editar_cotizacion&id=<?= $oferta_id ?>" data-tooltip="Editar" class="btn-floating yellow tooltipped"><i class="material-icons">edit</i></a></li>
        <li><a href="?pagina=eliminar_cotizacion&id=<?= $oferta_id ?>" data-tooltip="Eliminar" class="btn-floating red tooltipped"><i class="material-icons">delete</i></a></li>
    </ul>
</div>
<div class="row">
    <div class="col s12 m4 l2">
        <img src="files\logo.png" width="150" height="130">
    </div>
    <div class="col s12 m4 l8 center">
        <h5>
            COTIZACIÓN<br>
            SEGURO VEHICULO DE MOTOR <br>
            PLAN <?= strtoupper($oferta->getFieldValue('Plan')) ?> <?= strtoupper($oferta->getFieldValue('Tipo_de_poliza')) ?>
        </h5>
    </div>
    <div class="col s12 m4 l2">
        <?php if (!empty($cotizaciones)) : ?>
            <?php foreach ($cotizaciones as $cotizacion) : ?>
                <p>
                    <b>No. de cotización</b> <?= $cotizacion->getFieldValue('Quote_Number') ?><br>
                    <b>Fecha</b> <br> <?= date('d/m/Y') ?>
                </p>
                <?php break ?>
            <?php endforeach ?>
        <?php endif ?>
    </div>

    <div class="col s12 center">
        <h6>DATOS DEL CLIENTE</h6>
    </div>
    <div class="col s12 m6">
        <div class="card blue-grey darken-1">
            <div class="card-content white-text">
                <div class="row">
                    <div class="col s4">
                        <P>
                            <b>Cliente:</b><br>
                            <b>Cédula/RNC:</b><br>
                            <b>Direccion:</b><br>
                            <b>Email: </b>
                        </P>
                    </div>
                    <div class="col s8">
                        <P>
                            <?= $oferta->getFieldValue('Nombre_del_asegurado') . " " . $oferta->getFieldValue('Apellido_del_asegurado') ?><br>
                            <?= $oferta->getFieldValue('RNC_Cedula_del_asegurado') ?><br>
                            <?= $oferta->getFieldValue('Direcci_n_del_asegurado') ?><br>
                            <?= $oferta->getFieldValue('Email_del_asegurado') ?>
                        </P>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col s12 m6">
        <div class="card blue-grey darken-1">
            <div class="card-content white-text">
                <div class="row">
                    <div class="col s6">
                        <P>
                            <b>Tel. Residencia:</b><br>
                            <b>Tel. Celular:</b><br>
                            <b>Tel. Trabajo:</b><br>
                            <b>Otro:</b>
                        </P>
                    </div>
                    <div class="col s6">
                        <P>
                            <?= $oferta->getFieldValue('Telefono_del_asegurado') ?>
                        </P>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col s12 center">
        <h6>DATOS DEL VEHICULO</h6>
    </div>
    <div class="col s12 m6">
        <div class="card blue-grey darken-1">
            <div class="card-content white-text">
                <div class="row">
                    <div class="col s6">
                        <P>
                            <b>Tipo:</b><br>
                            <b>Marca:</b><br>
                            <b>Modelo:</b><br>
                            <b>Año:</b><br>
                            <b>Suma Asegurado:</b>
                        </P>
                    </div>
                    <div class="col s6">
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
        </div>
    </div>
    <div class="col s12 m6">
        <div class="card blue-grey darken-1">
            <div class="card-content white-text">
                <div class="row">
                    <div class="col s6">
                        <P>
                            <b>Chasis:</b><br>
                            <b>Placa:</b><br>
                            <b>Color:</b><br>
                            <b>Condiciones:</b><br>
                            &nbsp;
                        </P>
                    </div>
                    <div class="col s6">
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
    </div>
    <div class="col s12 left">
        <h6>COBERTURAS</h6>
    </div>
    <div class="col s12">
        <div class="row">
            <div class="col">
                <p><b>&nbsp;</b></p>
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
            <?php if (!empty($cotizaciones)) : ?>
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
                                    <p><b><?= $plan_detalles->getFieldValue('Vendor_Name')->getLookupLabel() ?></b></p>
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
                            <?php endif ?>
                            <?php break ?>
                        <?php endforeach ?>
                    <?php endforeach ?>
                    <?php break ?>
                <?php endforeach ?>
            <?php endif ?>
        </div>
    </div>
</div>