<?php
$tratos = new tratos();
$trato = $tratos->detalles($_GET['id']);
$cotizaciones = $trato->getFieldValue('Aseguradoras_Disponibles');
?>

<head>
    <title>
        <?php if ($trato->getFieldValue('Stage') == "Cotizando") : ?>
            Cotización No.
        <?php else : ?>
            Póliza No.
        <?php endif ?>
        <?= $trato->getFieldValue('No_de_cotizaci_n') ?>
    </title>

    <link href="css/styles.css" rel="stylesheet" />


    <style>
        @media all {
            div.saltopagina {
                display: none;
            }
        }

        @media print {
            div.saltopagina {
                display: block;
                page-break-before: always;
            }
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="row">
            <div class="col-2">
                <?php if ($trato->getFieldValue('Stage') == "Cotizando") : ?>
                    <img src="img/portal/logo.png" width="120" height="140">
                <?php else : ?>
                    <?php foreach ($cotizaciones as $cotizacion) : ?>
                        <?php $ruta_imagen = $tratos->generar_imagen_aseguradora($cotizacion["Plan"]["id"]) ?>
                        <img height="100" width="120" src="<?= $ruta_imagen ?>">
                    <?php endforeach ?>
                <?php endif ?>
            </div>
            <div class="col-8">
                <center>
                    <h3>
                        <?php if ($trato->getFieldValue('Stage') == "Cotizando") : ?>
                            COTIZACIÓN
                        <?php else : ?>
                            RESUMEN COBERTURAS
                        <?php endif ?>
                        <br>
                        SEGURO VEHICULO DE MOTOR <br>
                        PLAN <?= strtoupper($trato->getFieldValue('Tipo_de_poliza')) . " " . strtoupper($trato->getFieldValue('Plan')) ?>
                    </h3>
                </center>
            </div>
            <div class="col-2">
                <p>
                    <b>
                        <?php if ($trato->getFieldValue('Stage') == "Cotizando") : ?>
                            Cotización No.
                        <?php else : ?>
                            Póliza No.
                        <?php endif ?>
                    </b> <?= $trato->getFieldValue('No_de_cotizaci_n') ?>
                    <br>
                    <b>Fecha</b> <?= date('d/m/Y') ?>
                </p>
            </div>
            <div class="col-12 d-flex justify-content-center bg-primary text-white">
                <h5>DATOS DEL CLIENTE</h5>
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
            <div class="col-12 d-flex justify-content-center bg-primary text-white" style="width: 200px;">
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
            <div class="col-12 d-flex justify-content-center bg-primary text-white" style="width: 200px;">
                <h5>COBERTURAS</h5>
            </div>
            <div class="col-12">
                <div class="row">
                    <div class="col">
                        &nbsp;
                    </div>
                    <?php if ($trato->getFieldValue('Stage') == "Cotizando") : ?>
                        <?php foreach ($cotizaciones as $cotizacion) : ?>
                            <?php if ($cotizacion["Prima_Total"] > 0) : ?>
                                <?php $ruta_imagen = $tratos->generar_imagen_aseguradora(
                                    $cotizacion["Plan"]["id"]
                                ) ?>
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
                            <?php $coberturas = $tratos->ver_coberturas(
                                $cotizacion["Plan"]["id"],
                                $trato->getFieldValue('Account_Name')->getEntityId()
                            ) ?>
                            <?php if ($coberturas != null) : ?>
                                <?php foreach ($coberturas as $cobertura) : ?>
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
        <?php if ($trato->getFieldValue('Stage') != "Cotizando") : ?>
            <div class="saltopagina"></div>
            <?php foreach ($cotizaciones as $cotizacion) : ?>
                <?php $coberturas = $tratos->ver_coberturas(
                    $cotizacion["Plan"]["id"],
                    $trato->getFieldValue('Account_Name')->getEntityId()
                ) ?>
                <?php foreach ($coberturas as $cobertura) : ?>
                    <div class="row">
                        <div class="col-6 border">
                            <?php foreach ($cotizaciones as $cotizacion) : ?>
                                <?php $ruta_imagen = $tratos->generar_imagen_aseguradora(
                                    $cotizacion["Plan"]["id"]
                                ) ?> <?php if ($ruta_imagen != null) : ?>
                                    <img height="100" width="160" src="<?= $ruta_imagen ?>">
                                <?php endif ?>
                            <?php endforeach ?>
                            <br><br>
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
                            <FONT SIZE=2>
                                <P>
                                    <b>RECOMENDACIONES EN CASO DE ACCIDENTE</b><br>
                                    <ul>
                                        <li>EN CASO DE EXISTIR LESIONADOS ATENDER AL HERIDO.</li>
                                        <li>NO ACEPTAR RESPONSABILIDAD EN EL MOMENTO DEL ACCIDENTE.</li>
                                        <li>EN CASO DE ROBO NOTIFIQUE INMEDIATAMENTE A LA POLICIA Y ASEGURADORA.</li>
                                    </ul>
                                    <?php if ($cobertura->getFieldValue('Casa_del_Conductor') == 1) : ?>
                                        <b>CENTRO DE ASISTENCIA AL AUTOMOVILISTA</b><br>
                                        SANTO DOMINGO: (809) 565-8222 <br>
                                        SANTIAGO: (809) 583-6222<br>
                                    <?php endif ?>
                                    <?php if ($cobertura->getFieldValue('Asistencia_vial') == 1) : ?>
                                        <b>ASISTENCIA VIAL 24 HORAS</b><br>
                                        (829) 378-8888<br>
                                    <?php endif ?>
                                </P>
                            </FONT>
                        </div>
                    </div>
                <?php endforeach ?>
            <?php endforeach ?>
        <?php else : ?>
            <br><br>
            <div class="row">
                <div class="col">
                    <p>
                        _______________________________
                        <br>
                        Firma Cliente
                    </p>
                </div>
                <div class="col">
                    <p>
                        _______________________________
                        <br>
                        Aseguradora Elegida
                    </p>
                </div>
                <div class="col">
                    <p>
                        _______________________________
                        <br>
                        Fecha
                    </p>
                </div>
            </div>
        <?php endif ?>
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