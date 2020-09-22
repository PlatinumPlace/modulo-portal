<?php
$api = new api;
$detalles = $api->detalles("Deals", $_GET["id"]);

if (empty($detalles)) {
    require_once "error.php";
    exit();
}

$imagen_aseguradora = $api->descargarFoto("Vendors", $detalles->getFieldValue('Aseguradora')->getEntityId());
$cliente = $api->detalles("Clientes", $detalles->getFieldValue('Cliente')->getEntityId());

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
                    Certificado <br>
                    Plan <?= $detalles->getFieldValue('Deal_Name') ?>
                </h4>
            </div>

            <div class="col-2">
                <b>Fecha</b> <br> <?= date("d-m-Y") ?> <br>
                <b>No.</b> <br> <?= $detalles->getFieldValue('No') ?> <br>
            </div>

            <div class="col-12">
                &nbsp;
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

            <div class="col-12">
                &nbsp;
            </div>

            <div class="col-12 d-flex justify-content-center bg-primary text-white">
                <h6>COBERTURAS</h6>
            </div>

            <div class="col-12 border">
                <div class="row">

                    <div class="col-4">
                        <div class="card border-0">
                            <div class="card-body small">

                                <img src="public/img/espacio.png" height="43" width="90" class="card-img-top">

                                <p>
                                    Suma Asegurada Vida: RD$<?= number_format($detalles->getFieldValue('Suma_asegurada'), 2) ?>
                                    <?php
                                    if ($detalles->getFieldValue('Cuota_men') != null) {
                                        echo "<br> Cuota Mensual Desempleo: RD$" . number_format($detalles->getFieldValue('Cuota_men'), 2);
                                    }
                                    ?>
                                </p>

                                <br>

                                <p>
                                    <b>Prima Neta</b> <br>
                                    <b>ISC</b> <br>
                                    <b>Prima Total</b>
                                </p>

                            </div>
                        </div>

                    </div>

                    <div class="col-2">
                        &nbsp;
                    </div>

                    <?php
                    $criteria = "Deal_Name:equals:" . $detalles->getEntityId();
                    $cotizaciones = $api->listaFiltrada("Quotes", $criteria);
                    foreach ($cotizaciones as $cotizacion) {
                        if ($cotizacion->getFieldValue('Grand_Total') > 0) {
                            echo '<div class="col-2">';
                            echo '<div class="card border-0">';

                            $imagen = $api->descargarFoto("Vendors", $cotizacion->getFieldValue('Aseguradora')->getEntityId());
                            echo '<img src="public/img/espacio.png" height="43" width="90" class="card-img-top">';

                            echo '<div class="card-body small">';

                            echo "<br><br><br>";

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
                        }
                    }
                    ?>

                </div>
            </div>

            <div class="col-12">
                &nbsp;
            </div>


            <div class="col-6 border">
                <h6 class="text-center">Observaciones</h6>

                <ul>
                    <?php
                    if ($detalles->getFieldValue('Cuota_men') != null) {
                        echo "<li>La cuota de desempleo es válida por hasta 6 meses</li>";
                    }
                    ?>
                </ul>
            </div>

        </div>
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

    <div class="row">

        <div class="col-3">
            <p class="text-center">
                _______________________________ <br> Firma Cliente
            </p>
        </div>

        <div class="col-6">
            &nbsp;
        </div>

        <div class="col-3">
            <p class="text-center">
                _______________________________ <br> Fecha
            </p>
        </div>

    </div>

    <script>
        var time = 500;
        var id = "<?= $_GET["id"] ?>";
        setTimeout(function() {
            window.print();
            window.location = "index.php?page=detallesVida&id=" + id;
        }, time);
    </script>

</body>

</html>