<?php

$api = new api;
$usuario = json_decode($_COOKIE["usuario"], true);

$criterio = "Contact_Name:equals:" . $usuario['id'];
$cotizaciones =  $api->searchRecordsByCriteria("Deals", $criterio);

$emitida = array("Emitido", "En trámite");

?>
<h2 class="text-uppercase text-center">
    Emisiones Del Mes
</h2>

<div class="card">
    <div class="card-body">
        <table class="table table-bordered">
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
                                <a href="<?= constant("url") . strtolower($cotizacion->getFieldValue('Type')) ?>/detalles/<?= $cotizacion->getEntityId() ?>" title="Detalles">
                                            <i class="tiny material-icons">details</i>
                                        </a>
                                        <?php if ($cotizacion->getFieldValue('Email') != null) : ?>
                                            <a href="<?= constant("url") . strtolower($cotizacion->getFieldValue('Type')) ?>/emitir/<?= $cotizacion->getEntityId() ?>" title="Emitir">
                                                <i class="tiny material-icons">folder_shared</i>
                                            </a>
                                            <a href="<?= constant("url") . strtolower($cotizacion->getFieldValue('Type')) ?>/descargar/<?= $cotizacion->getEntityId() ?>" title="Descargar">
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
    </div>
</div>