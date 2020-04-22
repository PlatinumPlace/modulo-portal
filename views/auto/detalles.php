<div class="row">

    <div class="col-lg-8">
        <h4 class="text-uppercase">
            <?php if ($trato->getFieldValue('P_liza') != null) : ?>
                resumen coberturas
            <?php else : ?>
                cotización
            <?php endif ?>
            <br>
            seguro vehículo de motor<br>
            plan <?= $trato->getFieldValue('Plan') ?>
        </h4>
        <?php if ($trato->getFieldValue('Stage') == "Abandonado") : ?>
            <div class="alert alert-danger" role="alert">
                Cotización Abandonada
            </div>
        <?php endif ?>
        <div class="row">
            <?php if ($trato->getFieldValue('Nombre') != null) : ?>
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
                                <?= $trato->getFieldValue('Nombre') . " " . $trato->getFieldValue('Apellido') ?><br>
                                <?= $trato->getFieldValue('RNC_Cedula') ?><br>
                                <?= $trato->getFieldValue('Email') ?><br>
                                <?= $trato->getFieldValue('Direcci_n') ?>
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
                                <?= $trato->getFieldValue('Tel_Residencia') ?><br>
                                <?= $trato->getFieldValue('Telefono') ?><br>
                                <?= $trato->getFieldValue('Tel_Trabajo') ?><br>
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
                            <?= $trato->getFieldValue('Tipo_de_vehiculo') ?><br>
                            <?= strtoupper($trato->getFieldValue('Marca')) ?><br>
                            <?= strtoupper($trato->getFieldValue('Modelo')) ?><br>
                            <?= $trato->getFieldValue('A_o_de_Fabricacion') ?><br>
                            RD$<?= number_format($trato->getFieldValue('Valor_Asegurado'), 2) ?>
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
                            <?= $trato->getFieldValue('Chasis') ?><br>
                            <?= $trato->getFieldValue('Placa') ?><br>
                            <?= $trato->getFieldValue('Color') ?><br>
                            <?= $trato->getFieldValue('Uso') ?><br>
                            <?= $retVal = ($trato->getFieldValue('Es_nuevo') == 1) ? "Nuevo" : "Usado"; ?>
                        </P>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card my-4">
            <div class="card-header">
                <h5>Opciones</h5>
            </div>
            <div class="card-body">
                <?php if ($trato->getFieldValue('Stage') != "Abandonado") : ?>
                    <?php if ($trato->getFieldValue('Nombre') == null) : ?>
                        <div class="form-group row justify-content-md-center">
                            <a href="<?= constant('url') ?>auto/completar/<?= $trato->getEntityId() ?>" class="btn btn-primary">Siguiente</a>
                        </div>
                    <?php else : ?>
                        <div class="form-group row justify-content-md-center">
                            <a href="<?= constant('url') ?>auto/emitir/<?= $trato->getEntityId() ?>" class="btn btn-success"><?= $retVal = ($trato->getFieldValue('P_liza') == null) ? "Emitir" : "Completar"; ?></a>
                        </div>
                        <div class="form-group row justify-content-md-center">
                            <a href="<?= constant('url') ?>auto/descargar/<?= $trato->getEntityId() ?>" class="btn btn-info">Descargar</a>
                        </div>
                    <?php endif ?>
                <?php endif ?>
                <div class="form-group row justify-content-md-center">
                    <?php if ($trato->getFieldValue('P_liza') != null) : ?>
                        <ul class="list-group">
                            <li class="list-group-item">
                                <a download="Condiciones del Vehículos" href="<?= constant('url') ?>public/documents/condiciones del vehiculo.pdf" class="btn btn-link">Condiciones del Vehículos</a>
                            </li>
                            <li class="list-group-item">
                                <a download="Formulario de conocimiento" href="<?= constant('url') ?>public/documents/formulario de conocimiento.pdf" class="btn btn-link">Formulario de conocimiento</a>
                            </li>
                            <li class="list-group-item">
                                <a download="Formulario de Inspección de Vehículos" href="<?= constant('url') ?>public/documents/formulario de inspeccion.pdf" class="btn btn-link">Formulario de Inspección</a>
                            </li>
                        </ul>
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
    <?php if (!empty($cotizaciones)) : ?>
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
    <?php endif ?>
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
            <?php if (!empty($cotizaciones)) : ?>
                <?php foreach ($cotizaciones as $cotizacion) : ?>
                    <?php if ($cotizacion->getFieldValue('Grand_Total') > 0) : ?>
                        <?php $contrato = $this->getRecord("Contratos", $cotizacion->getFieldValue('Contrato')->getEntityId()) ?>
                        <div class="col-2">
                            <p>
                                <?php $ruta_imagen = $this->downloadPhoto("Vendors", $contrato->getFieldValue('Aseguradora')->getEntityId(), "public/img/") ?>
                                <img height="50" width="110" src="<?= constant('url') . $ruta_imagen ?>">
                            </p>
                            <p>
                                <b>&nbsp;</b><br>
                                <?php
                                $resultado = $trato->getFieldValue('Valor_Asegurado') * ($contrato->getFieldValue('Riesgos_comprensivos') / 100);
                                echo "RD$" . number_format($resultado);
                                ?><br>
                                <?= $contrato->getFieldValue('Riesgos_Comprensivos_Deducible') ?><br>
                                <?= $contrato->getFieldValue('Rotura_de_cristales_Deducible') ?><br>
                                <?php
                                $resultado = $trato->getFieldValue('Valor_Asegurado') * ($contrato->getFieldValue('Colisi_n_y_vuelco') / 100);
                                echo "RD$" . number_format($resultado);
                                ?><br>
                                <?php
                                $resultado = $trato->getFieldValue('Valor_Asegurado') * ($contrato->getFieldValue('Incendio_y_robo') / 100);
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
                                <?= $Asistencia_vial = ($contrato->getFieldValue('Asistencia_vial') == 1) ? "Aplica" : "No Aplica"; ?><br>
                                <?= $Renta_Veh_culo = ($contrato->getFieldValue('Renta_Veh_culo') == 1) ? "Aplica" : "No Aplica"; ?><br>
                                <?= $Casa_del_Conductor_CAA = ($contrato->getFieldValue('Asistencia_Accidente') == 1) ? "Aplica" : "No Aplica"; ?>
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
            <?php endif ?>
        </div>
    </div>
</div>