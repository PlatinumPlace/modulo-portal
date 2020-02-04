<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <title>Cotización No. <?= $resultado['trato']->getFieldValue('No_de_cotizaci_n') ?></title>
    <style>
        @media print {
            .saltoDePagina {
                page-break-before: always;
            }
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="row">
            <div class="col-2">
                <?php if ($resultado['trato']->getFieldValue('Aseguradora') == null) : ?>
                    <img src="img/portal/logo.png" width="120" height="140">
                <?php else : ?>
                    <?php $planes = $resultado['cotizacion']->getLineItems() ?>
                    <?php foreach ($planes as $plan) : ?>
                        <?php $ruta_imagen = $this->cotizaciones->imagen_asegradora($plan->getProduct()->getEntityId()) ?>
                        <?php if ($ruta_imagen != null) : ?>
                            <img height="100" width="120" src="<?= $ruta_imagen ?>">
                        <?php endif ?>
                    <?php endforeach ?>
                <?php endif ?>
            </div>
            <div class="col-8">
                <center>
                    <h3>
                        COTIZACIÓN<br>
                        SEGURO VEHICULO DE MOTOR <br>
                        PLAN <?= strtoupper($resultado['trato']->getFieldValue('Plan')) ?> <?= strtoupper($resultado['trato']->getFieldValue('Tipo_de_poliza')) ?>
                    </h3>
                </center>
            </div>
            <div class="col-2">
                <p>
                    <b>No. de cotización</b> <?= $resultado['trato']->getFieldValue('No_de_cotizaci_n') ?><br>
                    <b>Fecha</b> <br> <?= date('d/m/Y') ?>
                </p>
            </div>
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
                            <?= $resultado['trato']->getFieldValue('Nombre_del_asegurado') . " " . $resultado['trato']->getFieldValue('Apellido_del_asegurado') ?><br>
                            <?= $resultado['trato']->getFieldValue('RNC_Cedula_del_asegurado') ?><br>
                            <?= $resultado['trato']->getFieldValue('Direcci_n_del_asegurado') ?><br>
                            <?= $resultado['trato']->getFieldValue('Email_del_asegurado') ?>
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
                            <?= $resultado['trato']->getFieldValue('Telefono_del_asegurado') ?>
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
                            <?= $resultado['trato']->getFieldValue('Tipo_de_vehiculo') ?><br>
                            <?= $resultado['trato']->getFieldValue('Marca') ?><br>
                            <?= $resultado['trato']->getFieldValue('Modelo') ?><br>
                            <?= $resultado['trato']->getFieldValue('A_o_de_Fabricacion') ?><br>
                            RD$<?= number_format($resultado['trato']->getFieldValue('Valor_Asegurado'), 2) ?>
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
                            <?= $resultado['trato']->getFieldValue('Chasis') ?><br>
                            <?= $resultado['trato']->getFieldValue('Placa') ?><br>
                            <?= $resultado['trato']->getFieldValue('Color') ?><br>
                            <?= $retVal = ($resultado['trato']->getFieldValue('Es_nuevo') == 1) ? "Nuevo" : "Usado"; ?>
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
                    <?php if ($resultado['trato']->getFieldValue('Aseguradora') == null) : ?>
                        <?php $planes = $resultado['cotizacion']->getLineItems() ?>
                        <?php foreach ($planes as $plan) : ?>
                            <?php $ruta_imagen = $this->cotizaciones->imagen_asegradora($plan->getProduct()->getEntityId()) ?>
                            <?php if ($ruta_imagen != null) : ?>
                                <div class="col-2">
                                    <img height="80" width="100" src="<?= $ruta_imagen ?>">
                                </div>
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
                    <?php $planes = $resultado['cotizacion']->getLineItems() ?>
                    <?php foreach ($planes as $plan) : ?>
                        <?php $coberturas = $this->cotizaciones->coberturas(
                            $plan->getProduct()->getEntityId(),
                            $resultado['trato']->getFieldValue('Account_Name')->getEntityId()
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
                                        RD$<?= number_format($plan->getListPrice(), 2) ?><br>
                                        RD$<?= number_format($plan->getTaxAmount(), 2) ?><br>
                                        RD$<?= number_format($plan->getNetTotal(), 2) ?>
                                    </p>
                                </div>
                            <?php endforeach ?>
                        <?php endif ?>
                    <?php endforeach ?>
                </div>
            </div>
        </div>
        <?php if ($resultado['trato']->getFieldValue('Aseguradora') != null) : ?>
            <div class="saltoDePagina"></div>
            <div class="col-12">
                <div class="card">
                    <div class="card-content">
                        <div class="row">
                            <?php $coberturas = $this->cotizaciones->coberturas(
                                $plan->getProduct()->getEntityId(),
                                $resultado['trato']->getFieldValue('Account_Name')->getEntityId()
                            ) ?>
                            <?php foreach ($coberturas as $cobertura) : ?>
                                <div class="col">
                                    <?php $planes = $resultado['cotizacion']->getLineItems() ?>
                                    <?php foreach ($planes as $plan) : ?>
                                        <?php $ruta_imagen = $this->cotizaciones->imagen_asegradora($plan->getProduct()->getEntityId()) ?>
                                        <?php if ($ruta_imagen != null) : ?>
                                            <img height="100" width="160" src="<?= $ruta_imagen ?>">
                                        <?php endif ?>
                                    <?php endforeach ?>
                                    <P>
                                        <b>PÓLIZA </b><?= $resultado['cotizacion']->getFieldValue('Poliza')->getLookupLabel() ?><br>
                                        <b>MARCA </b><?= $resultado['trato']->getFieldValue('Marca') ?><br>
                                        <b>MODELO </b><?= $resultado['trato']->getFieldValue('Modelo') ?><br>
                                        <b>AÑO </b><?= $resultado['trato']->getFieldValue('A_o_de_Fabricacion') ?><br>
                                        <b>CHASIS </b><?= $resultado['trato']->getFieldValue('Chasis') ?><br>
                                        <b>PLACA </b><?= $resultado['trato']->getFieldValue('Placa') ?><br>
                                        <b>VIGENTE HASTA </b><?= $resultado['trato']->getFieldValue('Closing_Date') ?>
                                    </P>
                                </div>
                                <div class="col">
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
                            <?php endforeach ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php else : ?>
            <br><br><br>
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

    <input type="text" value="<?= $_GET['id'] ?>" id="id" hidden>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <script>
        var time = 500;
        var id = document.getElementById('id').value;
        setTimeout(function() {
            window.print();
            window.location = "?pagina=detalles&id=" + id;
        }, time);
    </script>
</body>

</html>