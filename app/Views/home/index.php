<?= $this->extend('layouts/app') ?>

<?= $this->section('content') ?>

<h1 class="mt-4">Panel de control</h1>
<hr>

<div class="alert alert-success" role="alert">
    <h4 class="alert-heading">¡Bienvenido al Insurance Tech de Grupo Nobe!</h4>
    <p>Desde su panel de control podrás ver la infomación necesaria para manejar sus pólizas y cotizaciones.</p>
</div>

<br><br>

<div class="card-deck">
    <div class="card text-white bg-primary mb-3" style="max-width: 18rem;">
        <div class="card-body">
            <h5 class="card-title">Cotizaciones al mes</h5>
            <p class="card-text h5"><?= $cotizaciones ?></p>
        </div>
    </div>

    <div class="card text-white bg-success mb-3" style="max-width: 18rem;">
        <div class="card-body">
            <h5 class="card-title">Emisiones al mes</h5>
            <p class="card-text h5"><?= $emisiones ?></p>
        </div>
    </div>
</div>

<br><br>

<div class="card mb-4">
    <div class="card-header">
        <i class="fas fa-table mr-1"></i>
        Pólizas emitidas este mes
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Aseguradora</th>
                        <th>Cantidad</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Aseguradora</th>
                        <th>Cantidad</th>
                    </tr>
                </tfoot>
                <tbody>
                    <?php foreach ($aseguradoras as $nombre => $cantidad) : ?>
                        <tr>
                            <td><?= $nombre ?></td>
                            <td><?= $cantidad ?></td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>