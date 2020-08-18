<?php
$api = new api;
$cotizaciones_total = 0;
$cotizaciones_pendientes = 0;
$cotizaciones_emitidas = 0;
$cotizaciones_vencidas = 0;
$aseguradoras = array();

$criterio = "Contact_Name:equals:" . $_SESSION["usuario"]["id"];
$num_pagina = 1;

do {
    $cotizaciones = $api->searchRecordsByCriteria("Quotes", $criterio, $num_pagina);
    if (!empty($cotizaciones)) {
        $num_pagina++;
        foreach ($cotizaciones as $cotizacion) {
            $cotizaciones_total += 1;

            if ($cotizacion->getFieldValue("Deal_Name") == null and date("Y-m", strtotime($cotizacion->getFieldValue("Fecha_emisi_n"))) == date('Y-m')) {
                $cotizaciones_pendientes += 1;
            }

            if ($cotizacion->getFieldValue("Deal_Name") != null and date("Y-m", strtotime($cotizacion->getFieldValue("Fecha_emisi_n"))) == date('Y-m')) {
                $cotizaciones_emitidas += 1;
                $planes = $cotizacion->getLineItems();
                foreach ($planes as $plan) {
                    $aseguradoras[] = $plan->getDescription();
                }
            }

            if ($cotizacion->getFieldValue("Deal_Name") != null and date("Y-m", strtotime($cotizacion->getFieldValue("Valid_Till"))) == date('Y-m')) {
                $cotizaciones_vencidas += 1;
            }
        }
    } else {
        $num_pagina = 0;
    }
} while ($num_pagina > 0);
require_once 'views/layout/header.php';
?>
<h1 class="mt-4 text-uppercase text-center">panel de control</h1>

<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item active">Panel de Control</li>
</ol>

<div class="alert alert-success" role="alert">
    <h4 class="alert-heading">¡Bienvenido al Insurance Tech de Grupo Nobe!</h4>
    <p>Desde su panel de control podrá ver la infomación necesaria manejar
        sus pólizas y cotizaciones.</p>
</div>

<div class="row">

    <div class="col-xl-3 col-md-6">
        <div class="card bg-primary text-white mb-4">
            <div class="card-body">
                Cotizaciones Totales <br>
                <?= $cotizaciones_total ?>
            </div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <a class="small text-white stretched-link" href="<?= constant("url") ?>buscar">Buscar</a>
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
                <a class="small text-white stretched-link" href="<?= constant("url") ?>buscar/emisiones_mensuales">Ver más</a>
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
                <a class="small text-white stretched-link" href="<?= constant("url") ?>buscar/vencimientos_mensuales">Ver más</a>
                <div class="small text-white">
                    <i class="fas fa-angle-right"></i>
                </div>
            </div>
        </div>
    </div>

</div>

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
                            <?php
                            $aseguradoras = array_count_values($aseguradoras);
                            foreach ($aseguradoras as $nombre => $cantidad_polizas) {
                                echo "<tr>";
                                echo '<th scope="row">' . $nombre . '</th>';
                                echo "<td>" . $cantidad_polizas . "</td>";
                                echo "</tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once 'views/layout/footer.php'; ?>