<h1 class="mt-4">
    <?php
    if ($filtro == "pendientes") {
        echo "Cotizaciones Pendientes";
    } elseif ($filtro == "emisiones_mensuales") {
        echo "Emisiones Del Mes";
    } elseif ($filtro == "vencimientos_mensuales") {
        echo "Vencimientos Del Mes";
    }
    ?>
</h1>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item active">Cotizaciones</li>
</ol>

<div class="card mb-4">

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
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
                            <?php if ($filtro == "pendientes") : ?>
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
                                                <i class="fas fa-info-circle"></i>
                                            </a>
                                            <?php if ($cotizacion->getFieldValue('Email') != null) : ?>
                                                <a href="<?= constant("url") . strtolower($cotizacion->getFieldValue('Type')) . '/emitir/' . $cotizacion->getEntityId() ?>" title="Emitir">
                                                    <i class="fas fa-file-upload"></i>
                                                </a>
                                                <a href="<?= constant("url") . strtolower($cotizacion->getFieldValue('Type')) . '/descargar/' . $cotizacion->getEntityId() ?>" title="Descargar">
                                                    <i class="fas fa-file-download"></i>
                                                </a>
                                            <?php endif ?>
                                        </td>
                                    </tr>
                                <?php endif ?>
                            <?php elseif ($filtro == "emisiones_mensuales") : ?>
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
                                                <i class="fas fa-info-circle"></i>
                                            </a>
                                            <?php if ($cotizacion->getFieldValue('Email') != null) : ?>
                                                <a href="<?= constant("url") . strtolower($cotizacion->getFieldValue('Type')) . '/emitir/' . $cotizacion->getEntityId() ?>" title="Emitir">
                                                    <i class="fas fa-file-upload"></i>
                                                </a>
                                                <a href="<?= constant("url") . strtolower($cotizacion->getFieldValue('Type')) . '/descargar/' . $cotizacion->getEntityId() ?>" title="Descargar">
                                                    <i class="fas fa-file-download"></i>
                                                </a>
                                            <?php endif ?>
                                        </td>
                                    </tr>
                                <?php endif ?>
                            <?php elseif ($filtro == "vencimientos_mensuales") : ?>
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
                                                <i class="fas fa-info-circle"></i>
                                            </a>
                                            <?php if ($cotizacion->getFieldValue('Email') != null) : ?>
                                                <a href="<?= constant("url") . strtolower($cotizacion->getFieldValue('Type')) . '/emitir/' . $cotizacion->getEntityId() ?>" title="Emitir">
                                                    <i class="fas fa-file-upload"></i>
                                                </a>
                                                <a href="<?= constant("url") . strtolower($cotizacion->getFieldValue('Type')) . '/descargar/' . $cotizacion->getEntityId() ?>" title="Descargar">
                                                    <i class="fas fa-file-download"></i>
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
</div>