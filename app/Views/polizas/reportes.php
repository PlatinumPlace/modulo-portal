<?= $this->extend('portal') ?>

<?= $this->section('content') ?>

<h1 class="mt-4">Reportes</h1>
<hr>

<?php if (session()->has('alerta')) : ?>
    <div class="alert alert-danger" role="alert"> <?= session('alerta') ?> </div>
<?php endif ?>

<form enctype="multipart/form-data" action="<?= site_url("polizas/reportes") ?>" method="post">
    <?= csrf_field() ?>

    <div class="card mb-4">
        <div class="card-body">
            <div class="form-row">
                <div class="col-md-6 mb-3">
                    <label><b>Desde</b></label>
                    <input type="date" class="form-control" name="desde" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label><b>Hasta</b></label>
                    <input type="date" class="form-control" name="hasta" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label><b>Plan</b></label>
                    <select name="plan" class="form-control">
                        <option value="Auto" selected>Auto</option>
                        <option value="Vida">Vida</option>
                    </select>
                </div>

                <div class="col-md-6 mb-3">
                    <label><b>Aseguradora</b></label>
                    <select name="aseguradoraid" class="form-control">
                        <option value="" selected>Todas</option>
                        <?php foreach ($planes as $plan) : ?>
                            <option value="<?= $plan->getFieldValue('Vendor_Name')->getEntityId() ?>">
                                <?= $plan->getFieldValue('Vendor_Name')->getLookupLabel() ?>
                            </option>
                        <?php endforeach ?>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <button type="submit" class="btn btn-success" value="csv">Exportar a excel</button>
</form>

<?= $this->endSection() ?>