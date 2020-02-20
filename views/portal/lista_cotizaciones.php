<br><br><br>
<div class="card mb-4">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No. de cotización</th>
                        <th>Nombre del cliente</th>
                        <th>Bien Asegurado</th>
                        <th>Suma Asegurada</th>
                        <th>Estado</th>
                        <th>Fecha de cierre</th>
                        <th>Opciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($tratos)) : ?>
                        <?php foreach ($tratos as $trato) : ?>
                            <?php if (isset($filtro) and $trato->getFieldValue("Stage") == $filtro or date("Y-m", strtotime($trato->getFieldValue("Closing_Date"))) == date("Y-m")) : ?>
                                <tr>
                                    <td><?= $trato->getFieldValue('No_de_cotizaci_n')  ?></td>
                                    <td><?= $trato->getFieldValue('Nombre_del_asegurado') . " " . $trato->getFieldValue('Apellido_del_asegurado') ?></td>
                                    <td><?= $trato->getFieldValue('Type')  ?></td>
                                    <td>RD$<?= number_format($trato->getFieldValue('Valor_Asegurado'), 2) ?></td>
                                    <td><?= $trato->getFieldValue("Stage") ?></td>
                                    <td><?= $trato->getFieldValue("Closing_Date") ?></td>
                                    <td>
                                        <div class="btn-group btn-group-sm" role="group">
                                            <a href="index.php?pagina=detalles&id=<?= $trato->getEntityId() ?>" class="btn btn-info">Detalles</a>
                                            <a href="index.php?pagina=emitir&id=<?= $trato->getEntityId() ?>" class="btn btn-success">Emitir</a>
                                            <a href="index.php?pagina=descargar&id=<?= $trato->getEntityId() ?>" class="btn btn-secondary">Descargar</a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endif ?>
                        <?php endforeach ?>
                    <?php endif ?>
                </tbody>
            </table>
        </div>
    </div>
</div>