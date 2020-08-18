<?php
if ($cotizacion->getFieldValue("Deal_Name") != null) {
    $trato = $api->getRecord("Deals", $cotizacion->getFieldValue("Deal_Name")->getEntityId());
    $coberturas = $api->getRecord("Contratos", $trato->getFieldValue("Contrato")->getEntityId());
    $aseguradora = $api->getRecord("Vendors", $coberturas->getFieldValue("Aseguradora")->getEntityId());
    $imagen_aseguradora = $api->downloadPhoto("Vendors", $aseguradora->getEntityId());
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

    <title>Cotización No. <?= $cotizacion->getFieldValue('Quote_Number') ?></title>
    <link rel="icon" type="image/png" href="<?= constant("url") ?>public/icons/logo.png">

    <style>
        @media print {
            .pie_pagina {
                position: fixed;
                margin: auto;
                height: 100px;
                width: 100%;
                right: 0;
                bottom: 0;
                left: 0;
                z-index: 1030;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row">

            <div class="col-2">
                <?php if ($cotizacion->getFieldValue("Deal_Name") != null) : ?>
                    <img src="<?= constant("url") . $imagen_aseguradora ?>" width="130" height="100">
                <?php else : ?>
                    <img src="<?= constant("url") ?>public/icons/logo.png" width="100" height="100">
                <?php endif ?>
            </div>

            <div class="col-8">
                <h4 class="text-uppercase text-center">
                    <?= $cotizacion->getFieldValue('Subject') ?>
                </h4>
            </div>

            <div class="col-2">
                <b>Fecha</b> <br> <?= $cotizacion->getFieldValue('Fecha_emisi_n') ?> <br>
                <b>Cotización No.</b> <br> <?= $cotizacion->getFieldValue('Quote_Number') ?> <br>
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
                        <b>Direccion:</b>
                    </div>

                    <div class="col-8">
                        <?php
                        echo $cotizacion->getFieldValue('Nombre') . " " . $cotizacion->getFieldValue('Apellido');
                        echo "<br>";
                        echo $cotizacion->getFieldValue('RNC_C_dula');
                        echo "<br>";
                        echo $cotizacion->getFieldValue('Correo');
                        echo "<br>";
                        echo $cotizacion->getFieldValue('Direcci_n');
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
                        echo $cotizacion->getFieldValue('Tel_Residencial');
                        echo "<br>";
                        echo $cotizacion->getFieldValue('Tel_Celular');
                        echo "<br>";
                        echo $cotizacion->getFieldValue('Tel_Trabajo');
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
                            <div class="card-body">
                                <h5 class="card-title">
                                    Suma Asegurada:<br>
                                    RD$<?= number_format($cotizacion->getFieldValue('Valor_Asegurado'), 2) ?>
                                </h5>

                                <br>
                                <hr>

                                <p class="card-text">
                                    Prima Neta<br>
                                    ISC<br>
                                    Prima Mensual
                                </p>
                            </div>
                        </div>
                    </div>

                    <?php $planes = $cotizacion->getLineItems() ?>
                    <?php foreach ($planes as $plan) : ?>
                        <?php if ($plan->getNetTotal() > 0) : ?>
                            <?php
                            $criterio = "((Socio:equals:" . $_SESSION["usuario"]["empresa_id"] . ") and (Plan:equals:" . $plan->getProduct()->getEntityId() . "))";
                            $contratos = $api->searchRecordsByCriteria("Contratos", $criterio);
                            foreach ($contratos as $contrato) {
                                $coberturas = $contrato;
                            }
                            if ($cotizacion->getFieldValue("Deal_Name") == null) {
                                $imagen_aseguradora = $api->downloadPhoto("Vendors", $coberturas->getFieldValue("Aseguradora")->getEntityId());
                            }                            ?>
                            <div class="col-2">
                                <div class="card border-0">
                                    <div class="card-body">
                                        <div class="card-title">
                                            <img height="50" width="120" src="<?= constant("url") . $imagen_aseguradora ?>">
                                        </div>

                                        <br>
                                        <hr>

                                        <p class="card-text">
                                            RD$<?= number_format($plan->getListPrice(), 2) ?><br>
                                            RD$<?= number_format($plan->getTaxAmount(), 2) ?><br>
                                            RD$<?= number_format($plan->getNetTotal(), 2) ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        <?php endif ?>
                    <?php endforeach ?>
                </div>
            </div>

        </div>

        <div class="row pie_pagina">
            <div class="col-3">
                <p class="text-center">
                    _______________________________
                    <br>
                    Firma Cliente
                </p>
            </div>
            <div class="col-6">
                <p class="text-center">
                    _______________________________
                    <br>
                    Aseguradora Elegida
                </p>
            </div>
            <div class="col-3">
                <p class="text-center">
                    _______________________________
                    <br>
                    Fecha
                </p>
            </div>
        </div>

    </div>

    <script>
        var time = 500;
        var url = "<?= constant("url") ?>";
        var id = "<?= $cotizacion->getEntityId() ?>";
        setTimeout(function() {
            window.print();
            window.location = url + "detalles/" + id;
        }, time);
    </script>

</body>

</html>