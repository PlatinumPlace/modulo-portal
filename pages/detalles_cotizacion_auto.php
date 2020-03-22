<?php
$api = new api();
$trato = $api->getRecord("Deals", $_GET['id']);
$cotizaciones = $trato->getFieldValue('Aseguradoras_Disponibles');
function calcular($valor, $porciento)
{
    return $valor * ($porciento / 100);
}
?>
<h2 class="mt-4 text-uppercase">
    <?php if ($trato->getFieldValue('P_liza') != null) : ?>
        resumen coberturas
    <?php else : ?>
        cotización
    <?php endif ?>
    <br>
    seguro vehículo de motor<br>
    plan <?= $trato->getFieldValue('Plan') ?>
</h2>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item">Cotizaciones</li>
    <li class="breadcrumb-item">Detalles</li>
    <li class="breadcrumb-item active">Cotización No. <?= $trato->getFieldValue('No_de_cotizaci_n') ?></li>
</ol>

<div class="row">
    <?php if ($trato->getFieldValue('Stage') == "Abandonado") : ?>
        <div class="alert alert-danger" role="alert">
            Cotización Abandonada
        </div>
    <?php endif ?>
    <div class="col-12">
        &nbsp;
    </div>
    <div class="col-6">
        <?php if ($trato->getFieldValue('P_liza') != null) : ?>
            <ul class="list-group">
                <li class="list-group-item">
                    <a download="Condiciones del Vehículos" href="documents/condiciones del vehiculo.pdf" class="btn btn-link"><i class="fas fa-download"></i> Condiciones del Vehículos</a>
                </li>
                <li class="list-group-item">
                    <a download="Formulario de conocimiento" href="documents/formulario de conocimiento.pdf" class="btn btn-link"><i class="fas fa-download"></i> Formulario de conocimiento</a>
                </li>
                <li class="list-group-item">
                    <a download="Formulario de Inspección de Vehículos" href="documents/formulario de inspeccion.pdf" class="btn btn-link"><i class="fas fa-download"></i> Formulario de Inspección</a>
                </li>
            </ul>
        <?php endif ?>
    </div>
    <div class="col-6">
        <div class="row">
            <div class="col">
                <a href="?page=search" class="btn btn-secondary"><i class="fas fa-list"></i> Lista</a>
            </div>
            <?php if ($trato->getFieldValue('Stage') != "Abandonado") : ?>
                <?php if ($trato->getFieldValue('Nombre') == null) : ?>
                    <div class="col">
                        <a href="?page=complete_auto&id=<?= $trato->getEntityId() ?>" class="btn btn-primary"><i class="fas fa-edit"></i> Siguente</a>
                    </div>
                <?php else : ?>
                    <div class="col">
                        <a href="?page=emit&id=<?= $trato->getEntityId() ?>" class="btn btn-success"><i class="fas fa-portrait"></i> <?= $retVal = ($trato->getFieldValue('P_liza') == null) ? "Emitir" : "Completar"; ?></a>
                    </div>
                    <div class="col">
                        <a href="?page=download_auto&id=<?= $trato->getEntityId() ?>" class="btn btn-info"><i class="fas fa-download"></i> Descargar</a>
                    </div>
                <?php endif ?>
            <?php endif ?>
        </div>
    </div>
    <div class="col-12">
        &nbsp;
    </div>
    <?php if ($trato->getFieldValue('Nombre') != null) : ?>
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
                        <b>Direccion:</b>
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
                    <?= $trato->getFieldValue('Tipo_de_vehiculo') ?><br>
                    <?= $trato->getFieldValue('Marca') ?><br>
                    <?= $trato->getFieldValue('Modelo') ?><br>
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
    <div class="col-12 d-flex justify-content-center p-3 mb-2 bg-primary text-white" style="width: 200px;">
        <h4>COBERTURAS</h4>
    </div>
    <?php foreach ($cotizaciones as $cotizacion) : ?>
        <?php if ($cotizacion["Prima_Total"] == 0) : ?>
            <div class="alert alert-info" role="alert">
                La aseguradora <strong><?= $cotizacion["Aseguradora"]["name"] ?></strong> no esta disponible para cotizar.
            </div>
        <?php endif ?>
    <?php endforeach ?>
    <div class="col-12 border">
        <?php if ($trato->getFieldValue('P_liza') == null) : ?>
            <div class="row">
                <div class="col">
                    <p>&nbsp;</p>
                </div>
                <?php foreach ($cotizaciones as $cotizacion) : ?>
                    <?php if ($cotizacion["Prima_Total"] > 0) : ?>
                        <?php $ruta_imagen = $api->downloadPhoto("Vendors", $cotizacion["Aseguradora"]["id"], "img/") ?>
                        <?php if ($ruta_imagen != null) : ?>
                            <div class="col-2">
                                <img height="50" width="110" src="<?= $ruta_imagen ?>">
                            </div>
                        <?php endif ?>
                    <?php endif ?>
                <?php endforeach ?>
            </div>
        <?php endif ?>
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
            <?php foreach ($cotizaciones as $cotizacion) : ?>
                <?php if ($cotizacion["Prima_Total"] > 0) : ?>
                    <?php $cobertura = $api->getRecord("Coberturas", $cotizacion["Cobertura"]["id"]) ?>
                    <div class="col-2">
                        <p>
                            <b>&nbsp;</b><br>
                            RD$<?= number_format(calcular($trato->getFieldValue('Valor_Asegurado'), $cobertura->getFieldValue('Riesgos_comprensivos'))) ?><br>
                            <?= $cobertura->getFieldValue('Riesgos_Comprensivos_Deducible') ?><br>
                            <?= $cobertura->getFieldValue('Rotura_de_cristales_Deducible') ?><br>
                            RD$<?= number_format(calcular($trato->getFieldValue('Valor_Asegurado'), $cobertura->getFieldValue('Colisi_n_y_vuelco'))) ?><br>
                            RD$<?= number_format(calcular($trato->getFieldValue('Valor_Asegurado'), $cobertura->getFieldValue('Incendio_y_robo'))) ?><br><br>
                            <b>&nbsp;</b><br>
                            RD$<?= number_format($cobertura->getFieldValue('Da_os_Propiedad_ajena')) ?><br>
                            RD$<?= number_format($cobertura->getFieldValue('Lesiones_Muerte_1_Pers')) ?><br>
                            RD$<?= number_format($cobertura->getFieldValue('Lesiones_Muerte_m_s_de_1_Pers')) ?><br>
                            RD$<?= number_format($cobertura->getFieldValue('Lesiones_Muerte_1_pasajero')) ?><br>
                            RD$<?= number_format($cobertura->getFieldValue('Lesiones_Muerte_m_s_de_1_pasajero')) ?><br>
                            <br>
                            RD$<?= number_format($cobertura->getFieldValue('Riesgos_conductor')) ?><br>
                            <br>
                            RD$<?= number_format($cobertura->getFieldValue('Fianza_judicial')) ?><br>
                            <br>
                            <b>&nbsp;</b><br>
                            <?= $retVal = ($cobertura->getFieldValue('Asistencia_vial') == 1) ? "Aplica" : "No Aplica"; ?><br>
                            <?= $retVal = ($cobertura->getFieldValue('Renta_Veh_culo') == 1) ? "Aplica" : "No Aplica"; ?><br>
                            <?= $retVal = ($cobertura->getFieldValue('Casa_del_Conductor') == 1) ? "Aplica" : "No Aplica"; ?><br><br>
                            RD$<?= number_format($cotizacion["Prima_Neta"]) ?><br>
                            RD$<?= number_format($cotizacion["ISC"]) ?><br>
                            RD$<?= number_format($cotizacion["Prima_Total"]) ?>
                        </p>
                    </div>
                <?php endif ?>
            <?php endforeach ?>
        </div>
    </div>
</div>