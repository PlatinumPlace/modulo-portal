<br><br><br><br><br><br><br>
<div class="d-flex align-items-center">
    <strong>Cargando...</strong>
    <div class="spinner-border ml-auto" style="width: 3rem; height: 3rem;" role="status" aria-hidden="true"></div>
</div>
<input value="<?= $this->id ?>" id="id" hidden>
<?php
echo '
    <script>
        var time = 1500;
        var id = document.getElementById("id").value;
        setTimeout(function() {
            window.location = "'.constant('url').'cotizacion/detalles/" + id;
        }, time);
    </script>
';
?>