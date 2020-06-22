<h2 class="mt-4 text-uppercase">
    seguro vehículo de motor
    plan <?= $resumen->getFieldValue('Plan') ?>
</h2>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item"><a href="<?= constant("url") ?>cotizaciones/buscar">Cotizaciones</a></li>
    <li class="breadcrumb-item active">No. <?= $resumen->getFieldValue('No_Cotizaci_n') ?></li>
    <li class="breadcrumb-item"><a href="<?= constant("url") ?>auto/detalles/<?= $resumen_id ?>">Detalles</a></li>
    <?php if ($resumen->getFieldValue('Email') == null) : ?>
        <li class="breadcrumb-item"><a href="<?= constant("url") ?>auto/completar/<?= $resumen_id ?>">Completar</a></li>
    <?php else : ?>
        <li class="breadcrumb-item"><a href="<?= constant("url") ?>auto/emitir/<?= $resumen_id ?>">Emitir</a></li>
        <li class="breadcrumb-item"><a href="<?= constant("url") ?>auto/descargar/<?= $resumen_id ?>">Descargar</a></li>
    <?php endif ?>
</ol>