<?php
$url = explode("/", $_GET["url"]);
$id = (isset($url[2])) ? $url[2] : null;
$trato = detalles("Deals", $id);

if (empty($trato)) {
    require_once "views/portal/error.php";
    exit();
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

        <title>Cotizacion</title>

        <link rel="icon" type="image/png" href="<?= constant("url") ?>public/img/logo.png">
    </head>

    <body>

        <div class="container">
            <div class="row">

                <div class="col-2">
                    <img src="<?= constant("url") ?>public/img/logo.png" width="100" height="100">
                </div>

                <div class="col-8">
                    <h4 class="text-uppercase text-center"> cotización <br> Plan <?= $trato->getFieldValue('Plan') ?> </h4>
                </div>

                <div class="col-2">
                    <b>Fecha</b>
                    <br>
                    <?= date("d-m-Y") ?>
                    <br>
                    <b>No.</b>
                    <br>
                    <?= $trato->getFieldValue('No') ?>
                    <br>
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
                            <b>Nombre:</b>
                            <br>
                            <b>RNC/Cédula:</b>
                            <br>
                            <b>Email:</b>
                            <br>
                            <b>Dirección:</b>
                        </div>

                        <div class="col-8">
                            <?= $trato->getFieldValue('Nombre') ?>
                        </div>

                    </div>
                </div>

                <div class="col-6 border">
                    <div class="row">

                        <div class="col-4">
                            <b>Tel. Residencia:</b>
                            <br>
                            <b>Tel. Celular:</b>
                            <br>
                            <b>Tel. Trabajo:</b>
                        </div>

                        <div class="col-8">
                            &nbsp;
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

                                <br>

                                <div class="card-body small">

                                    <p>
                                        Suma Asegurada Vida: RD$<?= number_format($trato->getFieldValue('Suma_asegurada'), 2) ?>
                                        <?php
                                        if ($trato->getFieldValue('Cuota') != null) {
                                            echo "<br> Cuota Mensual Desempleo: RD$" . number_format($trato->getFieldValue('Cuota'), 2);
                                        } else {
                                            echo "<br><br>";
                                        }
                                        ?>
                                    </p>

                                    <p>
                                        <b>Prima Neta</b>
                                        <br>
                                        <b>ISC</b>
                                        <br>
                                        <b>Prima Total</b>
                                    </p>

                                </div>
                            </div>

                        </div>

                        <?php
                        $criteria = "Deal_Name:equals:" . $trato->getEntityId();
                        $cotizaciones = listaPorCriterio("Quotes", $criteria);
                        foreach ($cotizaciones as $cotizacion) {
                            if ($cotizacion->getFieldValue('Grand_Total') > 0) {

                                echo '<div class="col-2">';
                                echo '<div class="card border-0">';

                                $imagen = descargarFoto("Vendors", $cotizacion->getFieldValue('Aseguradora')->getEntityId());
                                echo '<img src="' . constant('url') . $imagen . '" height="35" width="90" class="card-img-top">';
                                echo '<div class="card-body small">';

                                echo "<br><br>";

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
                        if ($trato->getFieldValue('Cuota') != null) {
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

        <script>
            var time = 500;
            var id = "<?= $id ?>";
            var url = "<?= constant("url") ?>";
            setTimeout(function () {
                window.print();
                window.location = url + "cotizaciones/detallesVida/" + id;
            }, time);
        </script>


    </body>

</html>