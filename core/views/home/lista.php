<div class="row">
    <form class="col s12" method="POST" action="?pagina=lista">
        <div class="row">
            <div class="input-field col s6">
                <i class="material-icons prefix">search</i>
                <input id="buscar" type="text" class="validate" name="buscar">
                <label for="buscar">Buscar por nombre del cliente</label>
            </div>


            <div class="input-field col s6">
                <button class="btn waves-effect waves-light" type="submit" name="action">Buscar
                    <i class="material-icons right">send</i>
                </button>
            </div>

        </div>
    </form>
</div>

<table class="striped highlight responsive-table">
    <thead>
        <tr>
            <th>No. de cotización</th>
            <th>Nombre del cliente</th>
            <th>Suma Asegurada</th>
            <th>Estado</th>
            <th>Opciones</th>
        </tr>
    </thead>

    <tbody>
        <?php if (!empty($ofertas)) : ?>
            <?php foreach ($ofertas as $oferta) : ?>
                <?php if (isset($filtro) and in_array($oferta->getFieldValue("Stage"), $estado)) : ?>
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
                        <td>RD$<?= number_format($oferta->getFieldValue('Valor_Asegurado'), 2) ?></td>
                        <td><?= $oferta->getFieldValue("Stage") ?></td>
                        <td>
                            <a href="?pagina=detalles_cotizacion&id=<?= $oferta->getEntityId() ?>" data-tooltip="Detalles" class="tooltipped blue waves-effect waves-light btn-small btn-floating"><i class="material-icons left">details</i></a>
                            <a href="?pagina=editar_cotizacion&id=<?= $oferta->getEntityId() ?>" data-tooltip="Editar" class="tooltipped yellow waves-effect waves-light btn-small btn-floating"><i class="material-icons left">edit</i></a>
                            <a href="?pagina=emitir_cotizacion&id=<?= $oferta->getEntityId() ?>" data-tooltip="Emitir" class="tooltipped green waves-effect waves-light btn-small btn-floating"><i class="material-icons left">recent_actors</i></a>
                        </td>
                    </tr>
                <?php else : ?>
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
                        <td>RD$<?= number_format($oferta->getFieldValue('Valor_Asegurado'), 2) ?></td>
                        <td><?= $oferta->getFieldValue("Stage") ?></td>
                        <td>
                            <a href="?pagina=detalles_cotizacion&id=<?= $oferta->getEntityId() ?>" data-tooltip="Detalles" class="tooltipped blue waves-effect waves-light btn-small btn-floating"><i class="material-icons left">details</i></a>
                            <a href="?pagina=editar_cotizacion&id=<?= $oferta->getEntityId() ?>" data-tooltip="Editar" class="tooltipped yellow waves-effect waves-light btn-small btn-floating"><i class="material-icons left">edit</i></a>
                            <a href="?pagina=emitir_cotizacion&id=<?= $oferta->getEntityId() ?>" data-tooltip="Emitir" class="tooltipped green waves-effect waves-light btn-small btn-floating"><i class="material-icons left">recent_actors</i></a>
                        </td>
                    </tr>
                <?php endif ?>
            <?php endforeach ?>
        <?php endif ?>
    </tbody>
</table>