<?= $this->extend('portal') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Póliza</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <a href="<?= site_url("polizas/reportes") ?>" class="btn btn-sm btn-outline-secondary">Crear reporte</a>
        </div>
    </div>
</div>

<div class="card mb-4">
    <h6 class="card-header">
        <i class="fas fa-table mr-1"></i>
        Lista de Pólizas (Max: 15)
    </h6>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Chasis o RNC/Cédula</th>
                        <th>Vendedor</th>
                        <th>Fecha</th>
                        <th>Opcion</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($polizas as $poliza) : ?>
                        <tr>
                                <td><?= $poliza->getFieldValue('Bien')->getLookupLabel() ?></td>
                                <td><?= $poliza->getFieldValue('Contact_Name')->getLookupLabel() ?></td>
                                <td><?= date('d/m/Y', strtotime($poliza->getCreatedTime())) ?></td>
                                <td>
                                    <a href="<?= site_url("polizas/detalles/" . $poliza->getEntityId()) ?>" title="Detalles">
                                        <span data-feather="info"></span>
                                    </a>
                                    |
                                    <a href="<?= site_url("polizas/descargar/" . $poliza->getEntityId()) ?>" title="Descargar">
                                        <span data-feather="download"></span>
                                    </a>
                                </td>
                            </tr>
                    <?php endforeach ?>
                </tbody>
            </table>

            <br>

            <nav>
                <ul class="pagination justify-content-end">
                    <li class="page-item">
                        <a class="page-link" href="<?= site_url("polizas/index/" . ($pag - 1)) ?>">Anterior</a>
                    </li>

                    <li class="page-item">
                        <a class="page-link" href="<?= site_url("polizas/index/" . ($pag + 1)) ?>">Siguiente</a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</div>

<?= $this->endSection() ?>