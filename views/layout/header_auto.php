<h2 class="mt-4 text-uppercase">
    seguro vehículo de motor
    plan <?= $resumen->getFieldValue('Plan') ?>
</h2>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item"><a href="<?= constant("url") ?>">Panel de control</a></li>
    <li class="breadcrumb-item"><a href="<?= constant("url") ?>cotizaciones/buscar">Cotizaciones</a></li>
    <li class="breadcrumb-item"><a href="<?= constant("url") ?>auto/detalles/<?= $resumen_id ?>">Detalles</a></li>
</ol>

<div class="card mb-4">
    <div class="card-body">
        <?php if ($resumen->getFieldValue('Nombre') == null) : ?>
            <a href="<?= constant("url") ?>auto/completar/<?= $resumen_id ?>" class="btn btn-secondary">Completar</a>
        <?php else : ?>
            <?php if (in_array($resumen->getFieldValue("Stage"), array("Emitido", "En trámite"))) : ?>
                <a href="<?= constant("url") ?>auto/documentos/<?= $resumen_id ?>" class="btn btn-info">Subir Documentos</a>
            <?php else : ?>
                <a href="<?= constant("url") ?>auto/emitir/<?= $resumen_id ?>" class="btn btn-success">Emitir</a>
            <?php endif ?>
            <a href="<?= constant("url") ?>auto/descargar/<?= $resumen_id ?>" class="btn btn-primary">Descargar</a>
        <?php endif ?>
    </div>
</div>