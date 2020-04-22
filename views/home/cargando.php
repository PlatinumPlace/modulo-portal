<br><br><br>
<div class="d-flex align-items-center">
    <strong>Cargando...</strong>
    <div class="spinner-border ml-auto" style="width: 3rem; height: 3rem;" role="status" aria-hidden="true"></div>
</div>
<input value="<?= $id ?>" id="id" hidden>
<input value="<?= $origen ?>" id="origen" hidden>
<input value="<?= constant('url') ?>" id="url" hidden>
<script>
    var url = document.getElementById("url").value;
    var time = 3200;
    var id = document.getElementById("id").value;
    var origen = document.getElementById("origen").value;
    setTimeout(function() {
        window.location = url + origen + "/detalles/" + id;
    }, time);
</script>