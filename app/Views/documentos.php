<?= $this->extend('portal') ?>

<?= $this->section('content') ?>

<h1 class="mt-4">Cotización No. <?= $cotizacion->getFieldValue('Quote_Number') ?></h1>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item"><a href="<?= site_url("detalles/cotizacion/" . $cotizacion->getEntityId()) ?>">Regresar</a></li>
</ol>

<div class="card mb-4">
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
                                        <a href="<?= site_url("cotizaciones/documentos/descargar/" . json_encode([$detalles->getProduct()->getEntityId(), $adjunto->getId()])) ?>">Descargar</a>
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