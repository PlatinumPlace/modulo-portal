<?php
$tratos = new tratos();
$trato = $tratos->detalles($_GET['id']);
$cotizaciones = $trato->getFieldValue('Aseguradoras_Disponibles');
if ($_POST or $_FILES) {
  $resultado = $tratos->emitir($_GET['id']);
}
?>
<h1 class="mt-4">Emitir con</h1>
<ol class="breadcrumb mb-4">
  <li class="breadcrumb-item">Cotizaciones</li>
  <li class="breadcrumb-item">Emitir</li>
  <li class="breadcrumb-item active">Cotización No. <?= $trato->getFieldValue('No_de_cotizaci_n') ?></li>
</ol>

<form enctype="multipart/form-data" method="POST" action="index.php?page=emit&id=<?= $trato->getEntityId() ?>">

  <input hidden value="<?= $resultado["id"] ?>" id="id">

  <?php if ($trato->getFieldValue('Stage') == "Cotizando") : ?>
    <div class="form-group row">
      <label class="col-sm-2 col-form-label">Aseguradoras</label>
      <div class="col-sm-4">
        <select name="aseguradora" class="form-control" required>
          <?php foreach ($cotizaciones as $cotizacion) : ?>
            <?php if ($cotizacion["Prima_Total"] > 0) : ?>
              <option value="<?= $cotizacion["Aseguradora"]["id"] ?>"><?= $cotizacion["Aseguradora"]["name"] ?></option>
            <?php else : ?>
              <option value="" disabled selected>Aseguradora no disponible</option>
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
        <input type="file" class="custom-file-input" id="customFile1" multiple name="documentos[]">
        <label class="custom-file-label" for="customFile1">Cargar</label>
      </div>
    </div>
  </div>

  <div class="form-group row">
    <div class="col-sm-10">
    <a href="index.php?page=details&id=<?= $trato->getEntityId() ?>" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Cancelar</a>
      <button type="submit" class="btn btn-primary">Emitir</button>
    </div>
  </div>
</form>

<?php if ($_POST) : ?>
  <script>
    var id = document.getElementById("id").value;
    if (id > 0) {
      var mensaje = alert("Póliza emitida,descargue la cotización para obtener el carnet");
      window.location = "index.php?page=details&id=" + id;
    } else {
      alert(id);
    }
  </script>;
<?php endif ?>