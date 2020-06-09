<?php

$portal = new portal;
$cotizaciones = new cotizaciones;

$lista = $cotizaciones->lista_cotizaciones();

$url = $portal->obtener_url();
$tipo = $url[0];

$emitida = array("Emitido", "En trámite");

?>
<h2 class="text-uppercase text-center">
    <?php

    if ($tipo == "pendientes") {
        echo "Cotizaciones Pendientes";
    } elseif ($tipo == "emisiones_mensuales") {
        echo "Emisiones Del Mes";
    } elseif ($tipo == "vencimientos_mensuales") {
        echo "Vencimientos Del Mes";
    }

    ?>
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
                <?php if (!empty($lista)) : ?>
                    <?php foreach ($lista as $cotizacion) : ?>
                        <?php if ($tipo == "pendientes") : ?>
                            <?php if ($cotizacion->getFieldValue("Stage") == "Cotizando") : ?>
                                <tr>
                                    <td><?= $cotizacion->getFieldValue('No_Cotizaci_n') ?></td>
                                    <td><?= $cotizacion->getFieldValue('Nombre') . " " . $cotizacion->getFieldValue('Apellido') ?></td>
                                    <td><?= $cotizacion->getFieldValue('Type') ?></td>
                                    <td>RD$<?= number_format($cotizacion->getFieldValue('Valor_Asegurado'), 2) ?></td>
                                    <td><?= $cotizacion->getFieldValue("Stage") ?></td>
                                    <td><?= date("d/m/Y", strtotime($cotizacion->getFieldValue("Closing_Date"))) ?></td>
                                    <td>
                                        <a href="<?= constant("url") . strtolower($cotizacion->getFieldValue('Type')) . '/detalles/' . $cotizacion->getEntityId() ?>" title="Detalles">
                                            <i class="tiny material-icons">details</i>
                                        </a>
                                        <?php if ($cotizacion->getFieldValue('Email') != null) : ?>
                                            <a href="<?= constant("url") . strtolower($cotizacion->getFieldValue('Type')) . '/emitir/' . $cotizacion->getEntityId() ?>" title="Emitir">
                                                <i class="tiny material-icons">folder_shared</i>
                                            </a>
                                            <a href="<?= constant("url") . strtolower($cotizacion->getFieldValue('Type')) . '/descargar/' . $cotizacion->getEntityId() ?>" title="Descargar">
                                                <i class="tiny material-icons">file_download</i>
                                            </a>
                                        <?php endif ?>
                                    </td>
                                </tr>
                            <?php endif ?>
                        <?php elseif ($tipo == "emisiones_mensuales") : ?>
                            <?php if (
                                in_array($cotizacion->getFieldValue("Stage"), $emitida)
                                and
                                date("Y-m", strtotime($cotizacion->getFieldValue("Fecha_de_emisi_n"))) == date('Y-m')
                            ) : ?>
                                <tr>
                                    <td><?= $cotizacion->getFieldValue('No_Cotizaci_n') ?></td>
                                    <td><?= $cotizacion->getFieldValue('Nombre') . " " . $cotizacion->getFieldValue('Apellido') ?></td>
                                    <td><?= $cotizacion->getFieldValue('Type') ?></td>
                                    <td>RD$<?= number_format($cotizacion->getFieldValue('Valor_Asegurado'), 2) ?></td>
                                    <td><?= $cotizacion->getFieldValue("Stage") ?></td>
                                    <td><?= date("d/m/Y", strtotime($cotizacion->getFieldValue("Closing_Date"))) ?></td>
                                    <td>
                                        <a href="<?= constant("url") . strtolower($cotizacion->getFieldValue('Type')) . '/detalles/' . $cotizacion->getEntityId() ?>" title="Detalles">
                                            <i class="tiny material-icons">details</i>
                                        </a>
                                        <?php if ($cotizacion->getFieldValue('Email') != null) : ?>
                                            <a href="<?= constant("url") . strtolower($cotizacion->getFieldValue('Type')) . '/emitir/' . $cotizacion->getEntityId() ?>" title="Emitir">
                                                <i class="tiny material-icons">folder_shared</i>
                                            </a>
                                            <a href="<?= constant("url") . strtolower($cotizacion->getFieldValue('Type')) . '/descargar/' . $cotizacion->getEntityId() ?>" title="Descargar">
                                                <i class="tiny material-icons">file_download</i>
                                            </a>
                                        <?php endif ?>
                                    </td>
                                </tr>
                            <?php endif ?>
                        <?php elseif ($tipo == "vencimientos_mensuales") : ?>
                            <?php if (
                                in_array($cotizacion->getFieldValue("Stage"), $emitida)
                                and
                                date("Y-m", strtotime($cotizacion->getFieldValue("Closing_Date"))) == date('Y-m')
                            ) : ?>
                                <tr>
                                    <td><?= $cotizacion->getFieldValue('No_Cotizaci_n') ?></td>
                                    <td><?= $cotizacion->getFieldValue('Nombre') . " " . $cotizacion->getFieldValue('Apellido') ?></td>
                                    <td><?= $cotizacion->getFieldValue('Type') ?></td>
                                    <td>RD$<?= number_format($cotizacion->getFieldValue('Valor_Asegurado'), 2) ?></td>
                                    <td><?= $cotizacion->getFieldValue("Stage") ?></td>
                                    <td><?= date("d/m/Y", strtotime($cotizacion->getFieldValue("Closing_Date"))) ?></td>
                                    <td>
                                        <a href="<?= constant("url") . strtolower($cotizacion->getFieldValue('Type')) . '/detalles/' . $cotizacion->getEntityId() ?>" title="Detalles">
                                            <i class="tiny material-icons">details</i>
                                        </a>
                                        <?php if ($cotizacion->getFieldValue('Email') != null) : ?>
                                            <a href="<?= constant("url") . strtolower($cotizacion->getFieldValue('Type')) . '/emitir/' . $cotizacion->getEntityId() ?>" title="Emitir">
                                                <i class="tiny material-icons">folder_shared</i>
                                            </a>
                                            <a href="<?= constant("url") . strtolower($cotizacion->getFieldValue('Type')) . '/descargar/' . $cotizacion->getEntityId() ?>" title="Descargar">
                                                <i class="tiny material-icons">file_download</i>
                                            </a>
                                        <?php endif ?>
                                    </td>
                                </tr>
                            <?php endif ?>
                        <?php endif ?>
                    <?php endforeach ?>
                <?php endif ?>
            </tbody>
        </table>
    </div>
</div>