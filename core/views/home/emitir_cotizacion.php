<!-- Modal -->
<div class="modal fade" id="Modal" tabindex="-1" role="dialog" aria-labelledby="Modal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><?= $mensaje ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-footer">
                <a href="<?= $retVal = (!empty($resultado)) ? '?pagina=ver_cotizacion&id=' . $resultado["id"] : "?pagina=emitir_cotizacion"; ?>" class="btn btn-primary">Aceptar</a>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Emitir con:</h1>
</div>
<form class="col s12" action="?pagina=emitir_cotizacion&id=<?= $oferta_id ?>" method="post" enctype="multipart/form-data">
    <div class="form-group row">
        <div class="col-sm-6 mb-3 mb-sm-0">
            <select name="aseguradora" class="form-control">
                <?php foreach ($cotizaciones as $cotizacion) : ?>
                    <?php $planes = $cotizacion->getLineItems() ?>
                    <?php foreach ($planes as $plan) : ?>
                        <?php $plan_detalles = $this->api->getRecord("Products", $plan->getProduct()->getEntityId()) ?>
                        <option value="<?= $plan_detalles->getFieldValue('Vendor_Name')->getEntityId() ?>"><?= $plan_detalles->getFieldValue('Vendor_Name')->getLookupLabel() ?></option>
                    <?php endforeach ?>
                <?php endforeach ?>
            </select>
        </div>
        <div class="col-sm-6">
            <div class="form-control">
                <label>Cargar Cotización Firmada</label>
                <input type="file" name="cotizacion_firmada" required>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-control">
                <label>Cargar Expedientes</label>
                <input type="file" name="expedientes[]" multiple="true">
            </div>
        </div>
    </div>
    <div class="text-center">
        <button type="submit" class="btn btn-primary btn-block">Guardas cambios</button>
        <a href="?pagina=ver_cotizacion&id<?= $oferta_id ?>" class="btn btn-success btn-block">Cancelar</a>
    </div>
</form>