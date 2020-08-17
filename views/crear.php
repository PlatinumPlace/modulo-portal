<?php
$cotizaciones = new cotizaciones();
$tipo = (isset($url[1])) ? $url[1] : null;
$result = $cotizaciones->dispobible_crear();
require_once 'views/layout/header.php';
?>
<h1 class="mt-4 text-uppercase text-center">crear cotización</h1>

<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item"><a href="<?= constant("url") ?>">Panel de Control</a></li>
    <li class="breadcrumb-item active"><a href="<?= constant("url") ?>crear">Crear</a></li>
</ol>

<div class="row">

    <?php if (isset($result["auto"])) : ?>
        <div class="card col-3">
            <img src="<?= constant("url") ?>public/icons/auto.png" class="card-img-top"> <a class="small text-white  stretched-link" href="<?= constant("url") ?>crear/auto"></a>
            <div class="card-body">
                <h5 class="card-title text-center">AUTO</h5>
            </div>
        </div>

        <div class="col-1">
            &nbsp;
        </div>
    <?php endif ?>

    <?php if (isset($result["vida"])) : ?>
        <div class="card col-3">
            <img src="<?= constant("url") ?>public/icons/vida.png" class="card-img-top"> <a class="small text-white  stretched-link" href="<?= constant("url") ?>crear/vida"></a>
            <div class="card-body">
                <h5 class="card-title text-center">VIDA/DESEMPLEO</h5>
            </div>
        </div>

        <div class="col-1">
            &nbsp;
        </div>
    <?php endif ?>

    <?php if (isset($result["incendio"])) : ?>
        <div class="card col-3">
            <img src="<?= constant("url") ?>public/icons/incendio.png" class="card-img-top"> <a class="small text-white  stretched-link" href="<?= constant("url") ?>crear/incendio"></a>
            <div class="card-body">
                <h5 class="card-title text-center">INCENDIO</h5>
            </div>
        </div>
    <?php endif ?>

</div>

<?php require_once 'views/layout/footer.php'; ?>