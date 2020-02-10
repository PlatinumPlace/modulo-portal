<h1 class="mt-4">Emitir con:</h1>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item active">Dashboard</li>
    <li class="breadcrumb-item active">Cotizaciones</li>
    <li class="breadcrumb-item active">No. <?= $trato->getFieldValue('No_de_cotizaci_n') ?></li>
</ol>
<div class="row justify-content-center">
  <div class="col-lg-10">
    <div class="card shadow-lg border-0 rounded-lg mt-5">
      <div class="card-body">
        <form method="POST" action="?pagina=emitir&id=<?= $trato->getEntityId() ?>">
          <?php if ($trato->getFieldValue('Aseguradora') == null) : ?>
            <div class="form-row">
              <div class="col-md-6">
                <div class="form-group">
                  <label class="small mb-1">Nombre del Cliente</label>
                  <select name="aseguradora" class="form-control">
                    <?php $planes = $cotizacion->getLineItems() ?>
                    <?php foreach ($planes as $plan) : ?>
                      <?php $aseguradora = $this->planes->detalles_aseguradora($plan->getProduct()->getEntityId()) ?>
                      <option value="<?= $aseguradora['id'] ?>"><?= $aseguradora['nombre'] ?></option>
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
          <?php endif ?>
          <div class="form-row">
            <div class="col-md-6">
              <div class="form-group">
                <label class="small mb-1">Cargar Expedientes</label>
                <input type="file" name="expedientes[]" class="form-control" multiple>
              </div>
            </div>
          </div>
          <div class="form-group mt-4 mb-0">
            <button type="submit" class="btn btn-success btn-block">Emitir</button>
            <a href="?pagina=detalles&id=<?= $trato->getEntityId() ?>" class="btn btn-primary btn-block">Cancelar</a>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
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
        <a href="?pagina=detalles&id=<?= $resultado['id'] ?>" class="btn btn-primary">Aceptar</a>
      </div>
    </div>
  </div>
</div>