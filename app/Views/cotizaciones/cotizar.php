<?= $this->extend('portal') ?>

<?= $this->section('content') ?>

<h1 class="mt-4">Cotizar</h1>
<hr>

<div class="row justify-content-center">
    <div class="col-sm-3">
        <div class="card mb-3 text-center">
            <img src="<?= base_url("img/auto.png") ?>" class="card-img-top">
            <a class="small text-white stretched-link" href="<?= site_url("cotizaciones/auto") ?>"></a>
            <div class="card-body">
                <h5 class="card-title">AUTO</h5>
            </div>
        </div>
    </div>

    <div class="col-sm-3">
        <div class="card mb-3 text-center">
            <img src="<?= base_url("img/vida.png") ?>" class="card-img-top">
            <a class="small text-white stretched-link" href="<?= site_url("cotizaciones/vida") ?>"></a>
            <div class="card-body">
                <h5 class="card-title">VIDA/DESEMPLEO</h5>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>