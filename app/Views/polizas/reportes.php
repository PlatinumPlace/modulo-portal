<?= $this->extend('portal') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Reporteria</h1>
</div>


<form enctype="multipart/form-data" action="<?= site_url("polizas/reporte") ?>" method="post">
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
                        <option value="desempleo">Vida/Desempleo</option>
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