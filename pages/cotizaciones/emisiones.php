<?php

$criterio = "Contact_Name:equals:" . $_SESSION['usuario_id'];
$cotizaciones = $api->buscar_registro_por_criterio("Deals", $criterio);

$emitida = array("Emitido", "En trámite");

?>
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
            <?php foreach ($cotizaciones as $cotizacion) : ?>
                <?php if (
                    in_array($cotizacion->getFieldValue("Stage"), $emitida)
                    and
                    date("Y-m", strtotime($cotizacion->getFieldValue("Fecha_de_emisi_n"))) == date('Y-m')
                ) : ?>
                    <tr>
                        <td><?= $cotizacion->getFieldValue('No_Cotizaci_n')  ?></td>
                        <td><?= $cotizacion->getFieldValue('Nombre') . " " . $cotizacion->getFieldValue('Apellido') ?></td>
                        <td><?= $cotizacion->getFieldValue('Type')  ?></td>
                        <td>RD$<?= number_format($cotizacion->getFieldValue('Valor_Asegurado'), 2) ?></td>
                        <td><?= $cotizacion->getFieldValue("Stage") ?></td>
                        <td><?= date("d/m/Y", strtotime($cotizacion->getFieldValue("Closing_Date"))) ?></td>
                        <td>
                            <a href="<?= constant('url') ?>cotizaciones/detalles_<?= strtolower($cotizacion->getFieldValue('Type')) ?>/<?= $cotizacion->getEntityId() ?>" title="Detalles">
                                <i class="tiny material-icons">details</i>
                            </a>
                            <?php if ($cotizacion->getFieldValue('Nombre') != null) : ?>
                                <a href="<?= constant('url') ?>cotizaciones/emitir/<?= $cotizacion->getEntityId() ?>" title="Emitir">
                                    <i class="tiny material-icons">folder_shared</i>
                                </a>
                                <a href="<?= constant('url') ?>cotizaciones/descargar_<?= strtolower($cotizacion->getFieldValue('Type')) ?>/<?= $cotizacion->getEntityId() ?>" title="Descargar">
                                    <i class="tiny material-icons">file_download</i>
                                </a>
                            <?php endif ?>
                        </td>
                    </tr>
                <?php endif ?>
            <?php endforeach ?>
        <?php endif ?>
    </tbody>
</table>