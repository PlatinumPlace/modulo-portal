<div class="section no-pad-bot" id="index-banner">
  <div class="container">
    <br><br>
    <h1 class="header center orange-text">Dashboard</h1>
    <div class="row center">
      <h5 class="header col s12 light">A modern responsive front-end framework based on Material Design</h5>
    </div>
    <div class="row center">
      <a href="http://materializecss.com/getting-started.html" id="download-button" class="btn-large waves-effect waves-light orange">Get Started</a>
    </div>
    <br><br>

  </div>
</div>



<div class="container">
  <div class="section">

    <!--   Icon Section   -->
    <div class="row">
      <div class="col s12 m4">
        <div class="icon-block">
          <h2 class="center light-blue-text"><i class="material-icons">flash_on</i></h2>
          <h5 class="center">Speeds up development</h5>

          <p class="light">We did most of the heavy lifting for you to provide a default stylings that incorporate our custom components. Additionally, we refined animations and transitions to provide a smoother experience for developers.</p>
        </div>
      </div>

      <div class="col s12 m4">
        <div class="icon-block">
          <h2 class="center light-blue-text"><i class="material-icons">group</i></h2>
          <h5 class="center">User Experience Focused</h5>

          <p class="light">By utilizing elements and principles of Material Design, we were able to create a framework that incorporates components and animations that provide more feedback to users. Additionally, a single underlying responsive system across all platforms allow for a more unified user experience.</p>
        </div>
      </div>

      <div class="col s12 m4">
        <div class="icon-block">
          <h2 class="center light-blue-text"><i class="material-icons">settings</i></h2>
          <h5 class="center">Easy to work with</h5>

          <p class="light">We have provided detailed documentation as well as specific code examples to help new users get started. We are also always open to feedback and can answer any questions a user may have about Materialize.</p>
        </div>
      </div>
    </div>

  </div>
  <br><br>
</div>

































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