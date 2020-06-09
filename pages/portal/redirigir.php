<?php

$portal = new portal;
$url = $portal->obtener_url();

?>
<br><br><br>
<div class="d-flex align-items-center">
    <strong>Cargando...</strong>
    <div class="spinner-border ml-auto" style="width: 3rem; height: 3rem;" role="status" aria-hidden="true"></div>
</div>

<script>
    var url = "<?= constant("url") ?>";
    var data = <?= $url[0] ?>;
    var nueva_url = "";

    for (var i = 0; i < data.length; i++) {
        nueva_url += data[i] + "/";
    }

    var time = 5500;
    setTimeout(function() {
        window.location = url + nueva_url;
    }, time);
</script>