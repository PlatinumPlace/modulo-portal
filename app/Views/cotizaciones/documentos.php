<?= $this->extend('portal') ?>

<?= $this->section('content') ?>

<h1 class="mt-4">Cotización No. <?= $cotizacion->getFieldValue('Quote_Number') ?></h1>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item"><a href="<?= site_url("cotizaciones/detalles/" . $cotizacion->getEntityId()) ?>">Regresar</a></li>
</ol>

<div class="card mb-4">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Aseguradora</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($cotizacion->getLineItems() as $detalles) : ?>
                        <?php $plan = $api->getRecord("Products", $detalles->getProduct()->getEntityId()) ?>
                        <tr>
                            <td><?= $plan->getFieldValue('Vendor_Name')->getLookupLabel() ?></td>
                            <?php foreach ($api->getAttachments("Products", $detalles->getProduct()->getEntityId(), 1, 200) as $adjunto) : ?>
                                <td>
                                    <form action="<?= site_url("cotizaciones/documentos/" . $cotizacion->getEntityId()) ?>" method="post">
                                        <?= csrf_field() ?>

                                        <label><b><?= strtoupper($adjunto->getFileName()) ?></b></label> <br>

                                        <input value="<?= $detalles->getProduct()->getEntityId() ?>" name="plan" hidden />
                                        <input value="<?= $adjunto->getId() ?>" name="documento" hidden />

                                        <button type="submit" class="btn btn-link">Descargar</button>
                                    </form>
                                </td>
                            <?php endforeach ?>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>