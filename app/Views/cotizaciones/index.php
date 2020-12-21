<?= $this->extend('portal') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Cotizaciones</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <a href="<?= site_url("cotizaciones/cotizar/auto") ?>" class="btn btn-sm btn-outline-secondary">Cotizar auto</a>
            <a href="<?= site_url("cotizaciones/cotizar/vida") ?>" class="btn btn-sm btn-outline-secondary">Cotizar vida</a>
        </div>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header">Buscar Cotización</h6>
    <div class="card-body">
        <form action="<?= site_url("cotizaciones/buscar") ?>" method="post">
            <?= csrf_field() ?>

            <div class="mb-3 col-6">
                <label class="form-label">Número de Cotización</label>
                <input type="text" class="form-control" name="busqueda">
            </div>

            <button type="submit" class="btn btn-success">Buscar</button>
            |
            <a href="<?= site_url("cotizaciones") ?>" class="btn btn-info">Limpiar</a>
        </form>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header">
        <i class="fas fa-table mr-1"></i>
        Lista de cotizaciones (Max: 15)
    </h6>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No. Cotización</th>
                        <th>Plan</th>
                        <th>Vendedor</th>
                        <th>Fecha</th>
                        <th>Opcion</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($cotizaciones as $cotizacion) : ?>
                        <?php if (empty($cotizacion->getFieldValue('Deal_Name'))) : ?>
                            <tr>
                                <td><?= $cotizacion->getFieldValue('Quote_Number') ?></td>
                                <td><?= $cotizacion->getFieldValue('Plan') ?></td>
                                <td><?= $cotizacion->getFieldValue('Contact_Name')->getLookupLabel() ?></td>
                                <td><?= date('d/m/Y', strtotime($cotizacion->getCreatedTime())) ?></td>
                                <td>
                                    <a href="<?= site_url("cotizaciones/detalles/" . $cotizacion->getEntityId()) ?>" title="Detalles">
                                        <span data-feather="info"></span>
                                    </a>
                                    |
                                    <a href="<?= site_url("cotizaciones/emitir/" . $cotizacion->getEntityId()) ?>" title="Emitir">
                                        <span data-feather="clipboard"></span>
                                    </a>
                                    |
                                    <a href="<?= site_url("cotizaciones/descargar/" . $cotizacion->getEntityId()) ?>" title="Descargar">
                                        <span data-feather="download"></span>
                                    </a>
                                </td>
                            </tr>
                        <?php endif ?>
                    <?php endforeach ?>
                </tbody>
            </table>

            <br>

            <nav>
                <ul class="pagination justify-content-end">
                    <li class="page-item">
                        <a class="page-link" href="<?= site_url("cotizaciones/index/" . ($pag - 1)) ?>">Anterior</a>
                    </li>

                    <li class="page-item">
                        <a class="page-link" href="<?= site_url("cotizaciones/index/" . ($pag + 1)) ?>">Siguiente</a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</div>

<?= $this->endSection() ?>