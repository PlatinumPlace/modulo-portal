<form enctype="multipart/form-data" method="POST" action="<?= constant('url') ?>cotizaciones/emitir/<?= $resumen->getEntityId() ?>">

    <?php if (isset($_POST['submit'])) : ?>
        <div class="alert alert-primary" role="alert">
            <?= $alerta ?>
        </div>
    <?php endif ?>

    <div class="card">
        <div class="card-body">
            <?php if (!isset($_POST['submit']) and !in_array($resumen->getFieldValue("Stage"), $emitida)) : ?>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Aseguradora</label>
                    <div class="col-sm-6">
                        <select name="aseguradora" class="form-control" required>
                            <?php foreach ($cotizaciones as $cotizacion) : ?>
                                <?php $contrato = $this->cotizacion->detalles_contrato($cotizacion->getFieldValue('Contrato')->getEntityId()) ?>
                                <option value="<?= $contrato->getFieldValue('Aseguradora')->getEntityId() ?>"><?= $contrato->getFieldValue('Aseguradora')->getLookupLabel() ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="cotizacion" class="col-sm-3 col-form-label">Cotización Firmada</label>
                    <div class="col-sm-6">
                        <input type="file" class="form-control-file" id="cotizacion" name="cotizacion_firmada" required>
                    </div>
                </div>
            <?php else : ?>
                <div class="form-group row">
                    <label for="expedientes" class="col-sm-2 col-form-label">Expedientes</label>
                    <div class="col-sm-6">
                        <input type="file" class="form-control-file" id="expedientes" multiple name="documentos[]" required>
                    </div>
                </div>
            <?php endif ?>
        </div>
    </div>

    <br>

    <div class="row">

        <div class="col-md-8">
            &nbsp;
        </div>

        <div class="col-md-4">
            <div class="card">
                <h5 class="card-header">Opciones</h5>
                <div class="card-body">
                    <a href="<?= constant('url') ?>cotizaciones/detalles_<?= $resumen->getFieldValue("Type") ?>/<?= $resumen->getEntityId() ?>" class="btn btn-primary">Detalles</a>
                    |
                    <button type="submit" name="submit" class="btn btn-success">
                        <?= (in_array($resumen->getFieldValue("Stage"), $emitida)) ? "Emitir" : "Completar"; ?>
                    </button> </div>
            </div>
        </div>

    </div>
</form>