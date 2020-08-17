<?php
$alerta = (isset($url[2]) and!is_numeric($url[1])) ? $url[2] : null;
$num_pagina = (isset($url[2]) and is_numeric($url[1])) ? $url[2] : 1;
$documentos_aduntos = $api->getAttachments("Deals", $cotizacion->getFieldValue("Deal_Name")->getEntityId(), $num_pagina, 5);
if ($_FILES) {
    $ruta_archivo = "public/path";
    if (!is_dir($ruta_archivo)) {
        mkdir($ruta_archivo, 0755, true);
    }

    foreach ($_FILES["documentos"]["error"] as $key => $error) {
        if ($error == UPLOAD_ERR_OK) {
            $tmp_name = $_FILES["documentos"]["tmp_name"][$key];
            $name = basename($_FILES["documentos"]["name"][$key]);
            move_uploaded_file($tmp_name, "$ruta_archivo/$name");
            $api->uploadAttachment("Deals", $cotizacion->getFieldValue("Deal_Name")->getEntityId(), "$ruta_archivo/$name");
            unlink("$ruta_archivo/$name");
        }
    }

    header("Location:" . constant('url') . "adjuntar/$id/Documentos Adjuntados");
    exit();
}
require_once 'views/layout/header.php';
?>
<h2 class="mt-4 text-uppercase">
    adjuntar documentos
</h2>

<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item"><a href="<?= constant("url") ?>">Panel de control</a></li>
    <li class="breadcrumb-item"><a href="<?= constant("url") ?>buscar">Cotizaciones</a></li>
    <li class="breadcrumb-item"><a href="<?= constant("url") ?>detalles/<?= $id ?>">No. <?= $cotizacion->getFieldValue('Quote_Number') ?></a></li>
</ol>

<div class="row justify-content-center">
    <div class="col-lg-10">

        <?php if (isset($alerta)) : ?>
            <div class="alert alert-primary" role="alert">
                <?= $alerta ?>
            </div>
        <?php endif ?>

        <div class="card mb-4">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-borderless">
                        <tbody>
                            <?php foreach ($documentos_aduntos as $documento) : ?>
                                <tr>
                                    <td><?= $documento->getFileName() ?></td>
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                    <br>
                    <nav aria-label="Page navigation example">
                        <ul class="pagination justify-content-end">
                            <li class="page-item">
                                <a class="page-link" href="<?= constant("url") ?>adjuntar/<?= $id ?>/<?= $num_pagina - 1 ?>">Anterior</a>
                            </li>
                            <li class="page-item">
                                <a class="page-link" href="<?= constant("url") ?>adjuntar/<?= $id ?>/<?= $num_pagina + 1 ?>">Siguente</a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-body">
                <form enctype="multipart/form-data" method="POST" action="<?= constant("url") ?>adjuntar/<?= $id ?>">

                    <div class="form-group row">
                        <label for="modelo" class="col-sm-3 col-form-label font-weight-bold">
                            Documentos <br> <small>(Manten presionado Ctrl para seleccionar varios archivos)</small>
                        </label>
                        <div class="col-sm-9">
                            <input type="file" class="form-control-file" multiple name="documentos[]" required>
                        </div>
                    </div>

                    <br>
                    <button type="submit" class="btn btn-primary">Adjuntar</button>
                    |
                    <a href="<?= constant("url") ?>detalles/<?= $id ?>" class="btn btn-info">Cancelar</a>

                </form>
            </div>
        </div>
    </div>
</div>

<?php require_once 'views/layout/footer.php'; ?>