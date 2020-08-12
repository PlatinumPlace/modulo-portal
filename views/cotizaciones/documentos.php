<h2 class="mt-4 text-uppercase">
    documentos
</h2>

<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item"><a href="<?= constant("url") ?>">Panel de control</a></li>
    <li class="breadcrumb-item"><a href="<?= constant("url") ?>cotizaciones/buscar">Cotizaciones</a></li>
    <li class="breadcrumb-item"><a href="<?= constant("url") ?>cotizaciones/detalles/<?= $id ?>">No. <?= $cotizacion->getFieldValue('Quote_Number') ?></a></li>
</ol>

<div class="row justify-content-center">
    <div class="col-lg-10">

        <div class="card mb-4">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-borderless">
                        <tbody>
                            <?php foreach ($ajuntos as $ajunto) : ?>
                                <?php $ruta_descarga = $api->downloadAttachment("Contratos", $trato->getFieldValue('Contrato')->getEntityId(), $ajunto->getId()) ?>
                                <tr>
                                    <td><?= $ajunto->getFileName() ?></td>
                                    <td><a href="<?= constant("url") . $ruta_descarga ?>" download>Descargar</a></td>
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>

                <br>
                <a href="<?= constant("url") ?>cotizaciones/detalles/<?= $id ?>" class="btn btn-info">Ir a Detalles</a>
            </div>
        </div>

    </div>
</div>