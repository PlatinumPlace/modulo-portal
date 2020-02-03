<div class="section no-pad-bot" id="index-banner">
    <div class="container">
        <h1 class="header center orange-text">Buscar</h1>
        <div class="row center">
            <form class="col s12" method="post" action="?page=search">
                <div class="input-field col s6">
                    <input name="buscar" id="buscar" type="text" class="validate" required>
                    <label for="buscar">Buscar</label>
                </div>
                <div class="input-field col s6">
                    <select name="opcion">
                        <option value="nombre" selected>Nombre del cliente</option>
                        <option value="numero">No. de cotización</option>
                    </select>
                    <label>Por:</label>
                </div>
                <button type="submit" class="btn-large waves-effect waves-light">Buscar</a>
            </form>
        </div>
    </div>
</div>

<div class="section">

    <table class="striped highlight centered">
        <thead>
            <tr>
                <th>No. de cotización</th>
                <th>Nombre del cliente</th>
                <th>Bien Asegurado</th>
                <th>Suma Asegurada</th>
                <th>Estado</th>
                <th>Opciones</th>
            </tr>
        </thead>

        <tbody>
            <?php if (!empty($tratos)) : ?>
                <?php foreach ($tratos as $trato) : ?>
                    <tr>
                        <td><?= $trato->getFieldValue('No_de_cotizaci_n')  ?></td>
                        <td><?= $trato->getFieldValue('Nombre_del_asegurado') . " " . $trato->getFieldValue('Apellido_del_asegurado') ?></td>
                        <td><?= $trato->getFieldValue('Type')  ?></td>
                        <td>RD$<?= number_format($trato->getFieldValue('Valor_Asegurado'), 2) ?></td>
                        <td><?= $trato->getFieldValue("Stage") ?></td>
                        <td>
                            <a href="?page=details&id=<?= $trato->getEntityId() ?>" class="btn-floating btn-small waves-effect waves-light blue tooltipped" data-position="bottom" data-tooltip="Detalles"><i class="material-icons">details</i></a>
                            <?php if ($trato->getFieldValue('Activo') != false and $trato->getFieldValue('Aseguradora') == null) : ?>
                                <a href="?page=emit&id=<?= $trato->getEntityId() ?>" class="btn-floating btn-small waves-effect waves-light tooltipped" data-position="bottom" data-tooltip="Emitir"><i class="material-icons">recent_actors</i></a>
                                <a href="?page=edit&id=<?= $trato->getEntityId() ?>" class="btn-floating btn-small waves-effect waves-light yellow tooltipped" data-position="bottom" data-tooltip="Editar"><i class="material-icons">edit</i></a>
                            <?php endif ?>
                            <a class="btn-floating btn-small waves-effect waves-light green tooltipped" data-position="bottom" data-tooltip="Descargar" href="?page=download&id=<?= $trato->getEntityId() ?>"><i class="material-icons">cloud_download</i></a>
                        </td>
                    </tr>
                <?php endforeach ?>
            <?php endif ?>
        </tbody>
    </table>

</div>