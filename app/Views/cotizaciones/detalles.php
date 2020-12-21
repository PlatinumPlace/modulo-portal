<?= $this->extend('portal') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Cotización No. <?= $cotizacion->getFieldValue('Quote_Number') ?></h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <a href="<?= site_url("cotizaciones/descargar/" . $cotizacion->getEntityId()) ?>" class="btn btn-sm btn-outline-secondary">Descargar</a>
            <a href="<?= site_url("cotizaciones/documentos/" . $cotizacion->getEntityId()) ?>" class="btn btn-sm btn-outline-secondary">Descargar documentos</a>
            <a href="<?= site_url("cotizaciones/emitir/" . $cotizacion->getEntityId()) ?>" class="btn btn-sm btn-outline-secondary">Emitir</a>
        </div>
    </div>
</div>

<div class="card mb-4">
    <h5 class="card-header">Detalles</h5>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6 mb-3">
                <label><b>Vendedor</b></label>
                <br>
                <label class="label-control"><?= $cotizacion->getFieldValue('Contact_Name')->getLookupLabel() ?></label>
            </div>

            <div class="col-md-6 mb-3">
                <label><b>Suma Asegurada</b></label>
                <br>
                <label class="label-control">RD$ <?= number_format($cotizacion->getFieldValue('Suma_asegurada'), 2) ?></label>
            </div>

            <div class="col-md-6 mb-3">
                <label><b>Plan</b></label>
                <br>
                <label class="label-control"><?= $cotizacion->getFieldValue('Plan') ?></label>
            </div>

            <div class="col-md-6 mb-3">
                <label><b>Nombre del cliente</b></label>
                <br>
                <label class="label-control"><?= $cotizacion->getFieldValue('Nombre') . ' ' . $cotizacion->getFieldValue('Apellido') ?></label>
            </div>

            <?php if (!empty($cotizacion->getFieldValue('Edad_codeudor'))) : ?>
                <div class="col-md-6 mb-3">
                    <label><b>Edad del codeudor</b></label>
                    <br>
                    <label class="label-control"><?= $cotizacion->getFieldValue('Edad_codeudor') ?> años</label>
                </div>
            <?php endif ?>

            <?php if (!empty($cotizacion->getFieldValue('Cuota'))) : ?>
                <div class="col-md-6 mb-3">
                    <label><b>Cuota Mensual</b></label>
                    <br>
                    <label class="label-control">RD$<?= number_format($cotizacion->getFieldValue('Cuota'), 2) ?></label>
                </div>
            <?php endif ?>
        </div>
    </div>
</div>

<?php if ($cotizacion->getFieldValue('Tipo') == 'Auto') : ?>
    <div class="card mb-4">
        <h5 class="card-header">Vehículo</h5>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label><b>Marca</b></label>
                    <br>
                    <label class="label-control"><?= $cotizacion->getFieldValue('Marca')->getLookupLabel() ?></label>
                </div>

                <div class="col-md-6 mb-3">
                    <label><b>Modelo</b></label>
                    <br>
                    <label class="label-control"><?= $cotizacion->getFieldValue('Modelo')->getLookupLabel() ?></label>
                </div>

                <div class="col-md-6 mb-3">
                    <label><b>Año</b></label>
                    <br>
                    <label class="label-control"><?= $cotizacion->getFieldValue('A_o') ?></label>
                </div>

                <div class="col-md-6 mb-3">
                    <label><b>Tipo</b></label>
                    <br>
                    <label class="label-control"><?= $cotizacion->getFieldValue('Tipo_veh_culo') ?></label>
                </div>
            </div>
        </div>
    </div>
<?php endif ?>

<div class="card mb-4">
    <h5 class="card-header">Aseguradoras disponibles</h5>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Motivo</th>
                        <th>Prima Neta</th>
                        <th>ISC</th>
                        <th>Prima Total</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($cotizacion->getLineItems() as $detalles) : ?>
                        <?php $plan = $api->getRecord("Products", $detalles->getProduct()->getEntityId()) ?>
                        <tr>
                            <td><?= $plan->getFieldValue('Vendor_Name')->getLookupLabel() ?></td>
                            <td><?= $detalles->getDescription() ?></td>
                            <td>RD$<?= number_format($detalles->getListPrice(), 2) ?></td>
                            <td>RD$<?= number_format($detalles->getTaxAmount(), 2) ?></td>
                            <td>RD$<?= number_format($detalles->getNetTotal(), 2) ?></td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>