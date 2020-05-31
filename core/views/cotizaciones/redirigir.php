<br><br><br>
<div class="d-flex align-items-center">
    <strong>Cargando...</strong>
    <div class="spinner-border ml-auto" style="width: 3rem; height: 3rem;" role="status" aria-hidden="true"></div>
</div>


<script>
    var url = "<?= constant("url") ?>";
    var controlador = "<?= $controlador ?>";
    var funcion = "<?= $funcion ?>";
    var id = "<?= $id ?>";
    var alerta = "<?= $alerta ?>";

    if (alerta != "") {
        var nueva_url = url + controlador + "/" + funcion + "/" + id + "?alert=" + alerta;
    } else {
        var nueva_url = url + controlador + "/" + funcion + "/" + id;
    }

    var time = 5000;
    setTimeout(function() {
        window.location = nueva_url;
    }, time);
</script>