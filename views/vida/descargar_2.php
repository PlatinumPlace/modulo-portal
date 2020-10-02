<?php
$vida = new vida;
$id = (isset($_GET["id"])) ? $_GET["id"] : null;
$trato = $vida->getRecord("Deals", $id);

if (empty($trato)) {
    require_once "views/error.php";
    exit();
}

$imagen_aseguradora = $vida->downloadPhoto("Vendors", $trato->getFieldValue('Aseguradora')->getEntityId());
$cliente = $vida->getRecord("Contacts", $trato->getFieldValue('Cliente')->getEntityId());
$contrato = $vida->getRecord("Contratos", $trato->getFieldValue('Contrato')->getEntityId());
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
                <img height="60" width="150" alt="50" src="<?= $imagen_aseguradora ?>">
            </div>

            <div class="col-8">
                <h4 class="text-uppercase text-center">
                    certificado <br> plan <?= $trato->getFieldValue('Deal_Name') ?>
                </h4>
            </div>

            <div class="col-2">
                <b>Fecha</b> <br> <?= date("d-m-Y") ?> <br>
                <b>No. de cotización</b> <br> <?= $trato->getFieldValue('No') ?> <br>
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
                        <b>Nombre:</b> <br>
                        <b>RNC/Cédula:</b> <br>
                        <b>Email:</b> <br>
                        <b>Dirección:</b>
                    </div>

                    <div class="col-8">
                        <?php
                        echo $cliente->getFieldValue('First_Name') . " " . $cliente->getFieldValue('Last_Name');
                        echo "<br>";
                        echo $cliente->getFieldValue('RNC_C_dula');
                        echo "<br>";
                        echo $cliente->getFieldValue('Email');
                        echo "<br>";
                        echo $cliente->getFieldValue('Mailing_Street');
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
                        echo $cliente->getFieldValue('Phone');
                        echo "<br>";
                        echo $cliente->getFieldValue('Home_Phone');
                        echo "<br>";
                        echo $cliente->getFieldValue('Other_Phone');
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

                    <div class="col-3">
                        <div class="card border-0">

                            <br><br>

                            <div class="card-body small">

                                <p>
                                    <b>Suma Asegurada Vida</b> <br>
                                    <?php
                                    if ($trato->getFieldValue('Cuota') != null) {
                                        echo "<b>Cuota Mensual Desempleo</b> <br>";
                                    }
                                    ?>
                                    <br>
                                    <b>Prima Neta</b> <br>
                                    <b>ISC</b> <br>
                                    <b>Prima Total</b>
                                </p>

                            </div>
                        </div>

                    </div>

                    <div class="col-2">
                        <div class="card border-0">

                            <br><br>

                            <div class="card-body small">

                                <p>
                                    <?php
                                    echo "RD$" . number_format($trato->getFieldValue('Suma_asegurada'), 2);
                                    echo "<br>";
                                    if ($trato->getFieldValue('Cuota') != null) {
                                        echo "RD$" .  number_format($trato->getFieldValue('Cuota'), 2);
                                    }
                                    ?>
                                </p>

                            </div>
                        </div>

                    </div>

                    <?php
                    echo '<div class="col-2">';
                    echo '<div class="card border-0">';

                    echo '<img src="public/img/espacio.png" height="43" width="90" class="card-img-top">';

                    echo '<div class="card-body small">';
                    echo '<p>';

                    echo "<br>";

                    if ($trato->getFieldValue('Cuota') != null) {
                        echo "<br>";
                    }

                    echo "<br>";

                    echo "RD$" . number_format($trato->getFieldValue('Prima_neta'), 2) . "<br>";
                    echo "RD$" . number_format($trato->getFieldValue('ISC'), 2) . "<br>";
                    echo "RD$" . number_format($trato->getFieldValue('Prima_total'), 2) . "<br>";

                    echo '</p>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
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
                        echo "<li>La cuota de desempleo es válida hasta por 6 meses</li>";
                    }
                    ?>
                </ul>
            </div>

            <div class="col-6 border">
                <h6 class="text-center">Requisitos del deudor</h6>

                <ul>
                    <?php
                    foreach ($contrato->getFieldValue('Requisitos_deudor') as $requisito) {
                        echo  "<li>" . $requisito . "</li>";
                    }
                    ?>
                </ul>

                <h6 class="text-center">Requisitos del codeudor</h6>

                <ul>
                    <?php
                    if ($contrato->getFieldValue('Requisitos_codeudor') != null) {
                        foreach ($contrato->getFieldValue('Requisitos_codeudor') as $requisito) {
                            echo  "<li>" . $requisito . "</li>";
                        }
                    } else {
                        echo "<br>";
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
            &nbsp;
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
        setTimeout(function() {
            window.print();
            window.location = "?pagina=detallesVida&id=" + id;
        }, time);
    </script>

</body>

</html>