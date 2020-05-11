<?php

$criterio = "Contact_Name:equals:" . $_SESSION['usuario_id'];
$cotizaciones = $api->buscar_registro_por_criterio("Deals", $criterio);

$total = 0;
$pendientes = 0;
$emisiones = 0;
$vencimientos = 0;
$emitida = array("Emitido", "En trámite");

if ($cotizaciones) {

    foreach ($cotizaciones as $cotizacion) {

        if ($cotizacion->getFieldValue("Stage") != "Abandonado") {

            $total += 1;
        }

        if ($cotizacion->getFieldValue("Stage") == "Cotizando") {

            $pendientes += 1;
        }

        if (in_array($cotizacion->getFieldValue("Stage"), $emitida)) {

            if (date("Y-m", strtotime($cotizacion->getFieldValue("Fecha_de_emisi_n"))) == date('Y-m')) {

                $emisiones += 1;
                $cantidad_aseguradoras[] = $cotizacion->getFieldValue('Aseguradora')->getLookupLabel();
            }

            if (date("Y-m", strtotime($cotizacion->getFieldValue("Closing_Date"))) == date('Y-m')) {

                $vencimientos += 1;
            }
            
        }
    }

    $aseguradoras = array_count_values($cantidad_aseguradoras);
}

?>
<div class="alert alert-success" role="alert">
    <h4 class="alert-heading">¡Bienvenido al Insurance Tech de Grupo Nobe!</h4>
    <p>Desde su panel de control podrá ver la infomación necesaria manejar sus pólizas y cotizaciones.</p>
</div>

<div class="card-deck">

    <div class="card">
        <div class="card-header text-white bg-primary">
            <h1><?= $total ?></h1>
            <br>
            <h5>Cotizaciones <br> Totales</h5>
        </div>
        <div class="card-body">
            <a href="<?= constant('url') ?>cotizaciones/buscar" class="card-link">Ver más</a>
        </div>
    </div>

    <div class="card">
        <div class="card-header text-white bg-success">
            <h1><?= $pendientes ?></h1>
            <br>
            <h5>Cotizaciones <br> al Mes</h5>
        </div>
        <div class="card-body">
            <a href="<?= constant('url') ?>cotizaciones/pendientes" class="card-link">Ver más</a>
        </div>
    </div>

    <div class="card">
        <div class="card-header text-white bg-info">
            <h1><?= $emisiones ?></h1>
            <br>
            <h5>Emisiones <br> al Mes</h5>
        </div>
        <div class="card-body">
            <a href="<?= constant('url') ?>cotizaciones/emisiones" class="card-link">Ver más</a>
        </div>
    </div>

    <div class="card">
        <div class="card-header text-white bg-warning">
            <h1><?= $vencimientos ?></h1>
            <br>
            <h5>Vencimientos <br> al Mes</h5>
        </div>
        <div class="card-body">
            <a href="<?= constant('url') ?>cotizaciones/vencimientos" class="card-link">Ver más</a>
        </div>
    </div>

</div>

<br>

<div class="card">
    <h5 class="card-header">Póliza emitidas este mes</h5>
    <div class="card-body">
        <table class="table table-striped table-borderless">
            <thead>
                <tr>
                    <th scope="col">Aseguradoras</th>
                    <th scope="col">Cantidad de Pólizas</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($aseguradoras)) : ?>

                    <?php foreach ($aseguradoras as $nombre => $cantidad_polizas) : ?>
                        <tr>
                            <th scope="row"><?= $nombre ?></th>
                            <td><?= $cantidad_polizas ?></td>
                        </tr>
                    <?php endforeach ?>

                <?php endif ?>
            </tbody>
        </table>
    </div>
</div>