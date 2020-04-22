<form class="form-inline" method="POST" action="<?= constant('url') ?>home/buscar">
    <div class="form-group mb-2">
        <select class="form-control" name="parametro" required>
            <option value="numero" selected>No. de cotización</option>
            <option value="id">RNC/Cédula</option>
            <option value="nombre">Nombre</option>
            <option value="apellido">Apellido</option>
            <option value="chasis">Chasis</option>
        </select>
    </div>
    <div class="form-group mx-sm-3 mb-2">
        <input type="text" class="form-control" name="busqueda" required>
    </div>
    <button type="submit" name="submit" class="btn btn-primary mb-2">Buscar</button>|
    <a href="<?= constant('url') ?>home/buscar" class="btn btn-info mb-2">Limpiar</a>
</form>
<?php if (empty($resultado)) : ?>
    <div class="alert alert-info" role="alert">
        No se encontraron registros
    </div>
<?php endif ?>
<table class="table">
    <thead>
        <tr>
            <th>Cotización No.</th>
            <th>RNC/Cédula</th>
            <th>Póliza</th>
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
                        <td>
                            <?php
                            if ($trato->getFieldValue('RNC_Cedula') == null) {
                                echo "N/A";
                            } else {
                                echo $trato->getFieldValue('RNC_Cedula');
                            }
                            ?>
                        </td>
                        <td>
                            <?php
                            if ($trato->getFieldValue('P_liza') == null) {
                                echo "N/A";
                            } else {
                                echo $trato->getFieldValue('P_liza')->getLookupLabel();
                            }
                            ?>
                        </td>
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