<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0" />
    <title>Cotización
        No.
        <?php if (!empty($cotizaciones)) : ?>
            <?php foreach ($cotizaciones as $cotizacion) : ?>
                <?= $cotizacion->getFieldValue('Quote_Number') ?>
                <?php break ?>
            <?php endforeach ?>
        <?php endif ?>
    </title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous" media="print">

    <style>
        @media print {
            .saltoDePagina {
                page-break-before: always;
            }
        }
    </style>
</head>

<body>

    <main>
        <div class="container">
            <div class="row">
                <div class="col-2">
                    <?php if (!empty($cotizaciones)) : ?>
                        <?php foreach ($cotizaciones as $cotizacion) : ?>
                            <?php $planes = $cotizacion->getLineItems() ?>
                            <?php foreach ($planes as $plan) : ?>
                                <?php $plan_detalles = $this->api->getRecord("Products", $plan->getProduct()->getEntityId()) ?>
                                <?php
                                $criterio = "Aseguradora:equals:" . $plan_detalles->getFieldValue('Vendor_Name')->getEntityId();
                                $coberturas = $this->api->searchRecordsByCriteria("Coberturas", $criterio);
                                ?>
                                <?php foreach ($coberturas as $cobertura) : ?>
                                    <?php if (
                                        $cobertura->getFieldValue('Aseguradora')->getEntityId() == $plan_detalles->getFieldValue('Vendor_Name')->getEntityId()
                                        and
                                        $cobertura->getFieldValue('Socio_IT')->getEntityId() == $oferta->getFieldValue('Account_Name')->getEntityId()
                                    ) : ?>
                                        <?php if ($oferta->getFieldValue('Aseguradora') != null) : ?>
                                            <?php
                                            $ruta_imagen = $this->api->downloadRecordPhoto(
                                                "Vendors",
                                                $plan_detalles->getFieldValue('Vendor_Name')->getEntityId(),
                                                "file/Aseguradoras/"
                                            );
                                            ?>
                                            <img height="120" width="130" src="<?= $ruta_imagen ?>" alt="<?= $plan_detalles->getFieldValue('Vendor_Name')->getLookupLabel() ?>">
                                        <?php else : ?>
                                            <img src="logo.png" width="150" height="130">
                                        <?php endif ?>
                                    <?php endif ?>
                                    <?php break ?>
                                <?php endforeach ?>
                            <?php endforeach ?>
                            <?php break ?>
                        <?php endforeach ?>
                    <?php endif ?>
                </div>
                <div class="col-8">
                    <center>
                        <h3>
                            COTIZACIÓN<br>
                            SEGURO VEHICULO DE MOTOR <br>
                            PLAN <?= strtoupper($oferta->getFieldValue('Plan')) ?> <?= strtoupper($oferta->getFieldValue('Tipo_de_poliza')) ?>
                        </h3>
                    </center>
                </div>
                <div class="col-2">
                    <?php if (!empty($cotizaciones)) : ?>
                        <?php foreach ($cotizaciones as $cotizacion) : ?>
                            <p>
                                <b>No. de cotización</b> <?= $cotizacion->getFieldValue('Quote_Number') ?><br>
                                <b>Fecha</b> <br> <?= date('d/m/Y') ?>
                            </p>
                            <?php break ?>
                        <?php endforeach ?>
                    <?php endif ?>
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
                                <?= $oferta->getFieldValue('Nombre_del_asegurado') . " " . $oferta->getFieldValue('Apellido_del_asegurado') ?><br>
                                <?= $oferta->getFieldValue('RNC_Cedula_del_asegurado') ?><br>
                                <?= $oferta->getFieldValue('Direcci_n_del_asegurado') ?><br>
                                <?= $oferta->getFieldValue('Email_del_asegurado') ?>
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
                                <?= $oferta->getFieldValue('Telefono_del_asegurado') ?>
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
                                <?= $oferta->getFieldValue('Tipo_de_vehiculo') ?><br>
                                <?= $oferta->getFieldValue('Marca') ?><br>
                                <?= $oferta->getFieldValue('Modelo') ?><br>
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
                                <b>Condiciones:</b><br>
                                &nbsp;
                            </P>
                        </div>
                        <div class="col">
                            <P>
                                <?= $oferta->getFieldValue('Chasis') ?><br>
                                <?= $oferta->getFieldValue('Placa') ?><br>
                                <?= $oferta->getFieldValue('Color') ?><br>
                                <?= $retVal = ($oferta->getFieldValue('Es_nuevo') == 1) ? "Nuevo" : "Usado"; ?>
                            </P>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="row bg-primary text-white" style="padding: 20px;">
                        <div class="col">
                            <h4>COBERTURAS</h4>
                        </div>
                        <?php if (!empty($cotizaciones)) : ?>
                            <?php foreach ($cotizaciones as $cotizacion) : ?>
                                <?php $planes = $cotizacion->getLineItems() ?>
                                <?php foreach ($planes as $plan) : ?>
                                    <?php $plan_detalles = $this->api->getRecord("Products", $plan->getProduct()->getEntityId()) ?>
                                    <?php
                                    $criterio = "Aseguradora:equals:" . $plan_detalles->getFieldValue('Vendor_Name')->getEntityId();
                                    $coberturas = $this->api->searchRecordsByCriteria("Coberturas", $criterio);
                                    ?>
                                    <?php foreach ($coberturas as $cobertura) : ?>
                                        <?php if (
                                            $cobertura->getFieldValue('Aseguradora')->getEntityId() == $plan_detalles->getFieldValue('Vendor_Name')->getEntityId()
                                            and
                                            $cobertura->getFieldValue('Socio_IT')->getEntityId() == $oferta->getFieldValue('Account_Name')->getEntityId()
                                        ) : ?>
                                            <div class="col-2">
                                                <?php if ($oferta->getFieldValue('Aseguradora') == null) : ?>
                                                    <?php
                                                    $ruta_imagen = $this->api->downloadRecordPhoto(
                                                        "Vendors",
                                                        $plan_detalles->getFieldValue('Vendor_Name')->getEntityId(),
                                                        "file/Aseguradoras/"
                                                    );
                                                    ?>
                                                    <img height="50" width="70" src="<?= $ruta_imagen ?>" alt="<?= $plan_detalles->getFieldValue('Vendor_Name')->getLookupLabel() ?>">
                                                <?php endif ?>
                                            </div>
                                        <?php endif ?>
                                        <?php break ?>
                                    <?php endforeach ?>
                                <?php endforeach ?>
                                <?php break ?>
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
                        <?php if (!empty($cotizaciones)) : ?>
                            <?php foreach ($cotizaciones as $cotizacion) : ?>
                                <?php $planes = $cotizacion->getLineItems() ?>
                                <?php foreach ($planes as $plan) : ?>
                                    <?php $plan_detalles = $this->api->getRecord("Products", $plan->getProduct()->getEntityId()) ?>
                                    <?php
                                    $criterio = "Aseguradora:equals:" . $plan_detalles->getFieldValue('Vendor_Name')->getEntityId();
                                    $coberturas = $this->api->searchRecordsByCriteria("Coberturas", $criterio);
                                    ?>
                                    <?php foreach ($coberturas as $cobertura) : ?>
                                        <?php if (
                                            $cobertura->getFieldValue('Aseguradora')->getEntityId() == $plan_detalles->getFieldValue('Vendor_Name')->getEntityId()
                                            and
                                            $cobertura->getFieldValue('Socio_IT')->getEntityId() == $oferta->getFieldValue('Account_Name')->getEntityId()
                                        ) : ?>
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
                                        <?php endif ?>
                                        <?php break ?>
                                    <?php endforeach ?>
                                <?php endforeach ?>
                                <?php break ?>
                            <?php endforeach ?>
                        <?php endif ?>
                    </div>
                </div>
            </div>
            <?php if ($oferta->getFieldValue('Aseguradora') != null) : ?>
                <div class="saltoDePagina"></div>
                <div class="col-12">
                    <div class="card">
                        <div class="card-content">
                            <div class="row">
                                <?php foreach ($cotizaciones as $cotizacion) : ?>
                                    <?php $planes = $cotizacion->getLineItems() ?>
                                    <?php foreach ($planes as $plan) : ?>
                                        <?php $plan_detalles = $this->api->getRecord("Products", $plan->getProduct()->getEntityId()) ?>
                                        <?php
                                        $criterio = "Aseguradora:equals:" . $plan_detalles->getFieldValue('Vendor_Name')->getEntityId();
                                        $coberturas = $this->api->searchRecordsByCriteria("Coberturas", $criterio);
                                        ?>
                                        <?php foreach ($coberturas as $cobertura) : ?>
                                            <?php if (
                                                $cobertura->getFieldValue('Aseguradora')->getEntityId() == $plan_detalles->getFieldValue('Vendor_Name')->getEntityId()
                                                and
                                                $cobertura->getFieldValue('Socio_IT')->getEntityId() == $oferta->getFieldValue('Account_Name')->getEntityId()
                                            ) : ?>
                                                <div class="col">
                                                    <?php
                                                    $ruta_imagen = $this->api->downloadRecordPhoto(
                                                        "Vendors",
                                                        $plan_detalles->getFieldValue('Vendor_Name')->getEntityId(),
                                                        "file/Aseguradoras/"
                                                    );
                                                    ?>
                                                    <img height="70" width="85" src="<?= $ruta_imagen ?>" alt="<?= $plan_detalles->getFieldValue('Vendor_Name')->getLookupLabel() ?>">
                                                    <P>
                                                        <b>PÓLIZA </b><?= $cotizacion->getFieldValue('Poliza')->getLookupLabel() ?><br>
                                                        <b>MARCA </b><?= $oferta->getFieldValue('Marca') ?><br>
                                                        <b>MODELO </b><?= $oferta->getFieldValue('Modelo') ?><br>
                                                        <b>AÑO </b><?= $oferta->getFieldValue('A_o_de_Fabricacion') ?><br>
                                                        <b>CHASIS </b><?= $oferta->getFieldValue('Chasis') ?><br>
                                                        <b>PLACA </b><?= $oferta->getFieldValue('Placa') ?><br>
                                                        <b>VIGENTE HASTA </b><?= $cotizacion->getFieldValue('Valid_Till') ?>
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
                                            <?php endif ?>
                                            <?php break ?>
                                        <?php endforeach ?>
                                    <?php endforeach ?>
                                    <?php break ?>
                                <?php endforeach ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php else : ?>
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
        </div>
    </main>

    <script>
        var time = 500;
        var id = document.getElementById('id').value;
        setTimeout(function() {
            window.print();
            window.location = "?pagina=ver_cotizacion&id=" + id;
        }, time);
    </script>
</body>

</html>