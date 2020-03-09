<?php
$api = new api();
$trato = $api->getRecord("Deals", $_GET['id']);
$cotizaciones = $trato->getFieldValue('Aseguradoras_Disponibles');
function calcular($valor, $porciento)
{
    return $valor * ($porciento / 100);
}
if (isset($_POST['delete'])) {
    $cambios["Stage"] = "Abandonado";
    $api->updateRecord("Deals", $cambios, $_GET['id']);
}
?>
<h1 class="mt-4">Detalles Cotizaciones</h1>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item">Cotizaciones</li>
    <li class="breadcrumb-item">Detalles</li>
    <li class="breadcrumb-item active">Cotización No. <?= $trato->getFieldValue('No_de_cotizaci_n') ?></li>
</ol>

<div class="row">

    <div class="col-6">
        <h3>
            <?php if ($trato->getFieldValue('Stage') == "Cotizando") : ?>
                COTIZACIÓN
            <?php else : ?>
                RESUMEN COBERTURAS
            <?php endif ?>
            <br>
            SEGURO VEHICULO DE MOTOR <br>
            PLAN <?= strtoupper($trato->getFieldValue('Per_odo')) . " " . strtoupper($trato->getFieldValue('Plan')) ?>
        </h3>
    </div>
    <div class="col-6">
        <form class="row" method="POST" action="?page=details&id=<?= $trato->getEntityId() ?>">
            <div class="col">
                <a href="?page=search" class="btn btn-secondary"><i class="fas fa-list"></i> Lista</a>
            </div>
            <?php if ($trato->getFieldValue('Stage') != "Abandonado" or $_POST['delete']) : ?>
                <div class="col">
                    <a href="?page=emit&id=<?= $trato->getEntityId() ?>" class="btn btn-success"><i class="fas fa-portrait"></i> Emitir</a>
                </div>
                <div class="col">
                    <a href="?page=download&id=<?= $trato->getEntityId() ?>" class="btn btn-primary"><i class="fas fa-download"></i> Descargar</a>
                </div>
                <?php if ($trato->getFieldValue('Stage') == "Cotizando") : ?>
                    <div class="col">
                        <a href="?page=edit&id=<?= $trato->getEntityId() ?>" class="btn btn-warning"><i class="fas fa-edit"></i> Editar</a>
                    </div>
                    <div class="col">
                        <button type="submit" name="delete" onclick="return confirm('¿Estas seguro?');" class="btn btn-danger"><i class="fas fa-trash"></i>Eliminar</button>
                    </div>
                <?php else : ?>
                    <br><br>
                    <div class="col-12">
                        <ul class="list-group">
                            <li class="list-group-item">
                                <a download="Condiciones del Vehículos" href="documents/vehiculo/condiciones.pdf" class="btn btn-link"><i class="fas fa-download"></i> Condiciones del Vehículos</a>
                            </li>
                            <li class="list-group-item">
                                <a download="Formulario de conocimiento" href="documents/vehiculo/conocimiento.pdf" class="btn btn-link"><i class="fas fa-download"></i> Formulario de conocimiento</a>
                            </li>
                            <li class="list-group-item">
                                <a download="Formulario de Inspección de Vehículos" href="documents/vehiculo/inspeccion.pdf" class="btn btn-link"><i class="fas fa-download"></i> Formulario de Inspección</a>
                            </li>
                        </ul>
                    </div>
                <?php endif ?>
            <?php endif ?>
        </form>
    </div>

    <?php if ($trato->getFieldValue('Stage') == "Abandonado" or isset($_POST['delete'])) : ?>
        <div class="alert alert-danger" role="alert">
            Cotización Abandonada
        </div>
    <?php endif ?>

    <div class="col-12 d-flex justify-content-center p-3 mb-2 bg-primary text-white">
        <h4>DATOS DEL CLIENTE</h4>
    </div>
    <div class="col-6 border">
        <div class="row">
            <div class="col">
                <P>
                    <b>Cliente:</b><br>
                    <b>Cédula/RNC:</b><br>
                    <b>Direccion:</b><br><br>
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
                    <?= $trato->getFieldValue('Telefono_del_asegurado') ?>
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
    <div class="col-12 d-flex justify-content-center p-3 mb-2 bg-primary text-white" style="width: 200px;">
        <h4>COBERTURAS</h4>
    </div>

    <?php foreach ($cotizaciones as $cotizacion) : ?>
        <?php if ($cotizacion["Prima_Total"] == 0) : ?>
            <div class="alert alert-info" role="alert">
                La aseguradora <strong><?= $cotizacion["Aseguradora"]["name"] ?></strong> no esta disponible para cotizar.
                </span>
            </div>
        <?php endif ?>
    <?php endforeach ?>

    <div class="col-12">
        <div class="row">
            <div class="col">
                &nbsp;
            </div>
            <?php if ($trato->getFieldValue('Stage') == "Cotizando") : ?>
                <?php foreach ($cotizaciones as $cotizacion) : ?>
                    <?php if ($cotizacion["Prima_Total"] > 0) : ?>
                        <?php
                        $plan_detalles = $api->getRecord("Products", $cotizacion["Plan"]["id"]);
                        if ($plan_detalles->getFieldValue('Vendor_Name') != null) {
                            $ruta_imagen = $api->downloadPhoto("Vendors", $plan_detalles->getFieldValue('Vendor_Name')->getEntityId(), "img/Aseguradoras/");
                        } else {
                            $ruta_imagen = null;
                        }
                        ?>
                        <?php if ($ruta_imagen != null) : ?>
                            <div class="col-2">
                                <img height="80" width="100" src="<?= $ruta_imagen ?>">
                            </div>
                        <?php endif ?>
                    <?php endif ?>
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
            <?php foreach ($cotizaciones as $cotizacion) : ?>
                <?php if ($cotizacion["Prima_Total"] > 0) : ?>
                    <?php
                    $plan_detalles = $api->getRecord("Products", $cotizacion["Plan"]["id"]);
                    $criterio = "((Aseguradora:equals:" . $plan_detalles->getFieldValue('Vendor_Name')->getEntityId() . ") and (Socio_IT:equals:" . $trato->getFieldValue('Account_Name')->getEntityId() . "))";
                    $coberturas = $api->searchRecordsByCriteria("Coberturas", $criterio);
                    ?>
                    <?php foreach ($coberturas as $cobertura) : ?>
                        <?php if ($cobertura->getFieldValue('Tipo_de_Plan') == $trato->getFieldValue('Plan')) : ?>
                            <div class="col-2">
                                <p>
                                    <b>&nbsp;</b><br>
                                    RD$<?= number_format(calcular($trato->getFieldValue('Valor_Asegurado'), $cobertura->getFieldValue('Riesgos_comprensivos')), 2) ?><br>
                                    RD$<?= number_format(calcular($trato->getFieldValue('Valor_Asegurado'), $cobertura->getFieldValue('Riesgos_comprensivos_Deducible')), 2) ?><br>
                                    RD$<?= number_format(calcular($trato->getFieldValue('Valor_Asegurado'), $cobertura->getFieldValue('Rotura_de_Cristales_Deducible')), 2) ?><br>
                                    RD$<?= number_format(calcular($trato->getFieldValue('Valor_Asegurado'), $cobertura->getFieldValue('Colisi_n_y_vuelco')), 2) ?><br>
                                    RD$<?= number_format(calcular($trato->getFieldValue('Valor_Asegurado'), $cobertura->getFieldValue('Incendio_y_robo')), 2) ?><br>
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
                        <?php endif ?>
                    <?php endforeach ?>
                <?php endif ?>
            <?php endforeach ?>
        </div>
    </div>
</div>