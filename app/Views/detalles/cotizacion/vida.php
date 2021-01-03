<?= $this->extend('portal') ?>

<?= $this->section('content') ?>

<h1 class="mt-4">Cotización No. <?= $cotizacion->getFieldValue('Quote_Number') ?></h1>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item"><a href="<?= site_url("descargar/cotizacion/" . $cotizacion->getEntityId()) ?>">Descargar</a></li>
    <li class="breadcrumb-item"><a href="<?= site_url("documentos/index/" . $cotizacion->getEntityId()) ?>">Documentos</a></li>
    <li class="breadcrumb-item"><a href="<?= site_url("emitir/vida/index/" . $cotizacion->getEntityId()) ?>">Emitir</a></li>
</ol>

<div class="card mb-4">
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
        </div>
    </div>
</div>

<div class="card mb-4">
    <h5 class="card-header">Vida/desempleo</h5>
    <div class="card-body">
        <div class="row">
            <?php if (!empty($cotizacion->getFieldValue('Cuota'))) : ?>
                <div class="col-md-6 mb-3">
                    <label><b>Cuota Mensual</b></label>
                    <br>
                    <label class="label-control">RD$<?= number_format($cotizacion->getFieldValue('Cuota'), 2) ?></label>
                </div>
            <?php endif ?>

            <div class="col-md-6 mb-3">
                <label><b>Plazo</b></label>
                <br>
                <label class="label-control"><?= $cotizacion->getFieldValue('Plazo') ?> meses</label>
            </div>
        </div>
    </div>
</div>

<div class="card mb-4">
    <h5 class="card-header">Deudor</h5>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6 mb-3">
                <label><b>Nombre</b></label>
                <br>
                <label class="label-control"><?= $cotizacion->getFieldValue('Nombre') . " " . $cotizacion->getFieldValue('Apellido') ?></label>
            </div>

            <div class="col-md-6 mb-3">
                <label><b>Teléfono</b></label>
                <br>
                <label class="label-control"><?= $cotizacion->getFieldValue('Tel_Celular') ?></label>
            </div>

            <div class="col-md-6 mb-3">
                <label><b>Correo</b></label>
                <br>
                <label class="label-control"><?= $cotizacion->getFieldValue('Correo_electr_nico') ?></label>
            </div>

            <div class="col-md-6 mb-3">
                <label><b>Dirección</b></label>
                <br>
                <label class="label-control"><?= $cotizacion->getFieldValue('Direcci_n') ?></label>
            </div>

            <div class="col-md-6 mb-3">
                <label><b>Edad</b></label>
                <br>
                <label class="label-control"><?= $cotizacion->getFieldValue('Edad_deudor') ?></label>
            </div>
        </div>
    </div>
</div>

<?php if ($cotizacion->getFieldValue('Edad_codeudor') != null) : ?>
    <div class="card mb-4">
        <h5 class="card-header">Codeudor</h5>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label><b>Nombre</b></label>
                    <br>
                    <label class="label-control"><?= $cotizacion->getFieldValue('Nombre_codeudor') . " " . $cotizacion->getFieldValue('Apellido_codeudor') ?></label>
                </div>

                <div class="col-md-6 mb-3">
                    <label><b>Teléfono</b></label>
                    <br>
                    <label class="label-control"><?= $cotizacion->getFieldValue('Tel_Celular_codeudor') ?></label>
                </div>

                <div class="col-md-6 mb-3">
                    <label><b>Correo</b></label>
                    <br>
                    <label class="label-control"><?= $cotizacion->getFieldValue('Correo_electr_nico_codeudor') ?></label>
                </div>

                <div class="col-md-6 mb-3">
                    <label><b>Dirección</b></label>
                    <br>
                    <label class="label-control"><?= $cotizacion->getFieldValue('Direcci_n_codeudor') ?></label>
                </div>

                <div class="col-md-6 mb-3">
                    <label><b>Edad</b></label>
                    <br>
                    <label class="label-control"><?= $cotizacion->getFieldValue('Edad_codeudor') ?></label>
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