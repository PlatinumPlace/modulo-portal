<?= $this->extend('portal') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Cotización No. <?= $cotizacion->getFieldValue('Quote_Number') ?></h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <a href="<?= site_url("cotizaciones/detalles/" . $cotizacion->getEntityId()) ?>" class="btn btn-sm btn-outline-secondary">Volver</a>
        </div>
    </div>
</div>

<div class="card mb-4">
    <h5 class="card-header">Documentos por aseguradora</h5>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Aseguradora</th>
                        <th>Documentos</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($cotizacion->getLineItems() as $detalles) : ?>
                        <?php $plan = $api->getRecord("Products", $detalles->getProduct()->getEntityId()) ?>
                        <tr>
                            <td><?= $plan->getFieldValue('Vendor_Name')->getLookupLabel() ?></td>
                            <?php foreach ($api->getAttachments("Products", $detalles->getProduct()->getEntityId(), 1, 200) as $adjunto) : ?>
                                <?php if (
                                    ($cotizacion->getFieldValue('Plan') == 'Vida' and $adjunto->getFileName() == 'vida.pdf')
                                    or
                                    ($cotizacion->getFieldValue('Plan') == 'Vida/desempleo' and
                                        $adjunto->getFileName() == 'desempleo.pdf')
                                    or
                                    ($cotizacion->getFieldValue('Tipo') == 'Auto')
                                ) : ?>
                                    <td>
                                        <a href="<?= site_url("cotizaciones/adjuntos/" . json_encode([$detalles->getProduct()->getEntityId(), $adjunto->getId()])) ?>">Descargar</a>
                                    </td>
                                <?php endif ?>
                            <?php endforeach ?>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>