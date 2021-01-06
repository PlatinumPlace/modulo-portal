<?= $this->extend('portal') ?>

<?= $this->section('content') ?>

<h1 class="mt-4">Pólizas</h1>
<hr>

<div class="card mb-4">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Chasis o RNC/Cédula</th>
                        <th>Aseguradora</th>
                        <th>Inicio</th>
                        <th>Fin</th>
                        <th>Vendedor</th>
                        <th>Opcion</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($polizas as $poliza) : ?>
                        <tr>
                            <td><?= $poliza->getFieldValue('Bien')->getLookupLabel() ?></td>
                            <td><?= $poliza->getFieldValue('Aseguradora')->getLookupLabel() ?></td>
                            <td><?= date('d/m/Y', strtotime($poliza->getCreatedTime())) ?></td>
                            <td><?= date('d/m/Y', strtotime($poliza->getFieldValue('Closing_Date'))) ?></td>
                            <td><?= $poliza->getFieldValue('Contact_Name')->getLookupLabel() ?></td>
                            <td>
                                <a href="<?= site_url("polizas/detalles/" . $poliza->getEntityId()) ?>" title="Detalles">
                                    <i class="fas fa-info"></i>
                                </a>
                                |
                                <a href="<?= site_url("polizas/descargar/" . $poliza->getEntityId()) ?>" title="Descargar">
                                    <i class="fas fa-download"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>