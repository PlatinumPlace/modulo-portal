<?php
$api = new api;

$cotizaciones_total = 0;
$cotizaciones_pendientes = 0;
$cotizaciones_emitidas = 0;
$cotizaciones_vencidas = 0;
$criterio = "Contact_Name:equals:" . $_SESSION["usuario"]["id"];

$num_pagina = 1;
do {
    $cotizaciones = $api->buscar_criterio("Quotes", $criterio, $num_pagina, 200);
    if (!empty($cotizaciones)) {
        $num_pagina++;

        foreach ($cotizaciones as $cotizacion) {
            $cotizaciones_total += 1;

            if ($cotizacion->getFieldValue("Deal_Name") == null and date("Y-m", strtotime($cotizacion->getFieldValue("Fecha_emisi_n"))) == date('Y-m')) {
                $cotizaciones_pendientes += 1;
            }
            
            if ($cotizacion->getFieldValue("Deal_Name") != null and date("Y-m", strtotime($cotizacion->getFieldValue("Fecha_emisi_n"))) == date('Y-m')) {
                $trato = $api->detalles_registro("Deals", $cotizacion->getFieldValue("Deal_Name")->getEntityId());
                $cotizaciones_emitidas += 1;
                $poliza = $api->detalles_registro("P_lizas", $trato->getFieldValue("P_liza")->getEntityId());
                $aseguradoras[] = $poliza->getFieldValue('Aseguradora')->getLookupLabel();
            }

            if ($cotizacion->getFieldValue("Deal_Name") != null and date("Y-m", strtotime($cotizacion->getFieldValue("Valid_Till"))) == date('Y-m')) {
                $cotizaciones_vencidas += 1;
            }
        }
    } else {
        $num_pagina = 0;
    }
} while ($num_pagina > 0);
?>
<h1 class="mt-4 text-uppercase">panel de control</h1>

<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item active">Panel de Control</li>
</ol>

<div class="alert alert-success" role="alert">
    <h4 class="alert-heading">¡Bienvenido al Insurance Tech de Grupo Nobe!</h4>
    <p>Desde su panel de control podrá ver la infomación necesaria manejar sus pólizas y cotizaciones.</p>
</div>

<div class="row">

    <div class="col-xl-3 col-md-6">
        <div class="card bg-primary text-white mb-4">
            <div class="card-body">
                Cotizaciones Totales <br>
                <?= $cotizaciones_total ?>
            </div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <a class="small text-white stretched-link" href="<?= constant("url") ?>cotizaciones/buscar">Buscar</a>
                <div class="small text-white">
                    <i class="fas fa-angle-right"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="card bg-warning text-white mb-4">
            <div class="card-body">
                Pendientes del Mes <br>
                <?= $cotizaciones_pendientes ?>
            </div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <a class="small text-white stretched-link" href="<?= constant("url") ?>cotizaciones/buscar/pendientes">Ver más</a>
                <div class="small text-white">
                    <i class="fas fa-angle-right"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="card bg-success text-white mb-4">
            <div class="card-body">
                Emisiones del Mes <br>
                <?= $cotizaciones_emitidas ?>
            </div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <a class="small text-white stretched-link" href="<?= constant("url") ?>cotizaciones/buscar/emisiones_mensuales">Ver más</a>
                <div class="small text-white">
                    <i class="fas fa-angle-right"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="card bg-danger text-white mb-4">
            <div class="card-body">
                Vencimientos del Mes <br>
                <?= $cotizaciones_vencidas ?>
            </div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <a class="small text-white stretched-link" href="<?= constant("url") ?>cotizaciones/buscar/vencimientos_mensuales">Ver más</a>
                <div class="small text-white">
                    <i class="fas fa-angle-right"></i>
                </div>
            </div>
        </div>
    </div>

</div>
<?php if (!empty($aseguradoras)) : ?>
    <div class="row">

        <div class="col-xl-12">
            <div class="card mb-4">
                <div class="card-header">Pólizas emitidas este mes</div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Aseguradora</th>
                                    <th>Cantidad</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $aseguradoras =  array_count_values($aseguradoras) ?>
                                <?php foreach ($aseguradoras as $nombre => $cantidad_polizas) : ?>
                                    <tr>
                                        <th scope="row"><?= $nombre ?></th>
                                        <td><?= $cantidad_polizas ?></td>
                                    </tr>
                                <?php endforeach ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
<?php endif ?>