<?= $this->extend('portal') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Panel de control</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <a href="<?= site_url("home/index") ?>" class="btn btn-sm btn-outline-secondary">Tarjetas</a>
            <a href="<?= site_url("home/tabla") ?>" class="btn btn-sm btn-outline-secondary">Tabla</a>
        </div>
    </div>
</div>

<div class="alert alert-success" role="alert">
    <h4 class="alert-heading">¡Bienvenido al Insurance Tech de Grupo Nobe!</h4>
    <p>Desde su panel de control podrás ver la infomación necesaria para manejar sus pólizas y cotizaciones.</p>
</div>

<br>

<h4>Pólizas emitidas este mes</h4>
<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Aseguradora</th>
                <th>Cantidad</th>
            </tr>
        </thead>

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

<?= $this->endSection() ?>