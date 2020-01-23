<table class="striped highlight responsive-table">
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
        <?php if (!empty($ofertas)) : ?>
            <?php foreach ($ofertas as $oferta) : ?>
                <?php if ($filtro == $oferta->getFieldValue("Stage")) : ?>
                    <?php $criterio = "Deal_Name:equals:" . $oferta->getEntityId() ?>
                    <?php $cotizaciones = $this->api->searchRecordsByCriteria("Quotes", $criterio) ?>
                    <tr>
                        <td>
                            <?php if (!empty($cotizaciones)) : ?>
                                <?php foreach ($cotizaciones as $cotizacion) : ?>
                                    <?= $cotizacion->getFieldValue('Quote_Number') ?>
                                    <?php break ?>
                                <?php endforeach ?>
                            <?php endif ?>
                        </td>
                        <td><?= $oferta->getFieldValue('Nombre_del_asegurado') . " " . $oferta->getFieldValue('Apellido_del_asegurado') ?></td>
                        <td><?= $oferta->getFieldValue('Type')  ?></td>
                        <td>RD$<?= number_format($oferta->getFieldValue('Valor_Asegurado'), 2) ?></td>
                        <td><?= $oferta->getFieldValue("Stage") ?></td>
                        <td>
                            <a href="?pagina=emitir_cotizacion&id=<?= $oferta->getEntityId() ?>" data-tooltip="Emitir" class="tooltipped green waves-effect waves-light btn-small btn-floating"><i class="material-icons">recent_actors</i></a>
                            <a href="?pagina=ver_cotizacion&id=<?= $oferta->getEntityId() ?>" data-tooltip="Detalles" class="tooltipped blue waves-effect waves-light btn-small btn-floating"><i class="material-icons">details</i></a>
                            <?php if ($oferta->getFieldValue('Aseguradora') == null) : ?>
                            <a href="?pagina=editar_cotizacion&id=<?= $oferta->getEntityId() ?>" data-tooltip="Editar" class="tooltipped yellow waves-effect waves-light btn-small btn-floating"><i class="material-icons">edit</i></a>
                            <a href="?pagina=eliminar_cotizacion&id=<?= $oferta->getEntityId() ?>" data-tooltip="Eliminar" class="tooltipped red waves-effect waves-light btn-small btn-floating"><i class="material-icons">delete</i></a>
                            <?php endif ?> 
                            <a href="?pagina=descargar_cotizacion&id=<?= $oferta->getEntityId() ?>" data-tooltip="Descargar" class="tooltipped waves-effect waves-light btn-small btn-floating"><i class="material-icons">file_download</i></a>
                        </td>
                    </tr>
                <?php endif ?>
            <?php endforeach ?>
        <?php endif ?>
    </tbody>
</table>