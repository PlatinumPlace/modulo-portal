<?= $this->extend('portal') ?>

<?= $this->section('content') ?>

<h1 class="mt-4">Cotizaciones</h1>
<hr>

<div class="card mb-4">
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
                        <tr>
                            <td><?= $cotizacion->getFieldValue('Quote_Number') ?></td>
                            <td><?= $cotizacion->getFieldValue('Plan') ?></td>
                            <td><?= $cotizacion->getFieldValue('Contact_Name')->getLookupLabel() ?></td>
                            <td><?= date('d/m/Y', strtotime($cotizacion->getCreatedTime())) ?></td>
                            <td>
                                <a href="<?= site_url("detalles/cotizacion/" . $cotizacion->getEntityId()) ?>" title="Detalles">
                                    <i class="fas fa-info"></i>
                                </a>
                                |
                                <a href="<?= site_url("emitir/" . strtolower($cotizacion->getFieldValue('Tipo')) . "/index/" . $cotizacion->getEntityId()) ?>" title="Emitir">
                                    <i class="fas fa-user"></i>
                                </a>
                                |
                                <a href="<?= site_url("descargar/cotizacion/" . $cotizacion->getEntityId()) ?>" title="Descargar">
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