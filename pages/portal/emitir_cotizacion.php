<div class="section no-pad-bot" id="index-banner">
  <div class="container">
    <h1 class="header center orange-text">Emitir con:</h1>
  </div>
</div>

<div class="container">
  <div class="section">

    <div class="row">
      <form class="col s12" action="?pagina=emitir&id=<?= $resultado['trato']->getEntityId() ?>" method="post" enctype="multipart/form-data">
        <div class="row">
          <div class="input-field col s12">
            <select name="aseguradora">
              <?php $planes = $resultado['cotizacion']->getLineItems() ?>
              <?php foreach ($planes as $plan) : ?>
                <?php $aseguradora = $this->cotizaciones->aseguradora($plan->getProduct()->getEntityId()) ?>
                <option value="<?= $aseguradora['id'] ?>"><?= $aseguradora['nombre'] ?></option>
              <?php endforeach ?>
            </select>
            <label>Selecciona unau aseguradora</label>
          </div>
        </div>
        <div class="row">
          <div class="file-field input-field">
            <div class="btn">
              <span>Cargar Cotización Firmada</span>
              <input type="file" name="cotizacion_firmada" required>
            </div>
            <div class="file-path-wrapper">
              <input class="file-path validate" type="text">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="file-field input-field">
            <div class="btn">
              <span>Cargar Expedientes</span>
              <input type="file" name="expedientes[]" multiple>
            </div>
            <div class="file-path-wrapper">
              <input class="file-path validate" type="text">
            </div>
          </div>
        </div>
        <div class="col s12 center">
          <a href="?pagina=detalles&id=<?= $resultado['trato']->getEntityId() ?>" class="btn modal-trigger waves-effect waves-light green">Cancelar
            <i class="material-icons right">arrow_back</i>
          </a>
          <button class="btn waves-effect waves-light" type="submit" name="action">Guardar Cambios
            <i class="material-icons right">send</i>
          </button>
        </div>
      </form>
    </div>

  </div>
  <br><br>
</div>
<!-- Modal Structure -->
<div id="modal" class="modal">
  <div class="modal-content">
    <h4><?= $mensaje ?></h4>
  </div>
  <div class="modal-footer">
    <a href="?pagina=detalles&id=<?= $resultado['trato']->getEntityId() ?>" class="modal-close waves-effect waves-green btn-flat">Aceptar</a>
  </div>
</div>