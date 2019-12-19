<?php if (isset($_GET) && $_GET['estado'] == "exitoso") : ?>
    <?php if ($_GET['origen'] == "emitir_cotizacion") : ?>
        <div class="alert alert-success" role="alert">
            <h4 class="alert-heading">Poliza emitida</h4>
            <hr>
            <a href="index.php" class="btn btn-outline-success" role="button">Ir a inicio</a>
            |
            <a href="index.php?controller=HomeController&action=detalles_poliza_tramite&id=<?= $_GET['id'] ?>" class="btn btn-outline-primary" role="button">Ver poliza en trámite</a>
            |
            <a href="lib/print/Póliza_trámite.php?id=<?= $_GET['id'] ?>" target="blank" class="btn btn-outline-secondary" role="button">Imprimir poliza en trámite</a>
        </div>
    <?php endif ?>
    <?php if ($_GET['origen'] == "crear_cotizacion_vehiculo") : ?>
        <div class="alert alert-success" role="alert">
            <h4 class="alert-heading">Accion realizacda exitosamente</h4>
            <hr>
            <a role="button" class="btn btn-outline-primary" href="index.php?controller=HomeController&action=cotizacion_detalles_vehiculo&id=<?= $_GET['id'] ?>">Ver cotizacion</a>
        </div>
    <?php endif ?>
<?php elseif (isset($_GET) && $_GET['estado'] == "error") : ?>
    <div class="alert alert-danger" role="alert">
        <h4 class="alert-heading">Ha ocurrido un error</h4>
        <hr>
        <a role="button" class="btn btn-outline-primary" href="index.php">Regresar a inicio</a>
    </div>
<?php endif ?>