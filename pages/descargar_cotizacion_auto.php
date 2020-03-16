<?php
$api = new api();
$trato = $api->getRecord("Deals", $_GET['id']);
$cotizaciones = $trato->getFieldValue('Aseguradoras_Disponibles');
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
                    <img src="img/portal/logo.png" width="100" height="100">
                <?php else : ?>
                    <?php foreach ($cotizaciones as $cotizacion) : ?>
                        <?php $ruta_imagen = $api->downloadPhoto("Vendors", $cotizacion["Aseguradora"]["id"], "img/Aseguradoras/") ?>
                        <?php if ($ruta_imagen != null) : ?>
                            <img width="170" height="75" src="<?= $ruta_imagen ?>">
                        <?php endif ?>
                    <?php endforeach ?>
                <?php endif ?>
            </div>
            <div class="col-8">
                <h4 class="text-uppercase text-center">
                    <?php if ($trato->getFieldValue('P_liza') != null) : ?>
                        resumen coberturas
                    <?php else : ?>
                        cotización
                    <?php endif ?>
                    <br>
                    seguro vehículo de motor<br>
                    plan <?= $trato->getFieldValue('Plan') ?>
                </h4>
            </div>
            <div class="col-2">
                <p>
                    <b>
                        <?php if ($trato->getFieldValue('P_liza') == null) : ?>
                            Cotización No.
                        <?php else : ?>
                            Resumen No.
                        <?php endif ?>
                    </b> <?= $trato->getFieldValue('No_de_cotizaci_n') ?>
                    <br>
                    <b>Fecha</b> <?= date('d/m/Y') ?>
                </p>
            </div>
            <div class="col-12">
                &nbsp;
            </div>
            <div class="col-12 d-flex justify-content-center bg-primary text-white">
                <h6>DATOS DEL CLIENTE</h6>
            </div>
            <div class="col-6 border">
                <div class="row">
                    <div class="col">
                        <P>
                            <b>Cliente:</b><br>
                            <b>Cédula/RNC:</b><br>
                            <b>Direccion:</b><br>
                            <br>
                            <b>Email: </b>
                        </P>
                    </div>
                    <div class="col">
                        <P>
                            <?= $trato->getFieldValue('Nombre') . " " . $trato->getFieldValue('Apellido') ?><br>
                            <?= $trato->getFieldValue('RNC_Cedula') ?><br>
                            <?= $trato->getFieldValue('Direcci_n') ?><br>
                            <br>
                            <?= $trato->getFieldValue('Email') ?>
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
            <div class="col-12 d-flex justify-content-center bg-primary text-white">
                <h6>DATOS DEL VEHICULO</h6>
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
            <div class="col-12 d-flex justify-content-center bg-primary text-white">
                <h6>COBERTURAS</h6>
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
        <?php if ($trato->getFieldValue('Stage') != "Cotizando") : ?>
            <?php foreach ($cotizaciones as $cotizacion) : ?>
                <?php $ruta_imagen = $api->downloadPhoto("Vendors", $cotizacion["Aseguradora"]["id"], "img/Aseguradoras/") ?>
                <div class="row">
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
                </div>
                <div class="saltopagina"></div>
                <div class="row">
                    <div class="col-4">
                        <img height="50" width="150" src="<?= $ruta_imagen ?>">
                    </div>
                    <div class="col-8">
                        <h4>EXTRACTO DE LAS PRINCIPALES CONDICIONES DE
                            VEHICULOS DE MOTOR
                        </h4>
                    </div>
                </div>
                <ol>
                    <li>Este certificado es sólo un resumen de las condiciones principales contenidas en la póliza.</li>
                    <li>Si al momento de un siniestro, la suma asegurada del vehículo es menor que su valor de mercado, la aseguradora reducirá de la
                        reclamación presentada, el monto equivalente a la proporción dejada de asegurar. La compañía aseguradora sólo será
                        responsable por aquella parte de la pérdida en la proporción en la que tenga el valor real como suma asegurada.</li>
                    <li>Queda excluida de toda cobertura, los accesorios, equipos y aditamentos que no sean instalados de fábrica en el vehículo
                        asegurado, a menos de que hayan sido declarados previamente en la póliza. Tampoco tienen cobertura mercancías o herramientas
                        dejadas dentro del vehículo asegurado o que se transporten en el mismo.</li>
                    <li>Quedan excluidas las pérdidas y/o daños sufridos y/o causados al vehículo asegurado si el mismo fuese conducido por personas
                        sin licencia de conducir otorgada por las autoridades competentes. Se excluye también los daños sufridos u ocasionados en el
                        vehículo asegurado si este fuese conducido en estado de embriaguez o bajo la influencia de cualquier droga. Tampoco tendrá
                        cobertura si el vehículo asegurado no está siendo es utilizado con fines privados, es decir que se utilice como transporte comercial
                        (taxi, carro público, etc.).</li>
                    <li>En caso de realizarse alguna modificación o instalación de algún aditamento o accesorio a las especificaciones de fábrica al
                        vehículo asegurado, (Ejemplo: cambio en el sistema de combustible, cambio de ubicación del volante, aros, equipos de música,
                        luces, etc.), luego de haberse incluido en la póliza, obligatoriamente debe de notificarse a la compañía aseguradora para los fines
                        de re-inspección del vehículo, aceptación y cobertura, mediante endoso, por la aseguradora.</li>
                    <li>Si el vehículo asegurado se encontrase transitando fuera del territorio nacional o en caminos no declarados ni autorizados de
                        tránsito público por las autoridades competentes, y sufre algún tipo de daño o siniestro, la cobertura queda excluida, a menos que
                        fuera autorizado por la aseguradora.</li>
                    <li>Queda excluida de toda cobertura daños ocasionados por la entrada de agua al motor o cualquier otra parte del vehículo
                        asegurado, cuando dicha entrada es causada por el ingreso voluntario del vehículo a una vía, camino o terreno inundado.</li>
                    <li>En caso de reclamación parcial para vehículos de más de 3 años de fabricación, se indemnizará utilizando repuestos usados y/o
                        piezas de reemplazo.</li>
                    <li>La aseguradora indemnizará pérdidas y/ o daños sufridos al vehículo asegurado, descontando el deducible aplicable a cada
                        cobertura.</li>
                    <li>La aseguradora está en su derecho de proceder a la cancelación de la póliza, o descontinuar la cobertura del vehículo, en cualquier
                        momento previo aviso al asegurado con treinta (30) días de antelación a la efectividad de la misma. Si la cancelación es por falta de
                        pago, aplica lo establecido en los artículos 73, 74 y 75 de ley 146-02 de seguros y fianzas de la República Dominicana.</li>
                    <li>Para proceder a la inclusión del vehículo asegurado en la póliza, si el vehículo es usado debe de ser sometido a inspección y
                        reportar su inclusión a la aseguradora en un plazo no mayor de 48 horas. Pasado este plazo, la cobertura quedará reducida a
                        seguro de ley.En caso del vehículo ser nuevo (0 KMS) se puede proceder a la inclusión en la póliza con el conduce de salida,
                        debidamente sellado, completado con los datos del mismo y firmado por el dealer o concesionario.</li>
                    <li>La cobertura de este certificado está sujeta al pago de la prima.</li>
                    <li>Esta póliza tendrá un período de duración igual a la vigencia del préstamo. Si el préstamo es saldado antes del fin de la vigencia, la
                        cobertura cesará.</li>
                    <li>La prima de este seguro puede ser revisable sin previo aviso y está sujeta a la siniestralidad de la póliza.</li>
                    <li>Tarifa NO APLICA para Vehículos con Equipo de Gas instalado, solo se aceptarán si el Equipo es marca LOVATO o TARTARINI, los
                        cuales deben ser inspeccionado por perito de la aseguradora y sujeto a que cliente suministre copia de factura instalación y
                        garantía del mismo. En caso de aceptación aplica recargo a la tarifa.</li>
                    <li>Los vehiculos Mitsubishi para los modelos, nativa, montero sport y L200, y los camiones Daihatsu deberán de tener un sistema de
                        seguridad contra robo o restreo tipo GPS. En caso contrario solo se asegurará a un 50%.</li>
                </ol>
                <div class="row">
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
                        &nbsp;
                    </div>
                    <div class="col">
                        <p class="text-center">
                            _______________________________
                            <br>
                            Fecha
                        </p>
                    </div>
                </div>
            <?php endforeach ?>
        <?php else : ?>
            <div class="row">
                <div class="col-12">
                    &nbsp;
                </div>
                <div class="col-12">
                    &nbsp;
                </div>
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
            </div>
        <?php endif ?>
    </div>
    <input value="<?= $_GET['id'] ?>" id="id" hidden>
    <script>
        var time = 500;
        var id = document.getElementById('id').value;
        setTimeout(function() {
            window.print();
            window.location = "index.php?page=details_auto&id=" + id;
        }, time);
    </script>
</body>

</html>