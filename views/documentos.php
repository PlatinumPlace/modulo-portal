<?php
$trato = $api->getRecord("Deals", $cotizacion->getFieldValue('Deal_Name')->getEntityId());
$ajuntos = $api->getAttachments("Contratos", $trato->getFieldValue('Contrato')->getEntityId());
if (isset($url[2])) {
    $ruta_descarga = $api->downloadAttachment("Contratos", $trato->getFieldValue('Contrato')->getEntityId(), $url[2]);
    $fileName = basename($ruta_descarga);
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="' . $fileName . '"');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: ');
    header('Content-Length: ' . filesize($ruta_descarga));
    readfile($ruta_descarga);
    unlink($ruta_descarga);
    exit();
}
require_once 'views/layout/header.php';
?>
<h2 class="mt-4 text-uppercase text-center">
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
                                <tr>
                                    <td><?= $ajunto->getFileName() ?></td>
                                    <td><a href="<?= constant("url") . "documentos/$id/" . $ajunto->getId() ?>">Descargar</a></td>
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>

                <br>
                <a href="<?= constant("url") ?>detalles/<?= $id ?>" class="btn btn-info">Ir a Detalles</a>
            </div>
        </div>

    </div>
</div>

<?php require_once 'views/layout/footer.php'; ?>