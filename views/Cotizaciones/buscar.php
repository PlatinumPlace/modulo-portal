<form class="form-inline" method="POST" action="<?= constant('url') ?>cotizaciones/buscar">
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
    <a href="<?= constant('url') ?>cotizaciones/buscar" class="btn btn-info mb-2">Limpiar</a>
</form>
<?php if (!empty($alerta)) : ?>
    <div class="alert alert-info" role="alert">
        <?= $alerta ?>
    </div>
<?php endif ?>
<table class="table">
    <thead>
        <tr>
            <th>Cotización <br> No.</th>
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
            <?php foreach ($cotizaciones as $resumen) : ?>
                <?php if ($lim <= 50) : ?>
                    <?php if (
                        empty($filtro)
                        or
                        $resumen->getFieldValue("Stage") == $filtro
                        and
                        date("Y-m", strtotime($resumen->getFieldValue("Fecha_de_emisi_n"))) == date('Y-m')
                    ) : ?>
                        <tr>
                            <td><?= $resumen->getFieldValue('No_Cotizaci_n')  ?></td>
                            <td><?= $resumen->getFieldValue('Nombre') . " " . $resumen->getFieldValue('Apellido') ?></td>
                            <td><?= $resumen->getFieldValue('Type')  ?></td>
                            <td>RD$<?= number_format($resumen->getFieldValue('Valor_Asegurado'), 2) ?></td>
                            <td><?= $resumen->getFieldValue("Stage") ?></td>
                            <td><?= date("d/m/Y", strtotime($resumen->getFieldValue("Closing_Date"))) ?></td>
                            <td>
                                <a href="<?= constant('url') ?>cotizaciones/detalles_<?= strtolower($resumen->getFieldValue('Type')) ?>/<?= $resumen->getEntityId() ?>" title="Detalles">
                                    <i class="tiny material-icons">details</i>
                                </a>
                                <?php if ($resumen->getFieldValue('Nombre') != null) : ?>
                                    <a href="<?= constant('url') ?>cotizaciones/emitir/<?= $resumen->getEntityId() ?>" title="Emitir">
                                        <i class="tiny material-icons">folder_shared</i>
                                    </a>
                                    <a href="<?= constant('url') ?>cotizaciones/descargar_<?= strtolower($resumen->getFieldValue('Type')) ?>/<?= $resumen->getEntityId() ?>" title="Descargar">
                                        <i class="tiny material-icons">file_download</i>
                                    </a>
                                <?php endif ?>
                            </td>
                        </tr>
                    <?php endif ?>
                <?php endif ?>
                <?php $lim++ ?>
            <?php endforeach ?>
        <?php endif ?>
    </tbody>
</table>