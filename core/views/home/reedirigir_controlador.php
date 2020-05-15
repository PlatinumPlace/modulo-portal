<br><br><br>
<div class="d-flex align-items-center">
    <strong>Cargando...</strong>
    <div class="spinner-border ml-auto" style="width: 3rem; height: 3rem;" role="status" aria-hidden="true"></div>
</div>
<input value="<?= $controlador ?>" id="controlador" hidden>
<input value="<?= $funcion ?>" id="funcion" hidden>
<input value="<?= $id ?>" id="id" hidden>
<script>
    var time = 4500;
    var controlador = document.getElementById("controlador").value;
    var funcion = document.getElementById("funcion").value;
    var id = document.getElementById("id").value;
    setTimeout(function() {
       window.location = "?controller=" + controlador + "&function=" + funcion + "&value=" + id;
    }, time);
</script>