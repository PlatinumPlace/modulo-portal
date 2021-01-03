<?= $this->extend('portal') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Cotizar</h1>
</div>

<div class="row justify-content-center">
    <div class="col-sm-3">
        <div class="card mb-3 text-center">
            <img src="<?= base_url("img/auto.png") ?>" class="card-img-top">
            <a class="small text-white stretched-link" href="<?= site_url("cotizar/auto") ?>"></a>
            <div class="card-body">
                <h5 class="card-title">AUTO</h5>
            </div>
        </div>
    </div>

    <div class="col-sm-3">
        <div class="card mb-3 text-center">
            <img src="<?= base_url("img/vida.png") ?>" class="card-img-top">
            <a class="small text-white stretched-link" href="<?= site_url("cotizar/vida") ?>"></a>
            <div class="card-body">
                <h5 class="card-title">VIDA/DESEMPLEO</h5>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>