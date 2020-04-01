<h1 class="mt-4"><?= $retVal = ($this->trato->getFieldValue('P_liza') == null) ? "Emitir" : "Completar"; ?> con</h1>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item">Cotizaciones</li>
    <li class="breadcrumb-item">Emitir</li>
    <li class="breadcrumb-item active">Cotización No. <?= $this->trato->getFieldValue('No_de_cotizaci_n') ?></li>
</ol>
<?php if (!empty($_FILES["documentos"]['name'][0])) : ?>
    <div class="alert alert-primary" role="alert">
        Archivos adjuntados
    </div>
<?php endif ?>
<form enctype="multipart/form-data" method="POST" action="<?= constant('url') ?>cotizacion/emitir/<?= $this->trato->getEntityId() ?>">
    <div class="row">
        <div class="col-6">
            &nbsp;
        </div>
        <div class="col-6">
            <a href="<?= constant('url') ?>cotizacion/detalles/<?= $this->trato->getEntityId() ?>" class="btn btn-primary">Detalles</a>|
            <button type="submit" name="submit" class="btn btn-success">
                <?= $retVal = ($this->trato->getFieldValue('P_liza') == null) ? "Emitir" : "Completar"; ?>
            </button>
        </div>
    </div>
    <hr>
    <?php if ($this->trato->getFieldValue('P_liza') == null) : ?>
        <div class="form-group row">
            <label class="col-sm-2 col-form-label">Aseguradoras</label>
            <div class="col-sm-4">
                <select name="aseguradora" class="form-control" required>
                    <?php foreach ($this->cotizaciones as $cotizacion) : ?>
                        <?php if ($cotizacion["Prima_Total"] > 0) : ?>
                            <?php $contrato = $this->api->getRecord("Contratos", $cotizacion["Contrato"]["id"]) ?>
                            <option value="<?= $contrato->getFieldValue('Aseguradora')->getEntityId() ?>"><?= $contrato->getFieldValue('Aseguradora')->getLookupLabel() ?></option>
                        <?php endif ?>
                    <?php endforeach ?>
                </select>
            </div>
            <label class="col-sm-2 col-form-label">Cargar Cotización Firmada</label>
            <div class="col-sm-4">
                <div class="custom-file">
                    <input type="file" class="custom-file-input" id="customFile" name="cotizacion_firmada" required>
                    <label class="custom-file-label" for="customFile">Cargar</label>
                </div>
            </div>
        </div>
    <?php endif ?>
    <div class="form-group row">
        <label class="col-sm-2 col-form-label">Cargar Expedientes</label>
        <div class="col-sm-4">
            <div class="custom-file">
                <input type="file" class="custom-file-input" id="customFile1" multiple name="documentos[]" <?= $retVal = ($this->trato->getFieldValue('P_liza') != null) ? "required" : ""; ?>>
                <label class="custom-file-label" for="customFile1">Cargar</label>
            </div>
        </div>
    </div>
</form>