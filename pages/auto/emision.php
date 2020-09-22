<?php
$api = new api;
$detalles = $api->detalles("Deals", $_GET["id"]);

if (empty($detalles)) {
    require_once "error.php";
    exit();
}

$imagen_aseguradora = $api->descargarFoto("Vendors", $detalles->getFieldValue('Aseguradora')->getEntityId());
$cliente = $api->detalles("Clientes", $detalles->getFieldValue('Cliente')->getEntityId());
$bien = $api->detalles("Bienes", $detalles->getFieldValue('Bien')->getEntityId());
$aseguradora = $api->detalles("Vendors", $detalles->getFieldValue('Aseguradora')->getEntityId());

$criteria = "Deal_Name:equals:" . $detalles->getEntityId();
$cotizaciones = $api->listaFiltrada("Quotes", $criteria);
foreach ($cotizaciones as $cotizacion) {
    if (
        $detalles->getFieldValue("Aseguradora") != null
        and
        $detalles->getFieldValue("Stage") != "Cotizando"
    ) {
        $contrato = $api->detalles("Contratos", $cotizacion->getFieldValue('Contrato')->getEntityId());
        $coberturas = $api->detalles("Coberturas", $contrato->getFieldValue('Coberturas')->getEntityId());
    }
}
?>
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js" crossorigin="anonymous"></script>

    <title>Resumen</title>

    <link rel="icon" type="image/png" href="public/img/logo.png">
</head>

<body>

    <div class="container">
        <div class="row">

            <div class="col-2">
                <img src="<?= $imagen_aseguradora ?>" width="100" height="100">
            </div>

            <div class="col-8">
                <h4 class="text-uppercase text-center">
                    resumen coberturas <br>
                    seguro vehí­culo de motor <br>
                    Plan <?= $detalles->getFieldValue('Deal_Name') ?>
                </h4>
            </div>

            <div class="col-2">
                <b>Fecha</b> <br> <?= date("d-m-Y") ?> <br>
                <b>No.</b> <br> <?= $detalles->getFieldValue('No') ?> <br>
            </div>

            <div class="col-12 d-flex justify-content-center bg-primary text-white">
                <h6>CLIENTE</h6>
            </div>

            <div class="col-6 border">
                <div class="row">

                    <div class="col-4">
                        <b>Nombre:</b><br>
                        <b>RNC/Cédula:</b><br>
                        <b>Email:</b><br>
                        <b>Dirección:</b>
                    </div>

                    <div class="col-8">
                        <?php
                        echo $cliente->getFieldValue('Nombre') . " " . $cliente->getFieldValue('Apellido');
                        echo "<br>";
                        echo $cliente->getFieldValue('RNC_C_dula');
                        echo "<br>";
                        echo $cliente->getFieldValue('Email');
                        echo "<br>";
                        echo $cliente->getFieldValue('Direcci_n');
                        ?>
                    </div>

                </div>
            </div>

            <div class="col-6 border">
                <div class="row">

                    <div class="col-4">
                        <b>Tel. Residencia:</b><br>
                        <b>Tel. Celular:</b><br>
                        <b>Tel. Trabajo:</b>
                    </div>

                    <div class="col-8">
                        <?php
                        echo $cliente->getFieldValue('Tel_residencia');
                        echo "<br>";
                        echo $cliente->getFieldValue('Tel_fono');
                        echo "<br>";
                        echo $cliente->getFieldValue('Tel_trabajo');
                        ?>
                    </div>

                </div>
            </div>

            <div class="col-12 d-flex justify-content-center bg-primary text-white">
                <h6>VEHÍCULO</h6>
            </div>

            <div class="col-6 border">
                <div class="row">

                    <div class="col-4">
                        <b>Marca:</b><br>
                        <b>Modelo:</b><br>
                        <b>Año:</b><br>
                        <b>Tipo:</b><br>
                        <b>Suma Asegurada:</b>
                    </div>

                    <div class="col-8">
                        <?php
                        echo $bien->getFieldValue('Marca');
                        echo "<br>";
                        echo $bien->getFieldValue('Modelo');
                        echo "<br>";
                        echo $bien->getFieldValue('A_o');
                        echo "<br>";
                        echo $bien->getFieldValue('Tipo_de_veh_culo');
                        echo "<br>";
                        echo "RD$" . number_format($detalles->getFieldValue('Suma_asegurada'), 2);
                        ?>
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
                        <b>Condicion:</b>
                    </div>

                    <div class="col-8">
                        <?php
                        echo $bien->getFieldValue('Name');
                        echo "<br>";
                        echo $bien->getFieldValue('Placa');
                        echo "<br>";
                        echo $bien->getFieldValue('Color');
                        echo "<br>";
                        echo $bien->getFieldValue('Uso');
                        echo "<br>";
                        echo $bien->getFieldValue('Condicion');
                        ?>
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

                            <br>

                            <div class="card-body small">

                                <p>
                                    <b>DAÑOS PROPIOS</b><br>
                                    Riesgos comprensivos<br>
                                    Riesgos comprensivos (Deducible)<br>
                                    Rotura de Cristales (Deducible)<br>
                                    Colisión y vuelco<br>
                                    Incendio y robo
                                </p>

                                <p>
                                    <b>RESPONSABILIDAD CIVIL</b><br>
                                    Daños Propiedad ajena<br>
                                    Lesiones/Muerte 1 Pers<br>
                                    Lesiones/Muerte más de 1 Pers<br>
                                    Lesiones/Muerte 1 pasajero<br>
                                    Lesiones/Muerte más de 1 pasajero<br>
                                </p>

                                <p>
                                    <b>RIESGOS CONDUCTOR</b> <br>
                                    <b>FIANZA JUDICIAL</b>
                                </p>

                                <p>
                                    <b>COBERTURAS ADICIONALES</b><br>
                                    Asistencia vial<br>
                                    Renta Vehí­culo<br>
                                    <?= $coberturas->getFieldValue('En_caso_de_accidente') ?>
                                </p>

                                <br>

                                <p>
                                    <b>PRIMA NETA</b> <br>
                                    <b>ISC</b> <br>
                                    <b>PRIMA TOTAL</b> <br>
                                </p>

                            </div>
                        </div>
                    </div>

                    <div class="col-2">
                        &nbsp;
                    </div>

                    <?php
                    echo '<div class="col-2">';
                    echo '<div class="card border-0">';

                    echo '<img src="public/img/espacio.png" height="43" width="90" class="card-img-top">';

                    echo '<div class="card-body small">';

                    $riesgo_compresivo = $detalles->getFieldValue('Suma_asegurada') * ($coberturas->getFieldValue('Riesgos_comprensivos') / 100);
                    $colision = $detalles->getFieldValue('Suma_asegurada') * ($coberturas->getFieldValue('Colisi_n_y_vuelco') / 100);
                    $incendio = $detalles->getFieldValue('Suma_asegurada') * ($coberturas->getFieldValue('Incendio_y_robo') / 100);

                    echo '<p>';
                    echo "RD$" . number_format($riesgo_compresivo) . "<br>";
                    echo $coberturas->getFieldValue('Riesgos_comprensivos_deducible') . "<br>";
                    echo $coberturas->getFieldValue('Rotura_de_cristales_deducible') . "<br>";
                    echo "RD$" . number_format($colision) . "<br>";
                    echo "RD$" . number_format($incendio) . "<br>";
                    echo '</p>';

                    echo '<p>';
                    echo "<br>";
                    echo "RD$" . number_format($coberturas->getFieldValue('Da_os_propiedad_ajena')) . "<br>";
                    echo "RD$" . number_format($coberturas->getFieldValue('Lesiones_muerte_1_pas')) . "<br>";
                    echo "RD$" . number_format($coberturas->getFieldValue('Lesiones_muerte_m_s_pas')) . "<br>";
                    echo "RD$" . number_format($coberturas->getFieldValue('Lesiones_muerte_1_pers')) . "<br>";
                    echo "RD$" . number_format($coberturas->getFieldValue('Lesiones_muerte_m_s_pers')) . "<br>";
                    echo '</p>';

                    echo '<p>';
                    echo "RD$" . number_format($coberturas->getFieldValue('Riesgos_conductor')) . "<br>";
                    echo "RD$" . number_format($coberturas->getFieldValue('Fianza_judicial')) . "<br>";
                    echo '</p>';

                    echo '<p>';
                    echo "<br>";
                    echo ($coberturas->getFieldValue('Asistencia_vial') == 1) ? "Aplica <br>" : "No Aplica <br>";
                    echo ($coberturas->getFieldValue('Renta_veh_culo') == 1) ? "Aplica <br>" : "No Aplica <br>";
                    echo ($coberturas->getFieldValue('En_caso_de_accidente') != null) ? "Aplica" : "No Aplica";
                    echo '</p>';

                    echo "<br>";

                    $planes = $cotizacion->getLineItems();
                    foreach ($planes as $plan) {
                        echo '<p>';
                        echo "RD$" . number_format($plan->getListPrice(), 2) . "<br>";
                        echo "RD$" . number_format($plan->getTaxAmount(), 2) . "<br>";
                        echo "RD$" . number_format($plan->getNetTotal(), 2) . "<br>";
                        echo '</p>';
                    }

                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                    ?>

                </div>
            </div>

        </div>
    </div>

    <div class="col-12">
        &nbsp;
    </div>

    <div class="row small">

        <div class="col-6 border">

            <br>
            <img height="60" width="150" src="<?= $imagen_aseguradora ?>">
            <br><br>

            <div class="row">

                <div class="col-4">
                    <p>
                        <b>Póliza:</b><br>
                        <b>Marca:</b> <br>
                        <b>Modelo:</b> <br>
                        <b>Chasis:</b> <br>
                        <b>Placa:</b> <br>
                        <b>Año:</b> <br>
                        <b>Desde:</b> <br>
                        <b>Hasta:</b>
                    </p>
                </div>

                <div class="col-8">
                    <p>
                        <?php
                        echo $detalles->getFieldValue('P_liza')->getLookupLabel() . "<br>";
                        echo strtoupper($bien->getFieldValue('Marca')) . "<br>";
                        echo strtoupper($bien->getFieldValue('Modelo')) . "<br>";
                        echo $bien->getFieldValue('Name') . "<br>";
                        echo $bien->getFieldValue('Placa') . "<br>";
                        echo $bien->getFieldValue('A_o') . "<br>";
                        echo $detalles->getFieldValue('Fecha_de_emisi_n') . "<br>";
                        echo $detalles->getFieldValue('Closing_Date');
                        ?>
                    </p>
                </div>

            </div>

        </div>

        <div class="col-6 border">

            <div class="text-center font-weight-bold">EN CASO DE ACCIDENTE</div>
            <p>
                Realiza el levantamiento del acta policial y obténga la siguente cotizacionrmación:

                <ul>
                    <li>Nombre,dirección y teléfonos del conductor,los lesionados,del propietario y de los testigos.</li>
                    <li>Número de placa y póliza del vehí­culo involucrado, y nombre de la aseguradora</li>
                </ul>

                <b>EN CASO DE ROBO:</b>Notifica de inmediato a la Policía y a la Aseguradora. <br>

                <div class="text-center"><b>RESERVE SU DERECHO</b></div>
            </p>

            <p>
                <b>Aseguradora:</b> Tel. <?= $aseguradora->getFieldValue('Phone') ?>
            </p>

            <div class="row">

                <div class="col-md-8">
                    <?php if ($coberturas->getFieldValue('En_caso_de_accidente') != null) : ?>
                        <p>
                            <b><?= $coberturas->getFieldValue('En_caso_de_accidente') ?></b> <br>
                            Tel. Sto. Dgo <?= $coberturas->getFieldValue('Tel_accidente_Sto_Dgo') ?> <br>
                            Tel. Santiago <?= $coberturas->getFieldValue('Tel_accidente_Santiago') ?>
                        </p>
                    <?php endif ?>
                </div>

                <div class="col-md-4">
                    <?php if ($coberturas->getFieldValue('Asistencia_vial') == 1) : ?>
                        <p>
                            <b>Asistencia vial 24 horas</b> <br>
                            Tel. <?= $coberturas->getFieldValue('Tel_asistencia_vial') ?>
                        </p>
                    <?php endif ?>
                </div>

            </div>

        </div>

    </div>

    <script>
        var time = 500;
        var id = "<?= $_GET["id"] ?>";
        setTimeout(function() {
            window.print();
            window.location = "index.php?page=detallesAuto&id=" + id;
        }, time);
    </script>

</body>

</html>