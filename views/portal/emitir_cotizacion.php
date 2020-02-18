<h1 class="mt-4">Emitir con:</h1>
<ol class="breadcrumb mb-4">
  <li class="breadcrumb-item active">Dashboard</li>
  <li class="breadcrumb-item active">Cotizaciones</li>
  <li class="breadcrumb-item active">No. <?= $trato->getFieldValue('No_de_cotizaci_n') ?></li>
</ol>
<form method="POST" action="index.php?pagina=emitir&id=<?= $trato->getEntityId() ?>">
  <?php if ($trato->getFieldValue('Aseguradora') == null) : ?>
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <div class="form-row">
            <div class="col-md-6">
              <div class="form-group">
                <label class="small mb-1">Aseguradoras</label>
                <select name="aseguradora" class="form-control" required>
                  <?php $planes = $cotizacion->getLineItems() ?>
                  <?php foreach ($planes as $plan) : ?>
                    <?php if ($plan->getListPrice() > 0) : ?>
                      <?php $aseguradora = $this->planes->detalles_aseguradora($plan->getProduct()->getEntityId()) ?>
                      <option value="<?= $aseguradora['id'] ?>"><?= $aseguradora['nombre'] ?></option>
                    <?php else : ?>
                      <option value="" disabled selected>Aseguradora no disponible</option>
                    <?php endif ?>
                  <?php endforeach ?>
                </select>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label class="small mb-1">Cargar Cotización Firmada</label>
                <input type="file" name="cotizacion_firmada" class="form-control" required>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  <?php endif ?>
  <div class="col-12">
    &nbsp;
  </div>
  <div class="col-12">
    <div class="card">
      <div class="card-body">
        <div class="form-row">
          <div class="col-md-6">
            <div class="form-group">
              <label class="small mb-1">Cargar Expedientes</label>
              <input type="file" name="expedientes[]" class="form-control" multiple>
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
    <button type="submit" class="btn btn-success btn-block">Emitir</button>
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