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
                    <?php if ($trato->getFieldValue("Stage") == $filtro) : ?>
                        <tr>
                        <td><?= $trato->getFieldValue('No_de_cotizaci_n')  ?></td>
                        <td><?= $trato->getFieldValue('Nombre_del_asegurado') . " " . $trato->getFieldValue('Apellido_del_asegurado') ?></td>
                        <td><?= $trato->getFieldValue('Type')  ?></td>
                        <td>RD$<?= number_format($trato->getFieldValue('Valor_Asegurado'), 2) ?></td>
                        <td><?= $trato->getFieldValue("Stage") ?></td>
                        <td>
                            <a href="?pagina=detalles&id=<?= $trato->getEntityId() ?>" class="btn-floating btn-small waves-effect waves-light blue tooltipped" data-position="bottom" data-tooltip="Detalles"><i class="material-icons">details</i></a>
                            <?php if ($trato->getFieldValue('Activo') != false and $trato->getFieldValue('Aseguradora') == null) : ?>
                                <a href="?pagina=emitir&id=<?= $trato->getEntityId() ?>" class="btn-floating btn-small waves-effect waves-light tooltipped" data-position="bottom" data-tooltip="Emitir"><i class="material-icons">recent_actors</i></a>
                            <?php endif ?>
                            <a class="btn-floating btn-small waves-effect waves-light green tooltipped" data-position="bottom" data-tooltip="Descargar" href="?page=download&id=<?= $trato->getEntityId() ?>"><i class="material-icons">cloud_download</i></a>
                        </td>
                    </tr>
                    <?php endif ?>
                <?php endforeach ?>
            <?php endif ?>
        </tbody>
    </table>

</div>