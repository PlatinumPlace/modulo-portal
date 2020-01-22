<!-- Modal Structure -->
<div id="modal1" class="modal">
    <div class="modal-content">
        <h4><?= $mensaje ?></h4>
    </div>
    <div class="modal-footer">
        <a href="?pagina=ver_cotizacion&id=<?= $oferta_id ?>" class="modal-close waves-effect waves-green btn-flat">Continuar</a>
    </div>
</div>
<div class="row">
    <div class="col s12 center">
        <h2>Emitir con:</h2>
    </div>
    <hr>
    <form class="col s12" action="?pagina=emitir_cotizacion&id=<?= $oferta_id ?>" method="post" enctype="multipart/form-data">
        <?php if (!file_exists($ruta_cotizacion)) : ?>
            <div class="col s12">
                <div class="input-field">
                    <select name="aseguradora">
                        <?php foreach ($cotizaciones as $cotizacion) : ?>
                            <?php $planes = $cotizacion->getLineItems() ?>
                            <?php foreach ($planes as $plan) : ?>
                                <?php $plan_detalles = $this->api->getRecord("Products", $plan->getProduct()->getEntityId()) ?>
                                <option value="<?= $plan_detalles->getFieldValue('Vendor_Name')->getEntityId() ?>"><?= $plan_detalles->getFieldValue('Vendor_Name')->getLookupLabel() ?></option>
                            <?php endforeach ?>
                        <?php endforeach ?>
                    </select>
                    <label>Aseguradora</label>
                </div>
            </div>
            <div class="col s12">
                <div class="file-field input-field">
                    <div class="btn">
                        <span>Cotización Firmada</span>
                        <input type="file" name="cotizacion_firmada" required>
                    </div>
                    <div class="file-path-wrapper">
                        <input class="file-path validate" type="text">
                    </div>
                </div>
            </div>
        <?php endif ?>
        <div class="col s12">
            <div class="file-field input-field">
                <div class="btn">
                    <span>Cargar Expedientes</span>
                    <input type="file" name="expedientes[]" multiple="true">
                </div>
                <div class="file-path-wrapper">
                    <input class="file-path validate" type="text">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col s6 center">
                <a class="btn waves-effect waves-light blue" href="?pagina=ver_cotizacion&id=<?= $oferta_id ?>">
                    <i class="material-icons left">arrow_back</i>
                    Cancelar
                </a>
            </div>
            <div class="col s6 center">
                <button class="btn waves-effect waves-light green" type="submit" name="submit">
                    <i class="material-icons left">send</i>
                    Aceptar
                </button>
            </div>
        </div>
    </form>
</div>