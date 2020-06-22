<h1 class="mt-4">Panel de Control</h1>
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
                Cotizaciones Totales
                <br>
                <?= $total ?>

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
                Cotizaciones al Mes
                <br>
                <?= $pendientes ?>
            </div>

            <div class="card-footer d-flex align-items-center justify-content-between">
                <a class="small text-white stretched-link" href="<?= constant("url") ?>cotizaciones/lista/pendientes">Ver más</a>
                <div class="small text-white">
                    <i class="fas fa-angle-right"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card bg-success text-white mb-4">

            <div class="card-body">
                Emisiones al Mes
                <br>
                <?= $emisiones ?>
            </div>

            <div class="card-footer d-flex align-items-center justify-content-between">
                <a class="small text-white stretched-link" href="<?= constant("url") ?>cotizaciones/lista/emisiones_mensuales">Ver más</a>
                <div class="small text-white">
                    <i class="fas fa-angle-right"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card bg-danger text-white mb-4">

            <div class="card-body">
                Vencimientos al Mes
                <br>
                <?= $vencimientos ?>
            </div>

            <div class="card-footer d-flex align-items-center justify-content-between">
                <a class="small text-white stretched-link" href="<?= constant("url") ?>cotizaciones/lista/vencimientos_mensuales">Ver más</a>
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
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Aseguradora</th>
                                    <th>Cantidad</th>
                                </tr>
                            </thead>
                            <tbody>
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