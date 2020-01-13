<div class='container'>

    <h4>Completa el formulario</h4>

    <hr>

    <form action="?page=complete&id=<?= $oferta_id ?>" method="post" enctype="multipart/form-data">
        <div class='row'>
            <div class="input-field col s12">
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
            <div class="file-field input-field col s12">
                <div class="btn">
                    <span>Firma</span>
                    <input type="file" name="firma">
                </div>
                <div class="file-path-wrapper">
                    <input class="file-path validate" type="text">
                </div>
            </div>
            <div class="input-field col s12">
                <a href="file\contratos\vehiculo.pdf" download="" class="red waves-effect waves-light btn"><i class="material-icons right">cloud_download</i>Descargar contratos para vehiculo</a>
            </div>
            <div class="input-field col s12">
                <a href="?page=details&id=<?= $oferta_id ?>" class="blue waves-effect waves-light btn"><i class="material-icons right">arrow_back</i>Cancelar</a>
                <button class="btn waves-effect waves-light" type="submit" name="action">Finalizar
                    <i class="material-icons right">send</i>
                </button>
            </div>
        </div>
    </form>
</div>