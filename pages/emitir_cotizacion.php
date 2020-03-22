<?php
$api = new api();
$trato = $api->getRecord("Deals", $_GET['id']);
$cotizaciones = $trato->getFieldValue('Aseguradoras_Disponibles');
if (isset($_POST['submit'])) {
  $ruta_cotizacion = "tmp";
  if (!is_dir($ruta_cotizacion)) {
    mkdir($ruta_cotizacion, 0755, true);
  }
  if (!empty($_FILES["cotizacion_firmada"]["name"])) {
    $extension = pathinfo($_FILES["cotizacion_firmada"]["name"], PATHINFO_EXTENSION);
    $permitido = array("pdf");
    if (in_array($extension, $permitido)) {
      $cambios["Aseguradora"] = $_POST["aseguradora"];
      $cambios["Stage"] = "En trámite";
      $cambios["Deal_Name"] = "Resumen";
      $resultado =  $api->updateRecord("Deals", $cambios, $_GET['id']);
      $tmp_name = $_FILES["cotizacion_firmada"]["tmp_name"];
      $name = basename($_FILES["cotizacion_firmada"]["name"]);
      move_uploaded_file($tmp_name, "$ruta_cotizacion/$name");
      $api->uploadAttachment("Deals", $_GET['id'], "$ruta_cotizacion/$name");
      unlink("$ruta_cotizacion/$name");
    } else {
      echo '<script>alert("Error al cargar documentos,formatos adminitos: PDF");</script>';
    }
  }
  if (!empty($_FILES["documentos"]['name'][0])) {
    foreach ($_FILES["documentos"]["error"] as $key => $error) {
      if ($error == UPLOAD_ERR_OK) {
        $tmp_name = $_FILES["documentos"]["tmp_name"][$key];
        $name = basename($_FILES["documentos"]["name"][$key]);
        move_uploaded_file($tmp_name, "$ruta_cotizacion/$name");
        $api->uploadAttachment("Deals", $_GET['id'], "$ruta_cotizacion/$name");
        unlink("$ruta_cotizacion/$name");
      }
    }
    $resultado['id'] = $_GET['id'];
  }
}
?>
<h1 class="mt-4"><?= $retVal = ($trato->getFieldValue('P_liza') == null) ? "Emitir" : "Completar"; ?> con</h1>
<ol class="breadcrumb mb-4">
  <li class="breadcrumb-item">Cotizaciones</li>
  <li class="breadcrumb-item">Emitir</li>
  <li class="breadcrumb-item active">Cotización No. <?= $trato->getFieldValue('No_de_cotizaci_n') ?></li>
</ol>

<?php if (!empty($_FILES["documentos"]['name'][0])) : ?>
  <div class="alert alert-primary" role="alert">
    Archivos adjuntados
  </div>
<?php endif ?>

<form enctype="multipart/form-data" method="POST" action="?page=emit&id=<?= $trato->getEntityId() ?>">

  <input value="<?= $resultado['id']  ?>" id="id" hidden>

  <div class="row">
    <div class="col-6">
      &nbsp;
    </div>
    <div class="col-6">
      <div class="row">
        <div class="col">
          <a href="?page=search" class="btn btn-secondary"><i class="fas fa-list"></i> Lista</a>
        </div>
        <div class="col">
          <a href="?page=details_auto&id=<?= $trato->getEntityId() ?>" class="btn btn-primary"><i class="fas fa-arrow-left"></i> Detalles</a>
        </div>
        <div class="col">
          <button type="submit" name="submit" class="btn btn-success">
            <i class="far fa-id-card"></i> <?= $retVal = ($trato->getFieldValue('P_liza') == null) ? "Emitir" : "Completar"; ?>
          </button>
        </div>
      </div>
    </div>
  </div>

  <hr>

  <?php if ($trato->getFieldValue('P_liza') == null) : ?>
    <div class="form-group row">
      <label class="col-sm-2 col-form-label">Aseguradoras</label>
      <div class="col-sm-4">
        <select name="aseguradora" class="form-control" required>
          <?php foreach ($cotizaciones as $cotizacion) : ?>
            <?php if ($cotizacion["Prima_Total"] > 0) : ?>
              <option value="<?= $cotizacion["Aseguradora"]["id"] ?>"><?= $cotizacion["Aseguradora"]["name"] ?></option>
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
        <input type="file" class="custom-file-input" id="customFile1" multiple name="documentos[]" <?= $retVal = ($trato->getFieldValue('P_liza') != null) ? "required" : ""; ?>>
        <label class="custom-file-label" for="customFile1">Cargar</label>
      </div>
    </div>
  </div>

</form>
<?php if (!empty($_FILES["cotizacion_firmada"]['name'])) : ?>
  <script>
    var id = document.getElementById('id').value;
    alert("Póliza emitida,descargue la cotización para obtener el carnet");
    window.location = "?page=load&id=" + id;
  </script>
<?php endif ?>