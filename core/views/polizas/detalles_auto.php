<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2 text-uppercase"><?= $detalles->getFieldValue('Deal_Name') ?></h1>

    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group mr-2">
            <a href="<?= constant("url") ?>polizas/adjuntar?id=<?= $_GET["id"] ?>" class="btn btn-sm btn-outline-secondary">Adjuntar</a>

            <a href="<?= constant("url") ?>polizas/descargar?id=<?= $_GET["id"] ?>" class="btn btn-sm btn-outline-secondary">Descargar</a>
        </div>
    </div>

</div>