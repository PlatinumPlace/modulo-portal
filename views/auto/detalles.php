<div class="row">

    <div class="col-lg-9">
        <h4 class="text-uppercase">
            <?php if (!in_array($oferta->getFieldValue("Stage"), $emitida)) : ?>
                cotización
            <?php else : ?>
                resumen coberturas
            <?php endif ?>
            <br>
            seguro vehículo de motor<br>
            plan <?= $oferta->getFieldValue('Plan') ?>
        </h4>
        <?php if ($oferta->getFieldValue('Stage') == "Abandonado") : ?>
            <div class="alert alert-danger" role="alert">
                Cotización Abandonada
            </div>
        <?php endif ?>
        <div class="row">
            <?php if ($oferta->getFieldValue('Nombre') != null) : ?>
                <div class="col-12 d-flex justify-content-center bg-primary text-white">
                    <h6>DATOS DEL CLIENTE</h6>
                </div>
                <div class="col-6 border">
                    <div class="row">
                        <div class="col">
                            <P>
                                <b>Cliente:</b><br>
                                <b>Cédula/RNC:</b><br>
                                <b>Email:</b><br>
                                <b>Dirección:</b>
                            </P>
                        </div>
                        <div class="col">
                            <P>
                                <?= $oferta->getFieldValue('Nombre') . " " . $oferta->getFieldValue('Apellido') ?><br>
                                <?= $oferta->getFieldValue('RNC_Cedula') ?><br>
                                <?= $oferta->getFieldValue('Email') ?><br>
                                <?= $oferta->getFieldValue('Direcci_n') ?>
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
                            </P>
                        </div>
                        <div class="col">
                            <P>
                                <?= $oferta->getFieldValue('Tel_Residencia') ?><br>
                                <?= $oferta->getFieldValue('Telefono') ?><br>
                                <?= $oferta->getFieldValue('Tel_Trabajo') ?><br>
                            </P>
                        </div>
                    </div>
                </div>
            <?php endif ?>
            <div class="col-12 d-flex justify-content-center bg-primary text-white">
                <h6>DATOS DEL VEHÍCULO</h6>
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
                            <?= $oferta->getFieldValue('Tipo_de_veh_culo') ?><br>
                            <?= strtoupper($oferta->getFieldValue('Marca')->getLookupLabel()) ?><br>
                            <?= strtoupper($oferta->getFieldValue('Modelo')->getLookupLabel()) ?><br>
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
                            <b>Uso:</b><br>
                            <b>Condiciones:</b><br>
                            &nbsp;
                        </P>
                    </div>
                    <div class="col">
                        <P>
                            <?= $oferta->getFieldValue('Chasis') ?><br>
                            <?= $oferta->getFieldValue('Placa') ?><br>
                            <?= $oferta->getFieldValue('Color') ?><br>
                            <?= $oferta->getFieldValue('Uso') ?><br>
                            <?= ($oferta->getFieldValue('Es_nuevo') == 1) ? "Nuevo" : "Usado"; ?>
                        </P>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card my-3">
            <div class="card-header">
                <h5>Opciones</h5>
            </div>
            <div class="card-body">
                <?php if ($oferta->getFieldValue('Stage') != "Abandonado") : ?>
                    <?php if ($oferta->getFieldValue('Nombre') == null) : ?>
                        <div class="form-group row justify-content-md-center">
                            <a href="<?= constant('url') ?>auto/completar/<?= $oferta->getEntityId() ?>" class="btn btn-primary">Siguiente</a>
                        </div>
                    <?php else : ?>
                        <div class="form-group row justify-content-md-center">
                            <a href="<?= constant('url') ?>auto/emitir/<?= $oferta->getEntityId() ?>" class="btn btn-success"><?= (!in_array($oferta->getFieldValue("Stage"), $emitida)) ? "Emitir" : "Completar"; ?></a>
                        </div>
                        <div class="form-group row justify-content-md-center">
                            <a href="<?= constant('url') ?>auto/descargar/<?= $oferta->getEntityId() ?>" class="btn btn-info">Descargar</a>
                        </div>
                    <?php endif ?>
                <?php endif ?>
                <div class="form-group row justify-content-md-center">
                    <?php if (in_array($oferta->getFieldValue("Stage"), $emitida)) : ?>
                        <div class="form-group row justify-content-md-center">
                            <a download="Condiciones del Vehículos.pdf" href="<?= constant('url') ?>public/documents/condiciones_vehiculo.pdf" class="btn btn-link">Condiciones del Vehículos</a>
                        </div>
                        <div class="form-group row justify-content-md-center">
                            <a download="Formulario de Conocimiento.pdf" href="<?= constant('url') ?>public/documents/for_conocimiento.pdf" class="btn btn-link">Formulario de conocimiento</a>
                        </div>
                        <div class="form-group row justify-content-md-center">
                            <a download="Formulario de Inspección de Vehículos.pdf" href="<?= constant('url') ?>public/documents/for_inspeccion.pdf" class="btn btn-link">Formulario de Inspección</a>
                        </div>
                    <?php endif ?>
                </div>
            </div>
        </div>
    </div>

</div>
<div class="row">
    <div class="col-md-12 d-flex justify-content-center bg-primary text-white">
        <h6>COBERTURAS</h6>
    </div>
    <div class="col-12 border">
        <div class="row">
            <?php foreach ($cotizaciones as $cotizacion) : ?>
                <?php if ($cotizacion->getFieldValue('Grand_Total') == 0) : ?>
                    <?php $contrato = $this->getRecord("Contratos", $cotizacion->getFieldValue('Contrato')->getEntityId()) ?>
                    <div class="col">
                        <div class="alert alert-info" role="alert">
                            <b><?= $contrato->getFieldValue('Aseguradora')->getLookupLabel() ?></b> no esta disponible.
                        </div>
                    </div>
                <?php endif ?>
            <?php endforeach ?>
        </div>
    </div>
    <div class="col-12 border">
        <div class="row">
            <div class="col">
                <p>&nbsp;</p><br>
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
                <?php if ($cotizacion->getFieldValue('Grand_Total') > 0) : ?>
                    <?php if (!in_array($oferta->getFieldValue("Stage"), $emitida)) : ?>
                        <?php $contrato = $this->getRecord("Contratos", $cotizacion->getFieldValue('Contrato')->getEntityId()) ?>
                        <?php $imagen_aseguradora = $this->downloadPhoto("Vendors", $contrato->getFieldValue('Aseguradora')->getEntityId(), "public/img/") ?>
                    <?php endif ?>
                    <div class="col-2">
                        <p>
                            <img height="50" width="110" src="<?= constant('url') . $imagen_aseguradora ?>">
                        </p>
                        <p>
                            <b>&nbsp;</b><br>
                            <?php
                            $resultado = $oferta->getFieldValue('Valor_Asegurado') * ($contrato->getFieldValue('Riesgos_comprensivos') / 100);
                            echo "RD$" . number_format($resultado);
                            ?><br>
                            <?= $contrato->getFieldValue('Riesgos_Comprensivos_Deducible') ?><br>
                            <?= $contrato->getFieldValue('Rotura_de_cristales_Deducible') ?><br>
                            <?php
                            $resultado = $oferta->getFieldValue('Valor_Asegurado') * ($contrato->getFieldValue('Colisi_n_y_vuelco') / 100);
                            echo "RD$" . number_format($resultado);
                            ?><br>
                            <?php
                            $resultado = $oferta->getFieldValue('Valor_Asegurado') * ($contrato->getFieldValue('Incendio_y_robo') / 100);
                            echo "RD$" . number_format($resultado);
                            ?><br><br>
                            <b>&nbsp;</b><br>
                            RD$<?= number_format($contrato->getFieldValue('Da_os_Propiedad_ajena')) ?><br>
                            RD$<?= number_format($contrato->getFieldValue('Lesiones_Muerte_1_Pers')) ?><br>
                            RD$<?= number_format($contrato->getFieldValue('Lesiones_Muerte_m_s_de_1_Pers')) ?><br>
                            RD$<?= number_format($contrato->getFieldValue('Lesiones_Muerte_1_pasajero')) ?><br>
                            RD$<?= number_format($contrato->getFieldValue('Lesiones_Muerte_m_s_de_1_pasajero')) ?><br>
                            <br>
                            RD$<?= number_format($contrato->getFieldValue('Riesgos_conductor')) ?><br>
                            <br>
                            RD$<?= number_format($contrato->getFieldValue('Fianza_judicial')) ?><br>
                            <br>
                            <b>&nbsp;</b><br>
                            <?= ($contrato->getFieldValue('Asistencia_vial') == 1) ? "Aplica" : "No Aplica"; ?><br>
                            <?= ($contrato->getFieldValue('Renta_Veh_culo') == 1) ? "Aplica" : "No Aplica"; ?><br>
                            <?= ($contrato->getFieldValue('Asistencia_Accidente') == 1) ? "Aplica" : "No Aplica"; ?>
                            <br>
                            <?php $planes = $cotizacion->getLineItems() ?>
                            <?php foreach ($planes as $plan) : ?>
                                <div class="row">
                                    <div class="col-6">
                                        RD$
                                        <br>
                                        RD$
                                        <br>
                                        RD$
                                    </div>
                                    <div class="col-6 text-right">
                                        <?= number_format($plan->getTotalAfterDiscount(), 2) ?>
                                        <br>
                                        <?= number_format($plan->getTaxAmount(), 2) ?>
                                        <br>
                                        <?= number_format($plan->getNetTotal(), 2) ?>
                                    </div>
                                </div>
                            <?php endforeach ?>
                        </p>
                    </div>
                <?php endif ?>
            <?php endforeach ?>
        </div>
    </div>
</div>