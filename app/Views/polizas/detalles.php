<?= $this->extend('portal') ?>

<?= $this->section('content') ?>

<h1 class="mt-4">Poliza No. <?= $bien->getFieldValue('P_liza') ?></h1>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item"><a href="<?= site_url("polizas/descargar/" . $poliza->getEntityId()) ?>">Descargar</a></li>
</ol>

<div class="card mb-4">
    <div class="card-body">
        <div class="row">
            <div class="col-md-6 mb-3">
                <label><b>Vendedor</b></label>
                <br>
                <label class="label-control"><?= $poliza->getFieldValue('Contact_Name')->getLookupLabel() ?></label>
            </div>

            <div class="col-md-6 mb-3">
                <label><b>Suma Asegurada</b></label>
                <br>
                <label class="label-control">RD$ <?= number_format($bien->getFieldValue('Suma_asegurada'), 2) ?></label>
            </div>

            <div class="col-md-6 mb-3">
                <label><b>Plan</b></label>
                <br>
                <label class="label-control"><?= $bien->getFieldValue('Plan') ?></label>
            </div>

            <div class="col-md-6 mb-3">
                <label><b>Nombre del cliente</b></label>
                <br>
                <label class="label-control"><?= $bien->getFieldValue('Nombre') . ' ' . $bien->getFieldValue('Apellido') ?></label>
            </div>

            <div class="col-md-6 mb-3">
                <label><b>Aseguradora</b></label>
                <br>
                <label class="label-control"><?= $bien->getFieldValue('Aseguradora')->getLookupLabel() ?></label>
            </div>

            <div class="col-md-6 mb-3">
                <label><b>Prima</b></label>
                <br>
                <label class="label-control">RD$ <?= number_format($bien->getFieldValue('Prima'), 2) ?></label>
            </div>

            <div class="col-md-6 mb-3">
                <label><b>Vigencia desde</b></label>
                <br>
                <label class="label-control"><?= $bien->getFieldValue('Vigencia_desde') ?></label>
            </div>

            <div class="col-md-6 mb-3">
                <label><b>Vigencia hasta</b></label>
                <br>
                <label class="label-control"><?= $bien->getFieldValue('Vigencia_hasta') ?></label>
            </div>
        </div>
    </div>
</div>

<?php if ($poliza->getFieldValue('Type') == "Auto") : ?>
    <div class="card mb-4">
        <h5 class="card-header">Vehículo</h5>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label><b>Marca</b></label>
                    <br>
                    <label class="label-control"><?= $bien->getFieldValue('Marca') ?></label>
                </div>

                <div class="col-md-6 mb-3">
                    <label><b>Modelo</b></label>
                    <br>
                    <label class="label-control"><?= $bien->getFieldValue('Modelo') ?></label>
                </div>

                <div class="col-md-6 mb-3">
                    <label><b>Año</b></label>
                    <br>
                    <label class="label-control"><?= $bien->getFieldValue('A_o') ?></label>
                </div>

                <div class="col-md-6 mb-3">
                    <label><b>Tipo</b></label>
                    <br>
                    <label class="label-control"><?= $bien->getFieldValue('Tipo') ?></label>
                </div>
            </div>
        </div>
    </div>
<?php endif ?>

<?php if ($poliza->getFieldValue('Type') == "Vida") : ?>
    <div class="card mb-4">
        <div class="card-body">
            <div class="row">
                <?php if ($bien->getFieldValue('Nombre_codeudor') != null) : ?>
                    <div class="col-md-6 mb-3">
                        <label><b>Nombre del codeudor</b></label>
                        <br>
                        <label class="label-control"><?= $bien->getFieldValue('Nombre_codeudor') . ' ' . $bien->getFieldValue('Apellido_codeudor') ?></label>
                    </div>
                <?php endif ?>

                <?php if (!empty($bien->getFieldValue('Cuota'))) : ?>
                    <div class="col-md-6 mb-3">
                        <label><b>Cuota Mensual</b></label>
                        <br>
                        <label class="label-control">RD$<?= number_format($bien->getFieldValue('Cuota'), 2) ?></label>
                    </div>
                <?php endif ?>

                <div class="col-md-6 mb-3">
                    <label><b>Plazo</b></label>
                    <br>
                    <label class="label-control"><?= $bien->getFieldValue('Plazo') ?> meses</label>
                </div>
            </div>
        </div>
    </div>
<?php endif ?>


<?= $this->endSection() ?>