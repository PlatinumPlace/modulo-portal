<form class="form-inline" method="POST" action="<?= constant('url') ?>home/buscar">
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
    <a href="<?= constant('url') ?>home/buscar" class="btn btn-info mb-2">Limpiar</a>
</form>
<?php if (!empty($alerta)) : ?>
    <div class="alert alert-info" role="alert">
        <?= $alerta ?>
    </div>
<?php endif ?>
<table class="table">
    <thead>
        <tr>
            <th>Cotización No.</th>
            <th>RNC/Cédula</th>
            <th>Nombre del Asegurado</th>
            <th>Bien Asegurado</th>
            <th>Suma Asegurada</th>
            <th>Estado</th>
            <th>Fecha de cierre</th>
            <th>Opciones</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($resultado)) : ?>
            <?php $lim = 0 ?>
            <?php foreach ($resultado as $trato) : ?>
                <?php if ($lim <= 50) : ?>
                    <tr>
                        <td><?= $trato->getFieldValue('No_Cotizaci_n')  ?></td>
                        <td><?= $trato->getFieldValue('RNC_Cedula') ?></td>
                        <td><?= $trato->getFieldValue('Nombre') . " " . $trato->getFieldValue('Apellido') ?></td>
                        <td><?= $trato->getFieldValue('Type')  ?></td>
                        <td>RD$<?= number_format($trato->getFieldValue('Valor_Asegurado'), 2) ?></td>
                        <td><?= $trato->getFieldValue("Stage") ?></td>
                        <td><?= date("d/m/Y", strtotime($trato->getFieldValue("Closing_Date"))) ?></td>
                        <td>
                            <a href="<?= constant('url') . $trato->getFieldValue('Type') ?>/detalles/<?= $trato->getEntityId() ?>" title="Detalles">
                                <ion-icon name="information-outline" size="small"></ion-icon>
                            </a>
                            <?php if ($trato->getFieldValue('Nombre') != null) : ?>
                                <a href="<?= constant('url') . $trato->getFieldValue('Type') ?>/emitir/<?= $trato->getEntityId() ?>" title="Emitir">
                                    <ion-icon name="person-sharp" size="small"></ion-icon>
                                </a>
                                <a href="<?= constant('url') . $trato->getFieldValue('Type') ?>/descargar/<?= $trato->getEntityId() ?>" title="Descargar">
                                    <ion-icon name="download-sharp" size="small"></ion-icon>
                                </a>
                            <?php endif ?>
                        </td>
                    </tr>
                <?php endif ?>
                <?php $lim++ ?>
            <?php endforeach ?>
        <?php endif ?>
    </tbody>
</table>