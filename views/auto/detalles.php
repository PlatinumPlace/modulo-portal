<div class="row">
    <div class="col-8">
        <h4 class="text-uppercase text-center">
            <?php if ($this->trato->getFieldValue('P_liza') != null) : ?>
                resumen coberturas
            <?php else : ?>
                cotización
            <?php endif ?>
            <br>
            seguro vehículo de motor<br>
            plan <?= $this->trato->getFieldValue('Plan') ?>
        </h4>
    </div>
    <div class="col-4">
        <b>
            <?php if ($this->trato->getFieldValue('P_liza') == null) : ?>
                Cotización No.
            <?php else : ?>
                Resumen No.
            <?php endif ?>
        </b> <?= $this->trato->getFieldValue('No_Cotizaci_n') ?>
        <br>
        <b>Fecha</b> <?= $this->trato->getFieldValue('Fecha_de_emisi_n') ?>
    </div>
    <div class="col-12">
        &nbsp;
    </div>
    <?php if ($this->trato->getFieldValue('Stage') == "Abandonado") : ?>
        <div class="alert alert-danger" role="alert">
            Cotización Abandonada
        </div>
    <?php endif ?>
    <br>
    <?php if ($this->trato->getFieldValue('Nombre') != null) : ?>
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
                    <?= $this->trato->getFieldValue('Tipo_de_vehiculo') ?><br>
                    <?= strtoupper($this->trato->getFieldValue('Marca')) ?><br>
                    <?= strtoupper($this->trato->getFieldValue('Modelo')) ?><br>
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
    <div class="col-12 d-flex justify-content-center bg-primary text-white">
        <h6>COBERTURAS</h6>
    </div>
    <?php foreach ($this->cotizaciones as $cotizacion) : ?>
        <?php if ($cotizacion->getFieldValue('Grand_Total') == 0) : ?>
            <?php $contrato = $this->api->getRecord("Contratos", $cotizacion->getFieldValue('Contrato')->getEntityId()) ?>
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
                <?php if ($cotizacion->getFieldValue('Grand_Total') > 0) : ?>
                    <?php $contrato = $this->api->getRecord("Contratos", $cotizacion->getFieldValue('Contrato')->getEntityId()) ?>
                    <div class="col-2">
                        <p>
                            <?php $ruta_imagen = $this->api->downloadPhoto("Vendors", $contrato->getFieldValue('Aseguradora')->getEntityId(), "public/img/") ?>
                            <img height="50" width="110" src="<?= constant('url') . $ruta_imagen ?>">
                        </p>
                        <p>
                            <b>&nbsp;</b><br>
                            <?php
                            $resultado = $this->trato->getFieldValue('Valor_Asegurado') * ($contrato->getFieldValue('Riesgos_comprensivos') / 100);
                            echo "RD$" . number_format($resultado);
                            ?><br>
                            <?= $contrato->getFieldValue('Riesgos_Comprensivos_Deducible') ?><br>
                            <?= $contrato->getFieldValue('Rotura_de_cristales_Deducible') ?><br>
                            <?php
                            $resultado = $this->trato->getFieldValue('Valor_Asegurado') * ($contrato->getFieldValue('Colisi_n_y_vuelco') / 100);
                            echo "RD$" . number_format($resultado);
                            ?><br>
                            <?php
                            $resultado = $this->trato->getFieldValue('Valor_Asegurado') * ($contrato->getFieldValue('Incendio_y_robo') / 100);
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
                            <?= $Casa_del_Conductor_CAA = ($contrato->getFieldValue('Casa_del_Conductor_CAA') == 1) ? "Aplica" : "No Aplica"; ?><br><br>
                            <?php
                            $planes = $cotizacion->getLineItems();
                            foreach ($planes as $plan) {
                                echo "RD$" . number_format($plan->getTotalAfterDiscount(), 2);
                                echo "<br>";
                                echo "RD$" . number_format($plan->getTaxAmount(), 2);
                                echo "<br>";
                                echo "RD$" . number_format($plan->getNetTotal(), 2);
                            }
                            ?>
                        </p>
                    </div>
                <?php endif ?>
            <?php endforeach ?>
        </div>
    </div>
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
    <div class="col-2">
        &nbsp;
    </div>
    <div class="col-4">
        <?php if ($this->trato->getFieldValue('Stage') != "Abandonado") : ?>
            <?php if ($this->trato->getFieldValue('Nombre') == null) : ?>
                <a href="<?= constant('url') ?>auto/completar/<?= $this->trato->getEntityId() ?>" class="btn btn-primary">Siguiente</a>
            <?php else : ?>
                <a href="<?= constant('url') ?>auto/emitir/<?= $this->trato->getEntityId() ?>" class="btn btn-success"><?= $retVal = ($this->trato->getFieldValue('P_liza') == null) ? "Emitir" : "Completar"; ?></a>|
                <a href="<?= constant('url') ?>auto/descargar/<?= $this->trato->getEntityId() ?>" class="btn btn-info">Descargar</a>
            <?php endif ?>
        <?php endif ?>
    </div>
    <div class="col-12">
        &nbsp;
    </div>
</div>