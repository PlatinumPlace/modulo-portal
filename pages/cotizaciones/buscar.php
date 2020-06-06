<?php

$api = new api;
$usuario = json_decode($_COOKIE["usuario"], true);

if ($_POST) {
    $criterio = "((Contact_Name:equals:" .  $usuario['id'] . ") and (".$_POST['parametro'].":equals:".$_POST['busqueda']."))";
    $cotizaciones = $api->searchRecordsByCriteria("Deals", $criterio);
} else {
    $criterio = "Contact_Name:equals:" . $usuario['id'];
    $cotizaciones =  $api->searchRecordsByCriteria("Deals", $criterio);
}

?>
<h2 class="text-uppercase text-center">
    Buscar cotizaciones
</h2>

<div class="card">
    <div class="card-body">
        <form class="form-inline" method="post" action="?url=cotizaciones/buscar">

            <div class="form-group mb-2">
                <select class="form-control" name="parametro" required>
                    <option value="No_Cotizaci_n" selected>No. de cotización</option>
                    <option value="RNC_Cedula">RNC/Cédula</option>
                    <option value="Nombre">Nombre</option>
                    <option value="Apellido">Apellido</option>
                    <option value="Chasis">Chasis</option>
                </select>
            </div>

            <div class="form-group mx-sm-3 mb-2">
                <input type="text" class="form-control" name="busqueda" required>
            </div>

            <button type="submit" class="btn btn-primary mb-2">Buscar</button>
            |
            <a href="?url=cotizaciones/buscar" class="btn btn-info mb-2">Limpiar</a>

        </form>
    </div>
</div>


<?php if (empty($cotizaciones)) : ?>

    <br>

    <div class="alert alert-info" role="alert">
        No se encontraron registros
    </div>

<?php endif ?>

<br>

<div class="card">
    <div class="card-body">
        <table class="table table-bordered">

            <thead>
                <tr>
                    <th>No. <br> Cotización</th>
                    <th>Nombre <br> Asegurado</th>
                    <th>Bien <br> Asegurado</th>
                    <th>Suma <br> Asegurada</th>
                    <th>Estado</th>
                    <th>Fecha <br> Cierre</th>
                    <th>Opciones</th>
                </tr>
            </thead>

            <tbody>
                <?php if (!empty($cotizaciones)) : ?>
                    <?php $lim = 0 ?>
                    <?php foreach ($cotizaciones as $cotizacion) : ?>
                        <?php if ($lim <= 10) : ?>
                            <tr>
                                <td><?= $cotizacion->getFieldValue('No_Cotizaci_n')  ?></td>
                                <td><?= $cotizacion->getFieldValue('Nombre') . " " . $cotizacion->getFieldValue('Apellido') ?></td>
                                <td><?= $cotizacion->getFieldValue('Type')  ?></td>
                                <td>RD$<?= number_format($cotizacion->getFieldValue('Valor_Asegurado'), 2) ?></td>
                                <td><?= $cotizacion->getFieldValue("Stage") ?></td>
                                <td><?= date("d/m/Y", strtotime($cotizacion->getFieldValue("Closing_Date"))) ?></td>
                                <td>
                                    <?php if ($cotizacion->getFieldValue("Stage") != "Abandonado") : ?>
                                        <a href="<?= constant("url") . strtolower($cotizacion->getFieldValue('Type')) ?>/detalles/<?= $cotizacion->getEntityId() ?>" title="Detalles">
                                            <i class="tiny material-icons">details</i>
                                        </a>
                                        <?php if ($cotizacion->getFieldValue('Email') != null) : ?>
                                            <a href="<?= constant("url") . strtolower($cotizacion->getFieldValue('Type')) ?>/emitir/<?= $cotizacion->getEntityId() ?>" title="Emitir">
                                                <i class="tiny material-icons">folder_shared</i>
                                            </a>
                                            <a href="<?= constant("url") . strtolower($cotizacion->getFieldValue('Type')) ?>/descargar/<?= $cotizacion->getEntityId() ?>" title="Descargar">
                                                <i class="tiny material-icons">file_download</i>
                                            </a>
                                        <?php endif ?>
                                    <?php endif ?>
                                </td>
                            </tr>
                        <?php endif ?>
                        <?php $lim++ ?>
                    <?php endforeach ?>
                <?php endif ?>
            </tbody>

        </table>
    </div>
</div>