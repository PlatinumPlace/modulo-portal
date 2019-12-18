<?php if (isset($_GET) && $_GET['estado'] == "exitoso") : ?>
    <div class="alert alert-success" role="alert">
        <h4 class="alert-heading">Accion realizacda exitosamente</h4>
        <hr>
        <a role="button" class="btn btn-outline-primary" href="index.php?controller=HomeController&action=cotizacion_detalles&id=<?=$_GET['id']?>">Ver cotizacion</a>
    </div>
<?php elseif (isset($_GET) && $_GET['estado'] == "error") : ?>
    <div class="alert alert-danger" role="alert">
        <h4 class="alert-heading">Ha ocurrido un error</h4>
        <hr>
        <a role="button" class="btn btn-outline-primary" href="index.php">Regresar a inicio</a>
    </div>
<?php endif ?>