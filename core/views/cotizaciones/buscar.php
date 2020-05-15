<form class="form-inline" method="POST" action="<?= constant('buscar_cotizaciones') ?>">

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

    <button type="submit" name="submit" class="btn btn-primary mb-2">Buscar</button>|
    <a href="<?= constant('buscar_cotizaciones') ?>" class="btn btn-info mb-2">Limpiar</a>

</form>

<?php if (empty($cotizaciones)) : ?>

    <div class="alert alert-info" role="alert">
        No se encontraron registros
    </div>

<?php endif ?>

<table class="table">
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
                <?php if ($lim <= 50) : ?>
                    <tr>
                        <td><?= $cotizacion->getFieldValue('No_Cotizaci_n')  ?></td>
                        <td><?= $cotizacion->getFieldValue('Nombre') . " " . $cotizacion->getFieldValue('Apellido') ?></td>
                        <td><?= $cotizacion->getFieldValue('Type')  ?></td>
                        <td>RD$<?= number_format($cotizacion->getFieldValue('Valor_Asegurado'), 2) ?></td>
                        <td><?= $cotizacion->getFieldValue("Stage") ?></td>
                        <td><?= date("d/m/Y", strtotime($cotizacion->getFieldValue("Closing_Date"))) ?></td>
                        <td>
                            <?php if ($cotizacion->getFieldValue("Stage") != "Abandonado") : ?>
                                <a href="<?= constant('detalles_cotizacion_') ?><?= strtolower($cotizacion->getFieldValue('Type')) ?>&value=<?= $cotizacion->getEntityId() ?>" title="Detalles">
                                    <i class="tiny material-icons">details</i>
                                </a>
                                <?php if ($cotizacion->getFieldValue('Nombre') != null) : ?>
                                    <a href="<?= constant('emitir_cotizacion') ?>&value=<?= $cotizacion->getEntityId() ?>" title="Emitir">
                                        <i class="tiny material-icons">folder_shared</i>
                                    </a>
                                    <a href="<?= constant('descargar_cotizacion_') ?><?= strtolower($cotizacion->getFieldValue('Type')) ?>&value=<?= $cotizacion->getEntityId() ?>" title="Descargar">
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