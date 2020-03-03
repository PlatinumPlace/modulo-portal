<?php
$tratos = new tratos();
$trato = $tratos->detalles($_GET['id']);
$cotizaciones = $trato->getFieldValue('Aseguradoras_Disponibles');
if ($_POST or $_FILES) {
    $resultado = $tratos->emitir($_GET['id']);
}
?>
<div class="section no-pad-bot" id="index-banner">
  <h2 class="header center blue-text">Emitir con</h2>
</div>

<div class="row">
  <form class="col s12" enctype="multipart/form-data" method="POST" action="index.php?page=emit&id=<?= $trato->getEntityId() ?>">
  
  <input hidden value="<?= $resultado["id"] ?>" id="id">

  <?php if ($trato->getFieldValue('Stage') == "Cotizando") : ?>
      <div class="row">
        <div class="input-field col s6">
          <select name="aseguradora" required>
            <?php foreach ($cotizaciones as $cotizacion) : ?>
              <?php if ($cotizacion["Prima_Total"] > 0) : ?>
                <option value="<?= $cotizacion["Aseguradora"]["id"] ?>"><?= $cotizacion["Aseguradora"]["name"] ?></option>
              <?php else : ?>
                <option value="" disabled selected>Aseguradora no disponible</option>
              <?php endif ?>
            <?php endforeach ?>
          </select>
          <label>Aseguradoras</label>
        </div>
        <div class="file-field input-field col s6">
          <div class="btn">
            <span>Cargar Cotización Firmada</span>
            <input type="file" name="cotizacion_firmada" required>
          </div>
          <div class="file-path-wrapper">
            <input class="file-path validate" type="text">
          </div>
        </div>
      </div>
    <?php endif ?>
    <div class="row">
      <div class="file-field input-field">
        <div class="btn">
          <span>Cargar Expedientes</span>
          <input type="file" multiple name="documentos[]">
        </div>
        <div class="file-path-wrapper">
          <input class="file-path validate" type="text">
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col s6">
        <a href="index.php?page=details&id=<?= $trato->getEntityId() ?>" class="green waves-effect waves-light btn"><i class="material-icons left">arrow_back</i>Cancelar</a>
        <button class="btn waves-effect waves-light" type="submit" name="action">Emitir
          <i class="material-icons right">send</i>
        </button>
      </div>
    </div>
  </form>
</div>

<?php if ($_POST) : ?>
    <script>
        var id = document.getElementById("id").value;
        if (id > 0) {
            var mensaje = alert("Póliza emitida,descargue la cotización para obtener el carnet");
            window.location = "index.php?page=details&id=" + id;
        }else{
            alert(id);
        }
    </script>;
<?php endif ?>