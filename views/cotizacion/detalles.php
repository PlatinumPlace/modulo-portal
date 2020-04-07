<h2 class="mt-4 text-uppercase">
    <?php if ($this->trato->getFieldValue('P_liza') != null) : ?>
        resumen coberturas
    <?php else : ?>
        cotización
    <?php endif ?>
    <br>
    seguro vehículo de motor<br>
    plan <?= $this->trato->getFieldValue('Plan') ?>
</h2>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item">Cotizaciones</li>
    <li class="breadcrumb-item">Detalles</li>
    <li class="breadcrumb-item active">Cotización No. <?= $this->trato->getFieldValue('No_de_cotizaci_n') ?></li>
</ol>
<div class="row">
    <?php if ($this->trato->getFieldValue('Stage') == "Abandonado") : ?>
        <div class="alert alert-danger" role="alert">
            Cotización Abandonada
        </div>
    <?php endif ?>
    <div class="col-12">
        &nbsp;
    </div>
    <div class="col-6">
        <?php if ($this->trato->getFieldValue('P_liza') != null) : ?>
            <h6>Descargar :</h6>
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
    <div class="col-6">
        <a href="<?= constant('url') ?>cotizacion/buscar/" class="btn btn-secondary">Lista</a>|
        <?php if ($this->trato->getFieldValue('Stage') != "Abandonado") : ?>
            <?php if ($this->trato->getFieldValue('Nombre') == null) : ?>
                <a href="<?= constant('url') ?>cotizacion/completar/<?= $this->trato->getEntityId() ?>" class="btn btn-primary">Siguiente</a>
            <?php else : ?>
                <a href="<?= constant('url') ?>cotizacion/emitir/<?= $this->trato->getEntityId() ?>" class="btn btn-success"><?= $retVal = ($this->trato->getFieldValue('P_liza') == null) ? "Emitir" : "Completar"; ?></a>|
                <a href="<?= constant('url') ?>cotizacion/descargar/<?= $this->trato->getEntityId() ?>" class="btn btn-info">Descargar</a>
            <?php endif ?>
        <?php endif ?>
    </div>
</div>
<div class="row">
    <div class="col-12">
        &nbsp;
    </div>
    <?php if ($this->trato->getFieldValue('Nombre') != null) : ?>
        <div class="col-12 d-flex justify-content-center p-3 mb-2 bg-primary text-white">
            <h4>DATOS DEL CLIENTE</h4>
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
                        <?= $this->trato->getFieldValue('Nombre') . " " . $this->trato->getFieldValue('Apellido') ?><br>
                        <?= $this->trato->getFieldValue('RNC_Cedula') ?><br>
                        <?= $this->trato->getFieldValue('Email') ?><br>
                        <?= $this->trato->getFieldValue('Direcci_n') ?>
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
                        <?= $this->trato->getFieldValue('Tel_Residencia') ?><br>
                        <?= $this->trato->getFieldValue('Telefono') ?><br>
                        <?= $this->trato->getFieldValue('Tel_Trabajo') ?><br>
                    </P>
                </div>
            </div>
        </div>
    <?php endif ?>
    <div class="col-12 d-flex justify-content-center p-3 mb-2 bg-primary text-white" style="width: 200px;">
        <h4>DATOS DEL VEHÍCULO</h4>
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
                    <?= $this->trato->getFieldValue('Tipo_de_vehiculo') ?><br>
                    <?= $this->trato->getFieldValue('Marca') ?><br>
                    <?= $this->trato->getFieldValue('Modelo') ?><br>
                    <?= $this->trato->getFieldValue('A_o_de_Fabricacion') ?><br>
                    RD$<?= number_format($this->trato->getFieldValue('Valor_Asegurado'), 2) ?>
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
                    <?= $this->trato->getFieldValue('Chasis') ?><br>
                    <?= $this->trato->getFieldValue('Placa') ?><br>
                    <?= $this->trato->getFieldValue('Color') ?><br>
                    <?= $this->trato->getFieldValue('Uso') ?><br>
                    <?= $retVal = ($this->trato->getFieldValue('Es_nuevo') == 1) ? "Nuevo" : "Usado"; ?>
                </P>
            </div>
        </div>
    </div>
    <div class="col-12 d-flex justify-content-center p-3 mb-2 bg-primary text-white" style="width: 200px;">
        <h4>COBERTURAS</h4>
    </div>
    <?php foreach ($this->cotizaciones as $cotizacion) : ?>
        <?php if ($cotizacion["Prima_Total"] == 0) : ?>
            <?php $contrato = $this->api->getRecord("Contratos", $cotizacion["Contrato"]["id"]) ?>
            <div class="alert alert-info" role="alert">
                <b><?= $contrato->getFieldValue('Aseguradora')->getLookupLabel() ?></b> no esta disponible.
            </div>
        <?php endif ?>
    <?php endforeach ?>
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
            <?php foreach ($this->cotizaciones as $cotizacion) : ?>
                <?php if ($cotizacion["Prima_Total"] > 0) : ?>
                    <?php $contrato = $this->api->getRecord("Contratos", $cotizacion["Contrato"]["id"]) ?>
                    <div class="col-2">
                        <p>
                            <?php $ruta_imagen = $this->api->downloadPhoto("Vendors", $contrato->getFieldValue('Aseguradora')->getEntityId(), "public/img/") ?>
                            <img height="50" width="110" src="<?= constant('url') . $ruta_imagen ?>">
                        </p>
                        <p>
                            <b>&nbsp;</b><br>
                            RD$<?= number_format(calcular($this->trato->getFieldValue('Valor_Asegurado'), $contrato->getFieldValue('Riesgos_comprensivos'))) ?><br>
                            <?= $contrato->getFieldValue('Riesgos_Comprensivos_Deducible') ?><br>
                            <?= $contrato->getFieldValue('Rotura_de_cristales_Deducible') ?><br>
                            RD$<?= number_format(calcular($this->trato->getFieldValue('Valor_Asegurado'), $contrato->getFieldValue('Colisi_n_y_vuelco'))) ?><br>
                            RD$<?= number_format(calcular($this->trato->getFieldValue('Valor_Asegurado'), $contrato->getFieldValue('Incendio_y_robo'))) ?><br><br>
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
                            <?= $Casa_del_Conductor_CAA = ($contrato->getFieldValue('Casa_del_Conductor_CAA') == 1) ? "Aplica" : "No Aplica"; ?><br><br>
                            RD$<?= number_format($cotizacion["Prima_Neta"], 2) ?><br>
                            RD$<?= number_format($cotizacion["ISC"], 2) ?><br>
                            RD$<?= number_format($cotizacion["Prima_Total"], 2) ?>
                        </p>
                    </div>
                <?php endif ?>
            <?php endforeach ?>
        </div>
    </div>
</div>