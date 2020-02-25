<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
  <h1 class="h2">Emitir con:</h1>
</div>
<form method="POST" enctype="multipart/form-data" action="index.php?pagina=emitir&id=<?= $trato->getEntityId() ?>">
  <div class="col-12">
    <div class="card">
      <div class="card-body">
        <div class="form-row">
          <?php if ($trato->getFieldValue('Stage') == "Cotizando") : ?>
            <div class="col-md-6">
              <div class="form-group">
                <label class="small mb-1">Aseguradoras</label>
                <select name="aseguradora" class="custom-select" required>
                  <?php foreach ($cotizaciones as $cotizacion) : ?>
                    <?php if ($cotizacion["Prima_Total"] > 0) : ?>
                      <option value="<?= $cotizacion["Aseguradora"]["id"] ?>"><?= $cotizacion["Aseguradora"]["name"] ?></option>
                    <?php else : ?>
                      <option value="" disabled selected>Aseguradora no disponible</option>
                    <?php endif ?>
                  <?php endforeach ?>
                </select>
              </div>
            </div>
          <div class="col-md-6">
            <div class="form-group">
              <label class="small mb-1">&nbsp;</label>
              <div class="custom-file">
                <input type="file" class="custom-file-input" id="cotizacion_firmada" name="cotizacion_firmada" required>
                <label class="custom-file-label" for="cotizacion_firmada">Cargar Cotización Firmada</label>
              </div>
            </div>
          </div>
          <?php endif ?>
        </div>
      </div>
    </div>
  </div>
  <div class="col-12">
    &nbsp;
  </div>
  <div class="col-12">
    <div class="card">
      <div class="card-body">
        <div class="form-row">
          <div class="col-md-6">
            <div class="form-group">
              <label class="small mb-1">&nbsp;</label>
              <div class="custom-file">
                <input type="file" class="custom-file-input" id="expedientes" name="expedientes[]" multiple>
                <label class="custom-file-label" for="expedientes">Cargar Expedientes</label>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-12">
    &nbsp;
  </div>
  <div class="mx-auto" style="width: 200px;">
    <input type="submit" class="btn btn-success btn-block" value="Emitir">
    <a href="?pagina=detalles&id=<?= $trato->getEntityId() ?>" class="btn btn-primary btn-block">Cancelar</a>
  </div>
  <div class="col-12">
    &nbsp;
  </div>
</form>
<!-- Alerta -->
<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal"><?= $mensaje ?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-footer">
        <a href="index.php?pagina=detalles&id=<?= $trato->getEntityId() ?>" class="btn btn-primary">Aceptar</a>
      </div>
    </div>
  </div>
</div>