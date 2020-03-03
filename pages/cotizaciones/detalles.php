<?php
$tratos = new tratos();
$trato = $tratos->detalles($_GET['id']);
$cotizaciones = $trato->getFieldValue('Aseguradoras_Disponibles');
if (isset($_POST['eliminar'])) {
    $tratos->eliminar($_GET['id']);
    header("Location: index.php?page=details&id=" . $_GET['id']);
}
?>
<div class="section no-pad-bot" id="index-banner">
    <h2 class="header center blue-text">
        <?php if ($trato->getFieldValue('Stage') == "Cotizando" or $trato->getFieldValue('Stage') == "Abandonado") : ?>
            COTIZACIÓN
        <?php else : ?>
            RESUMEN COBERTURAS
        <?php endif ?>
        <br>
        SEGURO VEHICULO DE MOTOR <br>
        PLAN <?= strtoupper($trato->getFieldValue('Plan')) ?> <?= strtoupper($trato->getFieldValue('Tipo_de_poliza')) ?>
    </h2>
</div>
<?php if ($trato->getFieldValue('Stage') == "Abandonado") : ?>
    <div class="row">
        <div class="col s6 m4 right">
            <div class="card-panel red">
                <span class="white-text">
                    Cotización No. <?= $trato->getFieldValue('No_de_cotizaci_n') ?> Abandonado
                </span>
            </div>
        </div>
    </div>
<?php endif ?>
<form method="POST" action="index.php?page=details&id=<?= $trato->getEntityId() ?>">
    <a href="index.php?page=search" class="waves-effect waves-light btn"><i class="material-icons left">arrow_back</i>Ir a la lista</a>
    <a href="index.php?page=download&id=<?= $trato->getEntityId() ?>" class="green waves-effect waves-light btn"><i class="material-icons left">file_download</i>Descargar</a>
    <?php if ($trato->getFieldValue('Stage') != "Abandonado") : ?>
        <a href="index.php?page=emit&id=<?= $trato->getEntityId() ?>" class="blue waves-effect waves-light btn"><i class="material-icons left">description</i>Emitir</a>
        <button onclick="confirm('¿Estas seguro?')"  type="submit" name="eliminar" class="red waves-effect waves-light btn"><i class="material-icons left">delete</i>Eliminar</button>
    <?php endif ?>
    <?php if ($trato->getFieldValue('Stage') == "Cotizando") : ?>
        <a href="index.php?page=edit&id=<?= $trato->getEntityId() ?>" class="yellow waves-effect waves-light btn"><i class="material-icons left">edit</i>Editar</a>
    <?php endif ?>
</form>

<br><br>

<div class="row">
    <div class="col s12">
        <div class="card blue darken-1">
            <div class="card-content white-text">
                <span class="card-title center">DATOS DEL CLIENTE</span>
                <div class="row">
                    <div class="col s3">
                        <P>
                            <b>Cliente:</b><br>
                            <b>Cédula/RNC:</b><br>
                            <b>Direccion:</b><br>
                            <b>Email: </b>
                        </P>
                    </div>
                    <div class="col s3">
                        <P>
                            <?= $trato->getFieldValue('Nombre_del_asegurado') . " " . $trato->getFieldValue('Apellido_del_asegurado') ?><br>
                            <?= $trato->getFieldValue('RNC_Cedula_del_asegurado') ?><br>
                            <?= $trato->getFieldValue('Direcci_n_del_asegurado') ?><br>
                            <?= $trato->getFieldValue('Email_del_asegurado') ?>
                        </P>
                    </div>
                    <div class="col s3">
                        <P>
                            <b>Tel. Residencia:</b><br>
                            <b>Tel. Celular:</b><br>
                            <b>Tel. Trabajo:</b><br>
                            <b>Otro:</b>
                        </P>
                    </div>
                    <div class="col s3">
                        <P>
                            <?= $trato->getFieldValue('Telefono_del_asegurado') ?>
                        </P>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col s12">
        <div class="card blue darken-1">
            <div class="card-content white-text">
                <span class="card-title center">DATOS DEL VEHICULO</span>
                <div class="row">
                    <div class="col s3">
                        <P>
                            <b>Tipo:</b><br>
                            <b>Marca:</b><br>
                            <b>Modelo:</b><br>
                            <b>Año:</b><br>
                            <b>Suma Asegurado:</b>
                        </P>
                    </div>
                    <div class="col s3">
                        <P>
                            <?= $trato->getFieldValue('Tipo_de_vehiculo') ?><br>
                            <?= $trato->getFieldValue('Marca') ?><br>
                            <?= $trato->getFieldValue('Modelo') ?><br>
                            <?= $trato->getFieldValue('A_o_de_Fabricacion') ?><br>
                            RD$<?= number_format($trato->getFieldValue('Valor_Asegurado'), 2) ?>
                        </P>
                    </div>
                    <div class="col s3">
                        <P>
                            <b>Chasis:</b><br>
                            <b>Placa:</b><br>
                            <b>Color:</b><br>
                            <b>Condiciones:</b><br>
                            &nbsp;
                        </P>
                    </div>
                    <div class="col s3">
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
    <div class="col s12 center">
        <h4>COBERTURAS</h4>
    </div>
    <div class="row">
        <?php foreach ($cotizaciones as $cotizacion) : ?>
            <?php if ($cotizacion["Prima_Total"] == 0) : ?>
                <div class="col s4">
                    <div class="card-panel teal">
                        <span class="white-text">
                            La aseguradora <strong><?= $cotizacion["Aseguradora"]["name"] ?></strong> no esta disponible para cotizar.
                        </span>
                    </div>
                </div>
            <?php endif ?>
        <?php endforeach ?>
    </div>
    <div class="col s12">
        <div class="row">
            <div class="col s4">
                &nbsp;
            </div>
            <?php foreach ($cotizaciones as $cotizacion) : ?>
                <?php if ($cotizacion["Prima_Total"] > 0) : ?>
                    <?php $ruta_imagen = $tratos->generar_imagen_aseguradora($cotizacion["Plan"]["id"]) ?>
                    <?php if ($ruta_imagen != null) : ?>
                        <div class="col s2">
                            <img height="80" width="100" src="<?= $ruta_imagen ?>">
                        </div>
                    <?php endif ?>
                <?php endif ?>
            <?php endforeach ?>
        </div>
    </div>
    <div class="col s12">
        <div class="row">
            <div class="col s4">
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
                    <?php $coberturas = $tratos->ver_coberturas(
                        $cotizacion["Plan"]["id"],
                        $trato->getFieldValue('Account_Name')->getEntityId()
                    ) ?>
                    <?php if ($coberturas != null) : ?>
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
                                    RD$<?= number_format($cotizacion["Prima_Neta"], 2) ?><br>
                                    RD$<?= number_format($cotizacion["ISC"], 2) ?><br>
                                    RD$<?= number_format($cotizacion["Prima_Total"], 2) ?>
                                </p>
                            </div>
                        <?php endforeach ?>
                    <?php endif ?>
                <?php endif ?>
            <?php endforeach ?>
        </div>
    </div>
</div>