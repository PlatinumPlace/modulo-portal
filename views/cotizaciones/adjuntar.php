<h2 class="mt-4 text-uppercase">
    adjuntar documentos a cotización
</h2>

<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item"><a href="<?= constant("url") ?>">Panel de control</a></li>
    <li class="breadcrumb-item"><a href="<?= constant("url") ?>tratos/buscar">Tratos</a></li>
    <li class="breadcrumb-item"><a href="<?= constant("url") . $url[0] ?>/adjuntar/<?= $id ?>">No. <?= $cotizacion->getFieldValue('Quote_Number') ?></a></li>
</ol>

<div class="row justify-content-center">
    <div class="col-lg-10">

        <div class="card mb-4">
            <div class="card-body">
                <form enctype="multipart/form-data" method="POST" action="<?= constant("url") . $url[0] ?>/adjuntar/<?= $id ?>">

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
                    <a href="<?= constant("url") . $url[0] ?>/detalles/<?= $id ?>" class="btn btn-info">Cancelar</a>

                </form>
            </div>
        </div>

    </div>
</div>