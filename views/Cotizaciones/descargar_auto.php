<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>
        <?php if (!in_array($resumen->getFieldValue("Stage"), $emitida)) : ?>
            Cotización No.
        <?php else : ?>
            Resumen No.
        <?php endif ?>
        <?= $resumen->getFieldValue('No_Cotizaci_n') ?>
    </title>
    <!-- Bootstrap core CSS -->
    <link href="<?= constant('url') ?>public/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <link rel="icon" type="image/png" href="<?= constant('url') ?>public/img/logo.png">
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
                <?php if (!in_array($resumen->getFieldValue("Stage"), $emitida)) : ?>
                    <img src="<?= constant('url') ?>public/img/logo.png" width="100" height="100">
                <?php else : ?>
                    <img width="170" height="75" src="<?= constant('url') . $imagen_aseguradora ?>">
                <?php endif ?>
            </div>
            <div class="col-8">
                <h4 class="text-uppercase text-center">
                    <?php if (!in_array($resumen->getFieldValue("Stage"), $emitida)) : ?>
                        cotización
                    <?php else : ?>
                        resumen coberturas
                    <?php endif ?>
                    <br>
                    seguro vehículo de motor<br>
                    plan <?= $resumen->getFieldValue('Plan') ?>
                </h4>
            </div>
            <div class="col-2">
                <?php if (in_array($resumen->getFieldValue("Stage"), $emitida)) : ?>
                    <b> Póliza No.</b> <br> <?= $cotizacion->getFieldValue('P_liza')->getLookupLabel() ?>
                    <br>
                    <b> Resumen No.</b>
                <?php else : ?>
                    <br>
                    <b> Cotización No.</b>
                <?php endif ?>
                <br>
                <?= $resumen->getFieldValue('No_Cotizaci_n') ?>
                <br>
                <b>Fecha</b> <br> <?= $resumen->getFieldValue('Fecha_de_emisi_n') ?>
            </div>
            <div class="col-12 d-flex justify-content-center bg-primary text-white">
                <h6>CLIENTE</h6>
            </div>
            <div class="col-6 border">
                <div class="row">
                    <div class="col-4">
                        <b>Cliente:</b><br>
                        <b>Cédula/RNC:</b><br>
                        <b>Email:</b><br>
                        <b>Direccion:</b>
                    </div>
                    <div class="col-8">
                        <?= $resumen->getFieldValue('Nombre') . " " . $resumen->getFieldValue('Apellido') ?><br>
                        <?= $resumen->getFieldValue('RNC_Cedula') ?><br>
                        <?= $resumen->getFieldValue('Email') ?><br>
                        <?= $resumen->getFieldValue('Direcci_n') ?>
                    </div>
                </div>
            </div>
            <div class="col-6 border">
                <div class="row">
                    <div class="col-4">
                        <b>Tel. Residencia:</b><br>
                        <b>Tel. Celular:</b><br>
                        <b>Tel. Trabajo:</b><br>
                    </div>
                    <div class="col-8">
                        <?= $resumen->getFieldValue('Tel_Residencia') ?><br>
                        <?= $resumen->getFieldValue('Telefono') ?><br>
                        <?= $resumen->getFieldValue('Tel_Trabajo') ?><br>
                    </div>
                </div>
            </div>
            <div class="col-12 d-flex justify-content-center bg-primary text-white">
                <h6>VEHICULO</h6>
            </div>
            <div class="col-6 border">
                <div class="row">
                    <div class="col-4">
                        <b>Tipo:</b><br>
                        <b>Marca:</b><br>
                        <b>Modelo:</b><br>
                        <b>Año:</b><br>
                        <b>Suma Asegurado:</b>
                    </div>
                    <div class="col-8">
                        <?= $resumen->getFieldValue('Tipo_de_veh_culo') ?><br>
                        <?= strtoupper($resumen->getFieldValue('Marca')->getLookupLabel()) ?><br>
                        <?= strtoupper($resumen->getFieldValue('Modelo')->getLookupLabel()) ?><br>
                        <?= $resumen->getFieldValue('A_o_de_Fabricacion') ?><br>
                        RD$<?= number_format($resumen->getFieldValue('Valor_Asegurado'), 2) ?>
                    </div>
                </div>
            </div>
            <div class="col-6 border">
                <div class="row">
                    <div class="col-4">
                        <b>Chasis:</b><br>
                        <b>Placa:</b><br>
                        <b>Color:</b><br>
                        <b>Uso:</b><br>
                        <b>Condiciones:</b><br>
                        &nbsp;
                    </div>
                    <div class="col-8">
                        <?= $resumen->getFieldValue('Chasis') ?><br>
                        <?= $resumen->getFieldValue('Placa') ?><br>
                        <?= $resumen->getFieldValue('Color') ?><br>
                        <?= $resumen->getFieldValue('Uso') ?><br>
                        <?= ($resumen->getFieldValue('Es_nuevo') == 1) ? "Nuevo" : "Usado"; ?>
                    </div>
                </div>
            </div>
            <div class="col-12 d-flex justify-content-center bg-primary text-white">
                <h6>COBERTURAS</h6>
            </div>
            <div class="col-12 border">
                <div class="row">
                    <div class="col-4">
                        <h5>&nbsp;</h5>
                        <p class="card-text">
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
                        <div class="col-2">
                            <?php if ($cotizacion->getFieldValue('Grand_Total') > 0) : ?>
                                <?php $contrato = $this->cotizacion->detalles_contrato($cotizacion->getFieldValue('Contrato')->getEntityId()) ?>
                                <h5>
                                    <?php if (!in_array($resumen->getFieldValue("Stage"), $emitida)) : ?>
                                    <?php $imagen_aseguradora = $this->cotizacion->obtener_imagen_aseguradora($cotizacion->getFieldValue('Aseguradora')->getEntityId()) ?>
                                        <img height="50" width="110" src="<?= constant('url') . $imagen_aseguradora ?>">
                                    <?php else : ?>
                                        &nbsp;
                                        <br><br>
                                    <?php endif ?>
                                </h5>
                                <p class="card-text">
                                    <?php
                                    $resultado = $resumen->getFieldValue('Valor_Asegurado') * ($contrato->getFieldValue('Riesgos_comprensivos') / 100);
                                    echo "RD$" . number_format($resultado);
                                    ?><br>
                                    <?= $contrato->getFieldValue('Riesgos_Comprensivos_Deducible') ?><br>
                                    <?= $contrato->getFieldValue('Rotura_de_cristales_Deducible') ?><br>
                                    <?php
                                    $resultado = $resumen->getFieldValue('Valor_Asegurado') * ($contrato->getFieldValue('Colisi_n_y_vuelco') / 100);
                                    echo "RD$" . number_format($resultado);
                                    ?><br>
                                    <?php
                                    $resultado = $resumen->getFieldValue('Valor_Asegurado') * ($contrato->getFieldValue('Incendio_y_robo') / 100);
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
                                    <?= ($contrato->getFieldValue('Asistencia_vial') == 1) ? "Aplica" : "No Aplica"; ?><br>
                                    <?= ($contrato->getFieldValue('Renta_Veh_culo') == 1) ? "Aplica" : "No Aplica"; ?><br>
                                    <?= ($contrato->getFieldValue('Asistencia_Accidente') == 1) ? "Aplica" : "No Aplica"; ?>
                                    <br><br>
                                    <?php $planes = $cotizacion->getLineItems() ?>
                                    <?php foreach ($planes as $plan) : ?>
                                        RD$<?= number_format($plan->getTotalAfterDiscount(), 2) ?>
                                        <br>
                                        RD$<?= number_format($plan->getTaxAmount(), 2) ?>
                                        <br>
                                        RD$<?= number_format($plan->getNetTotal(), 2) ?>
                                    <?php endforeach ?>
                                </p>
                            <?php else : ?>
                                <h5>
                                    &nbsp;
                                </h5>
                                <p class="card-text">
                                    &nbsp;
                                </p>
                            <?php endif ?>
                        </div>
                    <?php endforeach ?>
                </div>
            </div>
        </div>
        <?php if (in_array($resumen->getFieldValue("Stage"), $emitida)) : ?>
            <div class="row">
                <div class="col-6 border">
                    <br>
                    <div class="col-2">
                        <img height="50" width="150" src="<?= constant('url') . $imagen_aseguradora ?>">
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-2">
                            <b>Póliza </b><br>
                            <b>Tipo </b><br>
                            <b>Año </b><br>
                            <b>Marca </b><br>
                            <b>Modelo </b>
                        </div>
                        <div class="col-4">
                            <?= $cotizacion->getFieldValue('P_liza')->getLookupLabel() ?><br>
                            <?= $resumen->getFieldValue('Tipo_de_veh_culo') ?><br>
                            <?= $resumen->getFieldValue('A_o_de_Fabricacion') ?><br>
                            <?= $resumen->getFieldValue('Marca')->getLookupLabel() ?><br>
                            <?= $resumen->getFieldValue('Modelo')->getLookupLabel() ?>
                        </div>
                        <div class="col-md-2">
                            <b>Chasis </b>
                            <br>
                            <b>Placa </b>
                            <br>
                            <b>Desde </b>
                            <br>
                            <b>Hasta </b>
                        </div>
                        <div class="col-4">
                            <?= $resumen->getFieldValue('Chasis') ?>
                            <br>
                            <?= $resumen->getFieldValue('Placa') ?>
                            <br>
                            <?= $resumen->getFieldValue('Fecha_de_emisi_n') ?>
                            <br>
                            <?= $resumen->getFieldValue('Closing_Date') ?>
                        </div>
                    </div>
                </div>
                <div class="col-6 border">
                    <small>
                        <b>EN CASO DE ACCIDENTE</b>
                        <br>
                        Realiza el levantamiento del acta policial y obtén la siguente información:
                        <li>Nombre,dirección y teléfonos del conductor,los lesionados,del propietario y de los testigos.</li>
                        <li>Número de placa y póliza del vehículo involucrado, y nombre de la aseguradora</li>
                        <b>EN CASO DE ROBO: </b>Notifica de inmediato a la Policía y a la Aseguradora.
                        <br>
                        <div class="text-center"><b>RESERVE SU DERECHO</b></div>
                        <div class="row">
                            <div class="col-12">
                                <b>Aseguradora</b><br>
                                Tel. <?= $aseguradora->getFieldValue('Phone') ?><br>
                            </div>
                            <?php if ($contrato->getFieldValue('Asistencia_Accidente') == 1) : ?>
                                <div class="col-6">
                                    <b>Reporte accidente</b><br>
                                    Tel. Sto. Dgo <?= $aseguradora->getFieldValue('Tel_fono_Asistencia_Accidente_Sto_Dgo') ?>
                                    <br>
                                    Tel. Santiago <?= $aseguradora->getFieldValue('Tel_fono_Asistencia_Accidente_Santiago') ?>
                                </div>
                            <?php endif ?>
                            <?php if ($contrato->getFieldValue('Asistencia_vial') == 1) : ?>
                                <div class="col-6">
                                    <b>Asistencia vial 24 horas</b><br>
                                    Tel. <?= $aseguradora->getFieldValue('Tel_fono_Asistencia_vial') ?><br>
                                </div>
                            <?php endif ?>
                        </div>
                    </small>
                </div>
            </div>
            <div class="saltopagina"></div>
            <div class="row">
                <div class="col-2">
                    <img height="50" width="150" src="<?= constant('url') . $imagen_aseguradora ?>">
                </div>
                <div class="col-7 text-center">
                    <h4>
                        RESUMEN DE LAS PRINCIPALES CONDICIONES DE
                        VEHICULOS DE MOTOR
                    </h4>
                </div>
                <div class="col-3">
                    <b>Póliza No. <br> <?= $cotizacion->getFieldValue('P_liza')->getLookupLabel() ?></b>
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
    <input value="<?= $id ?>" id="id" hidden>
    <input value="<?= constant('url') ?>" id="url" hidden>
    <script>
        var url = document.getElementById("url").value;
        var time = 500;
        var id = document.getElementById("id").value;
        setTimeout(function() {
            window.print();
            window.location = url + "cotizaciones/detalles_auto/" + id;
        }, time);
    </script>
</body>

</html>