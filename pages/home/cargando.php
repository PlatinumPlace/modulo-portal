<?php

$url = explode("-", $datos);
$carpeta = $url[0];
$pagina = $url[1];
$id = $url[2];

?>
<br><br><br>
<div class="d-flex align-items-center">
    <strong>Cargando...</strong>
    <div class="spinner-border ml-auto" style="width: 3rem; height: 3rem;" role="status" aria-hidden="true"></div>
</div>
<input value="<?= constant('url') ?>" id="url" hidden>
<input value="<?= $carpeta ?>" id="carpeta" hidden>
<input value="<?= $pagina ?>" id="pagina" hidden>
<input value="<?= $id ?>" id="id" hidden>
<script>
    var time = 4000;
    var url = document.getElementById("url").value;
    var controlador = document.getElementById("carpeta").value;
    var funcion = document.getElementById("pagina").value;
    var id = document.getElementById("id").value;
    setTimeout(function() {
       window.location = url + controlador + "/" + funcion + "/" + id;
    }, time);
</script>