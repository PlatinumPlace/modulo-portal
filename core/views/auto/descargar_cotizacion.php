<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?php if (!in_array($cotizacion->getFieldValue("Stage"), $emitida)) : ?>
            Cotización No.
        <?php else : ?>
            Resumen No.
        <?php endif ?>
        <?= $cotizacion->getFieldValue('No_Cotizaci_n') ?>
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
                <?php if (!in_array($cotizacion->getFieldValue("Stage"), $emitida)) : ?>
                    <img src="<?= constant('url') ?>public/img/logo.png" width="100" height="100">
                <?php else : ?>
                    <img width="170" height="75" src="<?= constant('url') . $imagen_aseguradora ?>">
                <?php endif ?>
            </div>
            <div class="col-8">
                <h4 class="text-uppercase text-center">
                    <?php if (!in_array($cotizacion->getFieldValue("Stage"), $emitida)) : ?>
                        cotización
                    <?php else : ?>
                        Resumen
                    <?php endif ?>
                    coberturas
                    <br>
                    seguro vehículo de motor<br>
                    plan <?= $cotizacion->getFieldValue('Plan') ?>
                </h4>
            </div>
            <div class="col-2">
                <b> Cotización No.</b>
                <br>
                <?= $cotizacion->getFieldValue('No_Cotizaci_n') ?>
                <br>
                <?php if (in_array($cotizacion->getFieldValue("Stage"), $emitida)) : ?>
                    <b> Póliza No.</b>
                    <br>
                    <?= $cotizacion->getFieldValue('P_liza') ?>
                    <br>
                <?php endif ?>
                <b>Fecha</b> <br> <?= $cotizacion->getFieldValue('Fecha_de_emisi_n') ?>
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
                        <?= $cotizacion->getFieldValue('Nombre') . " " . $cotizacion->getFieldValue('Apellido') ?><br>
                        <?= $cotizacion->getFieldValue('RNC_Cedula') ?><br>
                        <?= $cotizacion->getFieldValue('Email') ?><br>
                        <?= $cotizacion->getFieldValue('Direcci_n') ?>
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
                        <?= $cotizacion->getFieldValue('Tel_Residencia') ?><br>
                        <?= $cotizacion->getFieldValue('Telefono') ?><br>
                        <?= $cotizacion->getFieldValue('Tel_Trabajo') ?><br>
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
                        <?= $cotizacion->getFieldValue('Tipo_de_veh_culo') ?><br>
                        <?= strtoupper($cotizacion->getFieldValue('Marca')->getLookupLabel()) ?><br>
                        <?= strtoupper($cotizacion->getFieldValue('Modelo')->getLookupLabel()) ?><br>
                        <?= $cotizacion->getFieldValue('A_o_de_Fabricacion') ?><br>
                        RD$<?= number_format($cotizacion->getFieldValue('Valor_Asegurado'), 2) ?>
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
                        <?= $cotizacion->getFieldValue('Chasis') ?><br>
                        <?= $cotizacion->getFieldValue('Placa') ?><br>
                        <?= $cotizacion->getFieldValue('Color') ?><br>
                        <?= $cotizacion->getFieldValue('Uso') ?><br>
                        <?= ($cotizacion->getFieldValue('Es_nuevo') == 1) ? "Nuevo" : "Usado"; ?>
                    </div>
                </div>
            </div>


            <div class="col-12 d-flex justify-content-center bg-primary text-white">
                <h6>COBERTURAS</h6>
            </div>
            <div class="col-12 border">

                <div class="row">

                    <div class="col-4">

                        <div class="card border-0">
                            <div class="card-body">

                                <h6 class="card-title"><small><b>DAÑOS PROPIOS</b></small></h6>
                                <p class="card-text">
                                    <small>
                                        Riesgos comprensivos<br>
                                        Riesgos comprensivos (Deducible)<br>
                                        Rotura de Cristales (Deducible)<br>
                                        Colisión y vuelco<br>
                                        Incendio y robo
                                    </small>
                                </p>

                                <h6 class="card-title"><small><b>RESPONSABILIDAD CIVIL</b></small></h6>
                                <p class="card-text">
                                    <small>
                                        Daños Propiedad ajena<br>
                                        Lesiones/Muerte 1 Pers<br>
                                        Lesiones/Muerte más de 1 Pers<br>
                                        Lesiones/Muerte 1 pasajero<br>
                                        Lesiones/Muerte más de 1 pasajero<br>
                                    </small>
                                </p>

                                <h6 class="card-title"><small><b>RIESGOS CONDUCTOR</b></small></h6>

                                <h6 class="card-title"><small><b>FIANZA JUDICIAL</b></small></h6>

                                <h6 class="card-title"><small><b>COBERTURAS ADICIONALES</b></small></h6>
                                <p class="card-text">
                                    <small>
                                        Asistencia vial<br>
                                        Renta Vehículo<br>
                                        Casa del conductor/Centro <br> del Automovilista
                                    </small>
                                </p>


                                <h6 class="card-title"><small><b>Prima Neta</b></small></h6>

                                <h6 class="card-title"><small><b>ISC</b></small></h6>

                                <h6 class="card-title"><small><b>Prima Total</b></small></h6>

                            </div>
                        </div>
                    </div>

                    <?php foreach ($detalles as $resumen) : ?>
                        <?php if ($resumen->getFieldValue('Grand_Total') > 0) : ?>

                            <div class="col-2">

                                <?php if (!in_array($cotizacion->getFieldValue("Stage"), $emitida)) : ?>
                                    <?php $imagen_aseguradora = $this->aseguradora->foto($resumen->getFieldValue("Aseguradora")->getEntityId()) ?>
                                    <img height="31" width="90" src="<?= constant('url') . $imagen_aseguradora ?>">
                                <?php else : ?>
                                    &nbsp;
                                <?php endif ?>


                                <div class="card border-0">

                                    <div class="card-body">

                                        <?php $coberturas = $this->contrato->detalles($resumen->getFieldValue('Contrato')->getEntityId()) ?>

                                        <p class="card-text">
                                            <small>
                                                <?php

                                                $resultado = $cotizacion->getFieldValue('Valor_Asegurado') * ($coberturas->getFieldValue('Riesgos_comprensivos') / 100);
                                                echo "RD$" . number_format($resultado);

                                                echo "<br>";

                                                echo $coberturas->getFieldValue('Riesgos_Comprensivos_Deducible');

                                                echo "<br>";

                                                echo $coberturas->getFieldValue('Rotura_de_cristales_Deducible');

                                                echo "<br>";

                                                $resultado = $cotizacion->getFieldValue('Valor_Asegurado') * ($coberturas->getFieldValue('Colisi_n_y_vuelco') / 100);
                                                echo "RD$" . number_format($resultado);

                                                echo "<br>";

                                                $resultado = $cotizacion->getFieldValue('Valor_Asegurado') * ($coberturas->getFieldValue('Incendio_y_robo') / 100);
                                                echo "RD$" . number_format($resultado);

                                                ?>
                                            </small>
                                        </p>

                                        <h6 class="card-title">&nbsp;</h6>
                                        <p class="card-text">
                                            <small>
                                                <?php

                                                echo "RD$" . number_format($coberturas->getFieldValue('Da_os_Propiedad_ajena'));
                                                echo "<br>";
                                                echo "RD$" . number_format($coberturas->getFieldValue('Lesiones_Muerte_1_Pers'));
                                                echo "<br>";
                                                echo "RD$" . number_format($coberturas->getFieldValue('Lesiones_Muerte_m_s_de_1_Pers'));
                                                echo "<br>";
                                                echo "RD$" . number_format($coberturas->getFieldValue('Lesiones_Muerte_1_pasajero'));
                                                echo "<br>";
                                                echo "RD$" . number_format($coberturas->getFieldValue('Lesiones_Muerte_m_s_de_1_pasajero'));

                                                ?>
                                            </small>
                                        </p>

                                        <h6 class="card-title"><small>RD$<?= number_format($coberturas->getFieldValue('Riesgos_conductor')) ?></small></h6>

                                        <h6 class="card-title"><small>RD$<?= number_format($coberturas->getFieldValue('Fianza_judicial')) ?></small></h6>

                                        <h6 class="card-title">&nbsp;</h6>
                                        <p class="card-text">
                                            <small>
                                                <?php

                                                echo ($coberturas->getFieldValue('Renta_Veh_culo') == 1) ? "Aplica" : "No Aplica";
                                                echo "<br>";
                                                echo ($coberturas->getFieldValue('Asistencia_vial') == 1) ? "Aplica" : "No Aplica";
                                                echo "<br>";
                                                echo ($coberturas->getFieldValue('Asistencia_Accidente') != null) ? "Aplica" : "No Aplica";
                                                echo "<br><br>";

                                                ?>
                                            </small>
                                        </p>


                                        <?php $planes = $resumen->getLineItems() ?>
                                        <?php foreach ($planes as $plan) : ?>
                                            <h6 class="card-title">
                                                <small>
                                                    RD$<?= number_format($plan->getTotalAfterDiscount(), 2) ?>
                                                </small>
                                            </h6>

                                            <h6 class="card-title">
                                                <small>
                                                    RD$<?= number_format($plan->getTaxAmount(), 2) ?>
                                                </small>
                                            </h6>

                                            <h6 class="card-title">
                                                <small>
                                                    RD$<?= number_format($plan->getNetTotal(), 2) ?>
                                                </small>
                                            </h6>
                                        <?php endforeach ?>

                                    </div>

                                </div>
                            </div>

                        <?php endif ?>
                    <?php endforeach ?>


                </div>


            </div>


            <div class="col-12">
                &nbsp;
            </div>


            <?php if (in_array($cotizacion->getFieldValue("Stage"), $emitida)) : ?>

                <div class="col-6 border">

                    <br>

                    <img height="50" width="150" src="<?= constant('url') . $imagen_aseguradora ?>">

                    <br>
                    <br>

                    <div class="row">
                        <div class="col-6">
                            <b>Póliza: </b><?= $cotizacion->getFieldValue('P_liza') ?>
                            <br>
                            <div class="row">
                                <div class="col-3">
                                    <b>Marca:</b><br>
                                    <b>Placa:</b><br>
                                    <b>Tipo:</b><br>
                                    <b>Año:</b>
                                </div>
                                <div class="col-9">
                                    <?= strtoupper($cotizacion->getFieldValue('Marca')->getLookupLabel()) ?><br>
                                    <?= $cotizacion->getFieldValue('Placa') ?><br>
                                    <?= $cotizacion->getFieldValue('Tipo_de_veh_culo') ?><br>
                                    <?= $cotizacion->getFieldValue('A_o_de_Fabricacion') ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="row">
                                <div class="col-3">
                                    <b>Modelo:</b><br>
                                    <b>Chasis:</b><br>
                                    <b>Desde:</b><br>
                                    <b>Hasta:</b>
                                </div>
                                <div class="col-9">
                                    <?= strtoupper($cotizacion->getFieldValue('Modelo')->getLookupLabel()) ?><br>
                                    <?= $cotizacion->getFieldValue('Chasis') ?><br>
                                    <?= $cotizacion->getFieldValue('Fecha_de_emisi_n') ?><br>
                                    <?= $cotizacion->getFieldValue('Closing_Date') ?>
                                </div>
                            </div>
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
                                <b>Aseguradora</b> Tel. <?= $coberturas->getFieldValue('Tel_fono_Aseguradora') ?>
                            </div>
                            <br>
                            <?php if ($coberturas->getFieldValue('Asistencia_Accidente') != null) : ?>
                                <div class="col-6">
                                    <b><?= $coberturas->getFieldValue('Asistencia_Accidente') ?></b>
                                    <br>
                                    Tel. Sto. Dgo <?= $coberturas->getFieldValue('Tel_fono_Accidente') ?>
                                    <br>
                                    Tel. Santiago <?= $coberturas->getFieldValue('Tel_fono_Accidente_Santiago') ?>
                                </div>
                            <?php endif ?>
                            <?php if ($coberturas->getFieldValue('Asistencia_vial') == 1) : ?>
                                <div class="col-6">
                                    <b>Asistencia vial 24 horas</b><br>
                                    Tel. <?= $coberturas->getFieldValue('Tel_fono_Asistencia_vial') ?><br>
                                </div>
                            <?php endif ?>
                        </div>
                    </small>
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
                <div class="col-12">
                    &nbsp;
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
                        <b>Póliza No. <br> <?= $cotizacion->getFieldValue('P_liza') ?></b>
                    </div>

                    <div class="col-12">
                        &nbsp;
                    </div>

                    <div class="col-12">
                        <small>
                            <ul class="list-group list-group-flush ">


                                <li class="list-group-item">
                                    Este certificado es sólo un cotización de las condiciones principales contenidas en la póliza.
                                </li>
                                <li class="list-group-item">
                                    Si al momento de un siniestro, la suma asegurada del vehículo es menor que su valor de mercado, la aseguradora reducirá de la reclamación presentada, el monto equivalente a la proporción dejada de asegurar. La compañía aseguradora sólo será responsable por aquella parte de la pérdida en la proporción en la que tenga el valor real como suma asegurada.
                                </li>
                                <li class="list-group-item">
                                    Queda excluida de toda cobertura, los accesorios, equipos y aditamentos que no sean instalados de fábrica en el vehículo asegurado, a menos de que hayan sido declarados previamente en la póliza. Tampoco tienen cobertura mercancías o herramientas dejadas dentro del vehículo asegurado o que se transporten en el mismo.
                                </li>
                                <li class="list-group-item">
                                    Quedan excluidas las pérdidas y/o daños sufridos y/o causados al vehículo asegurado si el mismo fuese conducido por personas sin licencia de conducir otorgada por las autoridades competentes. Se excluye también los daños sufridos u ocasionados en el vehículo asegurado si este fuese conducido en estado de embriaguez o bajo la influencia de cualquier droga. Tampoco tendrá cobertura si el vehículo asegurado no está siendo es utilizado con fines privados, es decir que se utilice como transporte comercial (taxi, carro público, etc.).
                                </li>
                                <li class="list-group-item">
                                    En caso de realizarse alguna modificación o instalación de algún aditamento o accesorio a las especificaciones de fábrica al vehículo asegurado, (Ejemplo: cambio en el sistema de combustible, cambio de ubicación del volante, aros, equipos de música, luces, etc.), luego de haberse incluido en la póliza, obligatoriamente debe de notificarse a la compañía aseguradora para los fines de re-inspección del vehículo, aceptación y cobertura, mediante endoso, por la aseguradora.
                                </li>
                                <li class="list-group-item">
                                    Si el vehículo asegurado se encontrase transitando fuera del territorio nacional o en caminos no declarados ni autorizados de tránsito público por las autoridades competentes, y sufre algún tipo de daño o siniestro, la cobertura queda excluida, a menos que fuera autorizado por la aseguradora.
                                </li>
                                <li class="list-group-item">
                                    Queda excluida de toda cobertura daños ocasionados por la entrada de agua al motor o cualquier otra parte del vehículo asegurado, cuando dicha entrada es causada por el ingreso voluntario del vehículo a una vía, camino o terreno inundado.
                                </li>
                                <li class="list-group-item">
                                    En caso de reclamación parcial para vehículos de más de 3 años de fabricación, se indemnizará utilizando repuestos usados y/o piezas de reemplazo.
                                </li>
                                <li class="list-group-item">
                                    La aseguradora indemnizará pérdidas y/ o daños sufridos al vehículo asegurado, descontando el deducible aplicable a cada cobertura.
                                </li>
                                <li class="list-group-item">
                                    La aseguradora está en su derecho de proceder a la cancelación de la póliza, o descontinuar la cobertura del vehículo, en cualquier momento previo aviso al asegurado con treinta (30) días de antelación a la efectividad de la misma. Si la cancelación es por falta de pago, aplica lo establecido en los artículos 73, 74 y 75 de ley 146-02 de seguros y fianzas de la República Dominicana.
                                </li>
                                <li class="list-group-item">
                                    Para proceder a la inclusión del vehículo asegurado en la póliza, si el vehículo es usado debe de ser sometido a inspección y reportar su inclusión a la aseguradora en un plazo no mayor de 48 horas. Pasado este plazo, la cobertura quedará reducida a seguro de ley. En caso del vehículo ser nuevo (0 KM) se puede proceder a la inclusión en la póliza con el conduce de salida, debidamente sellado, completado con los datos del mismo y firmado por el dealer o concesionario.
                                </li>
                                <li class="list-group-item">
                                    La cobertura de este certificado está sujeta al pago de la prima.
                                </li>
                                <li class="list-group-item">
                                    Esta póliza tendrá un período de duración igual a la vigencia del préstamo. Si el préstamo es saldado antes del fin de la vigencia, la cobertura cesará.
                                </li>
                                <li class="list-group-item">
                                    La prima de este seguro puede ser revisable sin previo aviso y está sujeta a la siniestralidad de la póliza.
                                </li>
                                <li class="list-group-item">
                                    Tarifa NO APLICA para Vehículos con Equipo de Gas instalado, solo se aceptarán si el Equipo es marca LOVATO o TARTARINI, los cuales deben ser inspeccionado por perito de la aseguradora y sujeto a que cliente suministre copia de factura instalación y garantía del mismo. En caso de aceptación aplica recargo a la tarifa.
                                </li>
                                <li class="list-group-item">
                                    Los vehículos MITSUBISHI para los modelos, NATIVA, MONTERO SPORT Y L200, y los camiones DAIHATSU deberán de tener un sistema de seguridad contra robo o rastreo tipo GPS. En caso contrario solo se asegurará a un 50%.
                                </li>


                            </ul>
                        </small>
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
    </div>


    <input value="<?= $id ?>" id="id" hidden>
    <input value="<?= constant('url') ?>" id="url" hidden>
    <script>
        var url = document.getElementById("url").value;
        var time = 500;
        var id = document.getElementById("id").value;
        setTimeout(function() {
            window.print();
            window.location = url + "auto/detalles_cotizacion/" + id;
        }, time);
    </script>
</body>

</html>