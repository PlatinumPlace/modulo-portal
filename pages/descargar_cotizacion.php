<?php
$api = new api();
$trato = $api->getRecord("Deals", $_GET['id']);
$cotizaciones = $trato->getFieldValue('Aseguradoras_Disponibles');
if ($trato->getFieldValue('Stage') == "Abandonado") {
    header("Location:index.php");
}
function calcular($valor, $porciento)
{
    return $valor * ($porciento / 100);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>
        <?php if ($trato->getFieldValue('Stage') == "Cotizando") : ?>
            Cotización No.
        <?php else : ?>
            Resumen No.
        <?php endif ?>
        <?= $trato->getFieldValue('No_de_cotizaci_n') ?>
    </title>

    <link href="css/styles.css" rel="stylesheet" />
    <link rel="icon" type="image/png" href="img/portal/logo.png">
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-2">
                <?php if ($trato->getFieldValue('Stage') == "Cotizando") : ?>
                    <img src="img/portal/logo.png" width="120" height="140">
                <?php else : ?>
                    <?php foreach ($cotizaciones as $cotizacion) : ?>
                        <?php $ruta_imagen = $api->downloadPhoto("Vendors", $cotizacion["Aseguradora"]["id"], "img/Aseguradoras/") ?>
                        <?php if ($ruta_imagen != null) : ?>
                            <img width="170" height="85" src="<?= $ruta_imagen ?>">
                        <?php endif ?>
                    <?php endforeach ?>
                <?php endif ?>
            </div>
            <div class="col-8">
                <h3 class="text-uppercase text-center">
                    <?php if ($trato->getFieldValue('P_liza') != null) : ?>
                        resumen coberturas
                    <?php else : ?>
                        cotización
                    <?php endif ?>
                    <br>
                    seguro vehículo de motor<br>
                    plan <?= $trato->getFieldValue('Plan') ?>
                </h3>
            </div>
            <div class="col-2">
                <p>
                    <b>
                        <?php if ($trato->getFieldValue('P_liza') != null) : ?>
                            Cotización No.
                        <?php else : ?>
                            Resumen No.
                        <?php endif ?>
                    </b> <?= $trato->getFieldValue('No_de_cotizaci_n') ?>
                    <br>
                    <b>Fecha</b> <?= date('d/m/Y') ?>
                </p>
            </div>
            <div class="col-12 d-flex justify-content-center p-3 mb-2 bg-primary text-white">
                <h5>DATOS DEL CLIENTE</h5>
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
                        </P>
                    </div>
                    <div class="col">
                        <P>
                            <?= $trato->getFieldValue('Tel_Residencia') ?><br>
                            <?= $trato->getFieldValue('Telefono_del_asegurado') ?><br>
                            <?= $trato->getFieldValue('Tel_Trabajo') ?><br>
                        </P>
                    </div>
                </div>
            </div>
            <div class="col-12 d-flex justify-content-center p-3 mb-2 bg-primary text-white" style="width: 200px;">
                <h5>DATOS DEL VEHICULO</h5>
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
                <h5>COBERTURAS</h5>
            </div>
            <div class="col-12 border">
                <?php if ($trato->getFieldValue('P_liza') == null) : ?>
                    <div class="row">
                        <div class="col">
                            <p>&nbsp;</p>
                        </div>
                        <?php foreach ($cotizaciones as $cotizacion) : ?>
                            <?php if ($cotizacion["Prima_Total"] > 0) : ?>
                                <?php $ruta_imagen = $api->downloadPhoto("Vendors", $cotizacion["Aseguradora"]["id"], "img/Aseguradoras/") ?>
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
                                    <?= $retVal = ($cobertura->getFieldValue('Colisi_n_y_vuelco') > 0) ? "RD$" . number_format(calcular($trato->getFieldValue('Valor_Asegurado'), $cobertura->getFieldValue('Colisi_n_y_vuelco'))) : "No Aplica"; ?><br>
                                    <?= $retVal = ($cobertura->getFieldValue('Incendio_y_robo') > 0) ? "RD$" . number_format(calcular($trato->getFieldValue('Valor_Asegurado'), $cobertura->getFieldValue('Incendio_y_robo'))) : "No Aplica"; ?><br><br>
                                    <b>&nbsp;</b><br>
                                    RD$<?= number_format($cobertura->getFieldValue('Da_os_Propiedad_ajena')) ?><br>
                                    RD$<?= number_format($cobertura->getFieldValue('Lesiones_Muerte_1_Pers')) ?><br>
                                    RD$<?= number_format($cobertura->getFieldValue('Lesiones_Muerte_m_s_de_1_Pers')) ?><br>
                                    RD$<?= number_format($cobertura->getFieldValue('Lesiones_Muerte_1_pasajero')) ?><br>
                                    RD$<?= number_format($cobertura->getFieldValue('Lesiones_Muerte_m_s_de_1_pasajero')) ?><br>
                                    <br>
                                    <?= $retVal = ($cobertura->getFieldValue('Riesgos_conductor') > 0) ? "RD$" . number_format($cobertura->getFieldValue('Riesgos_conductor')) : "No Aplica"; ?><br>
                                    <br>
                                    <?= $retVal = ($cobertura->getFieldValue('Fianza_judicial') > 0) ? "RD$" . number_format($cobertura->getFieldValue('Fianza_judicial')) : "No Aplica"; ?><br>
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
        <div class="row">
            <?php if ($trato->getFieldValue('Stage') != "Cotizando") : ?>
                <?php foreach ($cotizaciones as $cotizacion) : ?>
                    <?php $ruta_imagen = $api->downloadPhoto("Vendors", $cotizacion["Aseguradora"]["id"], "img/Aseguradoras/") ?>
                    <div class="col-6 border">
                        <?php if ($ruta_imagen != null) : ?>
                            <div class="col-2">
                                <img height="50" width="150" src="<?= $ruta_imagen ?>">
                            </div>
                        <?php endif ?>
                        <br>
                        <div class="row">
                            <div class="col">
                                <P>
                                    <b>PÓLIZA </b><br>
                                    <b>MARCA </b><br>
                                    <b>MODELO </b><br>
                                    <b>AÑO </b><br>
                                    <b>CHASIS </b><br>
                                    <b>PLACA </b><br>
                                    <b>VIGENTE HASTA </b>
                                </P>
                            </div>
                            <div class="col">
                                <P>
                                    <?= $trato->getFieldValue('P_liza')->getLookupLabel() ?><br>
                                    <?= $trato->getFieldValue('Marca') ?><br>
                                    <?= $trato->getFieldValue('Modelo') ?><br>
                                    <?= $trato->getFieldValue('A_o_de_Fabricacion') ?><br>
                                    <?= $trato->getFieldValue('Chasis') ?><br>
                                    <?= $trato->getFieldValue('Placa') ?><br>
                                    <?= $trato->getFieldValue('Closing_Date') ?>
                                </P>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 border">
                        <h6><b>RECOMENDACIONES EN CASO DE ACCIDENTE</b></h6>
                        <ul>
                            <li>En caso de existir lesionados atender al herido.</li>
                            <li>No aceptar responsabilidad en el momento del accidente.</li>
                            <li>En caso de robo notifique inmediatamente a la policia y aseguradora.</li>
                        </ul>
                        <div class="row">
                            <div class="col-12">
                                <?php if ($cobertura->getFieldValue('Casa_del_Conductor') == 1) : ?>
                                    <b>Reporte accidente</b><br>
                                    Santo domingo: Tel. <?= $cobertura->getFieldValue('Tel_fono_casa_del_conductor') ?><br>
                                    Santiago: Tel. <?= $cobertura->getFieldValue('Tel_fono_casa_del_conductor_1') ?><br>
                                <?php endif ?>
                            </div>
                            <div class="col-6">
                                <?php $aseguradora = $api->getRecord("Vendors", $cotizacion["Aseguradora"]["id"]) ?>
                                <b>Aseguradora</b><br>
                                Tel. <?= $aseguradora->getFieldValue('Phone') ?><br>
                            </div>
                            <div class="col-6">
                                <?php if ($cobertura->getFieldValue('Asistencia_vial') == 1) : ?>
                                    <b>Asistencia vial 24 horas</b><br>
                                    Tel. <?= $cobertura->getFieldValue('Tel_fono_asistencia_vial') ?><br>
                                <?php endif ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach ?>
            <?php else : ?>
                <div class="col-12">
                    &nbsp;
                </div>
                <div class="col-12">
                    &nbsp;
                </div>
                <div class="col-12">
                    &nbsp;
                </div>
                <div class="col">
                    <p class="text-center">
                        _______________________________
                        <br>
                        Firma Cliente
                    </p>
                </div>
                <div class="col">
                    <p class="text-center">
                        _______________________________
                        <br>
                        Aseguradora Elegida
                    </p>
                </div>
                <div class="col">
                    <p class="text-center">
                        _______________________________
                        <br>
                        Fecha
                    </p>
                </div>
            <?php endif ?>
        </div>
    </div>
    <input value="<?= $_GET['id'] ?>" id="id" hidden>
    <script>
        var time = 500;
        var id = document.getElementById('id').value;
        setTimeout(function() {
            window.print();
            window.location = "index.php?page=details&id=" + id;
        }, time);
    </script>
</body>

</html>