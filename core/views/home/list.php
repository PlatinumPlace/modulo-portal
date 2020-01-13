<div class='container'>

    <h3 class="header">Cotizaciones Realizadas</h3>

    <hr>

    <table class="striped highlight responsive-table">
        <thead>
            <tr>
                <th>No. Aprobación</th>
                <th>Estado</th>
                <th>Ganancias</th>
                <th>Opciones</th>
            </tr>
        </thead>

        <tbody>
            <?php if (!empty($ofertas)) : ?>
                <?php foreach ($ofertas as $oferta) : ?>
                    <?php if (in_array($oferta->getFieldValue("Stage"), $estado)) : ?>
                        <?php $criterio = "Deal_Name:equals:" . $oferta->getEntityId() ?>
                        <?php $cotizaciones = $this->api->searchRecordsByCriteria("Quotes", $criterio) ?>
                        <tr>
                            <td>
                                <?php foreach ($cotizaciones as $cotizacion) : ?>
                                    <?= $cotizacion->getFieldValue('Quote_Number') ?>
                                    <?php break ?>
                                <?php endforeach ?>
                            </td>
                            <td><?= $oferta->getFieldValue("Stage") ?></td>
                            <td>RD$<?= number_format($oferta->getFieldValue('Amount'), 2) ?></td>
                            <td><a href="?page=details&id=<?= $oferta->getEntityId() ?>" data-tooltip="Ver detalles" class="tooltipped blue waves-effect waves-light btn-small btn-floating"><i class="material-icons left">details</i></a></td>
                        </tr>
                    <?php endif ?>
                <?php endforeach ?>
            <?php endif ?>
        </tbody>
    </table>
</div>