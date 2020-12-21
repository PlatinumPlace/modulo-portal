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

<div class="row">
    <div class="col-sm">
        <div class="card text-white bg-primary mb-3" style="max-width: 18rem;">
            <div class="card-header">Cotizaciones al mes</div>
            <div class="card-body">
                <h5 class="card-title"><?= $cotizaciones ?></h5>
            </div>
        </div>
    </div>

    <div class="col-sm">
        <div class="card text-white bg-success mb-3" style="max-width: 18rem;">
            <div class="card-header">Emisiones al mes</div>
            <div class="card-body">
                <h5 class="card-title"><?= $emisiones ?></h5>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>