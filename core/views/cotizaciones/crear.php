<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2 text-uppercase">crear cotización</h1>
</div>

<div class="row">

    <?php if (isset($contrato["auto"])) : ?>
        <div class="card col-3">
            <img src="<?= constant("url") ?>public/icons/auto.png" class="card-img-top">

            <a class="small text-white  stretched-link" href="<?= constant("url") ?>auto/crear"></a>

            <div class="card-body">
                <h5 class="card-title text-center">AUTO</h5>
            </div>
        </div>

        <div class="col-1">&nbsp;</div>
    <?php endif ?>

    <?php if (isset($contrato["vida"])) : ?>
        <div class="card col-3">
            <img src="<?= constant("url") ?>public/icons/vida.png" class="card-img-top">

            <a class="small text-white  stretched-link" href="<?= constant("url") ?>vida/crear"></a>

            <div class="card-body">
                <h5 class="card-title text-center">VIDA/DESEMPLEO</h5>
            </div>
        </div>

        <div class="col-1">&nbsp;</div>
    <?php endif ?>

    <?php if (isset($contrato["incendio"])) : ?>
        <div class="card col-3">
            <img src="<?= constant("url") ?>public/icons/incendio.png" class="card-img-top"> 

            <a class="small text-white  stretched-link" href="<?= constant("url") ?>incendio/crear"></a>

            <div class="card-body">
                <h5 class="card-title text-center">INCENDIO</h5>
            </div>
        </div>
    <?php endif ?>

</div>