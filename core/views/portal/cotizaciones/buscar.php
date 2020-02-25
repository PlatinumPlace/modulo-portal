<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Buscar Cotización</h1>
</div>
<div class="card mb-4">
    <div class="card-body">
        <form method="POST" action="index.php?pagina=buscar">
            <div class="form-row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="small mb-1">Busqueda</label>
                        <input class="form-control" type="text" name="busqueda" required />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="small mb-1">Buscar por:</label>
                        <select name="parametro" class="form-control">
                            <option selected value="numero">No. de cotización</option>
                            <option value="nombre">Nombre del cliente</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="form-row">
                <div class="col-md-6">
                    <div class="form-group">
                        <button type="submit" class="btn btn-success">Buscar</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<?php if ($_POST and empty($tratos)) : ?>
    <div class="alert alert-info" role="alert">
        No se encontraron registros
    </div>
<?php endif ?>
<?php if (isset($_GET['id'])) : ?>
    <div class="alert alert-info" role="alert">
        <?= $mensaje ?>
    </div>
<?php endif ?>
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
                            <tr>
                                <td><?= $trato->getFieldValue('No_de_cotizaci_n')  ?></td>
                                <td><?= $trato->getFieldValue('Nombre_del_asegurado') . " " . $trato->getFieldValue('Apellido_del_asegurado') ?></td>
                                <td><?= $trato->getFieldValue('Type')  ?></td>
                                <td>RD$<?= number_format($trato->getFieldValue('Valor_Asegurado'), 2) ?></td>
                                <td><?= $trato->getFieldValue("Stage") ?></td>
                                <td><?= date("d/m/Y", strtotime($trato->getFieldValue("Closing_Date"))) ?></td>
                                <td>
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="index.php?pagina=detalles&id=<?= $trato->getEntityId() ?>" class="btn btn-info">Detalles</a>
                                        <?php if (
                                            $trato->getFieldValue('Stage') == "Cotizando"
                                            or
                                            $trato->getFieldValue('Stage') != "Abandonado"
                                        ) : ?>
                                            <a href="index.php?pagina=emitir&id=<?= $trato->getEntityId() ?>" class="btn btn-success">Emitir</a>
                                            <a href="index.php?pagina=editar&id=<?= $trato->getEntityId() ?>" class="btn btn-warning">Editar</a>
                                        <?php endif ?>
                                        <a href="index.php?pagina=descargar&id=<?= $trato->getEntityId() ?>" class="btn btn-secondary">Descargar</a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    <?php endif ?>
                </tbody>
            </table>
        </div>
    </div>
</div>