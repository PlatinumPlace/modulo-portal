<form class="row" enctype="multipart/form-data" method="POST" action="<?= constant('url') ?>auto/emitir/<?= $oferta->getEntityId() ?>">
    <div class="col-12">
        <?php if (isset($_POST['submit'])) : ?>
            <div class="alert alert-primary" role="alert">
                <?= $alerta ?>
            </div>
        <?php endif ?>
        <div class="card">
            <div class="card-body">
                <?php if ($oferta->getFieldValue('Cliente') == null) : ?>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Aseguradora</label>
                        <div class="col-sm-4">
                            <select name="aseguradora" class="form-control" required>
                                <?php foreach ($cotizaciones as $cotizacion) : ?>
                                    <?php if ($cotizacion->getFieldValue('Grand_Total') > 0) : ?>
                                        <?php $contrato = $this->getRecord("Contratos", $cotizacion->getFieldValue('Contrato')->getEntityId()) ?>
                                        <option value="<?= $contrato->getFieldValue('Aseguradora')->getEntityId() ?>"><?= $contrato->getFieldValue('Aseguradora')->getLookupLabel() ?></option>
                                    <?php endif ?>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <label class="col-sm-2 col-form-label">Cotización Firmada</label>
                        <div class="col-sm-4">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="customFile" name="cotizacion_firmada" required>
                                <label class="custom-file-label" for="customFile">Cargar</label>
                            </div>
                        </div>
                    </div>
                <?php else : ?>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Expedientes</label>
                        <div class="col-sm-4">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="customFile1" multiple name="documentos[]" required>
                                <label class="custom-file-label" for="customFile1">Cargar</label>
                            </div>
                        </div>
                    </div>
                <?php endif ?>
            </div>
        </div>
    </div>
    <div class="col-12">
        &nbsp;
    </div>
    <div class="col-8">
        &nbsp;
    </div>
    <div class="col-4">
        <a href="<?= constant('url') ?>auto/detalles/<?= $oferta->getEntityId() ?>" class="btn btn-primary">Detalles</a>
        |
        <button type="submit" name="submit" class="btn btn-success">
            <?= ($oferta->getFieldValue('Cliente') == null) ? "Emitir" : "Completar"; ?>
        </button>
    </div>
</form>