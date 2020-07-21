<h2 class="mt-4 text-uppercase text-center">
    seguro vehículo de motor plan <?= $cotizacion->getFieldValue('Plan') ?>
</h2>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item"><a href="<?= constant("url") ?>">Panel de control</a></li>
    <li class="breadcrumb-item"><a href="<?= constant("url") ?>cotizaciones/buscar">Cotizaciones</a></li>
    <li class="breadcrumb-item"><a href="<?= constant("url") ?>auto/detalles/<?= $id ?>">No. <?= $cotizacion->getFieldValue('Quote_Number') ?></a></li>
</ol>
<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="card mb-4">
            <div class="card-body">
                <form enctype="multipart/form-data" method="POST" action="<?= constant("url") ?>auto/adjuntar/<?= $id ?>">
                    <div class="form-row">
                        <div class="col-md-6">
                            <label class="font-weight-bold">
                                Documentos <br> <small>(Manten presionado Ctrl para seleccionar varios archivos)</small>
                            </label>
                            <input type="file" class="form-control-file" multiple name="documentos[]" required>
                        </div>
                    </div>

                    <br>

                    <div class="form-row">
                        <div class="col-md-6">
                            <div class="form-groups">
                                <button type="submit" class="btn btn-success">Adjuntar</button>
                                |
                                <a href="<?= constant("url") ?>auto/detalles/<?= $id ?>" class="btn btn-info">Cancelar</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>