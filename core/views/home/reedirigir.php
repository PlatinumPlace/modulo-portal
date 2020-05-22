<br><br><br>
<div class="d-flex align-items-center">
    <strong>Cargando...</strong>
    <div class="spinner-border ml-auto" style="width: 3rem; height: 3rem;" role="status" aria-hidden="true"></div>
</div>


<script>
    var controlador = <?= json_encode($controlador) ?>;
    var funcion = <?= json_encode($funcion) ?>;
    var datos = <?= json_encode($datos) ?>;

    var time = 4500;

    setTimeout(function() {
        window.location = "?url=" + controlador + "/" + funcion + "/" + datos;
    }, time);
</script>