<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">
        COTIZACIÓN<br>
        SEGURO VEHICULO DE MOTOR <br>
        PLAN <?= strtoupper($oferta->getFieldValue('Plan')) ?> <?= strtoupper($oferta->getFieldValue('Tipo_de_poliza')) ?>
    </h1>
    <a href="?pagina=descargar_cotizacion&id=<?= $oferta_id ?>" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Descargar</a>
    <a href="?pagina=emitir_cotizacion&id=<?= $oferta_id ?>" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm"><i class="far fa-id-card fa-sm text-white-50"></i> Emitir</a>
    <a href="?pagina=editar_cotizacion&id=<?= $oferta_id ?>" class="d-none d-sm-inline-block btn btn-sm btn-warning shadow-sm"><i class="fas fa-edit fa-sm text-white-50"></i> Editar</a>
    <a href="?pagina=eliminar_cotizacion&id=<?= $oferta_id ?>" class="d-none d-sm-inline-block btn btn-sm btn-danger shadow-sm"><i class="fas fa-trash fa-sm text-white-50"></i> Eliminar</a>
</div>
<div class="row">
    <div class="col-12 d-flex justify-content-center p-3 mb-2 bg-primary text-white">
        <h4>DATOS DEL CLIENTE</h4>
    </div>
    <div class="col-6 border">
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
                    <?= $oferta->getFieldValue('Nombre_del_asegurado') . " " . $oferta->getFieldValue('Apellido_del_asegurado') ?><br>
                    <?= $oferta->getFieldValue('RNC_Cedula_del_asegurado') ?><br>
                    <?= $oferta->getFieldValue('Direcci_n_del_asegurado') ?><br>
                    <?= $oferta->getFieldValue('Email_del_asegurado') ?>
                </P>
            </div>
        </div>
    </div>
    <div class="col-6 border">
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
                    <?= $oferta->getFieldValue('Telefono_del_asegurado') ?>
                </P>
            </div>
        </div>
    </div>
    <div class="col-12 d-flex justify-content-center p-3 mb-2 bg-primary text-white" style="width: 200px;">
        <h4>DATOS DEL VEHICULO</h4>
    </div>
    <div class="col-6 border">
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
                    <?= $oferta->getFieldValue('Tipo_de_vehiculo') ?><br>
                    <?= $oferta->getFieldValue('Marca') ?><br>
                    <?= $oferta->getFieldValue('Modelo') ?><br>
                    <?= $oferta->getFieldValue('A_o_de_Fabricacion') ?><br>
                    RD$<?= number_format($oferta->getFieldValue('Valor_Asegurado'), 2) ?>
                </P>
            </div>
        </div>
    </div>
    <div class="col-6 border">
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
                    <?= $oferta->getFieldValue('Chasis') ?><br>
                    <?= $oferta->getFieldValue('Placa') ?><br>
                    <?= $oferta->getFieldValue('Color') ?><br>
                    <?= $retVal = ($oferta->getFieldValue('Es_nuevo') == 1) ? "Nuevo" : "Usado"; ?>
                </P>
            </div>
        </div>
    </div>
    <div class="col-12 d-flex justify-content-center p-3 mb-2 bg-primary text-white" style="width: 200px;">
        <h4>COBERTURAS</h4>
    </div>
    <div class="col-12">
        <div class="row">
            <div class="col">
                &nbsp;
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
                                <div class="col-2">
                                    <?php if ($oferta->getFieldValue('Aseguradora') == null) : ?>
                                        <?php
                                        $ruta_imagen = $this->api->downloadRecordPhoto(
                                            "Vendors",
                                            $plan_detalles->getFieldValue('Vendor_Name')->getEntityId(),
                                            "img/Aseguradoras/"
                                        );
                                        ?>
                                        <img height="50" width="70" src="<?= $ruta_imagen ?>" alt="<?= $plan_detalles->getFieldValue('Vendor_Name')->getLookupLabel() ?>">
                                    <?php endif ?>
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
    <div class="col-12 border">
        <div class="row">
            <div class="col">
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
                                <div class="col-2">
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