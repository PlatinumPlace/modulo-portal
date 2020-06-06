<?php

$url = rtrim($_GET['url'], "/");
$url = explode('/', $url);

$nueva_url = rtrim($url[2], "-");
$nueva_url = explode('-', $nueva_url);

?>
<br><br><br>
<div class="d-flex align-items-center">
    <strong>Cargando...</strong>
    <div class="spinner-border ml-auto" style="width: 3rem; height: 3rem;" role="status" aria-hidden="true"></div>
</div>

<script>
    var url = "<?= constant("url") ?>";
    var carpeta = "<?= $nueva_url[0] ?>";
    var pagina = "<?= $nueva_url[1] ?>";
    var id = "<?= (!empty($nueva_url[2])) ? $nueva_url[2] : ""; ?>";
    var alerta = "<?= (!empty($nueva_url[3])) ? $nueva_url[3] : ""; ?>";

    if (alerta != "") {
        var nueva_url = url + carpeta + "/" + pagina + "/" + id + "?alert=" + alerta;
    } else {
        var nueva_url = url + carpeta + "/" + pagina + "/" + id;
    }

    var time = 5500;
    setTimeout(function() {
        window.location = nueva_url;
    }, time);
</script>